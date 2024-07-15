<?php

include $_SERVER['DOCUMENT_ROOT'] . '/server/safe_query.php';
include $_SERVER['DOCUMENT_ROOT'] . '/server/database.php';
include $_SERVER['DOCUMENT_ROOT'] . '/server/send-message.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $conn->autocommit(FALSE);
    $conn->begin_transaction();

    $requestBody = file_get_contents('php://input');
    $data = json_decode($requestBody, true);

    $production_item_id = $_POST["id"];

    $sql = "UPDATE production_plan SET status = 'COMPLETED' WHERE id = $production_item_id";

    safe_query($conn, $sql);

    $production_item = $conn->query("SELECT * from production_plan where id = $production_item_id");

    if ($production_item->num_rows == 1) {
        $row = $production_item->fetch_assoc();
        $target = $row['target'];
        $product_id = $row['product_id'];
        $amount_produced = $row['amount'];
        $order_id = $row['order_id'];
        
        $storage_id_rand = $conn->query("select  
                id
                from production_facilities pf
                order by rand()
                limit 1;")->fetch_assoc()["id"];
        
        if ($target == "STORAGE") {

            // for now just select a random facility for storing the product
            


            $sql = "INSERT INTO storage_logs 
                (product_id, storage_id, order_id, amount, detail) 
                VALUES ($product_id, $storage_id_rand, NULL, $amount_produced, 'PRODUCTION_IN');";
            safe_query($conn, $sql);
            safe_query($conn, "UPDATE products SET storage_amount = storage_amount + $amount_produced WHERE id = $product_id;");
        } else if ($target == 'CUSTOMER') {

            $sql = "SELECT * FROM storage_logs WHERE order_id = $order_id AND detail = 'RESERVED' AND product_id = $product_id";
            $res = safe_query($conn, $sql);


            $row = $res->fetch_assoc();
            $st_id = $row["storage_id"];
            if ($res->num_rows == 1) {
                $amount = $row["amount"];
                $sql = "UPDATE storage_logs SET amount = amount - $amount_produced WHERE id = " . $row["id"];
                safe_query($conn, $sql);
            } else if ($res->num_rows > 1) {
                http_response_code(500);
                echo '{"success": false}';
                $conn->rollback();
                exit(1);
            } else {
                $sql = "INSERT INTO storage_logs 
                (product_id, storage_id, order_id, amount, detail) 
                VALUES 
                    ($product_id, $st_id, $order_id, $amount_produced, 'RESERVED');";
            safe_query($conn, $sql);
            }

            $sql = "INSERT INTO storage_logs 
                (product_id, storage_id, order_id, amount, detail) 
                VALUES 
                    ($product_id, $st_id, $order_id, $amount_produced, 'PRODUCTION_IN');";
            safe_query($conn, $sql);
            echo "Production item not found";
        } else {
            http_response_code(500);
            echo '{"success": false}';
        }
    }   

    $conn->commit();

    try {
        //code...
        sendMsg('{ "action": "reload", "message": "Production for order with id ' . $order_id . ' completed" }');
    } catch (\Throwable $th) {
        //throw $th;
    }
    echo '{"success": true}';

}
<?php

include $_SERVER['DOCUMENT_ROOT'] . '/server/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    $requestBody = file_get_contents('php://input');
    $data = json_decode($requestBody, true);

    // echo json_encode($data);
    $production_item_id = $_POST["id"];

    $sql = "UPDATE production_plan SET status = 'COMPLETED' WHERE id = $production_item_id";

    $conn->query($sql);

    $production_item = $conn->query("SELECT * from production_plan where id = $production_item_id");

    if ($production_item->num_rows == 1) {
        $row = $production_item->fetch_assoc();
        $target = $row['target'];
        $product_id = $row['product_id'];
        $amount = $row['amount'];
        if ($target == "STORAGE") {
            $sql = "START TRANSACTION; 
                INSERT INTO storage_logs 
                (product_id, storage_id, order_id, amount, detail) 
                VALUES ($product_id, 1, NULL, $amount, 'PRODUCTION_IN');
                UPDATE products SET storage_amount = storage_amount + $amount WHERE id = $product_id;
                COMMIT;";

            $conn->multi_query($sql);
            echo $sql;
        }
    } else {
        echo "Production item not found";
    }


}
<?php


include $_SERVER['DOCUMENT_ROOT'] . '/server/database.php';
include $_SERVER['DOCUMENT_ROOT'] . '/server/safe_query.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $conn->autocommit(FALSE);

    // when requesting via postman
    $requestBody = file_get_contents('php://input');
    $data = json_decode($requestBody, true);

    // when requesting through the browser
    if (!$data) {
        $data = $_POST;
    }

    // request body: {"item": {"amount":"10","productId":"7"}, "sp_id": 1}
    $amount = $data["item"]["amount"];
    $product_id = $data["item"]["productId"];
    $sp_id = $data['sp_id'];
    
    $conn->begin_transaction();


    $sql = 'select * from orders where sp_id = ' . $sp_id . ' and status = "IN_BASKET";';
    $order = safe_query($conn, $sql);
    
    if ($order-> num_rows == 0) {
        $sql = "INSERT INTO orders (sp_id, status) 
        VALUES ($sp_id, 'IN_BASKET');
        SET @order_id = LAST_INSERT_ID();
        INSERT INTO order_items (order_id, product_id, amount) VALUES
        (@order_id, $product_id, $amount);";

        echo $sql;

        $res = $conn->multi_query($sql);
    } else if ($order->num_rows == 1) {

        $order_id = $order->fetch_assoc()['id'];
        $sql = "SELECT * FROM order_items WHERE order_id = $order_id AND product_id = $product_id;";
        $result = safe_query($conn, $sql);
        
        if ($result->num_rows == 0) {
            $sql = "INSERT INTO order_items (order_id, product_id, amount) VALUES ($order_id, $product_id, $amount);";
        } else {
            $existingAmount = $result->fetch_assoc()['amount'];
            $newAmount = $existingAmount + $amount;
            $sql = "UPDATE order_items SET amount = $newAmount WHERE order_id = $order_id AND product_id = $product_id;";
        }
        
        $res = $conn->query($sql);

    } else {
        echo '{"success": false, "Error": "Multiple orders found for sp_id $sp_id with status IN_BASKET. Please contact support."}';
        $conn->rollback();
        exit(1);
    }

    while ($conn->next_result()) {
        ;
    } // flush multi_queries


    if ($conn->affected_rows === -1) {
        echo '{"success": false, "Error": ""}';
        $conn->rollback();
        exit(1);
    }

    echo '{"success": true, "msg": "Added to cart"}';

    $conn->commit();

}
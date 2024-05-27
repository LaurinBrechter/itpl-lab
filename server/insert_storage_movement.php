<?php

include $_SERVER['DOCUMENT_ROOT'] . '/server/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $requestBody = file_get_contents('php://input');
    $data = json_decode($requestBody, true);

    $product_id = $data['product_id'];
    $amount = $data['amount'];
    $order_id = $data['order_id'];
    $sql = "START TRANSACTION;
    INSERT INTO storage_logs 
    (product_id, storage_id, order_id, amount, detail) 
    VALUES ($product_id, 1, $order_id, $amount, 'MANUAL');
    UPDATE products SET storage_amount = storage_amount - $amount WHERE id = $product_id;
    COMMIT;";

    $conn->multi_query($sql);
    print_r($sql);
}
// echo $_SERVER['REQUEST_METHOD'];
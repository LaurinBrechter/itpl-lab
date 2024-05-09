<?php

include $_SERVER['DOCUMENT_ROOT'] . '/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'];
    $amount = $_POST['amount'];
    $order_id = $_POST['order_id'];
    $sql = "START TRANSACTION;
    INSERT INTO storage_logs 
    (product_id, storage_id, order_id, amount) 
    VALUES ($product_id, 1, $order_id, $amount);
    UPDATE products SET storage_amount = storage_amount - $amount WHERE id = $product_id;
    COMMIT;";

    $conn->multi_query($sql);
    echo $sql;
}
// echo $_SERVER['REQUEST_METHOD'];
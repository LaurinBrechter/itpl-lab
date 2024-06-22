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
    $order_item_id = $data["order_item_id"];

    $conn->begin_transaction();
    $sql = "DELETE FROM order_items WHERE id = $order_item_id;";
    $res = safe_query($conn, $sql);


    echo '{"success": true, "msg": "Added to cart"}';

    $conn->commit();

}
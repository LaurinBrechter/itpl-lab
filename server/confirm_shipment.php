<?php

include $_SERVER['DOCUMENT_ROOT'] . '/server/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // $requestBody = file_get_contents('php://input');
    // $data = json_decode($requestBody, true);

    $storage_item_id = $_POST["id"];

    $sql = "UPDATE storage_logs SET detail = 'SHIPPED' WHERE id = $storage_item_id";
    $res = $conn->query($sql);

    $response = array();
    if ($res) {
        $response["success"] = true;
        $response["message"] = "Shipment confirmed";
    } else {
        $response["success"] = false;
        $response["message"] = "Failed to confirm shipment";
    }

    echo json_encode($response);
}
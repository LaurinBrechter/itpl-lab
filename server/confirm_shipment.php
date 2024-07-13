<?php

include $_SERVER['DOCUMENT_ROOT'] . '/server/database.php';
function safe_query($conn, $sql)
{
    try {
        $res = $conn->query($sql);
        return $res;
    } catch (Exception $e) {
        http_response_code(500);
        echo '{"success": false, "msg":' . $e->getMessage() . '}';
        $conn->rollback();
        exit(1);
    }

    if (!$res) {
        http_response_code(500);
        echo '{"success": false, "msg":' . $conn->error . '}';
        $conn->rollback();
        exit(1);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // $requestBody = file_get_contents('php://input');
    // $data = json_decode($requestBody, true);
    $conn->autocommit(FALSE);

    $storage_item_id = $_POST["id"];

    $sql = "UPDATE storage_logs SET detail = 'SHIPPED' WHERE id = $storage_item_id";
    $res = safe_query($conn, $sql);

    $sql = "SELECT * FROM storage_logs WHERE id = $storage_item_id";
    $res = safe_query($conn, $sql);
    $row = $res->fetch_assoc();

    $sql = "UPDATE order_items SET status = 'COMPLETED' WHERE order_id = " . $row["order_id"] . " AND product_id = " . $row["product_id"] . " AND amount = " . abs($row["amount"]);
    $res = safe_query($conn, $sql);

    $response = array();
    if ($res) {
        $response["success"] = true;
        $response["message"] = "Shipment confirmed";
    } else {
        $response["success"] = false;
        $response["message"] = "Failed to confirm shipment";
    }

    $conn->commit();

    echo json_encode($response);
}
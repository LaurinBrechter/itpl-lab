<?php
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

include $_SERVER['DOCUMENT_ROOT'] . '/server/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // $requestBody = file_get_contents('php://input');
    // $data = json_decode($requestBody, true);
    $conn->autocommit(FALSE);
    $conn->begin_transaction();
    $order_id = $_POST["id"];

    $sql = "UPDATE orders SET status = 'CANCELLED' WHERE id = $order_id";
    $res = safe_query($conn, $sql);

    $response = array();
    if ($res) {
        $response["success"] = true;
        $response["message"] = "Oder cancelled";
    } else {
        $response["success"] = false;
        $response["message"] = "Failed to cancel the order.";
    }


    // TODO delete reservation from storage log
    $sql = "UPDATE storage_logs SET detail = 'CANCELLED' WHERE order_id = $order_id AND detail = 'RESERVED'";
    $res = safe_query($conn, $sql);


    // TODO add back amount


    // TODO remove items from production plan?
    $sql = "UPDATE production_plan SET status = 'CANCELLED' WHERE order_id = $order_id AND status = 'PENDING'";
    $res = safe_query($conn, $sql);


    $conn->commit();
    echo json_encode($response);
}
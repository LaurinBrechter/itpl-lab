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
    $sql = "SELECT * FROM storage_logs WHERE order_id = $order_id AND detail = 'RESERVED'";
    $res = safe_query($conn, $sql);
    while ($row = $res->fetch_assoc()) {
        $product_id = $row["product_id"];
        $amount = $row["amount"];
        $sql = "UPDATE products SET storage_amount = storage_amount + $amount WHERE id = $product_id";
        safe_query($conn, $sql);
    }


    // TODO remove items from production plan?
    $sql = "UPDATE production_plan SET status = 'CANCELLED' WHERE order_id = $order_id AND (status = 'PENDING' OR status = 'IN_PROGRESS')";
    $res = safe_query($conn, $sql);


    $conn->commit();
    echo json_encode($response);
}
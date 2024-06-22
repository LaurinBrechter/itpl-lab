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
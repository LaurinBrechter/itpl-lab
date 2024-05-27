<?php

include $_SERVER['DOCUMENT_ROOT'] . '/server/database.php';
include $_SERVER['DOCUMENT_ROOT'] . '/server/send-message.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // request body: {"items": [{"amount":"20","productId":"1","productName":"Premium Smartphone"}], "sp_id": 1, "customer_id": 1}

    // when requesting via postman
    $requestBody = file_get_contents('php://input');
    $data = json_decode($requestBody, true);

    // when requesting through the browser
    if (!$data) {
        $data = $_POST;
    }


    $items = $data["items"];
    $sql_order_items = "INSERT INTO order_items (order_id, product_id, amount) VALUES ";
    foreach ($items as $item) {
        $productId = $item['productId'];
        $amount = $item['amount'];
        $sql_order_items .= "(LAST_INSERT_ID(), $productId, $amount), ";
    }
    $sql_order_items = rtrim($sql_order_items, ", ");

    $sp_id = $data['sp_id'];
    $customer_id = $data['customer_id'];

    $customer = $conn->query("SELECT * FROM customers WHERE id = $customer_id;");
    $customer = $customer->fetch_assoc();


    // return 404 if customer not found
    if (!$customer) {
        http_response_code(404);
        echo '{"success": false, "msg": "Customer not found"}';
        exit();
    }

    if ($customer["isVip"] == 1) {
        $priority = "HIGH";
    } else {
        $priority = "MEDIUM";
    }



    $sql = "
    START TRANSACTION;
    INSERT INO orders (sp_id, status, customer_id, priority) 
    VALUES ($sp_id, 'PENDING', $customer_id, '$priority');
    SET @order_id = LAST_INSERT_ID();
    $sql_order_items;
    COMMIT;";

    // echo $sql;


    $res = $conn->multi_query($sql);




    // Fetch all results of the multi-query
    do {
        if ($result = $conn->store_result()) {
            // if (!$result) {
            //     http_response_code(500);
            //     echo "Couldn't create order";
            // }
            $result->free();
        }
    } while
    (
        // $conn->more_results() &&
        $conn->next_result()
    );

    exit(0);


    if ($conn->affected_rows === -1) {
        echo "Error: " . $conn->error;
    } else {
        $order_id_query = "SELECT @order_id as order_id";
        $order_id_result = $conn->query($order_id_query);
        $order_id_row = $order_id_result->fetch_assoc();
        $order_id = $order_id_row['order_id'];

        print_r($order_id);
    }


    $production_plan_sql = "with oi as (
        select * from order_items where order_id = $order_id
    ),
    product_storage as (
        select oi.order_id, oi.product_id, oi.amount, p.storage_amount, p.storage_amount - oi.amount as new_amount
        from oi
        left join test_db.products p on oi.product_id = p.id
    )
    select 
        if(ps.new_amount >= 0, ps.amount, ps.storage_amount) as to_send, -- Adjust this line as needed
        case 
            when ps.new_amount - 10 >= 0 then 0
            when ps.new_amount <= 10 and ps.new_amount >= 0 then 10 - ps.new_amount + 5
            when ps.new_amount < 0 then 10 + 5
        end as to_produce_store,
        if(ps.new_amount < 0, abs(ps.new_amount), 0) as to_produce_cust,
        ps.*
    from product_storage ps";

    $production_plan = $conn->query($production_plan_sql);

    // check if query went through



    // echo json_encode($production_plan->fetch_all(MYSQLI_ASSOC));
    // print_r($production_plan_sql);
    // exit(0);

    $isStorageOrder = false;
    $isProductionOrder = false;
    foreach ($production_plan as $row) {
        $to_send = $row['to_send'];
        $to_produce_store = $row['to_produce_store'];
        $to_produce_cust = $row['to_produce_cust'];
        $product_id = $row['product_id'];
        $order_id = $row['order_id'];

        if ($to_send > 0) {
            // reduce the official storage amount
            // TODO needs to be added back if e.g. the order is cancelled
            $conn->query("UPDATE products SET storage_amount = storage_amount - $to_send WHERE id = $product_id");

            // reserve the amount in the storage
            $conn->query("INSERT INTO storage_logs (product_id, storage_id, order_id, amount, detail) 
            VALUES ($product_id, 1, $order_id, -$to_send, 'RESERVED')
            ");
        }
        if ($to_produce_store > 0) {
            $conn->query("INSERT INTO 
            production_plan (product_id, amount, order_id, status, priority, target) 
            VALUES ($product_id, $to_produce_store, $order_id, 'PENDING', 'LOW', 'STORAGE')");
            $isProductionOrder = true;
        }
        if ($to_produce_cust > 0) {
            $conn->query("INSERT INTO 
            production_plan (product_id, amount, order_id, status, priority, target) 
            VALUES ($product_id, $to_produce_cust, $order_id, 'PENDING', 'MEDIUM', 'CUSTOMER')");
            $isProductionOrder = true;
        }
    }

    if ($isProductionOrder) {
        sendMsg('{"success": true, "data": "Order placed and production planned"}');
    }
}
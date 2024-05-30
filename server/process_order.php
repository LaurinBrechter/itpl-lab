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
        exit(1);
    }

    if ($customer["isVip"] == 1) {
        $priority = "HIGH";
    } else {
        $priority = "MEDIUM";
    }



    $sql = "
    START TRANSACTION;
    INSERT INTO orders (sp_id, status, customer_id, priority) 
    VALUES ($sp_id, 'PENDING', $customer_id, '$priority');
    SET @order_id = LAST_INSERT_ID();
    $sql_order_items;
    COMMIT;";

    // echo $sql;


    $res = $conn->multi_query($sql);

    while ($conn->next_result()) {
        ;
    } // flush multi_queries


    if ($conn->affected_rows === -1) {
        echo "Error: " . $conn->error;
        exit(1);
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
        if(ps.new_amount >= 0, ps.amount, ps.storage_amount) as to_send,
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
    if (!$production_plan) {
        echo "Error: " . $conn->error;
        exit(1);
    }



    // echo json_encode($production_plan->fetch_all(MYSQLI_ASSOC));
    // print_r($production_plan_sql);
    // exit(0);

    $isStorageOrder = false;
    $isProductionOrder = false;

    // loop through the production plan, each iteration is one order_item/product
    foreach ($production_plan as $row) {
        $to_send = $row['to_send']; // what to send to the customer
        $to_produce_store = $row['to_produce_store']; // what to produce for the storage
        $to_produce_cust = $row['to_produce_cust']; // what to produce for the customer -> higher prio
        $product_id = $row['product_id'];
        $order_id = $row['order_id'];

        if ($to_send > 0) {
            // reduce the official storage amount
            // TODO needs to be added back if e.g. the order is cancelled
            $conn->query("UPDATE products SET storage_amount = storage_amount - $to_send WHERE id = $product_id");


            // figure out from which storage facility we can take the product from
            // note that at this point we already know that facility storage will be enough to cover the demand
            $facility_storage = $conn->query("select storage_id, sum(amount) as total_amount, product_id  
            from storage_logs sl
            where product_id = $product_id
            group by storage_id, product_id
            having sum(amount) > 0
            ");

            // reserve the amount in the storage facilities until the amount we need is reached.
            foreach ($facility_storage as $row) {
                $storage_id_rand = $row['storage_id'];
                $amount = $row['total_amount'];
                $conn->query("INSERT INTO storage_logs (product_id, storage_id, order_id, amount, detail) 
                VALUES ($product_id, $storage_id_rand, $order_id, -$to_send, 'RESERVED')
                ");
                $to_send -= $amount;
                if ($to_send <= 0) {
                    break;
                }
            }

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
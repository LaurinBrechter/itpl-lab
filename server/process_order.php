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
include $_SERVER['DOCUMENT_ROOT'] . '/server/send-message.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $conn->autocommit(FALSE);

    // when requesting via postman
    $requestBody = file_get_contents('php://input');
    $data = json_decode($requestBody, true);

    // when requesting through the browser
    if (!$data) {
        $data = $_POST;
    }

    // request body: {"items": [{"amount":"10","productId":"7"}], "sp_id": 1, "customer_id": 1}

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


    $conn->begin_transaction();

    $sql = "
    INSERT INTO orders (sp_id, status, customer_id, priority) 
    VALUES ($sp_id, 'PENDING', $customer_id, '$priority');
    SET @order_id = LAST_INSERT_ID();
    $sql_order_items;";


    $res = $conn->multi_query($sql);

    while ($conn->next_result()) {
        ;
        // if (!$conn->store_result()) {
        //     echo '{"success": false, "msg":' . $conn->error . '}';
        //     $conn->rollback();
        //     exit(1);
        // }
    } // flush multi_queries


    if ($conn->affected_rows === -1) {
        echo "Error: " . $conn->error;
        $conn->rollback();
        exit(1);
    } else {
        $order_id_query = "SELECT @order_id as order_id";
        $order_id_result = $conn->query($order_id_query);
        $order_id_row = $order_id_result->fetch_assoc();
        $order_id = $order_id_row['order_id'];
    }


    $production_plan_sql = "with oi as (
        select * from order_items where order_id = $order_id
    ),
    product_storage as (
        select 
            oi.order_id, 
            oi.product_id, 
            oi.amount, 
            p.storage_amount, 
            p.storage_amount - oi.amount as new_amount,
            p.production_duration
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

    $production_plan = safe_query($conn, $production_plan_sql);


    $isStorageOrder = false;
    $isProductionOrder = false;

    // get the total current workload in hours of the facilities
    $total_workload = safe_query($conn, "with workload as (
        select
            pp.amount * p.production_duration as production_duration,
            facility_id 
        from production_plan pp 
        left join products p 
        on pp.product_id = p.id
    ),
    workload_grouped as (
    select sum(production_duration) as total_current_workload, 
    facility_id  from workload group by facility_id
    )
    select COALESCE(total_current_workload, 0) as total_current_workload, 
    pf.id as facility_id from workload_grouped wg
    right join production_facilities pf on wg.facility_id = pf.id");


    $total_workload_arr = [];
    while ($row = $total_workload->fetch_assoc()) {
        $total_workload_arr[] = $row;
    }

    // get the facility with the least workload
    function argmin_workload($data)
    {
        $min_workload = PHP_INT_MAX;
        $min_facility_id = null;
        $idx = null;

        foreach ($data as $row) {
            if ($row['total_current_workload'] < $min_workload) {
                $min_workload = $row['total_current_workload'];
                $min_facility_id = $row['facility_id'];
                $idx = array_search($row, $data);
            }
        }

        return [$min_facility_id, $idx];

    }

    // loop through the production plan, each iteration is one order_item/product
    foreach ($production_plan as $row) {
        $to_send = $row['to_send']; // what to send to the customer
        $to_produce_store = $row['to_produce_store']; // what to produce for the storage
        $to_produce_cust = $row['to_produce_cust']; // what to produce for the customer -> higher prio
        $product_id = $row['product_id'];
        $order_id = $row['order_id'];

        if ($to_send > 0) {
            $sql = "UPDATE 
                products SET storage_amount = storage_amount - $to_send 
                WHERE id = $product_id";

            safe_query($conn, $sql);

            // figure out from which storage facility we can take the product from
            // note that at this point we already know that facility storage will be enough to cover the demand
            $facility_storage = safe_query($conn, "select storage_id, sum(amount) as total_amount, product_id  
            from storage_logs sl
            where product_id = $product_id
            group by storage_id, product_id
            having sum(amount) > 0
            ");

            // reserve the amount in the storage facilities until the amount we need is reached.
            foreach ($facility_storage as $row) {
                $storage_id = $row['storage_id'];
                $amount = min($to_send, $row['total_amount']);
                safe_query($conn, "INSERT INTO storage_logs (product_id, storage_id, order_id, amount, detail) 
                VALUES ($product_id, $storage_id, $order_id, -$to_send, 'RESERVED')
                ");
                $to_send -= $amount;
                if ($to_send <= 0) {
                    break;
                }
            }
        }

        if ($to_produce_store > 0 || $to_produce_cust > 0) {
            // figure out the facility that has the least workload
            [$min_facility_id, $idx] = argmin_workload($total_workload_arr);
            $isProductionOrder = true;

            // storage production gets low prio
            if ($to_produce_store > 0) {
                $priority_production = "LOW";
                $detail = "STORAGE";
                $production_amount = $to_produce_store;
            }

            // customer production gets high or medium prio depending on customer's vip status
            if ($to_produce_cust > 0) {
                $priority_production = $priority;
                $detail = "CUSTOMER";
                $production_amount = $to_produce_cust;
            }

            $sql = "INSERT INTO 
            production_plan (product_id, amount, order_id, status, priority, target, facility_id) 
            VALUES ($product_id, $production_amount, $order_id, 'PENDING', 
            '$priority_production', '$detail', $min_facility_id)";

            $res = safe_query($conn, $sql);

            // only reachable if the query doesn't fail.
            $total_workload_arr[$idx]['total_current_workload'] += $row["production_duration"];
        }
    }

    // send a websocket event such that the production facility can update its view
    // if ($isProductionOrder) {
    //     sendMsg('{"success": true, "data": "Order placed and production planned"' . $order_id . '}');
    // }

    echo '{"success": true, "msg": "Order placed and production planned", "order_id": ' . $order_id . '}';
    $conn->commit();

}
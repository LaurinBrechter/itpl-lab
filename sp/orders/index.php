<?php
$title = "Catalog";
$req_jquery = true;
include $_SERVER['DOCUMENT_ROOT'] . '/server/document_head.php';
?>


<body>
    <?php
    include $_SERVER['DOCUMENT_ROOT'] . '/server/database.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/server/decode_jwt.php';

    $payload = getJwtPayload($_COOKIE["jwt"], ['SERVICE_PARTNER']);

    $user_id = $payload->user_id;
    $sp = $conn->query("SELECT * FROM service_partners WHERE user_id = $user_id;")->fetch_assoc();
    $sp_id = $sp['id'];
    $username = $sp["name"];

    include $_SERVER['DOCUMENT_ROOT'] . '/sp/sp_navbar.php';

    if ($sp_id == null) {
        echo "No service partner found for user_id $user_id";
        exit();
    }


    // TODO filter for sp_id in orders table
    $order_items = $conn->query("SELECT 
    oi.order_id,
    o.created_at,
    o.status,
    oi.amount,
    oi.product_id,
    p.name as name
    FROM 
    orders o
    left join order_items oi on o.id = oi.order_id
    left join products p on oi.product_id = p.id
    where o.sp_id = $sp_id
    order by o.id desc
    ;");

    ?>

    <h1>Orders</h1>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Order Id</th>
                    <th>Product name</th>
                    <th>Order Date</th>
                    <th>Est. Delivery</th>
                    <th>Status</th>
                    <th>Amount</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($order_items->num_rows > 0) {
                    $current_order_id = null;
                    while ($row = $order_items->fetch_assoc()) {
                        if ($row['order_id'] !== $current_order_id) {
                            if ($current_order_id !== null) {
                                echo "<tr><td colspan='5'></td></tr>";
                            }
                        }
                        echo "<tr>";
                        echo "<td>" . $row['order_id'] . "</td>";
                        echo "<td>" . $row['name'] . "</td>";
                        echo "<td>" . $row['created_at'] . "</td>";
                        echo "<td>" . $row['est_delivery'] . "</td>";
                        echo "<td>" . $row['status'] . "</td>";
                        echo "<td>" . $row['amount'] . "</td>";
                        if ($row["status"] == "PENDING") {
                            echo "<td><button onclick='cancelOrder(" . $row["order_id"] . ")'>Cancel</button></td>";
                        }
                        echo "</tr>";
                        $current_order_id = $row['order_id'];
                    }
                } else {
                    echo "<tr><td colspan='5'>No orders found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

</body>

<script>
    function cancelOrder(order_id) {
        console.log("Cancelling order with id", order_id);
        $.post('/server/cancel_order.php', {
            id: order_id
        }, function (data) {
            res = JSON.parse(data);

            if (res.success) {
                alert("Order Cancelled");
                location.reload();
            } else {
                alert("Failed to cancel order.");
            }
        });
    }
</script>

</html>
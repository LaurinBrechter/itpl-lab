<?php
$title = "Catalog";
$req_jquery = false;
include $_SERVER['DOCUMENT_ROOT'] . '/server/document_head.php';
?>


<body>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/sp/sp_navbar.php'; ?>

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/server/database.php';

    // TODO filter for sp_id in orders table
    $order_items = $conn->query("SELECT 
    oi.order_id,
    o.created_at,
    o.status,
    oi.amount,
    oi.product_id 
    FROM 
    orders o
    left join order_items oi on o.id = oi.order_id;");

    ?>

    <h1>Orders</h1>
    <table>
        <thead>
            <tr>
                <th>Order Id</th>
                <th>Order Date</th>
                <th>Est. Delivery</th>
                <th>Status</th>
                <th>Amount</th>
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
                    echo "<td>" . $row['created_at'] . "</td>";
                    echo "<td>" . $row['est_delivery'] . "</td>";
                    echo "<td>" . $row['status'] . "</td>";
                    echo "<td>" . $row['amount'] . "</td>";
                    echo "</tr>";
                    $current_order_id = $row['order_id'];
                    // echo "<tr>";
                    // echo "<td colspan='5'>" . $row['item_name'] . "</td>";
                    // echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No orders found</td></tr>";
            }
            ?>
        </tbody>
    </table>

</body>

</html>
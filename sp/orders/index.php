<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders</title>
    <style>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/style.css'; ?>
    </style>
</head>

<body>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/sp/sp_navbar.php'; ?>

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/database.php';

    // TODO filter for sp_id in orders table
    $orders = $conn->query("SELECT * FROM test_db.orders;");

    ?>

    <h1>Orders</h1>
    <table>
        <thead>
            <tr>
                <th>Order Id</th>
                <th>Order Date</th>
                <th>Est. Delivery</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($orders->num_rows > 0) {
                while ($row = $orders->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['created_at'] . "</td>";
                    echo "<td>" . $row['est_delivery'] . "</td>";
                    echo "<td>" . $row['status'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No orders found</td></tr>";
            }
            ?>

</body>

</html>
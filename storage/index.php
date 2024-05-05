<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/style.css'; ?>
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>



<body>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/sp/sp_navbar.php'; ?>
    <?php

    include $_SERVER['DOCUMENT_ROOT'] . '/database.php';
    $sql = "INSERT INTO storage_logs (product_id, storage_id, order_id, amount) VALUES (1, 1, 1, 10);";

    $request_uri = $_SERVER['REQUEST_URI'];

    // Remove any query parameters
    $url_parts = explode('?', $request_uri);
    $url = rtrim($url_parts[0], '/');

    // Split the URL into segments
    $segments = explode('/', $url);

    // The first segment is usually the controller or resource
    $controller = !empty($segments[0]) ? $segments[0] : 'home';

    // The second segment might be the action or an identifier
    $action_or_id = !empty($segments[1]) ? $segments[1] : '';

    // check for post request
    
    $sql = "SELECT * FROM test_db.storage_logs;";
    $result = $conn->query($sql);





    ?>
    <h3>Storage Movement</h3>
    <!-- <form id="storage_movement_form" onsubmit="event.preventDefault();"> -->
    <form id="storage_movement_form">
        <input type="hidden" name="storage_id" value="<?php echo $segments[2] ?>">
        <label for="order-id">order-id</label>
        <select id="order-id" name="order_id">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
        </select>
        <label for="sku">SKU</label>
        <select id="sku" name="product_id">
            <option value="1">SKU001</option>
            <option value="2">SKU002</option>
            <option value="3">SKU003</option>
        </select>
        <label for="quantity">Quantity</label>
        <input type="number" id="quantity" name="amount" required>
        <button type="submit">Move</button>
        <!-- <input type="submit" value="" id="submit" name="submit"> -->
    </form>
    <!-- <p style="display: none;" id="notification">Thank You!</p> -->
    <?php
    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>product_id</th>";
        echo "<th>order_id</th>";
        echo "<th>amount</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["product_id"] . "</td>";
            echo "<td>" . $row["order_id"] . "</td>";
            echo "<td>" . $row["amount"] . "</td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
    }
    ?>
    <h3>Open Orders</h3>
    <table>
        <thead>
            <tr>
                <th>Order Id</th>
                <th>SKU</th>
                <th>Quantity</th>
                <th>Destination</th>
                <th>Order Date</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td rowspan="2">1</td>
                <td>1</td>
                <td>100</td>
                <td rowspan="2">Dortmunder Str. 3</td>
                <td rowspan="2">2021-01-01</td>
            </tr>
            <tr>
                <td>10</td>
                <td>30</td>
            </tr>

            <tr>
                <td rowspan="2">2</td>
                <td>1</td>
                <td>100</td>
                <td rowspan="2">Dortmunder Str. 10</td>
                <td rowspan="2">2021-01-01</td>
            </tr>
            <tr>
                <td>10</td>
                <td>30</td>
            </tr>
        </tbody>

</body>

<script>
    $('#storage_movement_form').submit(function () {
        var post_data = $('#storage_movement_form').serialize();
        $.post('/server/insert_storage_movement.php', post_data, function (data) {
            // $('#notification').show();
        });
    });
</script>

</html>
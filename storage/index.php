<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Storage</title>
    <style>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/style.css'; ?>
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<body>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/storage/storage_navbar.php'; ?>
    <?php

    include $_SERVER['DOCUMENT_ROOT'] . '/database.php';

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
    
    $storage_logs = $conn->query(
        "
        SELECT 
            p.name, 
            sl.id,
            sl.order_id, 
            sl.amount, 
            sl.product_id, 
            sl.detail, 
            sl.created_at,
            CONCAT(a.street, ', ', a.house_number, ', ', a.city, ', ', a.zip, ', ', a.country) as address 
        FROM (   
            SELECT * 
            FROM test_db.storage_logs 
            where storage_id = $segments[2] ) as sl
        left join products p on sl.product_id = p.id
        left join orders o on sl.order_id = o.id
        left join customers c on o.customer_id = c.id
        left join addresses a on c.address_id = a.id
        order by sl.detail asc, sl.created_at asc;
    "
    );

    $products = $conn->query("SELECT * FROM test_db.products;");
    $orders = $conn->query("SELECT * FROM test_db.orders;");


    ?>

    <!-- <form id="storage_movement_form" onsubmit="event.preventDefault();"> -->
    <!-- <?php echo $segments[2] ?> -->
    <form id="storage_movement_form" onsubmit="event.preventDefault()">
        <h3>Storage Movement</h3>
        <input type="hidden" name="storage_id" value="<?php echo $segments[2] ?>">
        <label for="order-id">order-id</label>
        <select id="order-id" name="order_id">
            <?php
            if ($orders->num_rows > 0) {
                while ($row = $orders->fetch_assoc()) {
                    echo "<option value='" . $row["id"] . "'>" . $row["id"] . "</option>";
                }
            }
            ?>
        </select>
        <label for="sku">SKU</label>
        <select id="sku" name="product_id">
            <?php
            if ($products->num_rows > 0) {
                while ($row = $products->fetch_assoc()) {
                    echo "<option value='" . $row["id"] . "'>" . $row["name"] . "</option>";
                }
            }
            ?>
        </select>
        <label for="quantity">Quantity</label>
        <input type="number" id="quantity" name="amount" required>
        <button type="submit">Move</button>
        <!-- <input type="submit" value="" id="submit" name="submit"> -->
    </form>
    <!-- <p style="display: none;" id="notification">Thank You!</p> -->
    <div class="table-container">
        <?php
        if ($storage_logs->num_rows > 0) {
            echo "<table class='storage-movement-table'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>Product Name</th>";
            echo "<th>Created At</th>";
            echo "<th>Order Id</th>";
            echo "<th>amount</th>";
            echo "<th>Destination</th>";
            echo "<th>Details</th>";
            echo "<th>Action</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            while ($row = $storage_logs->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["name"] . "</td>";
                echo "<td>" . $row["created_at"] . "</td>";
                echo "<td>" . $row["order_id"] . "</td>";
                echo "<td>";
                if ($row["amount"] > 0) {
                    echo "IN " . $row["amount"];
                } elseif ($row["amount"] < 0) {
                    echo "OUT " . abs($row["amount"]);
                } else {
                    echo $row["amount"];
                }
                echo "</td>";
                echo "<td>" . $row["address"] . "</td>";
                echo "<td>" . $row["detail"] . "</td>";
                if ($row["detail"] == "RESERVED") {
                    echo "<td><button onclick=\"confirmShipment(" . $row["id"] . ")\">Confirm Shipment</button></td>";
                } else {
                    echo "<td></td>";
                }
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
        }
        ?>
    </div>
</body>
<!-- https://stackoverflow.com/questions/6806028/post-without-redirect-with-php -->
<script>
    $('#storage_movement_form').submit(function () {
        var post_data = $('#storage_movement_form').serialize();
        $.post('/server/insert_storage_movement.php', post_data, function (data) {
            // $('#notification').show();
            console.log(data);
            // reload the page
            location.reload();
        });
    });

    function confirmShipment(id) {

        console.log(id);

        $.post('/server/confirm_shipment.php', {
            id: id
        }, function (data) {

            // read json
            res = JSON.parse(data);

            console.log(data);
            if (res.success) {
                alert("Shipment confirmed");
                location.reload();
            } else {
                alert("Failed to confirm shipment");
            }
        });
    }

</script>

</html>
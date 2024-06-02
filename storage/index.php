<?php
$title = "Storage";
$req_jquery = true;
include $_SERVER['DOCUMENT_ROOT'] . '/server/document_head.php';
?>

<body>
    <?php

    // include $_SERVER['DOCUMENT_ROOT'] . '/server/notification.php';
    // renderNotification("Thank You!", "success")
    ?>



    <?php

    include $_SERVER['DOCUMENT_ROOT'] . '/server/database.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/server/decode_jwt.php';

    $payload = getJwtPayload($_COOKIE["jwt"], ['STORAGE']);
    $sql = "select * from storage_facilities where user_id = $payload->user_id;";
    $storage_id = $conn->query("select * from storage_facilities where user_id = $payload->user_id;")->fetch_assoc()["id"];
    include $_SERVER['DOCUMENT_ROOT'] . '/storage/storage_navbar.php';

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
            FROM storage_logs 
            where storage_id = $storage_id ) as sl
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
    <!-- <?php echo $storage_id ?> -->
    <form id="storage_movement_form" onsubmit="event.preventDefault()">
        <h3>Storage Movement</h3>
        <input type="hidden" name="storage_id" value="<?php echo $storage_id ?>">
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
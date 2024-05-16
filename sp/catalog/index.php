<?php
$title = "Catalog";
$req_jquery = false;
include $_SERVER['DOCUMENT_ROOT'] . '/document_head.php';
?>


<body>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/sp/sp_navbar.php'; ?>
    <form>
        <label for="sku">Search for a Product</label>
        <input type="text" id="sku-search" name="sku">
        <button type="submit">Search</button>
    </form>
    <?php

    include $_SERVER['DOCUMENT_ROOT'] . '/database.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/decode_jwt.php';

    $payload = getJwtPayload($_COOKIE["jwt"], 'SERVICE_PARTNER');

    ?>
    <div class="table-container">
        <?php



        $search_term = $_GET["sku"];

        if (empty($search_term)) {
            $sql = "SELECT * FROM test_db.products;";
        } else {
            $sql = "SELECT * FROM test_db.products where name like '%$search_term%';";
        }

        // echo $sql;
        
        $storage_logs = $conn->query($sql);

        if ($storage_logs->num_rows > 0) {
            echo "<table class='catalog-table'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>Name</th>";
            echo "<th>Price</th>";
            echo "<th>Quantity Available</th>";
            // echo "<th>Order</th>";
            echo "<th>Est. Delivery</th>";
            echo "<th>Details</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            while ($row = $storage_logs->fetch_assoc()) {
                $sku = $row["id"];

                echo "<tr>";
                echo "<td>" . $row["name"] . "</td>";
                echo "<td>" . $row["price"] . "€</td>";
                echo "<td>" . $row["storage_amount"] . "</td>";
                // echo "<td>TODO</td>";
                // echo "<td>";
                // echo "<input type='number' id='quantity' name='quantity'>";
                // echo "</td>";
                echo "<td>1 week</td>";
                echo "<td><a href='/sp/catalog/product?id=$sku'>Details</a></td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
        } else {
            echo "0 results";
        }

        ?>
    </div>
    <!-- <form>
        <label for="sku">SKU</label>
        <input type="text" id="sku" name="sku">
        <label for="quantity">Quantity</label>
        <input type="number" id="quantity" name="quantity">
        <button type="submit">Order</button>
    </form> -->
</body>

</html>
<?php
include $_SERVER['DOCUMENT_ROOT'] . '/document_head.php';
?>


<body>
    <?php

    include $_SERVER['DOCUMENT_ROOT'] . '/sp/sp_navbar.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/database.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/decode_jwt.php';

    $payload = getJwtPayload($_COOKIE["jwt"], 'SERVICE_PARTNER');


    // $jwt = $_COOKIE["jwt"];
    
    // if (empty($jwt)) {
    //     header("Location: /login");
    // }
    
    // // decode jwt
    // $jwt = explode(".", $jwt);
    // $payload = base64_decode($jwt[1]);
    // $payload = json_decode($payload);
    // if (isset($payload->role)) {
    //     $role = $payload->role;
    // } else {
    //     header("Location: /login");
    //     // handle the invalid JWT or missing 'sp_id' key scenario
    // }
    
    // $sql = "SELECT * FROM service_partners where id = $sp_id;";
    // $result = $conn->query($sql);
    // if ($result->num_rows > 0) {
    //     $row = $result->fetch_assoc();
    // } else {
    //     echo "0 results";
    // }
    

    echo '<form>
        <label for="sku">Search for a Product</label>
        <input type="text" id="sku-search" name="sku">
        <button type="submit">Search</button>
        <div>Welcome, ' . "TODO" . '</div>
    </form>';
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
            echo "<th>name</th>";
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
                echo "<td><a href='/sp/catalog/product/$sku'>Details</a></td>";
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
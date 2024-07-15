<?php
$title = "Catalog";
$req_jquery = false;
include $_SERVER['DOCUMENT_ROOT'] . '/server/document_head.php';
?>


<body>

    <?php
    include $_SERVER['DOCUMENT_ROOT'] . '/server/database.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/server/decode_jwt.php';
    $categories = $conn->query("select distinct category from test_db.products;");
    $payload = getJwtPayload($_COOKIE["jwt"], ['SERVICE_PARTNER', 'MANAGEMENT']);
    $user_id = $payload->user_id;
    if ($payload->role == 'SERVICE_PARTNER') {
        include $_SERVER['DOCUMENT_ROOT'] . '/sp/sp_navbar.php';
    } else {
        include $_SERVER['DOCUMENT_ROOT'] . '/management/mgmt_navbar.php';
    }
    ?>
    <form>
        <select name="category" id="category">
            <option value="">All Categories</option>
            <?php
            while ($row = $categories->fetch_assoc()) {
                echo "<option value='" . $row["category"] . "'>" . $row["category"] . "</option>";
            }
            ?>
        </select>
        <label for="sku">Search for a Product</label>
        <input type="text" id="sku-search" name="sku">
        <button type="submit">Search</button>
    </form>
    <div class="page-container">
        <div class="table-container">
            <?php
            $search_term = $_GET["sku"] ?? null;
            $category = $_GET["category"] ?? null;

            $sql = "SELECT * FROM test_db.products where true";

            if (!empty($search_term)) {
                $sql .= " AND name like '%$search_term%'";
            }
            if (!empty($category)) {
                $sql .= " AND category = '$category'";
            }

            $sql .= ";";

            $products = $conn->query($sql);

            if ($products->num_rows > 0) {
                echo "<table class='catalog-table'>";
                echo "<thead>";
                echo "<tr>";
                echo "<th>Name</th>";
                echo "<th>Category</th>";
                echo "<th>Price</th>";
                echo "<th>Quantity Available</th>";
                // echo "<th>Order</th>";
                echo "<th>Est. Delivery</th>";
                echo "<th>Details</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
                while ($row = $products->fetch_assoc()) {
                    $sku = $row["id"];

                    echo "<tr>";
                    echo "<td>" . $row["name"] . "</td>";
                    echo "<td>" . $row["category"] . "</td>";
                    echo "<td>" . $row["price"] . "€</td>";
                    if ($row["storage_amount"] == 0) {
                        echo "<td class='cell-warning'>" . $row["storage_amount"] . "</td>";
                    } else {
                        echo "<td>" . $row["storage_amount"] . "</td>";
                    }
                    if ($row["storage_amount"] == 0) {
                        echo "<td>" .$row['production_duration'] .  " days</td>";
                    } else {
                        echo "<td>3 days</td>";
                    }
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
    </div>
</body>

</html>
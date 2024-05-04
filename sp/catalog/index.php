<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalogue</title>
    <style>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/style.css'; ?>
    </style>
</head>

<body>
    <nav>
        <ul class="navbar">
            <h1>Service Partner</h1>
            <div class="navitems">
                <div><a href="/sp/orders/index.php">Orders</a></div>
                <div><a href="/sp/catalog/index.php">Catalog</a></div>
            </div>
        </ul>
    </nav>

    <form>
        <label for="sku">sku</label>
        <input type="text" id="sku-search" name="sku">
        <button type="submit">Search</button>
    </form>

    <div class="table-container">
        <?php

        include $_SERVER['DOCUMENT_ROOT'] . '/database.php';

        $search_term = $_GET["sku"];

        if (empty($search_term)) {
            $sql = "SELECT * FROM test_db.products;";
        } else {
            $sql = "SELECT * FROM test_db.products where name = '$search_term';";
        }

        echo $sql;

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>name</th>";
            echo "<th>Price</th>";
            echo "<th>Quantity Available</th>";
            echo "<th>Order</th>";
            echo "<th>Est. Delivery</th>";
            echo "<th>Details</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            while ($row = $result->fetch_assoc()) {
                $sku = $row["id"];

                echo "<tr>";
                echo "<td>" . $row["name"] . "</td>";
                echo "<td>" . $row["price"] . "</td>";
                echo "<td>" . $row["storage_amount"] . "</td>";
                echo "<td>TODO</td>";
                echo "<td>";
                echo "<input type='number' id='quantity' name='quantity'>";
                echo "</td>";
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
    <form>
        <!-- <label for="sku">SKU</label>
        <input type="text" id="sku" name="sku">
        <label for="quantity">Quantity</label>
        <input type="number" id="quantity" name="quantity"> -->
        <button type="submit">Order</button>
    </form>
</body>

</html>
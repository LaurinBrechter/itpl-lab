<?php
include $_SERVER['DOCUMENT_ROOT'] . '/server/document_head.php';
?>


<body>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/sp/sp_navbar.php'; ?>
    <?php

    include $_SERVER['DOCUMENT_ROOT'] . '/server/database.php';

    $payload = getJwtPayload($_COOKIE["jwt"], ['SERVICE_PARTNER', 'MANAGEMENT']);

    $product_id = $_GET["id"];
    $sql = "SELECT * FROM products WHERE id = $product_id;";

    // check if product_id is an int
    if (!is_numeric($product_id)) {
        echo "<div class='error-message'>";
        echo "<h1>Invalid product id</h1>";
        echo "<p>Product id must be a number</p>";
        echo "</div>";
        die();
    }

    $product = $conn->query($sql);
    $row = $product->fetch_assoc();

    // check for results
    if ($product->num_rows === 0) {
        echo "<div class='error-message'>";
        echo "<h1>Product not found</h1>";
        echo "<p>Product with id $product_id not found</p>";
        echo "</div>";
        die();
    }

    echo "<h1>" . $row['name'] . "</h1>";
    echo "<p>" . $row['description'] . "</p>";
    echo "<p>Price: $" . $row['price'] . "</p>";
    echo "<p>Quantity Available: " . $row['storage_amount'] . "</p>";
    echo "<p>Est. Delivery: 1 week</p>";

    ?>
    <img src="https://placehold.co/500x300">
    <form method="get" onsubmit="event.preventDefault(); saveToSessionStorage()">
        <input type="hidden" name="product_name" value="<?php echo $row['name']; ?>">
        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
        <input type="number" name="amount" placeholder="Amount" min="1" step="1">
        <button type="submit">Add to Cart</button>
    </form>

    <script>
        function saveToSessionStorage() {
            console.log('saving to session storage');
            var amount = document.querySelector('input[name="amount"]').value;
            var productId = document.querySelector('input[name="product_id"]').value;
            var productName = document.querySelector('input[name="product_name"]').value;
            var existingItems = JSON.parse(sessionStorage.getItem('items')) || [];
            var existingItem = existingItems.find(item => item.productId === productId);
            if (existingItem) {
                existingItem.amount = parseInt(existingItem.amount) + parseInt(amount);
            } else {
                var newItem = {
                    amount: amount,
                    productId: productId,
                    productName: productName
                };
                existingItems.push(newItem);
            }
            sessionStorage.setItem('items', JSON.stringify(existingItems));
            alert(`Added ${amount} of ${productName} to cart`);
        }
    </script>
</body>
</body>



</html>
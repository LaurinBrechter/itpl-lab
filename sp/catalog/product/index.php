<?php
include $_SERVER['DOCUMENT_ROOT'] . '/document_head.php';
?>


<body>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/sp/sp_navbar.php'; ?>
    <?php

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

    $product_id = $segments[4];

    include $_SERVER['DOCUMENT_ROOT'] . '/database.php';

    $sql = "SELECT * FROM products WHERE id = $product_id";

    $storage_logs = $conn->query($sql);
    $row = $storage_logs->fetch_assoc();

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
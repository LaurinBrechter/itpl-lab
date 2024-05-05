<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/style.css'; ?>
    </style>
</head>

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

    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    echo "<h1>" . $row['name'] . "</h1>";
    echo "<p>" . $row['description'] . "</p>";
    echo "<p>Price: $" . $row['price'] . "</p>";
    echo "<p>Quantity Available: " . $row['storage_amount'] . "</p>";
    echo "<p>Est. Delivery: 1 week</p>";

    ?>
    <img src="https://placehold.co/500x300">
    <form action="/sp/orders/create.php" method="post">
        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
        <button type="submit">Order</button>
    </form>

</body>

</html>
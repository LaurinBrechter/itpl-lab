<?php
$title = "Details";
$req_jquery = true;
include $_SERVER['DOCUMENT_ROOT'] . '/server/document_head.php';
?>

<body>
    <?php
    include $_SERVER['DOCUMENT_ROOT'] . '/server/decode_jwt.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/server/database.php';

    $payload = getJwtPayload($_COOKIE["jwt"], ['SERVICE_PARTNER', 'MANAGEMENT']);
    $role = $payload->role;
    if ($role == "SERVICE_PARTNER") {
        include $_SERVER['DOCUMENT_ROOT'] . '/sp/sp_navbar.php';
    } else {
        include $_SERVER['DOCUMENT_ROOT'] . '/management/mgmt_navbar.php';
    }
    $user_id = $payload->user_id;
    $product_id = $_GET["id"];
    $sql = "SELECT * FROM products WHERE id = $product_id;";

    if  ($role == "SERVICE_PARTNER") {
        $sp_id = $conn->query("SELECT * FROM service_partners WHERE user_id = $user_id;")->fetch_assoc()['id'];
    }

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
    ?>

    <div class="product-page">
        <div class="product-details">
            <?php
            echo "<h1>" . $row['name'] . "</h1>";
            echo "<p>" . $row['description'] . "</p>";
            echo "<p>Price: $" . $row['price'] . "</p>";
            echo "<p>Quantity Available: " . $row['storage_amount'] . "</p>";
            if ($row["storage_amount"] == 0) {
                echo "<p>" .$row['production_duration'] .  " days</p>";
            } else {
                echo "<p>3 days</p>";
            }
            echo "<img src='https://placehold.co/500x300' alt='Product Image'>";
            ?>
        </div>

        <form method="get" onsubmit="event.preventDefault(); add_to_cart()" class="add-to-cart-form">
            <input type="hidden" name="product_name" value="<?php echo $row['name']; ?>">
            <input type="hidden" name="price" value="<?php echo $row['price']; ?>">
            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
            <input type="hidden" id="sp-id" name="sp-id" value="<?php echo $sp_id ?>">
            <?php if ($payload->role != "MANAGEMENT") {
                echo '<input type="number" name="amount" placeholder="Amount" min="1" step="1" required>';
                echo '<button type="submit">Add to Cart</button>';
            } ?>
        </form>
    </div>

    <script>
        function add_to_cart() {
            console.log('saving to session storage');
            var amount = document.querySelector('input[name="amount"]').value;
            var productId = document.querySelector('input[name="product_id"]').value;
            var productName = document.querySelector('input[name="product_name"]').value;
            var price = document.querySelector('input[name="price"]').value;

            let req_body = {
                item: {
                    amount: amount,
                    productId: productId
                },
                sp_id: document.querySelector('input[name="sp-id"]').value
            }

            console.log(req_body);

            $.post('/server/add_to_cart.php', JSON.stringify(req_body), function(data) {
                data = JSON.parse(data);

                if (data.success === false) {
                    alert(data.msg);
                    return;
                } else if (data.success === true) {
                    alert('Added to cart');
                }
            });
        }
    </script>
</body>
</html>

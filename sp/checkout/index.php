<?php
$title = "Checkout";
$req_jquery = true;
include $_SERVER['DOCUMENT_ROOT'] . '/server/document_head.php';
?>


<body>
    <?php
    include $_SERVER['DOCUMENT_ROOT'] . '/server/decode_jwt.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/server/database.php';

    $payload = getJwtPayload($_COOKIE["jwt"], ['SERVICE_PARTNER']);
    include $_SERVER['DOCUMENT_ROOT'] . '/sp/sp_navbar.php';

    $user_id = $payload->user_id;
    $sp_id = $conn->query("SELECT * FROM service_partners WHERE user_id = $user_id;")->fetch_assoc()['id'];

    if ($sp_id == null) {
        echo "No service partner found for user_id $user_id";
        exit();
    }
    
    $basket = $conn->query("SELECT 
    
    oi.amount,
    p.price,
    oi.id as order_item_id,
    p.name as product_name

    FROM orders o
    JOIN order_items oi ON o.id = oi.order_id
    JOIN products p ON oi.product_id = p.id
    WHERE sp_id = $sp_id AND status = 'IN_BASKET';");

    ?>
    <h1>Checkout</h1>
    <?php if ($basket->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Amount</th>
                    <th>Unit Price</th>
                    <th>total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="checkout-items">
                <?php
                while ($row = $basket->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['product_name'] . "</td>";
                    echo "<td>" . $row['amount'] . "</td>";
                    echo "<td>" . $row['price'] . "$</td>";
                    echo "<td>" . $row['amount'] * $row['price'] . "$</td>";
                    echo '<td><button onclick="removeItem(' . $row['order_item_id'] . ')">Remove</button></td>';
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
        <form id="checkout-form" onsubmit="event.preventDefault()">
            <button id="buy-btn">Buy</button>
            <?php
            $customers = $conn->query("SELECT * FROM customers;");
            // select button for customer
            echo "<label for='customer-id'>Customer:</label>";
            echo "<select id='customer-id'>";
            while ($row = $customers->fetch_assoc()) {
                echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
            }
            echo "</select>";
            ?>
            <input type="hidden" id="sp-id" name="sp-id" value="<?php echo $sp_id ?>">
        </form>
        <div id="total-price"></div>
    <?php else: ?>
        <p>No items in the basket.</p>
    <?php endif; ?>

</body>

<script>
    function removeItem(order_item_id) {
        let req_body = {
                order_item_id: order_item_id
            }

            console.log(req_body);

            $.post('/server/remove_order_item.php', JSON.stringify(req_body), function(data) {
                data = JSON.parse(data);

                if (data.success === false) {
                    alert(data.msg);
                    return;
                } else if (data.success === true) {
                    alert("Item removed");
                    location.reload();
                }
            });
    }

</script>
<!-- <script>
    $('#buy-btn').click(function () {
        var existingItems = JSON.parse(sessionStorage.getItem('items')) || [];
        console.log("buying items", existingItems)

        req_body = {
            'items': existingItems,
            'sp_id': $("#sp-id").val(),
            'customer_id': $('#customer-id').val()
        }

        console.log(req_body)

        $.post('/server/process_order.php', req_body, function (data) {
            // $('#notification').show();
            console.log(data)

            data = JSON.parse(data); // Convert data from string to object

            if (data["success"] === true) {
                alert("Order successful");
                sessionStorage.setItem('items', JSON.stringify([]));
                renderItems();
            } else if (data["success"] === false) {
                alert("Order failed: " + data["msg"]);
            }
        });


    });
</script> -->

</html>
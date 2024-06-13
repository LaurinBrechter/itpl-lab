<?php
$title = "Checkout";
$req_jquery = true;
include $_SERVER['DOCUMENT_ROOT'] . '/server/document_head.php';
?>


<body>
    <?php
    include $_SERVER['DOCUMENT_ROOT'] . '/sp/sp_navbar.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/server/decode_jwt.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/server/database.php';

    $payload = getJwtPayload($_COOKIE["jwt"], ['SERVICE_PARTNER']);

    $user_id = $payload->user_id;
    echo $user_id;
    $sp_id = $conn->query("SELECT * FROM service_partners WHERE user_id = $user_id;")->fetch_assoc()['id'];

    if ($sp_id == null) {
        echo "No service partner found for user_id $user_id";
        exit();
    }
    ?>


    <h1>Checkout</h1>
    <table>
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Amount</th>
                <th>Unit Price</th>
            </tr>
        </thead>
        <tbody id="checkout-items">
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

</body>

<script>
    function removeItem(index) {
        var existingItems = JSON.parse(sessionStorage.getItem('items')) || [];
        existingItems.splice(index, 1);
        sessionStorage.setItem('items', JSON.stringify(existingItems));
        renderItems();
    }
    function renderItems() {
        total = 0
        var html = '';
        var existingItems = JSON.parse(sessionStorage.getItem('items')) || [];
        console.log(existingItems); // (2) [{amount: '20', productId: '1'}]
        for (var i = 0; i < existingItems.length; i++) {

            var item = existingItems[i];
            if (item) {
                console.log(item.amount, item.price)
                total += parseInt(item.amount) * parseFloat(item.price)
            }
            html += '<tr>';
            html += '<td>' + item.productName + '</td>';
            html += '<td>' + item.amount + '</td>';
            html += '<td>' + item.price + '</td>';
            html += '<td><button onclick="removeItem(' + i + ')">Remove</button></td>'
            html += '</tr>';
        }
        document.getElementById('checkout-items').innerHTML = html;
        document.getElementById("total-price").innerHTML = total
    }

    renderItems();





</script>

<script>
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
</script>

</html>
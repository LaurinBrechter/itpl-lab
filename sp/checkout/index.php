<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/style.css'; ?>
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<body>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/sp/sp_navbar.php'; ?>


    <h1>Checkout</h1>
    <table>
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody id="checkout-items">
        </tbody>
    </table>
    <button id="buy-btn">Buy</button>

</body>

<script>
    function removeItem(index) {
        var existingItems = JSON.parse(sessionStorage.getItem('items')) || [];
        existingItems.splice(index, 1);
        sessionStorage.setItem('items', JSON.stringify(existingItems));
        renderItems();
    }
    function renderItems() {

        var html = '';
        var existingItems = JSON.parse(sessionStorage.getItem('items')) || [];
        console.log(existingItems); // (2) [{amount: '20', productId: '1'}]
        for (var i = 0; i < existingItems.length; i++) {
            var item = existingItems[i];
            html += '<tr>';
            html += '<td>' + item.productName + '</td>';
            html += '<td>' + item.amount + '</td>';
            html += '<td><button onclick="removeItem(' + i + ')">Remove</button></td>'
            html += '</tr>';
        }
        document.getElementById('checkout-items').innerHTML = html;
    }

    renderItems();





</script>

<script>
    $('#buy-btn').click(function () {
        var existingItems = JSON.parse(sessionStorage.getItem('items')) || [];
        console.log("buying items", existingItems)

        $.post('/server/process_order.php', { 'items': JSON.stringify(existingItems) }, function (data) {
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
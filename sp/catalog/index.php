<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalogue</title>
    <style>
    <?php include 'style.css'; ?>
    </style>
</head>
<body>
    <h1>Service Partner</h1>
    <form>
        <label for="sku">sku</label>
        <input type="text" id="sku-search" name="sku">
        <button type="submit">Search</button>
    </form>
    
    <table>
        <thead>
            <tr>
                <th>SKU</th>
                <th>Price</th>
                <th>Quantity Available</th>
                <th>Order</th>
                <th>Est. Delivery</th>
                <th>Details</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>SKU001</td>
                <td>100</td>
                <td>10</td>
                <td>
                <select>
                    <option value="1">+1</option>
                    <option value="2">+2</option>
                    <option value="3">+3</option>
                </select>
                </td>
                <td>2021-01-01</td>
                <td><a href="details.php">Details</a></td>

            </tr>
            <tr>
                <td>SKU002</td>
                <td>200</td>
                <td>20</td>
                <td>
                <select>
                    <option value="1">+1</option>
                    <option value="2">+2</option>
                    <option value="3">+3</option>
                </select>
                </td>
                <td>2021-01-02</td>
                <td><a href="details.php">Details</a></td>
            </tr>
            <tr>
                <td>SKU003</td>
                <td>300</td>
                <td>30</td>
                <td>
                <select>
                    <option value="1">+1</option>
                    <option value="2">+2</option>
                    <option value="3">+3</option>
                </select>
                </td>
                <td>2021-01-03</td>
                <td><a href="details.php">Details</a></td>
            </tr>
    </table>
    <form>
        <!-- <label for="sku">SKU</label>
        <input type="text" id="sku" name="sku">
        <label for="quantity">Quantity</label>
        <input type="number" id="quantity" name="quantity"> -->
        <button type="submit">Order</button>
    </form>
</body>
</html>
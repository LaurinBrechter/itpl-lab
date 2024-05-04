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

    ?>
    <h1>Storage <?php echo $segments[2] ?></h1>
    <h3>Storage Movement</h3>
    <form>
        <label for="order-id">order-id</label>
        <select id="order-id" name="order-id">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
        </select>
        <label for="sku">SKU</label>
        <select id="sku" name="sku">
            <option value="1">SKU001</option>
            <option value="2">SKU002</option>
            <option value="3">SKU003</option>
        </select>
        <label for="quantity">Quantity</label>
        <input type="number" id="quantity" name="quantity">
        <button type="submit">Move</button>
    </form>
    <table>
        <thead>
            <tr>
                <th>SKU</th>
                <th>Quantity</th>
                <th>Timestamp</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>SKU001</td>
                <td>10</td>
                <td>2021-01-01</td>
            </tr>
            <tr>
                <td>SKU002</td>
                <td>20</td>
                <td>2021-01-02</td>
            </tr>
            <tr>
                <td>SKU003</td>
                <td>30</td>
                <td>2021-01-03</td>
            </tr>
        </tbody>
    </table>
    <h3>Open Orders</h3>
    <table>
        <thead>
            <tr>
                <th>Order Id</th>
                <th>SKU</th>
                <th>Quantity</th>
                <th>Destination</th>
                <th>Order Date</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td rowspan="2">1</td>
                <td>1</td>
                <td>100</td>
                <td rowspan="2">Dortmunder Str. 3</td>
                <td rowspan="2">2021-01-01</td>
            </tr>
            <tr>
                <td>10</td>
                <td>30</td>
            </tr>

            <tr>
                <td rowspan="2">2</td>
                <td>1</td>
                <td>100</td>
                <td rowspan="2">Dortmunder Str. 10</td>
                <td rowspan="2">2021-01-01</td>
            </tr>
            <tr>
                <td>10</td>
                <td>30</td>
            </tr>
        </tbody>

</body>

</html>
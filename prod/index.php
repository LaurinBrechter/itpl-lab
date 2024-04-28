<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Production</title>
    <style>
    <?php include 'style.css'; ?>
    </style>
</head>
<body>
    <h1>Production Plan</h1>
    <form>
        <button type="submit">Save</button>
    </form>
    <table>
        <thead>
            <tr>
                <th>SKU</th>
                <th>Quantity</th>
                <th>Created At</th>
                <th>Production Status</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>SKU001</td>
                <td>10</td>
                <td>2021-01-01</td>
                <td>
                <select>
                    <option value="1">In Progress</option>
                    <option value="2">Completed</option>
                    <option value="3">Open</option>
                </select>
                </td>
            </tr>
            <tr>
                <td>SKU002</td>
                <td>20</td>
                <td>2021-01-02</td>
                <td>
                <select>
                    <option value="3">Open</option>
                    <option value="1">In Progress</option>
                    <option value="2">Completed</option>
                </select>
                </td>
            </tr>
            <tr>
                <td>SKU003</td>
                <td>30</td>
                <td>2021-01-03</td>
                <td>
                <select>
                    <option value="2">Completed</option>
                    <option value="1">In Progress</option>
                    <option value="3">Open</option>
                </select>
                </td>
            </tr>
        </tbody>
</body>
</html>
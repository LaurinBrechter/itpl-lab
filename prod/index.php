<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Production</title>
    <style>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/style.css'; ?>
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<body>
    <?php

    include $_SERVER['DOCUMENT_ROOT'] . '/prod/prod_navbar.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/database.php';

    $production_plan = $conn->query("SELECT * FROM production_plan order by status asc, priority desc;");

    ?>

    <form id="production_form" method="GET" onsubmit="event.preventDefault()">
        <h2>Next Item</h2>

        <table>

            <?php

            if ($production_plan->num_rows > 0) {

                $row = $production_plan->fetch_assoc();
                if ($row['status'] == 'PENDING') {
                    echo
                        "<thead>
                        <tr>
                            <th>Id</th>
                            <th>Quantity</th>
                            <th>Created At</th>
                            <th>Production Status</th>
                            <th>Priority</th>
                            <th>Target</th>
                            <th>Product Id</th>
                            <th>Action</th>
                        </tr>
                    </thead>";
                    echo "<tr>";
                    echo "<input type='hidden' name='id' value='" . $row['id'] . "'>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['amount'] . "</td>";
                    echo "<td>" . $row['created_at'] . "</td>";
                    echo "<td>" . $row['status'] . "</td>";
                    echo "<td>" . $row['priority'] . "</td>";
                    echo "<td>" . $row['target'] . "</td>";
                    echo "<td>" . $row["product_id"] . "</td>";
                    echo "<td><button type='submit'>Complete</button></td>";
                    echo "</tr>";
                } else {
                    echo "<tr>";
                    echo "<td>No open items</td>";
                    echo "</tr>";
                }
            }
            ?>
        </table>
    </form>
    <h2>Production History</h2>
    <table class="production-item-table">
        <thead>
            <tr>
                <th>Id</th>
                <th>Quantity</th>
                <th>Created At</th>
                <th>Production Status</th>
                <th>Priority</th>
                <th>Target</th>
                <th>Product Id</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($production_plan->num_rows > 0) {
                while ($row = $production_plan->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['amount'] . "</td>";
                    echo "<td>" . $row['created_at'] . "</td>";
                    echo "<td>" . $row['status'] . "</td>";
                    echo "<td>" . $row['priority'] . "</td>";
                    echo "<td>" . $row['target'] . "</td>";
                    echo "<td>" . $row["product_id"] . "</td>";
                    echo "</tr>";
                }
            }
            ?>
        </tbody>
</body>

<script>
    $('#production_form').submit(function () {
        var post_data = $('#production_form').serialize();
        console.log(post_data);
        $.post('/server/process_production.php', post_data, function (data) {
            // $('#notification').show();
            console.log(data);
            location.reload(); // Reload the page after getting the response
        });
    });
</script>


</html>
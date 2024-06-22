<?php
$title = "Production";
$req_jquery = true;
include $_SERVER['DOCUMENT_ROOT'] . '/server/document_head.php';
?>

<body>
    <?php

    function render_production_plan($production_plan, $complete_btn = false) {
        echo "<table class='production-item-table'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>Id</th>";
        echo "<th>Quantity</th>";
        echo "<th>Created At</th>";
        echo "<th>Production Status</th>";
        echo "<th>Priority</th>";
        echo "<th>Target</th>";
        echo "<th>Product Name</th>";
        echo "<th>Action</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        foreach ($production_plan as $row) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['amount'] . "</td>";
            echo "<td>" . $row['created_at'] . "</td>";
            echo "<td>" . $row['status'] . "</td>";
            echo "<td>" . $row['priority'] . "</td>";
            echo "<td>" . $row['target'] . "</td>";
            echo "<td>" . $row["name"] . "</td>";
            if ($complete_btn) {
                echo "<td><button type='submit'>Complete</button></td>";
            }
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
    }


    include $_SERVER['DOCUMENT_ROOT'] . '/server/database.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/server/decode_jwt.php';

    $payload = getJwtPayload($_COOKIE["jwt"], ['PRODUCTION']);

    $production_id = $conn->query("select * from production_facilities where user_id = $payload->user_id;")->fetch_assoc()["id"];
    include $_SERVER['DOCUMENT_ROOT'] . '/production/prod_navbar.php';
    $production_plan = $conn->query("SELECT 
        pp.status,
        p.name,
        pp.amount,
        pp.id as id,
        pp.priority,
        pp.target,
        pp.created_at 
    FROM production_plan pp
    join products p on pp.product_id = p.id
    where 
        facility_id = $production_id
    order by 
        status asc, 
        priority desc,
        pp.created_at asc;");

    $completed_items = [];
    $in_progress_items = [];
    $pending_items = [];

    if ($production_plan->num_rows > 0) {
        while ($row = $production_plan->fetch_assoc()) {
            if ($row["status"] == "PENDING") {
                array_push($pending_items, $row);
            } elseif ($row["status"] == "COMPLETED") {
                array_push($completed_items, $row);
            } elseif ($row["status"] == "IN_PROGRESS") {
                array_push($in_progress_items, $row);
            }
        }

        if (empty($in_progress_items) && !empty($pending_items)) {
            $conn->query("update production_plan set status = 'IN_PROGRESS' where id = " . $pending_items[0]["id"] . ";");
            $pending_item = array_shift($pending_items);
            $pending_item['status'] = 'IN_PROGRESS';
            array_push($in_progress_items, $pending_item);
        }
    }

    ?>

    <form id="production_form" method="GET" onsubmit="event.preventDefault()">
        <h2>Next Item</h2>
        <?php 
        if (empty($in_progress_items)) {
            echo "<p>No items in progress</p>";
        } else {

            render_production_plan($in_progress_items, true); 
            echo "<input type='hidden' name='id' value='" . $in_progress_items[0]['id'] . "'>";
        }
        ?>
    </form>
    <div class="p-10">
        <h2>Pending Items</h2>
        <?php 
        if (empty($pending_items)) {
            echo "<p>No pending items</p>";
        } else {
        render_production_plan($pending_items); 
        }
        ?>
        <h2>Completed Items</h2>
        <?php 
        if (empty($completed_items)) {
            echo "<p>No completed items</p>";
        } else {
        render_production_plan($completed_items); 
        }
        ?>
    </div>
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


<script>
    var conn = new WebSocket('ws://localhost:8080');
    conn.onopen = function (e) {
        console.log("Connection established!");
    };

    conn.onmessage = function (e) {
        // console.log(e.data);
        location.reload();
    };
</script>

</html>
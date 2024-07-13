<?php
$title = "Management Dashboard";
$req_jquery = true;
include $_SERVER['DOCUMENT_ROOT'] . '/server/document_head.php';
?>

<body>
    <?php

    include $_SERVER['DOCUMENT_ROOT'] . '/management/mgmt_navbar.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/server/database.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/server/decode_jwt.php';

    $payload = getJwtPayload($_COOKIE["jwt"], ['MANAGEMENT']);

    $workload_query = "with workload as (
        select
            pp.amount * p.production_duration as production_duration,
            facility_id 
        from production_plan pp 
        left join products p 
        on pp.product_id = p.id
    ),
    workload_grouped as (
    select sum(production_duration) as total_current_workload, facility_id  from workload group by facility_id
    )
    select COALESCE(total_current_workload, 0) as total_current_workload, id as facility_id from workload_grouped wg
    right join production_facilities pf on wg.facility_id = pf.id;";

    // daily orders
    $order_query = "select count(*) as n_orders, DATE(created_at) as date from orders group by date;";


    $workload = $conn->query($workload_query);
    $orders_daily = $conn->query($order_query);

    $labels_wl = [];
    $data_wl = [];

    while ($row = $workload->fetch_assoc()) {
        $labels_wl[] = "Facility " . $row['facility_id'];
        $data_wl[] = $row['total_current_workload'];
    }

    $labels_orders = [];
    $data_orders = [];
    while ($row = $orders_daily->fetch_assoc()) {
        $labels_orders[] = $row['date'];
        $data_orders[] = (int) $row['n_orders'];
    }

    ?>
    <div class="page-container">
        <div class="chart-container">
            <canvas id="workload-chart"></canvas>
        </div>
        <div class="chart-container">
            <canvas id="orders-chart"></canvas>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const orders_chart = document.getElementById('orders-chart');
        new Chart(orders_chart, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($labels_orders); ?>,
                datasets: [{
                    label: 'N Orders',
                    data: <?php echo json_encode($data_orders); ?>,
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'Daily number of orders',
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

    <script>
        const workload_chart = document.getElementById('workload-chart');
        new Chart(workload_chart, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($labels_wl); ?>,
                datasets: [{
                    label: 'Workload [h]',
                    data: <?php echo json_encode($data_wl); ?>,
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'Workload per Facility in hours',
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

</body>
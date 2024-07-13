<?php
$title = "Websocket Test";
$req_jquery = true;
include $_SERVER['DOCUMENT_ROOT'] . '/server/document_head.php';
?>

<body>

    <div class='notification-container' id="notification">
        <div id="notification-message">

        </div>
        <button onclick="document.getElementById('notification').style.display = 'none';"
            class="notification-close">X</button>
    </div>

    <script>
        $("#notification").hide()
        // try {
        let conn;
        try {
            conn = new WebSocket('ws://localhost:8080');
            conn.onerror = function (error) {
                $("#notification-message").html("Can't establish connection with websocket server, realtime features will be disabled.");
            };
        } catch (error) {
            console.log("An unexpected error occurred: " + error.message);
        }

        conn.onopen = function (e) {
            console.log("Connection established!");
        };

        conn.onmessage = function (e) {
            console.log(e.data);
            const payload = JSON.parse(e.data);
            document.getElementById("notification").style.display = "inline"
            document.getElementById("notification").innerHTML = payload.data;
        };
    </script>
</body>

</html>
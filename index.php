<?php
$title = "Login";
$req_jquery = true;
include $_SERVER['DOCUMENT_ROOT'] . '/server/document_head.php';
?>

<body>
	<div class="login-body">
    <div class="login-container">
        <form action="login.php" method="POST" class="login-form">
            <h1 style="color: white;">Login</h1>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Login</button>
        </form>
    </div>
	</div>
</body>

<script>
    $(document).ready(function () {
        $('form').submit(function (event) {
            event.preventDefault();
            var username = $('#username').val();
            var password = $('#password').val();

            $.post('/server/login.php', {
                username: username,
                password: password
            }, function (data) {

                // read json
                res = JSON.parse(data);
                console.log(res)
                if (res.success) {
                    // save jwt to cookies
                    document.cookie = "jwt=" + res.token + "; path=/";

                    if (res.role == 'SERVICE_PARTNER') {
                        window.location.href = '/sp/catalog';
                    } else if (res.role === 'STORAGE') {
                        window.location.href = '/storage';
                    } else if (res.role === 'PRODUCTION') {
                        window.location.href = '/production';
                    } else if (res.role === 'MANAGEMENT') {
                        window.location.href = '/management/overview';
                    }
                } else {
                    alert("Wrong username or password. Please try again.");
                }
            });
        });
    });
</script>

</html>

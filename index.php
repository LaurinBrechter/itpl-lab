<?php
$title = "Login";
$req_jquery = true;
include $_SERVER['DOCUMENT_ROOT'] . '/document_head.php';
?>

<body>
    <h1>Login</h1>
    <form action="login.php" method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>

        <input type="submit" value="Login">
    </form>
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
                    }
                } else {
                    alert("Wrong username or password. Please try again.");
                }
            });
        });
    });
</script>

</html>
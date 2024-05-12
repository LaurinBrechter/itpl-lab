username: username,

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/style.css'; ?>
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

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
                    // redirect to catalog
                    window.location.href = '/sp/catalog';
                } else {
                    alert("Wrong username or password. Please try again.");
                }
            });
        });
    });
</script>




</html>
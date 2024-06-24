<?php
$title = "Login";
$req_jquery = true;
include $_SERVER['DOCUMENT_ROOT'] . '/server/document_head.php';
?>

<style>
    body {
        margin: 0;
        padding: 0;
        height: 100vh;
        background: url('/Login.jpg') no-repeat center center fixed;
        background-size: cover;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .login-container {
        padding: 20px;
        border-radius: 10px;
        max-width: 300px;
    }
    .login-form {
        display: flex;
        flex-direction: column;
    }
    .login-form label {
        font-weight: bold;
        color: black;
    }
    .login-form input[type="text"],
    .login-form input[type="password"] {
        color: black; 
        border: 2px solid #001f3f; 
        padding: 10px;
        border-radius: 5px;
        width: 100%;
        margin-bottom: 15px;
        box-sizing: border-box; 
    }
    .login-form button {
        background-color: #007bff;
        color: black;
        padding: 10px;
        border: none;
        border-radius: 5px;
        width: 100%;
        cursor: pointer;
    }
    .login-form button:hover {
        background-color: #0056b3;
    }
</style>

<body>
    <div class="login-container">
        <form action="login.php" method="POST" class="login-form">
            <h1 style="color: black;">Login</h1>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Login</button>
        </form>
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
                        window.location.href = '/management';
                    }
                } else {
                    alert("Wrong username or password. Please try again.");
                }
            });
        });
    });
</script>

</html>

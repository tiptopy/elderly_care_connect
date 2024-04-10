<!-- pages/login.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Elderly Care Connect</title>
    <link rel="stylesheet" href="../css/login_style.css">
    <link rel="stylesheet" href="../css/general.css">
    <!-- Font Awesome for eye icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <div class="container-login">
        <div class="box form-box">
            <h1>Login</h1>
            <div class="contain-box">
                <form action="login.php" method="post">
                    <div class="field input">
                        <label for="username">Username:</label>
                        <input type="text" id="username" name="username" required>
                    </div>
                    <div class="field input input-with-icon">
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" required>
                        <!-- Checkbox for toggling password visibility -->
                        <span class="password-toggle" onclick="togglePassword()">
                            <i class="far fa-eye"></i>
                        </span>
                    </div>
                    <button type="submit">Login</button>
                </form>
                <div class="links">
                    <a href="./forgot_password.php">Forgot password?</a>
                    <div class="links-items2">Don't have an account?<a href="./signup.php" id="item2">Sign Up</a></div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="..//scripts.js"></script>
</html>

<?php
require_once '../includes/authenticate.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = strtolower($_POST['username']);
    $password = $_POST['password'];

    if (login($username, $password)) {
        header("Location: homepage.php");
        exit;
    } else {
        echo '<div class="user-name-exists">Invalid username or password</div>';
    }
}
?>

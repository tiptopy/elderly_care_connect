<!-- pages/signup.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup - Elderly Care Connect</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h1>Signup</h1>
        <form action="signup.php" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Signup</button>
        </form>
    </div>
</body>
</html>
<!-- pages/signup.php -->
<?php
require_once '../includes/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $existing_user = $db->users->findOne(['username' => $username]);

    if ($existing_user) {
        echo "Username already exists";
    } else {
        $insertResult = $db->users->insertOne(['username' => $username, 'password' => $password]);
        if ($insertResult) {
            echo "User created successfully";
        } else {
            echo "Error creating user";
        }
    }
}
?>

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
            <label for="FullName">Full Name:</label>
            <input type="text" id="FullName" name="FullName" required>
            <label for="PhoneNumber">Phone Number:</label>
            <input type="text" id="PhoneNumber" name="PhoneNumber" required>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <label for="security_question">Security Question:</label>
            <select id="security_question" name="security_question">
                <option value="What is your mother's maiden name?">What is your mother's maiden name?</option>
                <option value="What city were you born in?">What city were you born in?</option>
                <!-- Add more security questions here -->
            </select>

            <label for="security_answer">Answer:</label>
            <input type="text" id="security_answer" name="security_answer" required>
            <button type="submit">Signup</button>
        </form>
        <p>Have an account? <a href="./login.php">Login</a></p>
    </div>
</body>

</html>
<!-- pages/signup.php -->
<?php
require_once '../includes/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $FullName = $_POST['FullName'];
    $PhoneNumber = $_POST['PhoneNumber'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $security_question = $_POST['security_question'];
    $security_answer = $_POST['security_answer'];


    $existing_user = $db->users->findOne(['username' => $username]);

    if ($existing_user) {
        echo "Username already exists";
    } else {
        $insertResult = $db->users->insertOne(['FullName' => $FullName, 'username' => $username, 'password' => $password, 'security_question' => $security_question, 'security_answer' => $security_answer]);
        if ($insertResult) {
            echo "User created successfully";
        } else {
            echo "Error creating user";
        }
    }
}
?>
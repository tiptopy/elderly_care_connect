<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Elderly Care Connect</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <div class="container">
        <h1>Forgot Password</h1>
        <form action="forgot_password.php" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="security_question">Security Question:</label>
            <select id="security_question" name="security_question">
                <option value="What is your mother's maiden name?">What is your mother's maiden name?</option>
                <option value="What city were you born in?">What city were you born in?</option>
                <!-- Add more security questions here -->
            </select>

            <label for="security_answer">Answer:</label>
            <input type="text" id="security_answer" name="security_answer" required>
            <label for="password">New Password:</label>
            <input type="password" id="password" name="password" required>

            <input type="submit" value="Submit">
        </form>
        <a href="./login.php">Login</a>
        <a href="./signup.php">Sign Up</a>
    </div>
</body>
<?php
require_once '../includes/db_connection.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $securityQuestion = $_POST['security_question'];
    $securityAnswer = $_POST['security_answer'];
    $newPassword = $_POST['password'];

    // Search for user in database
    $user = $db->users->findOne(['username' => $username]);

    if ($user && $user['security_question'] == $securityQuestion && $user['security_answer'] == $securityAnswer) {
        // User found and security question/answer match
        // Here you can implement the password reset mechanism, like sending an email with a reset link
        // Update password for the user
        $updateResult = $db->users->updateOne(
            ['username' => $username],
            ['$set' => ['password' => $newPassword]]
        );

        if ($updateResult->getModifiedCount() === 1) {
            // Password updated successfully
            echo "Password updated successfully.";
        } else {
            // Failed to update password
            echo "Failed to update password.";
        } // Example message
    } else {
        // User not found or security question/answer don't match
        echo "Invalid username or security question/answer.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Elderly Care Connect</title>
    <link rel="stylesheet" href="../css/forgotpassword.css">
    <link rel="stylesheet" href="../css/general.css">
</head>

<body>
    <div class="container-fpassword">
        <!-- Title -->
        <h1>Forgot/Reset Password</h1>
        <!-- Forgot password form -->
        <form action="forgot_password.php" method="post">
            <!-- Username input -->
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <!-- Security question selection -->
            <label for="security_question">Security Question:</label>
            <select id="security_question" name="security_question">
                <option value="What is your mother's maiden name?">What is your mother's maiden name?</option>
                <option value="What city were you born in?">What city were you born in?</option>
                <!-- Add more security questions here -->
            </select>
            <!-- Security answer input -->
            <label for="security_answer">Answer:</label>
            <input type="text" id="security_answer" name="security_answer" required>
            <!-- New password input -->
            <label for="password">New Password:</label>
            <input type="password" id="password" name="password" required>
            <!-- Submit button -->
            <input type="submit" value="Submit">
        </form>
        <!-- Links for login and signup -->
        <div class="forgot-passsword-item">
            <a href="./login.php">Login</a>
            <a href="./signup.php">Sign Up</a>
        </div>
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
        // Update password for the user
        $updateResult = $db->users->updateOne(
            ['username' => $username],
            ['$set' => ['password' => password_hash($newPassword, PASSWORD_DEFAULT)]]
        );

        if ($updateResult->getModifiedCount() === 1) {
            // Password updated successfully
            echo '<div class="success-message">Password updated successfully</div>';
            header("Refresh:1; url=./login.php");
        } else {
            // Failed to update password
            echo '<div class="error-message">Failed to update password</div>';
        }
    } else {
        // User not found or security question/answer don't match
        echo '<div class="error-message">Invalid username or security question/answer.</div>';
    }
}
?>
</html>

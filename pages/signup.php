<!-- pages/signup.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup - Elderly Care Connect</title>
    <link rel="stylesheet" href="../css/sign-up.css">
    <link rel="stylesheet" href="../css/general.css">
</head>

<body>
<div class="container-signup">
    <div class="box form-box">
    <h1>Sign Up</h1>
    <div class="contain-box">     
        <form action="signup.php" method="post" enctype="multipart/form-data">
        <div class="field input">
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
            <label for="image">Profile Image:</label>
            <input type="file" id="image" name="image" accept="image/*" required>
            <button type="submit">Signup</button>
        </div>
        </form>
     <div class="links">
        <p>Have an account? <a href="./login.php">Login</a></p>
  </div>
    </div>
    </div>
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

    // File upload handling
    $imageData = file_get_contents($_FILES['image']['tmp_name']);
    $imageMimeType = mime_content_type($_FILES['image']['tmp_name']);

    $existing_user = $db->users->findOne(['username' => $username]);

    if ($existing_user) {
        echo '<div class="user-name-exists">Username already exists</div>';
    } else {
        $insertResult = $db->users->insertOne([
            'FullName' => $FullName,
            'PhoneNumber' => $PhoneNumber,
            'username' => $username,
            'password' => $password,
            'security_question' => $security_question,
            'security_answer' => $security_answer,
            'imageData' => new MongoDB\BSON\Binary($imageData, MongoDB\BSON\Binary::TYPE_GENERIC),
            'imageMimeType' => $imageMimeType
        ]);

        if ($insertResult) {
            echo '<div class="success-message">User created successfully</div>';
        } else {
            echo '<div class="error-message">Error creating user</div>';
        }
    }
}
?>

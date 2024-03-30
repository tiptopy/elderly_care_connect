<?php
session_start(); // Start the session

$_SESSION = array(); // Unset all of the session variables

session_destroy(); // Destroy the session
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
</head>
<body>
    <h1>Logged Out Successfully</h1>
    <p>You have been logged out. Redirecting you to the index page...</p>

    <?php
    header("refresh:1;url=../index.php"); // Redirect to the index page after a short delay
    ?>
</body>
</html>

<?php
// Start the session
session_start();

// Unset all of the session variables
$_SESSION = array();

// Destroy the session
session_destroy();
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
    // Redirect to the index page after a short delay
    header("refresh:1;url=../index.php");
    ?>
</body>
</html>

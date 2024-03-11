<?php
require_once './includes/authenticate.php';
require_once './includes/db_connection.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elderly Care Connect</title>
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <div class="container">
        <h1>Welcome to Elderly Care Connect</h1>
        <h2>Summary of Elderly Profiles</h2>
        <?php
        // Retrieve and display elderly profiles created by the logged-in user
        $profiles = $db->profiles->find();

        foreach ($profiles as $profile) {
            echo '<div class="profile">';
            echo '<img src="' . $profile['picture'] . '" alt="' . $profile['name'] . '">';
            echo '<h3>' . $profile['name'] . '</h3>';
            echo '<p>' . $profile['summary'] . '</p>';
            echo '<a href="./pages/profile.php?id=' . $profile['_id'] . '">View Full Profile</a>';
            echo '</div>';
        }
        ?>
        <form id="paymentForm">
            <div class="form-submit">
                <button type="submit" onclick="payWithPaystack()"> Donate </button>
            </div>
        </form>

        <?php include './includes/donation.php'; ?>

        <script src="https://js.paystack.co/v1/inline.js"></script>
</body>

</html>
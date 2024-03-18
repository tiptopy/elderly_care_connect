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
    <form id="paymentForm" method="post" style = "display: none;">
            <div class="form-submit">
                <label for="donorName"><b>Donor Name</b></label>
                <input type="text" placeholder="Enter Name" name="donorName" id="donorName" required>

                <label for="donorEmail"><b>Donor Email</b></label>
                <input type="email" placeholder="Enter Email" name="donorEmail" id="donorEmail" required>

                <label for="donorAmount"><b>Donation Amount</b></label>
                <input type="number" placeholder="Enter Amount" name="donorAmount" id="donorAmount" required>

                <input type="hidden" name="donorEmail" id="hiddenEmail">
                <input type="hidden" name="donorAmount" id="hiddenAmount">
                <button type="submit" onclick="payWithPaystack()"> Donate </button>
            </div>
        </form>
        <button id="DonateBtn" onclick="toggleDonateForm()">Donate</button>

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
            // Base64 encode the image data and set it as the src attribute
            $imageData = base64_encode($profile['pictureData']->getData());
            $imageSrc = 'data:' . $profile['pictureMimeType'] . ';base64,' . $imageData;
            echo '<img src="' . $imageSrc . '" alt="' . $profile['name'] . '">';
            echo '<h3>' . $profile['name'] . '</h3>';
            echo '<p>' . $profile['summary'] . '</p>';
            echo '<a href="./pages/profile.php?id=' . $profile['_id'] . '">View Full Profile</a>';
            echo '</div>';
        }
        ?>
        
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $_SESSION['donorName'] = $_POST['donorName']; // Store donor name in session
        }
        ?>


        <?php
        if (isset($_GET['logout'])) {
            // Call the logout function
            logout();
        }
        ?>
        <?php
        if (!isLoggedIn()) {
            echo '<p>Have an elderly who needs help?</p>';
            echo '<a href="./pages/login.php"> Create profile here</a>';
        } else {
            echo '<a href="./pages/homepage.php">View my created profiles </a>';
            echo '<a href="?logout=true">Logout</a>';
        }
        ?>

        <?php include './includes/donation.php'; ?>

        <script src="https://js.paystack.co/v1/inline.js"></script>
        <script src="scripts.js"></script>
</body>

</html>
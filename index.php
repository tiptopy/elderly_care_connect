
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
    <link rel="stylesheet" href="./css/index.css">
    <link rel="stylesheet" href="./css/header.css">
    <header>
    <div class="container-header">
        <h1>EC Care</h1>
        <nav class="nav-header">
            <ul>
                <?php
            if (!isLoggedIn()) {
                echo '<a href="#"> Home</a>';
                echo '<a href="#"> About Us</a>';
                echo '<a href="./pages/login.php"> Login</a>';
                echo '<a href="./pages/signup.php"> Sign Up</a>';

            }
            else
            {
                echo '<a href="#"> Home</a>';
                echo '<a href="#"> About Us</a>';
                echo '<a href="./pages/profile.php">My profiles</a>';
                echo '<a href="./pages/logout.php">Logout</a>';

            
            }
            ?>

            </ul>
        </nav>
    </div>
    </header>
   <?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate the donation amount
    $donorAmount = $_POST["donorAmount"];

    if ($donorAmount < 0) {
        $errorMessage = "Please enter a positive donation amount.";
    } else {
        // Donation amount is valid, process the form data further
        // Your code to process the form data goes here...
    }
}
?>

<form id="paymentForm" method="post" style="display: none;" class="form-container">
    <div class="form-header">
        <h2>Donate Now</h2>
    </div>
    <div class="form-submit">
        <div class="form-group">
            <label for="donorName"><b>Donor Name</b></label>
            <input type="text" placeholder="Enter Name" name="donorName" id="donorName" required>
        </div>

        <div class="form-group">
            <label for="donorEmail"><b>Donor Email</b></label>
            <input type="email" placeholder="Enter Email" name="donorEmail" id="donorEmail" required>
        </div>

        <div class="form-group">
            <label for="donorPhone"><b>Donor Phone Number</b></label>
            <input type="number" placeholder="Enter Phone Number" name="donorPhone" id="donorPhone" required>
        </div>

        <div class="form-group">
            <label for="donorAmount"><b>Donation Amount</b></label>
            <input type="number" placeholder="Enter Amount" name="donorAmount" id="donorAmount" min="1" max="1000" required>
            <?php if(isset($errorMessage)) { echo "<p class='error'>$errorMessage</p>"; } ?>
        </div>

        <input type="hidden" name="creator_phone_number" id="creator_phone_number" value="">
        <input type="hidden" name="donorEmail" id="hiddenEmail">
        <input type="hidden" name="donorAmount" id="hiddenAmount">
        <button type="submit" onclick="payWithPaystack()" class="submit-button">Donate</button>
    </div>
</form>

        <button id="DonateBtn" onclick="toggleDonateForm()">Donate</button>

</head>

<body>
    <div class="index-container">
        <div class=index-headeritems>
        <h1>Welcome to Elderly Care Connect</h1>
        <h2>Summary of Elderly Profiles</h2>
        </div>
    <div class="container-index">
      
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
      if (isset($_GET['logout'])) {
          // Call the logout function
          logout();
      }
      ?>
  </div>
    </div>
    
       
      
        <?php include './includes/donation.php'; ?>

        <script src="https://js.paystack.co/v1/inline.js"></script>
        <script src="scripts.js"></script>
</body>

</html>
<?php include './pages/footer.php'; ?>


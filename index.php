
<?php
require_once './includes/authenticate.php';
require_once './includes/db_connection.php';

// Define the number of profiles per page
$profilesPerPage = 20;

// Calculate the total number of profiles
$totalProfiles = $db->profiles->count();

// Calculate the total number of pages
$totalPages = ceil($totalProfiles / $profilesPerPage);

// Determine the current page
$currentpage = isset($_GET['page']) ? $_GET['page'] : 1;

// Calculate the offset for MongoDB query
$offset = ($currentpage - 1) * $profilesPerPage;

// Retrieve profiles for the current page
$profiles = $db->profiles->find([], ['skip' => $offset, 'limit' => $profilesPerPage]);

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
        <h1>ECC Care</h1>
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
        $errorMessage = "Please enter a valid amount.";
    } else {
        // Donation amount is valid, process the form data further
        // Your code to process the form data goes here...
    }
}
?>
<form id="paymentForm" method="post" style="display: none;" class="form-container">
    <div class="form-header">
        <h2>Donate Now</h2>
        <button type="button" class="close-button" onclick="closeForm()">&#10006;</button>
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
        </div>

        <input type="hidden" name="donorEmail" id="hiddenEmail">
        <input type="hidden" name="donorAmount" id="hiddenAmount">
        <input type="hidden" name="creator_phone_number" id="creator_phone_number" value="<?php echo htmlspecialchars($creator['PhoneNumber']); ?>">
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

      foreach ($profiles as $profile) {
        echo '<div class="profile">';
        echo '<img src="data:' . $profile['pictureMimeType'] . ';base64,' . base64_encode($profile['pictureData']->getData()) . '" alt="' . $profile['fname'] . '">';
        echo '<h3>' . $profile['fname'] . ' ' . $profile['mname'] . ' ' . $profile['sname'] . '</h3>';
        echo '<p>Age: ' . $profile['age'] . '</p>'; // Display age
        echo '<p>Phone: ' . $profile['phone'] . '</p>'; // Display phone
        echo '<p>Location:  ' . $profile['location'] . '</p>'; // Display  location
        echo '<p>County:  ' . $profile['county'] . '</p>'; // Display homecounty
        echo '<a href="../pages/profile.php?id=' . $profile['_id'] . '" class="view-profile-link ">View Profile</a>';
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
  <!-- Pagination links -->
  <div class="pagination">
            <?php
            // Display pagination links
            for ($page = 1; $page <= $totalPages; $page++) {
                echo '<a href="?page=' . $page . '" ' . ($currentpage == $page ? 'class="current"' : '') . '>' . $page . '</a>';
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


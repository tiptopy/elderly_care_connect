<?php
require_once './includes/authenticate.php';
require_once './includes/db_connection.php';

// Define the number of profiles per page
$profilesPerPage = 12;

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

if(isset($_SESSION['profile_id'])) {
    unset($_SESSION['profile_id']);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elderly Care Connect</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <header>
        <div class="container-header">
            <div class="head"><h4>ECC Care</h4></div>
            <div class="nav-header">
            <nav >
                <ul>
                    <?php
                    if (!isLoggedIn()) {
                        echo '<a href="#"> Home</a>';
                        echo '<a href="#"> About Us</a>';
                        echo '<a href="./pages/login.php"> Login</a>';
                        echo '<a href="./pages/signup.php"> Sign Up</a>';
                    } else {
                        echo '<a href="#"> Home</a>';
                        echo '<a href="./pages/about_us.php"> About Us</a>';
                        echo '<a href="./pages/homepage.php">My profiles</a>';
                        if (isAdmin()) {
                            echo '<a href="./pages/all_donations.php">All donations</a>';
                            echo '<a href="./pages/all_users.php">All Users</a>';
                          }
                        echo '<a href="./pages/logout.php">Logout</a>';
                    }
                    ?>
                </ul>
            </nav>
            </div>
        </div>
        
        <nav id="humberger-nav">

  <div class="humberger-menu">
    <div class="humberger-icon" onclick="toggleMenu()">
      <span></span>
      <span></span>
      <span></span>

    </div>
    <div class="menu-links">
    <nav >
                <ul onclick="toggleMenu()">
                    <?php
                    if (!isLoggedIn()) {
                        echo '<a href="#"> Home</a>';
                        echo '<a href="./pages/about_us.php"> About Us</a>';
                        echo '<a href="./pages/login.php"> Login</a>';
                        echo '<a href="./pages/signup.php"> Sign Up</a>';
                    } else {
                        echo '<a href="#"> Home</a>';
                        echo '<a href="#"> About Us</a>';
                        echo '<a href="./pages/profile.php">My profiles</a>';
                        if (isAdmin()) {
                            echo '<a href="./all_donations.php">All donations</a>';
                            echo '<a href="./pages/all_users.php">All Users</a>';
                          }
                        echo '<a href="./pages/logout.php">Logout</a>';
                    }
                    ?>
                </ul>
            </nav>

    </div>
  </div
  >

</nav>
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
    <form id="paymentForm" method="post" style="display: none;" class="form-container" onsubmit="return validateDonationAmount()">
        <div class="form-header">
            <h3>Donate Now</h3>
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
                <input type="number" placeholder="Enter Amount" name="donorAmount" id="donorAmount" required>
            </div>

            <input type="hidden" name="donorEmail" id="hiddenEmail">
            <input type="hidden" name="donorAmount" id="hiddenAmount">
            <input type="hidden" name="creator_phone_number" id="creator_phone_number" value="<?php echo htmlspecialchars($creator['PhoneNumber']); ?>">
            <button type="submit" onclick="payWithPaystack()" class="submit-button">Donate</button>
        </div>
    </form>

    <button id="DonateBtn" onclick="toggleDonateForm()">Donate</button>

    <div class="index-container">
        <div class="index-headeritems">
            <h1>Welcome to Elderly Care Connect</h1>
            <h2>Summary of Elderly Profiles</h2>
        </div>
        <div class="container-index">

            <?php
            foreach ($profiles as $profile) {
                echo '<div class="profile">';
                echo '<img src="' . $profile['picturePath'] . '" alt="' . $profile['fname'] . '">';
                echo '<h3>' . $profile['fname'] . ' ' . $profile['mname'] . ' ' . $profile['sname'] . '</h3>';
                echo '<p>Age: ' . $profile['age'] . '</p>'; // Display age
                echo '<p>Phone: ' . $profile['phone'] . '</p>'; // Display phone
                echo '<p>Location:  ' . $profile['location'] . '</p>'; // Display location
                echo '<p>County:  ' . $profile['county'] . '</p>'; // Display county
                echo '<a href="./pages/profile.php?id=' . $profile['_id'] . '" class="view-profile-link">View Profile</a>';
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

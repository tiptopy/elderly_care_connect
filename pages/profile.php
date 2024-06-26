<?php include 'header.php'; ?>

<!-- pages/profile.php -->
<?php
require_once '../includes/authenticate.php';
require_once '../includes/db_connection.php';

if (!isset($_GET['id'])) {
    header("Location: ../index.php"); // Redirect to homepage if no profile ID is provided
    exit;
}

$profile_id = $_GET['id'];
$profile = $db->profiles->findOne(['_id' => new MongoDB\BSON\ObjectId($profile_id)]);


if (!$profile) {
    echo "Profile not found. Redirecting to home...";
    header("Refresh:1;url=../");
    exit();
}

$_SESSION['profile_id'] = (string)$profile['_id'];

$creator = $db->users->findOne(['_id' => new MongoDB\BSON\ObjectId($profile['created_by'])]);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $profile['name']; ?> - Elderly Care Connect</title>
    
    <link rel="stylesheet" href="./css/style.css">
    
</head>

<body>
    <form id="paymentForm" method="post" style="display: none;" class="form-container" onsubmit="return validateDonationAmount()">
        <div class="form-header">
            <button type="button" class="close-button" onclick="closeForm()">&#10006;</button>
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
                <input type="number" placeholder="Enter Amount" name="donorAmount" id="donorAmount" required>
            </div>

            <input type="hidden" name="donorEmail" id="hiddenEmail">
            <input type="hidden" name="donorAmount" id="hiddenAmount">
            <input type="hidden" name="creator_phone_number" id="creator_phone_number" value="<?php echo htmlspecialchars($creator['PhoneNumber']); ?>">
            <button type="submit" class="submit-button">Donate</button>
        </div>
    </form>

    <div class="container-profile">
        <h1><?php echo $profile['fname'] . ' ' . $profile['mname'] . ' ' . $profile['sname']; ?></h1>

        <div class="profile" id="profile-page">
            <?php
            echo '<img src="' . $profile['picturePath'] . '" alt="' . $profile['fname'] . '">'; // Display profile picture
            ?>
            <p>
                <?php
                echo '<p>Age: ' . $profile['age'] . '</p>'; // Display age
                echo '<p>ID Number: ' . $profile['idno'] . '</p>'; // Display ID number
                echo '<p>Phone: ' . $profile['phone'] . '</p>'; // Display phone
                echo '<p>Address: ' . $profile['address'] . '</p>'; // Display address
                echo '<p>Location:  ' . $profile['location'] . '</p>'; // Display location
                echo '<p>County:  ' . $profile['county'] . '</p>'; // Display county
                echo '<p>Additional Information: ' . $profile['additional'] . '</p>'; // Display additional information
                ?>
            </p>
            <button id="DonateBtn" onclick="toggleDonateForm()">Donate</button> <!-- Button to toggle donation form -->
        </div>
    </div>

    <!-- Popup message for validation -->
    <div id="popupMessage" class="popup-message">
        <p id="popupText"></p>
        <button onclick="closePopup()">OK</button>
    </div>

    
</body>

</html>

<?php
if (isLoggedIn()) {
    if (($loggeduser['_id'] == $profile['created_by']) || isAdmin()){
        $collection = $db->transactions;
        $cursor = $collection->find(['DonationTo' => $_SESSION['profile_id']]); // Get all donations for that specific user

        // Convert the donations to an array to use the count function
        $cursorArray = iterator_to_array($cursor);

        if (count($cursorArray) > 0) {
            // Display data in HTML table
            echo "<table id='transactionTable'>";
            echo "<thead><tr><th data-sort-order='asc'>Transaction ID</th><th data-sort-order='asc'>Amount</th><th data-sort-order='asc'>Paid At</th><th data-sort-order='asc'>Donated By</th></tr></thead>";
            echo "<tbody>";

            $totalAmount = 0;

            foreach ($cursorArray as $document) {
                echo "<tr>";
                echo "<td>" . $document['data']['reference'] . "</td>";
                echo "<td>" . 'KES ' . $document['data']['amount'] / 100 . "</td>";
                echo "<td>" . $document['data']['paidAt'] . "</td>";
                echo "<td>" . $document['data']['authorization']['bin'] . $document['data']['authorization']['last4'] . "</td>";
                echo "</tr>";
                $totalAmount += $document['data']['amount'] / 100;
            }

            echo "</tbody>";
            echo "</table>";
            echo '<P style="text-align:center">Total Donations: KES ' . $totalAmount . '</p>';
        } else {
            echo "No donations have ever been made to this profile";
        }
    }
}
?>

<?php include '../includes/donation.php'; ?>

<script src="https://js.paystack.co/v1/inline.js"></script>
<script src="../scripts.js"></script>
<?php include 'footer.php'; ?>

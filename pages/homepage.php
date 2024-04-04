<?php include 'header.php'; ?>
<!-- pages/homepage.php -->
<?php
require_once '../includes/authenticate.php';
require_once '../includes/db_connection.php';

if (!isLoggedIn()) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle form submission for creating profile
    $fname = $_POST['fname'];
    $mname = $_POST['mname'];
    $sname = $_POST['sname'];
    $idno = $_POST['idno'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $location = $_POST['location'];
    $county = $_POST['county'];
    $age = $_POST['age'];
    $additional = $_POST['additional'];
    $user_id = $_SESSION['user_id'];

    // File upload handling
    $pictureData = file_get_contents($_FILES['picture']['tmp_name']);
    $pictureMimeType = mime_content_type($_FILES['picture']['tmp_name']);

    // Insert profile into MongoDB with associated user ID and image data
    $insertResult = $db->profiles->insertOne([
        'fname' => $fname,
        'mname' => $mname,
        'sname' => $sname,
        'idno' => $idno,
        'phone' => $phone,
        'address' => $address,
        'location' => $location,
        'county' => $county,
        'age' => $age,
        'additional' => $additional,
        'pictureData' => new MongoDB\BSON\Binary($pictureData, MongoDB\BSON\Binary::TYPE_GENERIC),
        'pictureMimeType' => $pictureMimeType,
        'created_by' => $user_id
    ]);

    if ($insertResult) {
        echo '<div class="success-message">Profile created successfully</div>';
    } else {
        echo '<div class="error-message">Error creating profile</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elderly Care Connect</title>
    <link rel="stylesheet" href="../css/homepage.css">
</head>

<body>
    <?php echo '<img src="data:' . $loggeduser['imageMimeType'] . ';base64,' . base64_encode($loggeduser['imageData']->getData()) . '" alt="' . $loggeduser['username'] . '">'; ?>
    <div class="homepage-container">
        <a href="create_profile.php" class="create-profile-link">Create Profile</a>
        <div class="container-homepage">
            <?php
            // Retrieve and display elderly profiles created by the logged-in user
            $profiles = $db->profiles->find(['created_by' => $_SESSION['user_id']]);

            foreach ($profiles as $profile) {
                echo '<div class="profile">';
                echo '<img src="data:' . $profile['pictureMimeType'] . ';base64,' . base64_encode($profile['pictureData']->getData()) . '" alt="' . $profile['fname'] . '">';
                echo '<h3>' . $profile['fname'] . ' ' . $profile['mname'] . ' ' . $profile['sname'] . '</h3>';
                echo '<p>Age: ' . $profile['age'] . '</p>'; // Display age
                echo '<p>Phone: ' . $profile['phone'] . '</p>'; // Display phone
                echo '<p>Location:  ' . $profile['location'] . '</p>'; // Display  location
                echo '<p>County:  ' . $profile['county'] . '</p>'; // Display homecounty
                echo '<a href="profile.php?id=' . $profile['_id'] . '" class="view-profile-link">View Profile</a>';
                echo '<a href="edit_profile.php?id=' . $profile['_id'] . '" class="view-profile-link">Edit Profile</a>';
                echo '<a href="delete_profile.php?id=' . $profile['_id'] . '" class="view-profile-link">Delete Profile</a>';
                echo '</div>';
            }
            ?>
        </div>
    </div>
</body>
</html>
<?php include '../pages/footer.php'; ?>

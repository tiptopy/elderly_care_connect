<?php include 'header.php'; ?>

<?php
require_once '../includes/authenticate.php';
require_once '../includes/db_connection.php';

if (!isLoggedIn()) {
    header("Location: login.php");
}

if (!isAdmin()) {
    header("Location: access_denied.php");
}

if (!isset($_GET['id'])) {
    header("Location: ./all_users.php"); // Redirect to homepage if user ID is not set
    exit;
}

$user_id = $_GET['id']; // Get user ID from GET parameters
$user = $db->users->findOne(['_id' => new MongoDB\BSON\ObjectId($user_id)]); // Find user in database

if (!$user) {
    echo "user not found"; // Echo error message if user not found
    exit;
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
    <div class="propic">
        <?php echo '<img src="' . $user['picturePath'] . '" alt="' . $user['username'] . '">'; ?>
        <?php echo '<a href="./edit_user.php?id=' . $user['_id'] . '">Edit this Profile</a>'; ?>
    </div>
    <div class="homepage-container">
        <h3 style="text-align:center">Elderly Profiles Created:</h3>
        <br>
        <br>
        <div class="container-homepage">
            <?php
            // Retrieve and display elderly profiles created by the user
            $profiles = $db->profiles->find(['created_by' => (string)$user['_id']]);
            $found_a_Profile = false;

                foreach ($profiles as $profile) {
                    $found_a_Profile = true;
                    echo '<div class="profile">';
                    echo '<img src="' . $profile['picturePath'] . '" alt="' . $profile['fname'] . '">';
                    echo '<h3>' . $profile['fname'] . ' ' . $profile['mname'] . ' ' . $profile['sname'] . '</h3>';
                    echo '<p>Age: ' . $profile['age'] . '</p>'; // Display age
                    echo '<p>Phone: ' . $profile['phone'] . '</p>'; // Display phone
                    echo '<p>Location:  ' . $profile['location'] . '</p>'; // Display location
                    echo '<p>County:  ' . $profile['county'] . '</p>'; // Display home county
                    echo '<a href="profile.php?id=' . $profile['_id'] . '" class="view-profile-link">View Profile</a>';
                    echo '<a href="edit_profile.php?id=' . $profile['_id'] . '" class="view-profile-link">Edit Profile</a>';
                    echo '<a href="delete_profile.php?id=' . $profile['_id'] . '" class="view-profile-link">Delete Profile</a>';
                    echo '</div>';
                }
            if(!$found_a_Profile){
                echo '<p>No elderly profile created</p>';
            }
            ?>
        </div>
    </div>
</body>

</html>
<?php include '../pages/footer.php'; ?>
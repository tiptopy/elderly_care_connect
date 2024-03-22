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
    // Assuming the form fields are 'name', 'summary', and 'picture'
    $name = $_POST['name'];
    $summary = $_POST['summary'];
    $user_id = $_SESSION['user_id'];

    // File upload handling
    $pictureData = file_get_contents($_FILES['picture']['tmp_name']);
    $pictureMimeType = mime_content_type($_FILES['picture']['tmp_name']);

    // Insert profile into MongoDB with associated user ID and image data
    $insertResult = $db->profiles->insertOne([
        'name' => $name,
        'summary' => $summary,
        'pictureData' => new MongoDB\BSON\Binary($pictureData, MongoDB\BSON\Binary::TYPE_GENERIC),
        'pictureMimeType' => $pictureMimeType,
        'created_by' => $user_id
    ]);

    if ($insertResult) {
        echo "Profile created successfully";
    } else {
        echo "Error creating profile";
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
    <div class="container">

        <?php
        // Retrieve and display elderly profiles created by the logged-in user
        $profiles = $db->profiles->find(['created_by' => $_SESSION['user_id']]);

        foreach ($profiles as $profile) {
            echo '<div class="profile">';
            echo '<img src="data:' . $profile['pictureMimeType'] . ';base64,' . base64_encode($profile['pictureData']->getData()) . '" alt="' . $profile['name'] . '">';
            echo '<h3>' . $profile['name'] . '</h3>';
            echo '<p>' . $profile['summary'] . '</p>';
            echo '<a href="profile.php?id=' . $profile['_id'] . '" class="view-profile-link ">View Profile</a>';

            echo '</div>';
        }
        ?>
        
        <a href="createprofile.php" class="create-profile-link">Create Profile</a>
    </div>
</body>
</html>

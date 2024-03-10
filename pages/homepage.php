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
    // Assuming the form fields are 'name', 'summary', 'picture'
    $name = $_POST['name'];
    $summary = $_POST['summary'];
    $picture = $_POST['picture'];
    $user_id = $_SESSION['user_id'];

    // Insert profile into MongoDB with associated user ID
    $insertResult = $db->profiles->insertOne(['name' => $name, 'summary' => $summary, 'picture' => $picture, 'created_by' => $user_id]);

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
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h1>Welcome to Elderly Care Connect</h1>
        <h2>Summary of Elderly Profiles</h2>
        <?php
        // Retrieve and display elderly profiles created by the logged-in user
        $profiles = $db->profiles->find(['created_by' => $_SESSION['user_id']]);

        foreach ($profiles as $profile) {
            echo '<div class="profile">';
            echo '<img src="' . $profile['picture'] . '" alt="' . $profile['name'] . '">';
            echo '<h3>' . $profile['name'] . '</h3>';
            echo '<p>' . $profile['summary'] . '</p>';
            echo '<a href="profile.php?id=' . $profile['_id'] . '">View Full Profile</a>';
            echo '<a href="edit_profile.php?id=' . $profile['_id'] . '">Edit</a>';
            echo '<a href="delete_profile.php?id=' . $profile['_id'] . '">Delete</a>';
            echo '</div>';
        }
        ?>
        
        <h2>Create New Profile</h2>
        <form action="homepage.php" method="post">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
            <label for="summary">Summary:</label>
            <textarea id="summary" name="summary" required></textarea>
            <label for="picture">Picture URL:</label>
            <input type="text" id="picture" name="picture" required>
            <button type="submit">Create Profile</button>
        </form>
    </div>
</body>
</html>

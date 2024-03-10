<!-- pages/edit_profile.php -->
<?php
require_once '../includes/authenticate.php';
require_once '../includes/db_connection.php';

if (!isLoggedIn()) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: homepage.php");
    exit;
}

$profile_id = $_GET['id'];
$profile = $db->profiles->findOne(['_id' => new MongoDB\BSON\ObjectId($profile_id)]);

if (!$profile) {
    echo "Profile not found";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle form submission for updating profile
    // Assuming the form fields are 'name', 'summary', 'picture'
    $name = $_POST['name'];
    $summary = $_POST['summary'];
    $picture = $_POST['picture'];

    // Update profile in MongoDB
    $updateResult = $db->profiles->updateOne(['_id' => new MongoDB\BSON\ObjectId($profile_id)], ['$set' => ['name' => $name, 'summary' => $summary, 'picture' => $picture]]);

    if ($updateResult) {
        echo "Profile updated successfully";
    } else {
        echo "Error updating profile";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - Elderly Care Connect</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h1>Edit Profile</h1>
        <form action="edit_profile.php?id=<?php echo $profile_id; ?>" method="post">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo $profile['name']; ?>" required>
            <label for="summary">Summary:</label>
            <textarea id="summary" name="summary" required><?php echo $profile['summary']; ?></textarea>
            <label for="picture">Picture URL:</label>
            <input type="text" id="picture" name="picture" value="<?php echo $profile['picture']; ?>" required>
            <button type="submit">Update Profile</button>
        </form>
    </div>
</body>
</html>

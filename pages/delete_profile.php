<!-- pages/delete_profile.php -->
<?php
require_once '../includes/authenticate.php'; // Include authentication functions
require_once '../includes/db_connection.php'; // Include database connection

if (!isLoggedIn()) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: homepage.php"); // Redirect to homepage if profile ID is not set
    exit();
}

$profile_id = $_GET['id']; // Get profile ID from GET parameters
$profile = $db->profiles->findOne(['_id' => new MongoDB\BSON\ObjectId($profile_id)]);  // Find profile in database
if (($loggeduser['_id']!=$profile['created_by']) && !isAdmin()){
    header("Location: ./access_denied.php");
    exit();
}
//delete uploaded picture from storage
unlink($profile['picturePath']);
$deleteResult = $db->profiles->deleteOne(['_id' => new MongoDB\BSON\ObjectId($profile_id)]); // Delete profile from database

if ($deleteResult) {
    echo "Profile deleted successfully"; // Echo success message if profile deleted successfully
    header("refresh:1;url=../pages/homepage.php"); // Redirect to homepage after 1 second
} else {
    echo "Error deleting profile"; // Echo error message if deletion fails
}
?>

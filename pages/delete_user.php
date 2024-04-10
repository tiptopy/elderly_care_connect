<?php
require_once '../includes/authenticate.php'; // Include authentication functions
require_once '../includes/db_connection.php'; // Include database connection

if (!isLoggedIn()) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

if(!isAdmin()){
    header("Location: access_denied.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: all_users.php"); // Redirect to homepage if user ID is not set
    exit();
}

$user_id = $_GET['id']; // Get user ID from GET parameters
$user = $db->users->findOne(['_id' => new MongoDB\BSON\ObjectId($user_id)]); // Find user in database

//delete user created profiles
$profiles = $db->profiles->find(['created_by' => (string)$user['_id']]);
foreach ($profiles as $profile) {
    //delete elderly profile picture
    unlink($profile['picturePath']);
    //delete elderly profile
    $delete_profile = $db->profiles->deleteOne(['_id' => new MongoDB\BSON\ObjectId($profile['_id'])]);
    if(!$delete_profile){
        echo "error deleting one of the elderly Profiles";
        exit();
    }

}


//delete uploaded picture from storage
unlink($user['picturePath']);
$deleteResult = $db->users->deleteOne(['_id' => new MongoDB\BSON\ObjectId($user_id)]); // Delete user from database

if ($deleteResult) {
    echo "Profile deleted successfully"; // Echo success message if profile deleted successfully
    header("refresh:1;url=./all_users.php"); // Redirect after 1 second
} else {
    echo "Error deleting profile"; // Echo error message if deletion fails
}
?>
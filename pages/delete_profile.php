<!-- pages/delete_profile.php -->
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
$deleteResult = $db->profiles->deleteOne(['_id' => new MongoDB\BSON\ObjectId($profile_id)]);

if ($deleteResult) {
    echo "Profile deleted successfully";
    header("refresh:1;url=../pages/homepage.php");
} else {
    echo "Error deleting profile";
}
?>

<!-- pages/profile.php -->
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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $profile['name']; ?> - Elderly Care Connect</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <div class="container">
        <h1><?php echo $profile['name']; ?></h1>
        <div class="profile">
            <?php
            $imageData = base64_encode($profile['pictureData']->getData());
            $imageSrc = 'data:' . $profile['pictureMimeType'] . ';base64,' . $imageData;
            echo '<img src="' . $imageSrc . '" alt="' . $profile['name'] . '">';
            ?>
            <p><?php echo $profile['summary']; ?></p>
        </div>
    </div>
</body>

</html>
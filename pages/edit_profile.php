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

    // File upload handling
    $pictureData = file_get_contents($_FILES['picture']['tmp_name']);
    $pictureMimeType = mime_content_type($_FILES['picture']['tmp_name']);

    // Update profile in MongoDB
    $updateResult = $db->profiles->updateOne(['_id' => new MongoDB\BSON\ObjectId($profile_id)], ['$set' => [
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
        'pictureMimeType' => $pictureMimeType
    ]]);

    if ($updateResult) {
        echo "Profile updated successfully";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
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
    <link rel="stylesheet" href="../css/edit_profile.css">
    <link rel="stylesheet" href="../css/general.css">


</head>

<body>
    <div class="container-edit-profile">
        <h1>Edit Profile</h1>
        <form action="edit_profile.php?id=<?php echo $profile_id; ?>" method="post" enctype="multipart/form-data">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo $profile['name']; ?>" required>
            <label for="age">Age:</label>
            <input type="number" id="age" name="age" value="<?php echo $profile['age']; ?>" required>
            <label for="summary">Summary:</label>
            <textarea id="summary" name="summary" required><?php echo $profile['summary']; ?></textarea>
            <label for="picture">Picture URL:</label>
            <div class="image-container">
                <?php echo '<img src="data:' . $profile['pictureMimeType'] . ';base64,' . base64_encode($profile['pictureData']->getData()) . '" alt="' . $profile['fname'] . '">'; ?>
            </div>

            <input type="file" id="picture" name="picture" accept="image/*" required>
            <button type="submit">Update Profile</button>
        </form>
    </div>
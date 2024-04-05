<!-- pages/edit_profile.php -->
<?php
require_once '../includes/authenticate.php'; // Include authentication functions
require_once '../includes/db_connection.php'; // Include database connection

if (!isLoggedIn()) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: homepage.php"); // Redirect to homepage if profile ID is not set
    exit;
}

$profile_id = $_GET['id']; // Get profile ID from GET parameters
$profile = $db->profiles->findOne(['_id' => new MongoDB\BSON\ObjectId($profile_id)]); // Find profile in database

if (!$profile) {
    echo "Profile not found"; // Echo error message if profile not found
    exit;
}

if (!($loggeduser['_id']==$profile['created_by'])){
    header("Location: ./access_denied.php");
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
        echo "Profile updated successfully"; // Echo success message if profile updated successfully
        header("Location: " . $_SERVER['PHP_SELF']); // Redirect to current page
        exit();
    } else {
        echo "Error updating profile"; // Echo error message if update fails
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
        <!-- Form to edit profile -->
        <form action="edit_profile.php?id=<?php echo $profile_id; ?>" method="post" enctype="multipart/form-data">
            <label for="fname">First Name*</label>
            <input type="text" id="fname" name="fname" placeholder="Enter First Name" autocomplete="given-name" value="<?php echo $profile['fname']; ?>" required>

            <label for="mname">Middle Name</label>
            <input type="text" id="mname" name="mname" placeholder="Enter Middle Name" autocomplete="additional-name" value="<?php echo $profile['mname']; ?>">

            <label for="sname">Surname*</label>
            <input type="text" id="sname" name="sname" placeholder="Enter Surname" autocomplete="family-name" value="<?php echo $profile['sname']; ?>" required>

            <label for="idno">ID Number*</label>
            <input type="number" id="idno" name="idno" placeholder="Enter National ID number" value="<?php echo $profile['idno']; ?>" required>

            <label for="phone">Phone Number</label>
            <input type="tel" id="phone" name="phone" placeholder="Enter phone number" autocomplete="tel" value="<?php echo $profile['phone']; ?>">

            <label for="address">Address</label>
            <input type="text" id="address" name="address" placeholder="Enter address" autocomplete="street-address" value="<?php echo $profile['address']; ?>">

            <label for="location">Location</label>
            <input type="text" id="location" name="location" placeholder="Enter location" autocomplete="address-level2" value="<?php echo $profile['location']; ?>">

            <label for="county">County</label>
            <input type="text" id="county" name="county" placeholder="Enter county" autocomplete="address-level1" value="<?php echo $profile['county']; ?>">

            <label for="age">Age*</label>
            <input type="number" id="age" name="age" placeholder="Enter age" autocomplete="bday" value="<?php echo $profile['age']; ?>" required>

            <label for="additional">Additional info</label>
            <textarea id="additional" name="additional" placeholder="Enter any additional info e.g hobbies"><?php echo $profile['additional']; ?></textarea>

            <label for="picture">Picture:</label>
            <div class="image-container">
                <?php echo '<img src="data:' . $profile['pictureMimeType'] . ';base64,' . base64_encode($profile['pictureData']->getData()) . '" alt="' . $profile['fname'] . '">'; ?>
            </div>

            <input type="file" id="picture" name="picture" accept="image/*" required>
            <button type="submit">Update Profile</button> <!-- Submit button to update profile -->
        </form>
    </div>
</body>

</html>

<?php include 'header.php'; ?>
<!-- pages/homepage.php -->
<?php
require_once '../includes/authenticate.php';
require_once '../includes/db_connection.php';

if (!isLoggedIn()) {
    header("Location: login.php");
    exit;
}

// Function to compress image
function compressImage($source, $destination, $quality) {
    $info = getimagesize($source);
    if ($info['mime'] == 'image/jpeg') 
        $image = imagecreatefromjpeg($source);
    elseif ($info['mime'] == 'image/png') 
        $image = imagecreatefrompng($source);
    imagejpeg($image, $destination, $quality);
    return $destination;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle form submission for creating profile
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
    $user_id = $_SESSION['user_id'];

    // File upload handling
    $pictureTmpName = $_FILES['picture']['tmp_name'];
    $pictureName = $_FILES['picture']['name'];
    $picturePath = '../images/elderlies/' . uniqid() . '_' . $pictureName;

    // Compress and save image
    $compressedImage = compressImage($pictureTmpName, $picturePath, 50);

    // Insert profile into MongoDB with associated user ID and image path
    $insertResult = $db->profiles->insertOne([
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
        'picturePath' => $compressedImage,
        'created_by' => $user_id
    ]);

    if ($insertResult) {
        echo '<div class="success-message">Profile created successfully</div>';
    } else {
        echo '<div class="error-message">Error creating profile</div>';
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
    <div class="propic">
        <?php echo '<img src="' . $loggeduser['picturePath'] . '" alt="' . $loggeduser['username'] . '">'; ?>
        <?php echo '<a href="./edit_user.php?id=' . $loggeduser['_id'] . '">Edit my Profile</a>'; ?>
    </div>
    <div class="homepage-container">
        <a href="create_profile.php" class="create-profile-link">Create Profile</a>
        <div class="container-homepage">
            <?php
            // Retrieve and display elderly profiles created by the logged-in user
            if (isAdmin()) {
            $profiles = $db->profiles->find();
            } else{
                $profiles = $db->profiles->find(['created_by' => $_SESSION['user_id']]);
            }

            foreach ($profiles as $profile) {
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
            ?>
        </div>
    </div>
</body>

</html>
<?php include '../pages/footer.php'; ?>

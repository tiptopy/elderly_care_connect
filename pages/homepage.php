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
function compressImage($source, $destination, $quality)
{
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
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 400px;
            text-align: center;
        }
    </style>
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
            } else {
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
                echo '<a href="#" onclick="openModal1(\'' . $profile['_id'] . '\')" class="view-profile-link">Edit Profile</a>';
                echo '<a href="#" onclick="openModal(\'' . $profile['_id'] . '\')" class="view-profile-link">Delete Profile</a>';
                echo '</div>';
            }
            ?>
        </div>
    </div>
</body>
<!-- Modal -->
<div id="myModal" class="modal">
    <div class="modal-content">
        <p>Are you sure you want to delete this user?</p>
        <button onclick="deleteUser()">Yes</button>
        <button onclick="closeModal()">No</button>
    </div>
</div>

<div id="myModal1" class="modal">
    <div class="modal-content">
        <p>Are you sure you want to edit this user?</p>
        <button onclick="editUser()">Yes</button>
        <button onclick="closeModal1()">No</button>
    </div>
</div>

<script>
    function openModal(userId) {
        var modal = document.getElementById("myModal");
        modal.style.display = "block";
        // Pass userId to deleteUser function
        modal.dataset.userId = userId;
    }
    function openModal1(userId) {
        var modal = document.getElementById("myModal1");
        modal.style.display = "block";
        // Pass userId to deleteUser function
        modal.dataset.userId = userId;
    }

    function closeModal() {
        document.getElementById("myModal").style.display = "none";
    }
    function closeModal1() {
        document.getElementById("myModal1").style.display = "none";
    }

    function deleteUser() {
        var userId = document.getElementById("myModal").dataset.userId;
        window.location.href = "delete_profile.php?id=" + userId;
    }

    function editUser() {
        var userId = document.getElementById("myModal1").dataset.userId;
        window.location.href = "edit_profile.php?id=" + userId;
    }
</script>

</html>
<?php include '../pages/footer.php'; ?>
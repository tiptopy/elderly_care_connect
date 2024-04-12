<?php include 'header.php'; ?>
<!-- pages/homepage.php -->
<?php
require_once '../includes/authenticate.php';
require_once '../includes/db_connection.php';

if (!isLoggedIn()) {
    header("Location: login.php");
    exit;
}

if (!isAdmin()){
    header("Location: access_denied.php");
    exit();
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
        <div class="container-homepage">
            <?php
            // Retrieve and display user users
            $users = $db->users->find();

            foreach ($users as $user) {
                echo '<div class="profile">';
                echo '<img src="' . $user['picturePath'] . '" alt="' . $user['FullName'] . '">';
                echo '<h3>' . $user['FullName'] . '</h3>';
                echo '<p>Phone Number: ' . $user['PhoneNumber'] . '</p>'; // Display age
                echo '<p>Username: ' . $user['username'] . '</p>'; // Display phone
                echo '<a href="user.php?id=' . $user['_id'] . '" class="view-profile-link">View user</a>';
                echo '<a href="edit_user.php?id=' . $user['_id'] . '" class="view-profile-link">Edit user</a>';
                echo '<a href="#" onclick="openModal(\'' . $user['_id'] . '\')" class="view-profile-link">Delete user</a>';
                echo '</div>';
            }
            ?>
        </div>
    </div>

    <!-- Modal -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <p>Are you sure you want to delete this user?</p>
            <button onclick="deleteUser()">Yes</button>
            <button onclick="closeModal()">No</button>
        </div>
    </div>

    <script>
        function openModal(userId) {
            var modal = document.getElementById("myModal");
            modal.style.display = "block";
            // Pass userId to deleteUser function
            modal.dataset.userId = userId;
        }

        function closeModal() {
            document.getElementById("myModal").style.display = "none";
        }

        function deleteUser() {
            var userId = document.getElementById("myModal").dataset.userId;
            window.location.href = "delete_user.php?id=" + userId;
        }
    </script>
</body>

</html>
<?php include '../pages/footer.php'; ?>

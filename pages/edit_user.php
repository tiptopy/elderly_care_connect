<!-- pages/edit_user.php -->
<?php
require_once '../includes/authenticate.php'; // Include authentication functions
require_once '../includes/db_connection.php'; // Include database connection

$error = "";

if (!isLoggedIn()) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: ../index.php"); // Redirect to homepage if user ID is not set
    exit;
}

$user_id = $_GET['id']; // Get user ID from GET parameters
$user = $db->users->findOne(['_id' => new MongoDB\BSON\ObjectId($user_id)]); // Find user in database

if (!$user) {
    echo "user not found"; // Echo error message if user not found
    exit;
}

if (!($loggeduser['_id'] == $user['_id'])) {
    header("Location: ./access_denied.php"); //Redirect if it is an access not granted
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $FullName = $_POST['FullName'];
    $PhoneNumber = $_POST['PhoneNumber'];
    $username = $_POST['username'];
    $security_question = $_POST['security_question'];
    $security_answer = $_POST['security_answer'];

    // File upload handling
    $imageData = file_get_contents($_FILES['image']['tmp_name']);
    $imageMimeType = mime_content_type($_FILES['image']['tmp_name']);

    $existing_user = $db->users->findOne(['username' => $username]);

    if ($existing_user) {
        echo '<div class="user-name-exists">Username already exists</div>';
    } else {
        
            $updateResult = $db->users->updateOne(['_id' => new MongoDB\BSON\ObjectId($user_id)], ['$set' => [
                'FullName' => $FullName,
                'PhoneNumber' => $PhoneNumber,
                'username' => $username,
                'security_question' => $security_question,
                'security_answer' => $security_answer,
                'imageData' => new MongoDB\BSON\Binary($imageData, MongoDB\BSON\Binary::TYPE_GENERIC),
                'imageMimeType' => $imageMimeType
            ]]);


            if ($updateResult) {
                echo '<div class="success-message">User updated successfully</div>';
                // Redirect to index.php after successful signup
                header("refresh:1;url=./homepage.php");
                exit(); // Ensure script stops execution after redirection
            } else {
                echo '<div class="error-message">Error updatating user</div>';
            }
        
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
    <div class="container-edit-user">
        <h1>Edit user</h1>
        <!-- Form to edit user -->
        <form action="edit_user.php?id=<?php echo $user_id; ?>" method="post" enctype="multipart/form-data">
            <label for="FullName">Full Name:</label>
            <input type="text" id="FullName" name="FullName" value="<?php echo $user['FullName']; ?>" required>
            <label for="PhoneNumber">Phone Number:</label>
            <input type="text" id="PhoneNumber" name="PhoneNumber" value="<?php echo $user['PhoneNumber']; ?>" required>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo $user['username']; ?>" required>
            <span class="alert"><?php echo $error; ?></span><br>
            <label for="security_question">Security Question:</label>
            <select id="security_question" name="security_question">
                <option value="What is your mother's maiden name?" <?php if ($user['security_question'] === "What is your mother's maiden name?") echo 'selected'; ?>>What is your mother's maiden name?</option>
                <option value="What city were you born in?" <?php if ($user['security_question'] === "What city were you born in?") echo 'selected'; ?>>What city were you born in?</option>
                <!-- Add more security questions here -->
            </select>

            <label for="security_answer">Answer:</label>
            <input type="text" id="security_answer" name="security_answer" value="<?php echo $user['security_answer']; ?>" required>
            <label for="image">Picture:</label>
            <div class="image-container">
                <?php echo '<img src="data:' . $user['imageMimeType'] . ';base64,' . base64_encode($user['imageData']->getData()) . '" alt="' . $user['FullName'] . '">'; ?>
            </div>

            <input type="file" id="image" name="image" accept="image/*" required>
            <button type="submit">Update Profile</button> <!-- Submit button to update profile -->
            <br>
            <a href="./forgot_password.php">reset Password</a>
        </div>
</body>

</html>
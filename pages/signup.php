<?php
require_once '../includes/db_connection.php';

$error = "";
$FullName = $PhoneNumber = $username = $security_question = $security_answer = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $FullName = $_POST['FullName'];
    $PhoneNumber = $_POST['PhoneNumber'];
    $username = strtolower($_POST['username']);
    $password = $_POST['password'];
    $security_question = $_POST['security_question'];
    $security_answer = $_POST['security_answer'];

    // File upload handling
    $pictureTmpName = $_FILES['picture']['tmp_name'];
    $pictureName = $_FILES['picture']['name'];
    $picturePath = '../images/users/' . uniqid() . '_' . $pictureName;

    $existing_user = $db->users->findOne(['username' => $username]);

    if ($existing_user) {
        echo '<div class="user-name-exists">Username already exists</div>';
    } elseif (!validatePassword($password)) {
        $error = "Password must be at least 6 characters long, contain at least one uppercase, one lowercase and one number.";
    } else {
        // Compress and save image
        $compressedImage = compressImage($pictureTmpName, $picturePath, 50);

        //insert data into mongodb database.
        $insertResult = $db->users->insertOne([
            'FullName' => $FullName,
            'PhoneNumber' => $PhoneNumber,
            'username' => $username,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'security_question' => $security_question,
            'security_answer' => $security_answer,
            'picturePath' => $compressedImage
        ]);

        if ($insertResult) {
            echo '<div class="success-message">User created successfully</div>';
            // Redirect to index.php after successful signup
            header("refresh:1;url=./login.php");
            exit(); // Ensure script stops execution after redirection
        } else {
            echo '<div class="error-message">Error creating user</div>';
        }
    }
}

function validatePassword($password)
{
    // Password length should be between 6 and 20 characters
    if (strlen($password) < 6 || strlen($password) > 20) {
        return false;
    }
    // Password should contain at least one lowercase letter, one uppercase letter, and one number
    if (!preg_match('/[a-z]/', $password) || !preg_match('/[A-Z]/', $password) || !preg_match('/[0-9]/', $password)) {
        return false;
    }
    return true;
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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup - Elderly Care Connect</title>
    <link rel="stylesheet" href="../css/style.css">
    <!-- Font Awesome for eye icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

</head>

<body>
    <div class="container-signup">
        <div class="box form-box">
            <h1>Sign Up</h1>
            <div class="contain-box">
                <form action="signup.php" method="post" enctype="multipart/form-data">
                    <div class="field input">
                        <label for="FullName">Full Name:</label>
                        <input type="text" id="FullName" name="FullName" required value="<?php echo $FullName; ?>">
                        <label for="PhoneNumber">Phone Number:</label>
                        <input type="text" id="PhoneNumber" name="PhoneNumber" required pattern="(07|\+2547|01|\+2541)[0-9]{8}" title="Please enter a valid Kenyan phone number starting with 07 or +2547 for old numbers, or 01 or +2541 for new numbers">
                        <label for="username">Username:</label>
                        <input type="text" id="username" name="username" required value="<?php echo $username; ?>">
                        <div class="field input input-with-icon">
                            <label for="password">Password:</label>
                            <input type="password" id="password" name="password" required pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{6,20}" title="Password must be at least 6 characters long, contain at least one uppercase letter, one lowercase letter, and one number">
                            <span class="password-toggle" onclick="togglePassword()">
                                <i class="far fa-eye"></i>
                            </span>
                            <span class="alert"><?php echo $error; ?></span><br>
                        </div>
                        <label for="security_question">Security Question:</label>
                        <select id="security_question" name="security_question">
                            <option value="What is your mother's maiden name?" <?php if ($security_question === "What is your mother's maiden name?") echo "selected"; ?>>What is your mother's maiden name?</option>
                            <option value="What city were you born in?" <?php if ($security_question === "What city were you born in?") echo "selected"; ?>>What city were you born in?</option>
                            <!-- Add more security questions here -->
                        </select>
                        <label for="security_answer">Answer:</label>
                        <input type="text" id="security_answer" name="security_answer" required value="<?php echo $security_answer; ?>">
                        <label for="picture">Profile Picture:</label>
                        <input type="file" id="picture" name="picture" accept="image/jpeg, image/png" required>
                        <button type="submit">Signup</button>
                    </div>
                </form>
                <div class="links">
                    <p>Have an account? <a href="./login.php">Login</a></p>
                </div>
            </div>
        </div>
    </div>
    <script src="..//scripts.js"></script>
</body>

</html>
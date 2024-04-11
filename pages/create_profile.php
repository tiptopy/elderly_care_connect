<!-- pages/create_profile.php -->

<?php
require_once('../includes/authenticate.php');

if(!isLoggedIn()){
    header('Location: ./login.php'); //Redirect to login when user is not logged in.
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Profile - Elderly Care Connect</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <div class="container-createprofile">
        <h2>Create New Profile</h2>
        <!-- Form to create a new profile -->
        <form action="homepage.php" method="post" enctype="multipart/form-data">
            <label for="fname">First Name*</label>
            <input type="text" id="fname" name="fname" placeholder="Enter First Name" autocomplete="given-name" required>

            <label for="mname">Middle Name</label>
            <input type="text" id="mname" name="mname" placeholder="Enter Middle Name" autocomplete="additional-name">

            <label for="sname">Surname*</label>
            <input type="text" id="sname" name="sname" placeholder="Enter Surname" autocomplete="family-name" required>

            <label for="idno">ID Number*</label>
            <input type="number" id="idno" name="idno" placeholder="Enter National ID number" required>

            <label for="phone">Phone Number</label>
            <input type="tel" id="phone" name="phone" placeholder="Enter phone number" autocomplete="tel">

            <label for="address">Address</label>
            <input type="text" id="address" name="address" placeholder="Enter address" autocomplete="street-address">

            <label for="location">Location</label>
            <input type="text" id="location" name="location" placeholder="Enter location" autocomplete="address-level2">

            <label for="county">County</label>
            <input type="text" id="county" name="county" placeholder="Enter county" autocomplete="address-level1">

            <label for="age">Age*</label>
            <input type="number" id="age" name="age" placeholder="Enter age" autocomplete="bday" required>

            <label for="additional">Additional info</label>
            <textarea id="additional" name="additional" placeholder="Enter any additional info e.g hobbies"></textarea>

            <label for="picture">Picture*</label>
            <input type="file" id="picture" name="picture" accept="image/*" required>

            <button type="submit">Create Profile</button> <!-- Submit button to create profile -->
        </form>

    </div>
</body>

</html>

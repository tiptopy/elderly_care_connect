<?php
require_once './includes/authenticate.php';
require_once './includes/db_connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elderly Care Connect</title>
    <link rel="stylesheet" href="./css/style.css">
    <style>
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .profile {
            display: inline-block;
            width: calc(33.33% - 20px); /* Adjust as needed for grid spacing */
            margin: 10px;
            text-align: center;
        }

        .profile img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .profile h3 {
            margin-top: 10px;
        }

        .profile p {
            margin-bottom: 10px;
        }

        .profile a {
            display: block;
            margin-top: 10px;
            text-decoration: none;
            color: #007bff;
        }
    </style>
    <button>donate</button>
</head>
<body>
    <div class="container">
        <h1>Welcome to Elderly Care Connect</h1>
        <h2>Summary of Elderly Profiles</h2>
        <?php
        // Retrieve and display elderly profiles created by the logged-in user
        $profiles = $db->profiles->find();

        foreach ($profiles as $profile) {
            echo '<div class="profile">';
            echo '<img src="' . $profile['picture'] . '" alt="' . $profile['name'] . '">';
            echo '<h3>' . $profile['name'] . '</h3>';
            echo '<p>' . $profile['summary'] . '</p>';
            echo '<a href="/pages/profile.php?id=' . $profile['_id'] . '">View Full Profile</a>';
            echo '<a href="/pages/edit_profile.php?id=' . $profile['_id'] . '">Edit</a>';
            echo '<a href="/pages/delete_profile.php?id=' . $profile['_id'] . '">Delete</a>';
            echo '</div>';
        }
        ?>
        </div>
</body>
</html>

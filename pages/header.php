<!-- header.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/header.css">

</head>
<?php
require_once '../includes/authenticate.php';
?>

<body>
<header>
    <div class="container-header">
        <h1>EC Care</h1>
        <nav class="nav-header">
            <ul>
                <?php
            if (!isLoggedIn()) {
                echo '<a href="#"> Home</a>';
                echo '<a href="#"> About Us</a>';
                echo '<a href="#"> Login</a>';
                echo '<a href="#"> Sign Up</a>';
                

            }
            else
            {
                echo '<a href="#"> Home</a>';
                echo '<a href="#"> About Us</a>';
                echo '<a href="#">My Profiles </a>';
                echo '<a href="../index.php?logout=true">Logout</a>';

            
            }
            ?>

            </ul>
        </nav>
    </div>
</header>

</body>
</html>

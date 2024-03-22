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
        <nav>
            <ul>
                <?php
            if (!isLoggedIn()) {
                echo '<a href="./pages/login.php"> Create profile here</a>';

            }
            else
            {
                echo '<a href="./pages/homepage.php">View my created profiles </a>';
            echo '<a href="?logout=true">Logout</a>';
            }
            ?>

            </ul>
        </nav>
    </div>
</header>

</body>
</html>

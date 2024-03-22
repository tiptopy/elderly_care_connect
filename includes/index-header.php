

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/index-header.css">
</head>

<?php
require_once './includes/authenticate.php';
require_once './includes/db_connection.php';
?>
<body>
    <!-- index_header.php -->
<header>
    <div class="container-index-header">
        <h1>Elderly Care Connect</h1>
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
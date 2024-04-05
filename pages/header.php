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
            <h1>ECC Care</h1>
            <nav class="nav-header">
                <ul>
                    <?php
                    if (!isLoggedIn()) {
                        // Display links for non-logged-in users
                        echo '<a href="../"> Home</a>';
                        echo '<a href="#"> About Us</a>';
                        echo '<a href="../pages/login.php"> Login</a>';
                        echo '<a href="../pages/signup.php"> Sign Up</a>';
                    } else {
                        // Display links for logged-in users
                        echo '<a href="../"> Home</a>';
                        echo '<a href="#"> About Us</a>';
                        echo '<a href="../pages/profile.php">My Profiles </a>';
                        echo '<a href="../pages/logout.php">Logout</a>';
                    }
                    ?>
                </ul>
            </nav>
        </div>
        <nav id="humberger-nav">

<div class="humberger-menu">
  <div class="humberger-icon" onclick="toggleMenu()">
    <span></span>
    <span></span>
    <span></span>

  </div>
  <div class="menu-links">
  <nav >
              <ul onclick="toggleMenu()">
                  <?php
                  if (!isLoggedIn()) {
                      echo '<a href="../"> Home</a>';
                      echo '<a href="#"> About Us</a>';
                      echo '<a href="./login.php"> Login</a>';
                      echo '<a href="./signup.php"> Sign Up</a>';
                  } else {
                      echo '<a href="..//index.php"> Home</a>';
                      echo '<a href="#"> About Us</a>';
                      echo '<a href="./profile.php">My profiles</a>';
                      echo '<a href="./logout.php">Logout</a>';
                  }
                  ?>
              </ul>
          </nav>

  </div>
</div
>

</nav>
    </header>
    <script src="..//scripts.js"></script>
</body>

</html>

<!-- header.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<?php
require_once '../includes/authenticate.php';
?>

<body>
    <header>
        <div class="container-header">
            <h4>ECC Care</h4>
            <nav class="nav-header">
                <ul>
                    <?php
                    if (!isLoggedIn()) {
                        // Display links for non-logged-in users
                        echo '<a href="../"> Home</a>';
                        echo '<a href="../pages/about_us.php"> About Us</a>';
                        echo '<a href="../pages/login.php"> Login</a>';
                        echo '<a href="../pages/signup.php"> Sign Up</a>';
                    } else {
                        // Display links for logged-in users
                        echo '<a href="../"> Home</a>';
                        echo '<a href="./about_us.php"> About Us</a>';
                        echo '<a href="../pages/homepage.php">My Profiles </a>';
                        if (isAdmin()) {
                            echo '<a href="./all_donations.php">All donations</a>';
                            echo '<a href="./all_users.php">All Users</a>';
                          }
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
                      echo '<a href="./about_us.php"> About Us</a>';
                      echo '<a href="./login.php"> Login</a>';
                      echo '<a href="./signup.php"> Sign Up</a>';
                  } else {
                      echo '<a href="../index.php"> Home</a>';
                      echo '<a href="./about_us.php"> About Us</a>';
                      echo '<a href="./homepage.php">My profiles</a>';
                      if (isAdmin()) {
                        echo '<a href="./all_donations.php">All donations</a>';
                        echo '<a href="./all_users.php">All Users</a>';
                      }
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
    <script src="../scripts.js"></script>
</body>

</html>

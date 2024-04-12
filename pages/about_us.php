<?php include 'header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<title>About Us</title>
<style>
  body { 
    font-family: Arial, sans-serif;
    background-color: #f2f2f2;
    margin: 0;
    padding: 0;
  }
  h1, h2, h3 {
    margin-top: 0;
  }
  .container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
  }
  .about-section {
    background-color: white; padding: 40px; text-align: center; display: flex; justify-content: center; flex-wrap: wrap;
  .team-member { 
    display: flex; 
    flex-direction: column; 
    align-items: center; 
    margin: 10px; 
    position: relative; 
    width: 200px; 
  }
  .team-member:hover .member-card { 
    transform: translateY(-10px); 
  }
  .member-card { 
    background-color: #f9f9f9; 
    padding: 20px; 
    border-radius: 8px; 
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); 
    transition: transform 0.3s ease; 
  }
  .member-info { 
    margin-top: 10px; 
    text-align: center; 
  }
  .member-role { 
    font-weight: bold; 
  }
  .core-values { 
    background-color: white; 
    margin-top: 20px; 
    padding: 20px; 
    text-align: center; 
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  }
  .core-values h2 {
    margin-top: 0;
  }
  .core-values p {
    margin-bottom: 20px;
  }
  .core-values ul {
    list-style-type: none;
    padding: 0;
    margin: 0;
  }
  .core-values li {
    margin-bottom: 10px;
  }
  .social-links { 
    margin-top: 10px; 
  }
  .social-links a { 
    display: inline-block; 
    margin-right: 5px; 
  }
</style>
</head>
<body>

<div class="container">

  <div class="about-section">
    <h2> Our Team</h2>
    <div class="team-member">
      <div class="member-card">
        <img src="../images/erick.jpg" alt="Erick" style="width:100px; height:100px; border-radius:50%;">
        <div class="member-info">
          <div class="member-name">Erick</div>
          <div class="member-role">Founder</div>
          <p>One of the founding members involved in developing ECC. He believes the elderly are a paramount part of our society.</p>
          <div class="social-links">
            <a href="https://www.facebook.com/erick.profile" target="_blank" rel="noopener noreferrer"><i class="fab fa-facebook"></i></a>
            <a href="https://www.Twitter.com/erick.profile" target="_blank" rel="noopener noreferrer">   <i class="fab fa-twitter"></i></a>
            <!-- Add more social media links as needed -->
          </div>
        </div>
      </div>
    </div>
    <div class="team-member">
      <div class="member-card">
        <img src="../images/erick.jpg" alt="Erick" style="width:100px; height:100px; border-radius:50%;">
        <div class="member-info">
          <div class="member-name">Erick</div>
          <div class="member-role">Founder</div>
          <p>One of the founding members involved in developing ECC. He believes the elderly are a paramount part of our society.</p>
          <div class="social-links">
          <a href="https://www.facebook.com/erick.profile" target="_blank" rel="noopener noreferrer"><i class="fab fa-facebook"></i></a>
          <a href="https://www.Twitter.com/erick.profile" target="_blank" rel="noopener noreferrer">   <i class="fab fa-twitter"></i></a>
            <!-- Add more social media links as needed -->
          </div>
        </div>
      </div>
    </div>
    <div class="team-member">
      <div class="member-card">
        <img src="../images/erick.jpg" alt="Erick" style="width:100px; height:100px; border-radius:50%;">
        <div class="member-info">
          <div class="member-name">Erick</div>
          <div class="member-role">Founder</div>
          <p>One of the founding members involved in developing ECC. He believes the elderly are a paramount part of our society.</p>
          <div class="social-links">
          <a href="https://www.facebook.com/erick.profile" target="_blank" rel="noopener noreferrer"><i class="fab fa-facebook"></i></a>
          <a href="https://www.Twitter.com/erick.profile" target="_blank" rel="noopener noreferrer">   <i class="fab fa-twitter"></i></a>
            <!-- Add more social media links as needed -->
          </div>
        </div>
      </div>
    </div>
    <div class="team-member">
      <div class="member-card">
        <img src="../images/erick.jpg" alt="Erick" style="width:100px; height:100px; border-radius:50%;">
        <div class="member-info">
          <div class="member-name">Erick</div>
          <div class="member-role">Founder</div>
          <p>One of the founding members involved in developing ECC. He believes the elderly are a paramount part of our society.</p>
          <div class="social-links">
          <a href="https://www.facebook.com/erick.profile" target="_blank" rel="noopener noreferrer"><i class="fab fa-facebook"></i></a>
          <a href="https://www.Twitter.com/erick.profile" target="_blank" rel="noopener noreferrer">   <i class="fab fa-twitter"></i></a>
            <!-- Add more social media links as needed -->
          </div>
        </div>
      </div>
    </div>
    <!-- Repeat for other members -->
    <!-- ... -->
  </div>

  <div class="about-section">
    <h2>About Us</h2>
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla facilisi. Phasellus at varius nunc. Nulla facilisi. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Donec id arcu non tellus scelerisque egestas. Cras luctus ipsum id velit fringilla, id dictum justo feugiat. Nunc malesuada vestibulum nisi nec lacinia.</p>
  

  <div class="core-values">
    <h2>Core Values</h2>
    <p>At our company, we are committed to the following core values:</p>
    <ul>
      <li>Integrity</li>
      <li>Empathy</li>
      <li>Innovation</li>
      <li>Collaboration</li>
      <li>Excellence</li>
    </ul>
  </div>
</div>
</div>
</body>
</html>
<?php include 'footer.php'; ?>
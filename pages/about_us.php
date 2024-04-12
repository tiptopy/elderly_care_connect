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
          <div class="member-name">Erick Muteti</div>
          <div class="member-role">Founder</div>
          <p>One of the founding members involved in developing ECC. He believes the elderly are a paramount part of our society.</p>
          <div class="social-links">
            <a href="https://web.facebook.com/eric.muteti.5201" target="_blank" rel="noopener noreferrer"><i class="fab fa-facebook"></i></a>
            <a href="https://twitter.com/ErickMuteti254" target="_blank" rel="noopener noreferrer">   <i class="fab fa-twitter"></i></a>
            <!-- Add more social media links as needed -->
          </div>
        </div>
      </div>
    </div>
    <div class="team-member">
      <div class="member-card">
        <img src="../images/erick.jpg" alt="Erick" style="width:100px; height:100px; border-radius:50%;">
        <div class="member-info">
          <div class="member-name">Petetr Wafula</div>
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
          <div class="member-name"> Fidelis Kisevu</div>
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
          <div class="member-name">Kerry</div>
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
    <p>
Elderly Care Connect (ECC) is a compassionate initiative conceived by a team of four passionate university students.<br>
 Driven by the desire to make a positive impact on the lives of the elderly, ECC was born out of the recognition of the challenges faced by this vulnerable demographic.
<h2>Our Vision</h2>
At ECC, we envision a world where elderly individuals can age gracefully with dignity and access to the support they need.<br>
 Our ultimate goal is to create a seamless and comprehensive platform that empowers seniors to live fulfilling lives while remaining connected to their communities.
<h2>Our Mission</h2>
Our mission is simple yet profound: to bridge the gap between elderly individuals and the resources available to them. We strive to provide a user-friendly platform that offers easy access to essential services, vital information, and a supportive network of caregivers and volunteers.
<h2>What Drives Us</h2>
ECC is fueled by empathy, innovation, and a deep-rooted commitment to social responsibility. <br>
We believe that every elderly person deserves to age with grace, dignity, and the respect they deserve. By leveraging technology and human compassion, we aim to make a tangible difference in the lives of seniors across the globe.
<h2>Our Approach</h2>
ECC adopts a holistic approach to elderly care, recognizing the multifaceted needs of this diverse demographic. Our platform integrates user-friendly design with comprehensive features, ensuring that elderly individuals can navigate the digital landscape with ease and confidence.
<h2>How We Make a Difference</h2>
Through ECC, we strive to empower elderly individuals to live independently while staying connected to their communities. Whether it's accessing healthcare resources, finding social activities, or connecting with local support services, ECC serves as a lifeline for seniors seeking assistance and companionship.
<h2>Join Us in Our Mission</h2>
We invite you to join us on our journey to redefine elderly care and support. Whether you're a caregiver, volunteer, healthcare professional, or simply someone who shares our vision, there's a place for you in the ECC community. Together, we can make a meaningful difference in the lives of elderly individuals and create a more inclusive and compassionate society for all.
This condensed "About Us" section captures the essence of Elderly Care Connect while remaining concise and impactful.</p>
  

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
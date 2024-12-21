<?php

// to show error codes
ini_set("display_errors", 1);

// call dbconnection file to use
require_once("databaseconnection.php");

// creat session if not created
if (!isset($_SESSION)) {
  session_start();
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>AUS Sport Club</title>

  <!-- AOS Library CSS Link -->
  <link rel="stylesheet" href="../../dist/libraries/aos/aos.css" />

  <!-- Bootstrap Library CSS Link -->
  <link rel="stylesheet" href="../../dist/libraries/bootstrap-5.0.2/css/bootstrap.min.css" />

  <!-- Font Awesome CSS Link -->
  <link rel="stylesheet" href="../../dist/libraries/fontawesome-free-6.7.1-web/css/all.min.css" />

  <!-- j-Query Ui CSS Link -->
  <link rel="stylesheet" href="../../dist/libraries/jquery-ui/jquery-ui.css" />

  <!-- Custom CSS Link -->
  <link rel="stylesheet" type="text/css" href="../css/style.css" />
  <link rel="stylesheet" type="text/css" href="../css/navbar.css" />
  <link rel="stylesheet" type="text/css" href="../css/footer.css" />
  <link rel="stylesheet" type="text/css" href="../css/aboutus.css" />
</head>

<body>
  <!-- NavBar Section -->
  <nav class="navbar navbar-expand-lg navbar-dark cstm-navbar">
    <div class="container-fluid">
      <!-- Brand Name -->
      <a class="navbar-brand text-uppercase fw-bold" href="#">
        <span class="brand-highlight">AUS</span> Sport Club
      </a>
      <!-- Mobile Toggle -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
        aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <!-- Navigation Menu -->
      <div class="collapse navbar-collapse" id="navbarContent">
        <ul class="navbar-nav mx-auto d-flex align-items-center">
          <li class="nav-item">
            <a class="nav-link" href="./index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./events.php">Events</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./news.php">News</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./aboutus.php">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./contactus.php">Contact</a>
          </li>
        </ul>
        <!-- Login/Register/Profile -->
        <ul class="navbar-nav ms-auto d-flex align-items-center">
          <?php if (!isset($_SESSION['email'])) { ?>
            <li class="nav-item">
              <a class="nav-link btn-login" href="auth.php">Login</a>
            </li>
            <li class="nav-item">
              <a class="nav-link btn-register" href="auth.php">Register</a>
            </li>
          <?php } else { ?>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle profile-dropdown" href="#" id="profileMenu" role="button"
                data-bs-toggle="dropdown" aria-expanded="false">
                <img src="../../dist/img/profile.png" alt="Profile" class="rounded-circle profile-pic" />
              </a>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileMenu">
                <li><a class="dropdown-item" href="profile.php">Profile</a></li>
                <li><a class="dropdown-item" href="#">Settings</a></li>
                <li><a class="dropdown-item" href="exit.php">Logout</a></li>
              </ul>
            </li>
          <?php } ?>
        </ul>
      </div>
    </div>
  </nav>
  <!-- NavBar Section -->

  <!-- About Us Section -->
  <section id="about-us" class="py-5">
    <div class="container">
      <!-- Heading Section -->
      <div class="text-center mb-5" data-aos="fade-up">
        <h2 id="heading_title"></h2>
        <p id="heading_desc" class="lead">
        </p>
      </div>

      <!-- Story Section -->
      <div class="row align-items-center mb-5">
        <div class="col-md-6 mb-5" data-aos="fade-right">
          <img src="../../dist/img/aboutus/img1.png" id="journey_image" class="img-fluid rounded shadow" alt="Our Story" />
        </div>
        <div class="col-md-6" data-aos="fade-left">
          <h3 id="journey_title"></h3>
          <p id="journey_content1">
          </p>
          <p id="journey_content2">
          </p>
          <a href="contactus.php" class="btn button-1 mt-3">Contact Us</a>
        </div>
      </div>

      <!-- Vision, Mission, and Values -->
      <div class="row text-center">
        <div class="col-md-4 mb-4" data-aos="zoom-in">
          <div class="card border-0 shadow-sm h-100 bg-dark text-light">
            <div class="card-body">
              <i class="fas fa-lightbulb fa-3x text-primary mb-3"></i>
              <h4 id="vision_title"></h4>
              <p id="vision_content">
              </p>
            </div>
          </div>
        </div>
        <div class="col-md-4 mb-4" data-aos="zoom-in" data-aos-delay="200">
          <div class="card border-0 shadow-sm h-100 bg-dark text-light">
            <div class="card-body">
              <i class="fas fa-heartbeat fa-3x text-danger mb-3"></i>
              <h4 id="mission_title"></h4>
              <p id="mission_content">
              </p>
            </div>
          </div>
        </div>
        <div class="col-md-4 mb-4" data-aos="zoom-in" data-aos-delay="400">
          <div class="card border-0 shadow-sm h-100 bg-dark text-light">
            <div class="card-body">
              <i class="fas fa-star fa-3x text-warning mb-3"></i>
              <h4 id="values_title"></h4>
              <p id="values_content">
              </p>
            </div>
          </div>
        </div>
      </div>

      <!-- Meet Our Team -->
      <div class="text-center mt-5 mb-5" data-aos="fade-up">
        <h2 id="team_title"></h2>
        <p class="team_desc">
        </p>
      </div>
      <div class="row text-center" id="team_members">
      </div>

      <!-- Call to Action -->
      <div class="text-center mt-5" data-aos="fade-up">
        <h3>Join Us Today!</h3>
        <p class="lead">
          Be part of our thriving community and take the first step toward
          your fitness goals.
        </p>
        <a href="#membership" class="btn button-2 btn-lg">Get Started</a>
      </div>
    </div>
  </section>

  <!-- About Us Section -->

  <!-- Footer Section -->
  <footer class="footer">
    <div class="footer-container">
      <!-- Footer Navigation -->
      <div class="footer-nav">
        <h5 class="footer-title">Quick Links</h5>
        <ul class="footer-links">
          <li><a href="./index.php">Home</a></li>
          <li><a href="./events.php">Events</a></li>
          <li><a href="./news.php">News</a></li>
          <li><a href="./aboutus.php">About Us</a></li>
          <li><a href="./contactus.php">Contact</a></li>
        </ul>
      </div>

      <!-- Contact Information -->
      <div class="footer-contact">
        <h5 class="footer-title">Contact Us</h5>
        <p>Email: <a href="mailto:info@example.com">aus@sportclub.com</a></p>
        <p>Phone: +95 999 888 777</p>
        <p>Address: Mandalay, Myanmar</p>
      </div>

      <!-- Social Media Links -->
      <div class="footer-social">
        <h5 class="footer-title">Follow Us</h5>
        <ul class="social-icons">
          <li>
            <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
          </li>
          <li>
            <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
          </li>
          <li>
            <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
          </li>
          <li>
            <a href="#" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
          </li>
        </ul>
      </div>
    </div>

    <!-- Copyright Notice -->
    <div class="footer-bottom">
      <p>&copy; 2024 Your Sports Club. All Rights Reserved.</p>
    </div>
  </footer>
  <!-- Footer Section -->

  <!-- AOS Library JS Link -->
  <script src="../../dist/libraries/aos/aos.js"></script>
  <script>
    AOS.init();
  </script>

  <!-- Font Awesome Library JS Link -->
  <script src="../../dist/libraries/fontawesome-free-6.7.1-web/js/all.min.js"></script>

  <!-- Bootstrap Library JS Link -->
  <script src="../../dist/libraries/bootstrap-5.0.2/js/bootstrap.min.js"></script>

  <!-- j-Query Ui JS Link -->
  <script src="../../dist/libraries/jquery-ui/jquery-ui.js"></script>

  <!-- jQuery JS Link -->
  <script src="../../dist/libraries/jquery/jquery-3.7.1.min.js"></script>

  <!-- Custom JS Link -->
  <script src="../js/app.js"></script>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function() {
      $.ajax({
          url: 'about.json', // Path to your JSON file
          method: 'GET',
          dataType: 'json'
        })
        .done(function(data) {
          // Populate About Us Section
          // console.log(data.aboutUs.title);
          $('#heading_title').text(data.aboutUs.title);
          $('#heading_desc').text(data.aboutUs.description);
          $('#journey_title').text(data.aboutUs.journey.title);
          $('#journey_content1').text(data.aboutUs.journey.content1);
          $('#journey_content2').text(data.aboutUs.journey.content2);
          $('#journey_image').attr('src', data.aboutUs.journey.image);

          // Populate Vision, Mission, Values Section
          $('#vision_title').text(data.visionMissionValues.vision.title);
          $('#vision_content').text(data.visionMissionValues.vision.content);

          $('#mission_title').text(data.visionMissionValues.mission.title);
          $('#mission_content').text(data.visionMissionValues.mission.content);

          $('#values_title').text(data.visionMissionValues.values.title);
          $('#values_content').text(data.visionMissionValues.values.content);

          // Populate Team Section
          $('#team_title').text(data.team.title);
          $('#team_desc').text(data.team.subtitle);

          let teamContainer = $('#team_members');
          data.team.members.forEach(member => {
            teamContainer.append(`
            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="100">
              <div class="team-member">
                <img src="${member.image}" class="img-fluid rounded-circle shadow-sm"
                  alt="${member.name}" style="width: 180px; height: 180px; object-fit: cover" />
                <h5 class="mt-3">${member.name}</h5>
                <p>${member.role}</p>
                <p class="text-muted">
                  ${member.description}
                </p>
              </div>
            </div>
          `);
          });
        })
        .fail(function(error) {
          console.error('Error loading JSON:', error);
          $('#error-message').text('Failed to load data. Please try again later.');
        });
    });
  </script>


</body>

</html>
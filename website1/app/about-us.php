<?php

// to show error codes
ini_set("display_errors", 1);

// call dbconnection file to use
require_once("dbconnect.php");
// call sessionconfig file to use its methods
require_once("sessionconfig.php");

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <title>AUS Sport Club</title>

  <meta charset="UTF-8" />
  <meta
    name="viewport"
    content="width=device-width, initial-scale=1, maximum-scale=1" />

  <!-- Bootstrap CSS link -->
  <link rel="stylesheet" href="../public/libs/css/bootstrap.min.css" />

  <!-- Font Awesome CSS link -->
  <link
    rel="stylesheet"
    href="../public/libs/font-awesome-5/css/fontawesome-all.min.css" />

  <!-- AOS CSS Link -->
  <link rel="stylesheet" href="../public/libs/css/aos.css" />

  <!-- Custom CSS link -->
  <link rel="stylesheet" href="../css/style.css" />
  <link rel="stylesheet" href="../css/about-us.css" />
</head>

<body>
  <!-- MENU BAR -->
  <nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
      <a class="navbar-brand" href="./home.php">AUS Sport Club</a>

      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mx-auto">
          <li class="nav-item">
            <a href="home.php" class="nav-link smoothScroll">Home</a>
          </li>
          <li class="nav-item">
            <a href="events.php" class="nav-link smoothScroll">Events</a>
          </li>
          <li class="nav-item">
            <a href="news.php" class="nav-link smoothScroll">News & Announcements</a>
          </li>
          <li class="nav-item">
            <a href="about-us.php" class="nav-link smoothScroll">About Us</a>
          </li>
          <li class="nav-item">
            <a href="contact-us.php" class="nav-link smoothScroll">Contact</a>
          </li>
        </ul>

        <ul class="navbar-nav ml-auto d-flex align-items-center">
          <?php if (verifysession('email')) { ?>
            <li class="nav-item">
              <a href="./logout.php" class="nav-link">Logout</a>
            </li>
            <li class="nav-item">
              <a href="./profile.php" class="nav-link">
                <img
                  src="../public/images/auth/profile_icon.png"
                  style="width: 30px"
                  alt="Profile"
                  class="profile-pic" />
              </a>
            </li>
          <?php } else { ?>
            <li class="nav-item">
              <a href="./login.php" class="nav-link">Login</a>
            </li>
            <li class="nav-item">
              <a href="./register.php" class="nav-link">Register</a>
            </li>
          <?php } ?>
        </ul>
      </div>
    </div>
  </nav>

  <!-- ABOUT US  -->
  <section class="about section" id="about">
    <div class="container">
      <div class="row">
        <!-- Club DESCRIPTION -->
        <div class="mt-lg-5 mb-lg-0 mb-4 col-lg-6 col-md-10 mx-auto col-12" id="club-desc">
          <h2 class="mb-4" data-aos="fade-up" data-aos-delay="300" id="welcome-title"></h2>

          <p data-aos="fade-up" data-aos-delay="400" id="welcome-description"></p>

          <p data-aos="fade-up" data-aos-delay="500" id="welcome-values"></p>
        </div>

        <!-- TEAM  -->
        <div class="col-lg-6 col-md-12 mt-5" id="team-section">
          <h3
            class="text-center mb-4"
            data-aos="fade-up"
            data-aos-delay="600"
            id="team-title">
            Meet Our Team
          </h3>
          <div class="row" id="team-container">
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- FOOTER -->
  <footer class="site-footer">
    <div class="container">
      <div class="row align-items-center">
        <!-- Left Section -->
        <div class="ml-auto col-lg-4 col-md-5 text-center text-md-left">
          <p class="copyright-text mb-2">
            Copyright &copy; 2024 AUS Sport Club
          </p>
        </div>

        <!-- Right Section -->
        <div
          class="d-flex flex-column flex-md-row justify-content-center mx-auto col-lg-5 col-md-7 col-12">
          <p class="mx-md-4 mx-lg-5 mb-2 mb-md-0">
            <i class="fas fa-envelope mr-2" style="color: #c60a11"></i>
            <a href="#" style="color: #a47800; text-decoration: none">aussportclub@company.co</a>
          </p>
          <p>
            <i class="fa fa-phone mr-2" style="color: #c60a11"></i>
            09 876 543 210
          </p>
        </div>
      </div>

      <!-- Divider -->
      <hr style="border-top: 1px solid #444; margin: 1.5rem 0" />

      <!-- Social Links -->
      <div class="row">
        <div class="col-12 text-center">
          <a href="#" class="mr-3" style="color: #f97316; font-size: 1.2rem">
            <i class="fab fa-facebook"></i>
          </a>
          <a href="#" class="mr-3" style="color: #f97316; font-size: 1.2rem">
            <i class="fab fa-twitter"></i>
          </a>
          <a href="#" class="mr-3" style="color: #f97316; font-size: 1.2rem">
            <i class="fab fa-instagram"></i>
          </a>
          <a href="#" style="color: #f97316; font-size: 1.2rem">
            <i class="fab fa-linkedin"></i>
          </a>
        </div>
      </div>
    </div>
  </footer>

  <!-- AOS JS link -->
  <script src="../public/libs/js/aos.js"></script>

  <!-- Bootstrap JS link -->
  <script src="../public/libs/js/bootstrap.min.js"></script>

  <!-- JQuery JS link -->
  <script src="../public/libs/js/jquery-3.7.1.min.js"></script>

  <!-- Smoothscroll JS link -->
  <script src="../public/libs/js/smoothscroll.js"></script>

  <!-- Custom JS link -->
  <script src="../js/app.js"></script>
  <script type="text/javascript">
    fetch('about-us.json')
      .then(response => response.json())
      .then(data => {
        // Populate the Welcome Section
        document.getElementById('welcome-title').innerText = data.welcomeSection.title;
        document.getElementById('welcome-description').innerText = data.welcomeSection.description;
        document.getElementById('welcome-values').innerText = data.welcomeSection.values;

        // Populate the Team Section
        const teamContainer = document.getElementById('team-container');
        data.teamSection.members.forEach(member => {
          const memberCard = `
              <div
                class="col-md-6 col-12 mb-4"
                data-aos="fade-up"
                data-aos-delay="700"
              >
                <div class="team-thumb">
                  <img
                    src="../${member.image}"
                    class="img-fluid"
                    alt="${member.name}"
                  />
                  <div class="team-info d-flex flex-column">
                    <h3>${member.name}</h3>
                    <span>${member.role}</span>
                    <p>${member.description}
                    </p>
                    <ul class="social-icon mt-3">
                      <li><a href="#" class="fa fa-twitter"></a></li>
                      <li><a href="#" class="fa fa-instagram"></a></li>
                    </ul>
                  </div>
                </div>
              </div>`;
          teamContainer.innerHTML += memberCard;
        });
      })
      .catch(error => console.error('Error fetching data:', error));
  </script>
  
</body>

</html>
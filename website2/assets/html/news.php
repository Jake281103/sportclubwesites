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
  <link rel="stylesheet" type="text/css" href="../css/news.css" />
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

  <!-- News & Announcement Section -->
  <section class="news-announcements section" id="news-announcements">
    <div class="container">
      <!-- Section Header -->
      <div class="section-header text-center mb-5">
        <h1 class="text-uppercase text-warning" data-aos="fade-down" data-aos-duration="800">
          News & Announcements
        </h1>
        <p class="text-light" data-aos="fade-up" data-aos-duration="800">
          Stay updated with the latest news and happenings from AUS Sport
          Club.
        </p>
      </div>

      <!-- Featured News -->
      <div class="featured-news mb-5 p-4 rounded shadow-lg bg-dark text-white">
        <div class="row align-items-center">
          <div class="col-lg-6" data-aos="fade-right">
            <img src="../../dist/img/news/img1.png" alt="Featured News" class="img-fluid rounded" />
          </div>
          <div class="col-lg-6" data-aos="fade-left">
            <h2 class="text-uppercase">
              Featured: New Clubhouse Inauguration
            </h2>
            <p class="text-muted">Posted on: November 25, 2024</p>
            <p>
              We are thrilled to announce the grand opening of our new
              clubhouse! This state-of-the-art facility will serve as the
              heart of our community, hosting events, meetings, and training
              sessions.
            </p>
            <a href="#" class="btn btn-light btn-lg mt-3">
              Learn More
            </a>
          </div>
        </div>
      </div>

      <!-- News Lists -->
      <div class="row">
        <!-- News Item -->
        <div class="col-lg-4 col-md-6 mb-4" data-aos="flip-left" data-aos-duration="1000">
          <div class="news-card shadow-lg">
            <div class="news-image-wrapper">
              <img src="../../dist/img/news/news1.png" alt="News 1" class="news-image" />
            </div>
            <div class="news-content">
              <h3 class="news-title text-warning">
                New Training Facility Launch
              </h3>
              <p class="news-date text-muted">November 10, 2024</p>
              <p class="news-desc">
                We’re thrilled to announce the opening of our state-of-the-art
                training facility for athletes.
              </p>
              <a href="#" class="btn btn-outline-warning mt-2">Read More</a>
            </div>
          </div>
        </div>

        <!-- News Item -->
        <div class="col-lg-4 col-md-6 mb-4" data-aos="zoom-in" data-aos-duration="1000">
          <div class="news-card shadow-lg">
            <div class="news-image-wrapper">
              <img src="../../dist/img/news/news2.png" alt="News 2" class="news-image" />
            </div>
            <div class="news-content">
              <h3 class="news-title text-warning">Upcoming Winter Camp</h3>
              <p class="news-date text-muted">December 1-15, 2024</p>
              <p class="news-desc">
                Register now for our annual winter training camp designed for
                all sports enthusiasts.
              </p>
              <a href="#" class="btn btn-outline-warning mt-2">Read More</a>
            </div>
          </div>
        </div>

        <!-- News Item -->
        <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-duration="1000">
          <div class="news-card shadow-lg">
            <div class="news-image-wrapper">
              <img src="../../dist/img/news/news3.png" alt="News 3" class="news-image" />
            </div>
            <div class="news-content">
              <h3 class="news-title text-warning">Annual Sports Day Recap</h3>
              <p class="news-date text-muted">March 20, 2024</p>
              <p class="news-desc">
                Relive the moments of our exciting Annual Sports Day with
                highlights and winners.
              </p>
              <a href="#" class="btn btn-outline-warning mt-2">Read More</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- News $ Announcement Section -->

  <!-- Featured Stories Section -->
  <section class="featured-stories section" id="featured-stories">
    <div class="container" data-aos="fade-up" data-aos-delay="300">
      <!-- Section Header -->
      <div class="section-header text-center mb-5">
        <h1 class="text-uppercase text-warning" data-aos="fade-down" data-aos-duration="800">
          Featured Stories
        </h1>
        <p class="text-light" data-aos="fade-up" data-aos-duration="800">
          Discover inspiring stories and achievements from our members and
          teams.
        </p>
      </div>

      <!-- Stories Grid -->
      <div class="row">
        <!-- Story Item -->
        <div class="col-lg-6 mb-4" data-aos="fade-right" data-aos-duration="1000">
          <div class="story-card shadow-lg d-flex flex-row align-items-center">
            <div class="story-image-wrapper">
              <img src="../../dist/img/news/story1.png" alt="Story 1" class="story-image" />
            </div>
            <div class="story-content">
              <h3 class="story-title text-warning">Champion's Journey</h3>
              <p class="story-desc">
                Meet John, who overcame challenges to become a regional
                athletics champion, inspiring countless others.
              </p>
              <a href="#" class="btn btn-outline-warning mt-2">Read More</a>
            </div>
          </div>
        </div>

        <!-- Story Item -->
        <div class="col-lg-6 mb-4" data-aos="fade-left" data-aos-duration="1000">
          <div class="story-card shadow-lg d-flex flex-row align-items-center">
            <div class="story-image-wrapper">
              <img src="../../dist/img/news/story2.png" alt="Story 2" class="story-image" />
            </div>
            <div class="story-content">
              <h3 class="story-title text-warning">Rising Star</h3>
              <p class="story-desc">
                Emma, a young soccer player, shares her journey to excellence
                and her aspirations for the future.
              </p>
              <a href="#" class="btn btn-outline-warning mt-2">Read More</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Featured Stories Section -->

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
</body>

</html>
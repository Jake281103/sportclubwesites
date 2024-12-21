<?php

// to show error codes
ini_set("display_errors", 1);

// call dbconnection file to use
require_once("databaseconnection.php");

// creat session if not created
if (!isset($_SESSION)) {
  session_start();
}

$noti_message = "";

if (isset($_SESSION['message_sending_success'])) {
  $noti_message = $_SESSION['message_sending_success'];
}

// echo $noti_message;

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
  <link rel="stylesheet" type="text/css" href="../css/contactus.css" />
  <link rel="stylesheet" type="text/css" href="../css/toast.css" />
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

  <!-- Contact Us Section -->
  <section id="contact-us" class="py-5">
    <div class="container">
      <!-- Heading Section -->
      <div class="text-center mb-5" data-aos="fade-up">
        <h2 class="text-white">Contact Us</h2>
        <p class="lead">
          We'd love to hear from you! Whether you have questions, need more
          information, or want to join our club, feel free to reach out.
        </p>
      </div>

      <!-- Contact Information with Image and Form Section -->
      <div class="row align-items-center">
        <!-- Contact Information -->
        <div class="col-md-6 mb-5" data-aos="fade-right" data-aos-duration="1000">
          <div class="row">
            <div class="col-12 mb-4" data-aos="zoom-in" data-aos-delay="200">
              <div class="card border-0 shadow-sm h-100 bg-dark text-light">
                <div class="card-body">
                  <i class="fas fa-map-marker-alt fa-3x text-primary mb-3"></i>
                  <h4>Our Address</h4>
                  <p>Mandalay, Myanmar</p>
                </div>
              </div>
            </div>
            <div class="col-12 mb-4" data-aos="zoom-in" data-aos-delay="400">
              <div class="card border-0 shadow-sm h-100 bg-dark text-light">
                <div class="card-body">
                  <i class="fas fa-phone fa-3x text-success mb-3"></i>
                  <h4>Phone</h4>
                  <p>+95 999 888 777</p>
                </div>
              </div>
            </div>
            <div class="col-12" data-aos="zoom-in" data-aos-delay="600">
              <div class="card border-0 shadow-sm h-100 bg-dark text-light">
                <div class="card-body">
                  <i class="fas fa-envelope fa-3x text-warning mb-3"></i>
                  <h4>Email</h4>
                  <p>aus@sportsclub.com</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Contact Form -->
        <div class="col-md-6" data-aos="fade-left" data-aos-duration="1200">
          <div class="contact-image" data-aos="zoom-in" data-aos-delay="200">
            <h1>Reach out to us</h1>
            <img src="../../dist/img/contact/img1.png" alt="Contact Image"
              class="img-fluid rounded shadow-lg full-width-img" />
          </div>
        </div>
      </div>

      <!-- Programs Section -->
      <section id="our-programs" class="py-5">
        <div class="container">
          <!-- Section Heading -->
          <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="text-white">Our Programs</h2>
            <p class="lead text-muted">
              Explore our range of fitness and wellness programs tailored for
              all ages and fitness levels.
            </p>
          </div>

          <!-- Programs Grid -->
          <div class="row text-center">
            <!-- Program Card 1 -->
            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="100">
              <div class="program-card shadow-lg p-4 rounded">
                <i class="fa-solid fa-dumbbell fa-3x text-warning mb-3"></i>
                <h5 class="text-white">Body Combat</h5>
                <p class="text-muted">
                  Engage in martial arts & workouts that challenge your body
                  and mind.
                </p>
                <a href="#contact" class="btn btn-outline-light btn-sm mt-3">Join Now</a>
              </div>
            </div>

            <!-- Program Card 2 -->
            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="200">
              <div class="program-card shadow-lg p-4 rounded">
                <i class="fas fa-spa fa-3x text-success mb-3"></i>
                <h5 class="text-white">Yoga Programs</h5>
                <p class="text-muted">
                  Improve your flexibility and mindfulness with our expert-led
                  yoga sessions.
                </p>
                <a href="#contact" class="btn btn-outline-light btn-sm mt-3">Join Now</a>
              </div>
            </div>

            <!-- Program Card 3 -->
            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="300">
              <div class="program-card shadow-lg p-4 rounded">
                <i class="fas fa-bicycle fa-3x text-primary mb-3"></i>
                <h5 class="text-white">Cycling Program</h5>
                <p class="text-muted">
                  Build endurance and strengthen your legs with our guided
                  cycling sessions.
                </p>
                <a href="#contact" class="btn btn-outline-light btn-sm mt-3">Join Now</a>
              </div>
            </div>

            <!-- Program Card 4 -->
            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="400">
              <div class="program-card shadow-lg p-4 rounded">
                <i class="fas fa-fist-raised fa-3x text-danger mb-3"></i>
                <h5 class="text-white">Boxing Fitness</h5>
                <p class="text-muted">
                  Boost your strength and reflexes with our energizing boxing
                  workouts.
                </p>
                <a href="#contact" class="btn btn-outline-light btn-sm mt-3">Join Now</a>
              </div>
            </div>

            <!-- Program Card 5 -->
            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="500">
              <div class="program-card shadow-lg p-4 rounded">
                <i class="fas fa-swimmer fa-3x text-info mb-3"></i>
                <h5 class="text-white">Swimming Program</h5>
                <p class="text-muted">
                  Dive into our swimming sessions designed for relaxation and
                  fitness.
                </p>
                <a href="#contact" class="btn btn-outline-light btn-sm mt-3">Join Now</a>
              </div>
            </div>

            <!-- Program Card 6 -->
            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="600">
              <div class="program-card shadow-lg p-4 rounded">
                <i class="fas fa-hands-helping fa-3x text-light mb-3"></i>
                <h5 class="text-white">Massage</h5>
                <p class="text-muted">
                  Relax and rejuvenate with our professional massage
                  therapies.
                </p>
                <a href="#contact" class="btn btn-outline-light btn-sm mt-3">Join Now</a>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Contact Form -->
      <div class="row mt-5">
        <div class="col-md-8 offset-md-2">
          <div class="contact-form-wrapper position-relative p-4 rounded shadow-lg" data-aos="fade-up"
            data-aos-duration="1500">
            <!-- Background Overlay -->
            <div class="contact-bg-overlay"></div>

            <!-- Contact Form Content -->
            <form id="contactForm" action="sent_message_function.php" method="POST"
              class="position-relative p-4 rounded text-light">
              <h3 class="text-center mb-4">Get in Touch</h3>
              <div class="form-row mb-4">
                <!-- Name Field -->
                <div class="col-md-6 mb-3 position-relative">
                  <label for="name" class="form-label">Your Name</label>
                  <div class="input-icon-wrapper">
                    <i class="fas fa-user-circle form-icon"></i>
                    <input type="text" name="message_username" class="form-control" id="name" placeholder="Enter your name"
                      required />
                  </div>
                </div>
                <!-- Email Field -->
                <div class="col-md-6 mb-3 position-relative">
                  <label for="email" class="form-label">Your Email</label>
                  <div class="input-icon-wrapper">
                    <i class="fas fa-envelope form-icon"></i>
                    <input type="email" name="message_useremail" class="form-control" id="email"
                      placeholder="Enter your email" required />
                  </div>
                </div>
              </div>

              <!-- Message Field -->
              <div class="form-row mb-4">
                <div class="col-md-12 position-relative">
                  <label for="message" class="form-label">Your Message</label>
                  <div class="input-icon-wrapper">
                    <i class="fas fa-comment-dots form-icon"></i>
                    <textarea class="form-control" name="message_content" id="message" rows="3"
                      placeholder="Enter your message" required></textarea>
                  </div>
                </div>
              </div>

              <!-- Submit Button -->
              <button type="submit" name="contact_message_sent" class="btn button-3 btn-lg btn-block shadow-lg">
                Send Message
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Contact Us Section -->

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

  <?php if ($noti_message != null) { ?>
    <div class="toasts actives">
      <div class="toast-contents">
        <i class="fas fa-check check"></i>

        <div class="message">
          <span class="text text-1">Success</span>
          <span class="text text-2"><?php echo $noti_message ?></span>
        </div>
      </div>
      <i class="fas fa-times closes"></i>

      <div class="progress actives"></div>
    </div>
  <?php
    unset($_SESSION['message_sending_success']);
    $noti_message = '';
  }
  ?>

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
  <script src="../js/toast.js"></script>
</body>

</html>
<?php

// to show error codes
ini_set("display_errors", 1);

// call dbconnection file to use
require_once("databaseconnection.php");

// creat session if not created
if (!isset($_SESSION)) {
  session_start();
}

function get_upcoming_events()
{
  try {
    $conn = connect();
    $stmt = $conn->prepare("SELECT * FROM events WHERE status=? ORDER BY id DESC");
    $stmt->execute(['upcoming']);
    return $stmt->fetchAll();
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
}

function get_finished_events()
{
  try {
    $conn = connect();
    $stmt = $conn->prepare("SELECT * FROM events WHERE status=? ORDER BY id DESC");
    $stmt->execute(['finished']);
    return $stmt->fetchAll();
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
}

function get_last_upcoming_events()
{
  try {
    $conn = connect();
    $stmt = $conn->prepare("SELECT * FROM events WHERE status=? ORDER BY date DESC");
    $stmt->execute(['upcoming']);
    return $stmt->fetch();
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
}


$upcoming_events = get_upcoming_events();
$finished_events = get_finished_events();
$last_upcoming_event = get_last_upcoming_events();
// var_dump($last_upcoming_event);
//var_dump($showevents);


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
  <link rel="stylesheet" type="text/css" href="../css/events.css" />
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

  <!-- Event Details Section -->
  <section class="event-details section" id="event-details">
    <div class="container">
      <!-- Section Title -->
      <h2 class="section-title text-center" data-aos="fade-up" data-aos-duration="1200">
        Event Details
      </h2>
      <p class="section-subtitle text-center mb-5" data-aos="fade-up" data-aos-delay="200"
        data-aos-duration="1000">
        Get ready for an unforgettable experience at <?php echo ucwords($last_upcoming_event['name']) ?>.
        Here's everything you need to know.
      </p>

      <!-- Details Grid -->
      <div class="details-grid row g-4">
        <!-- Event Date -->
        <div class="col-md-6 col-lg-4" data-aos="flip-left" data-aos-delay="300" data-aos-duration="1500">
          <div class="detail-card p-4 text-light rounded shadow-lg">
            <div class="detail-icon mb-3">
              <i class="fas fa-calendar-alt"></i>
            </div>
            <h4 class="detail-title mb-2">Event Date</h4>
            <p class="detail-text"><?php echo date('F j, Y', strtotime($last_upcoming_event['date'])); ?></p>
          </div>
        </div>

        <!-- Location -->
        <div class="col-md-6 col-lg-4" data-aos="flip-left" data-aos-delay="400" data-aos-duration="1500">
          <div class="detail-card p-4 text-light rounded shadow-lg">
            <div class="detail-icon mb-3">
              <i class="fas fa-map-marker-alt"></i>
            </div>
            <h4 class="detail-title mb-2">Location</h4>
            <p class="detail-text"><?php echo $last_upcoming_event['location'] ?></p>
          </div>
        </div>

        <!-- Participants -->
        <div class="col-md-6 col-lg-4" data-aos="flip-left" data-aos-delay="500" data-aos-duration="1500">
          <div class="detail-card p-4 text-light rounded shadow-lg">
            <div class="detail-icon mb-3">
              <i class="fas fa-users"></i>
            </div>
            <h4 class="detail-title mb-2">Participants</h4>
            <p class="detail-text">Over <?php echo $last_upcoming_event['participantslimit'] ?> athletes from 50+ sports</p>
          </div>
        </div>

        <!-- Registration Deadline -->
        <div class="col-md-6 col-lg-4" data-aos="flip-left" data-aos-delay="600" data-aos-duration="1500">
          <div class="detail-card p-4 text-light rounded shadow-lg">
            <div class="detail-icon mb-3">
              <i class="fas fa-clock"></i>
            </div>
            <h4 class="detail-title mb-2">Registration Deadline</h4>
            <p class="detail-text"><?php echo date('F j, Y', strtotime($last_upcoming_event['date'])); ?></p>
          </div>
        </div>
      </div>

      <!-- Call to Action Button -->
      <div class="cta text-center mt-5" data-aos="fade-up" data-aos-delay="700" data-aos-duration="1000">
        <?php if (isset($_SESSION['email'])) { ?>
          <a href="profile.php?event_id=<?php echo $last_upcoming_event['id'] ?>" class="btn custom-btn-lg">Register Now</a>
        <?php } else { ?>
          <a href="#" class="btn custom-btn-lg">Register Now</a>
        <?php } ?>
      </div>
    </div>
  </section>
  <!-- Event Details Section -->

  <!-- Highlighted Event Section -->
  <section id="highlighted-event" class="highlighted-event py-5">
    <div class="overlay"></div>
    <!-- Background overlay -->
    <div class="container text-center text-light">
      <h2 class="section-title" data-aos="fade-up">
        Don't Miss Our Biggest Event!
      </h2>
      <p class="section-description mb-5" data-aos="fade-up" data-aos-delay="200">
        The Annual Sports Day is around the corner. Be a part of the
        excitement, join thousands of athletes and spectators for an
        unforgettable experience!
      </p>
      <div class="cta-buttons" data-aos="fade-up" data-aos-delay="400">
        <a href="#" class="btn custom-btn-lg">Join Now</a>
        <a href="#" class="btn custom-btn-outline">Learn More</a>
      </div>
    </div>
  </section>
  <!-- Highlighted Event Section -->

  <!-- Upcoming Events Section -->
  <section class="upcoming-events section" id="upcoming-events">
    <div class="container">
      <!-- Section Title -->
      <h2 class="section-title text-center" data-aos="fade-up" data-aos-duration="1200">
        Upcoming Events
      </h2>
      <p class="section-subtitle text-center mb-5" data-aos="fade-up" data-aos-delay="200"
        data-aos-duration="1000">
        Discover the latest events and stay updated on all upcoming sports
        activities.
      </p>

      <!-- Events Grid -->
      <div class="events-grid row g-4">
        <?php $delay = 300; ?>
        <?php foreach ($upcoming_events as $showevent) { ?>
          <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="<?php echo $delay ?>" data-aos-duration="1500">
            <div class="event-card p-4 text-light rounded shadow-lg">
              <div class="event-header">
                <img src="../../<?php echo $showevent['image'] ?>" alt="<?php echo $showevent['name'] ?>"
                  class="img-fluid rounded mb-3" />
              </div>
              <div class="event-info">
                <h4 class="event-title"><?php echo ucwords($showevent['name']) ?></h4>
                <p class="event-date"><?php echo date("F j, Y", strtotime($showevent['date'])); ?></p>
                <p class="event-location">
                  <i class="fas fa-map-marker-alt"></i> <?php echo ucwords($showevent['location']) ?>
                </p>
                <a href="eventdetails.php?event_id=<?php echo $showevent['id'] ?>" class="btn custom-btn-lg">Learn More</a>
              </div>
            </div>
          </div>
          <?php $delay += 50; ?>
        <?php } ?>
    </div>
  </section>
  <!-- Upcoming Events Section -->

  <!-- Finished Events Section -->
  <section class="upcoming-events section" id="upcoming-events">
    <div class="container">
      <!-- Section Title -->
      <h2 class="section-title text-center" data-aos="fade-up" data-aos-duration="1200">
        Completed Events
      </h2>
      <p class="section-subtitle text-center mb-5" data-aos="fade-up" data-aos-delay="200"
        data-aos-duration="1000">
        Review on our all terminated sports
        activities.
      </p>

      <!-- Events Grid -->
      <div class="events-grid row g-4">
        <?php $delay = 300; ?>
        <?php foreach ($finished_events as $showevent) { ?>
          <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="<?php echo $delay ?>" data-aos-duration="1500">
            <div class="event-card p-4 text-light rounded shadow-lg">
              <div class="event-header">
                <img src="../../<?php echo $showevent['image'] ?>" alt="<?php echo $showevent['name'] ?>"
                  class="img-fluid rounded mb-3" />
              </div>
              <div class="event-info">
                <h4 class="event-title"><?php echo ucwords($showevent['name']) ?></h4>
                <p class="event-date"><?php echo date("F j, Y", strtotime($showevent['date'])); ?></p>
                <p class="event-location">
                  <i class="fas fa-map-marker-alt"></i> <?php echo ucwords($showevent['location']) ?>
                </p>
                <a href="eventdetails.php?event_id=<?php echo $showevent['id'] ?>" class="btn custom-btn-lg">Learn More</a>
              </div>
            </div>
          </div>
          <?php $delay += 50; ?>
        <?php } ?>
    </div>
  </section>
  <!-- Finished Events Section -->

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
      <p>&copy; 2025 Your Sports Club. All Rights Reserved.</p>
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
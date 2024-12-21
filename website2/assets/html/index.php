<?php

// to show error codes
ini_set("display_errors", 1);

// call dbconnection file to use
require_once("databaseconnection.php");

// creat session if not created
if (!isset($_SESSION)) {
  session_start();
}

// making default time zone
date_default_timezone_set("Asia/Yangon");

$date = date("Y-m-d");
$newdate = date('Y-m-d', strtotime($date . '+1 days'));

$noti_message = "";
$sports = null;
$locations = null;
$show_events = null;
$filter = false;

function get_all_sports()
{
  try {
    $conn = connect();
    $sql = "SELECT * FROM sports";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
}

function get_sport_by_id($id)
{
  try {
    $conn = connect();
    $sql = "SELECT * FROM sports WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);
    return $stmt->fetch();
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
}

function get_unique_event_locations()
{
  try {
    $conn = connect();
    $sql = "SELECT DISTINCT location FROM events ORDER BY location;";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["filter_event"])) {
  $filter = true;
  $filter_column_array = [];
  $filter_value_array = [];
  if (isset($_POST["filter_date"])) {
    array_push($filter_column_array, 'date');
    array_push($filter_value_array, $_POST["filter_date"]);
  }
  if ($_POST["filter_sport"] != 0) {
    array_push($filter_column_array, 'sports_id');
    array_push($filter_value_array, $_POST["filter_sport"]);
  }
  if ($_POST["filter_location"] != 0) {
    array_push($filter_column_array, 'location');
    array_push($filter_value_array, $_POST["filter_location"]);
  }
  if ($_POST["filter_agegroup"] != 0) {
    array_push($filter_column_array, 'agegroup');
    array_push($filter_value_array, $_POST["filter_agegroup"]);
  }
  //    var_dump($filer_column_array);
  //    var_dump($filter_value_array);

  try {
    $conn = connect();
    $sql = 'SELECT * FROM events WHERE ';
    for ($i = 0; $i < count($filter_column_array); $i++) {
      if ($i == count($filter_column_array) - 1) {
        $sql .= $filter_column_array[$i] . "=?";
      } else {
        $sql .= $filter_column_array[$i] . "=? AND ";
      }
    }
    $stmt = $conn->prepare($sql);
    $stmt->execute($filter_value_array);
    $show_events = $stmt->fetchAll();
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
}

if (isset($_SESSION['login_success'])) {
  $noti_message = $_SESSION['login_success'];
} elseif (isset($_SESSION['register_success'])) {
  $noti_message = $_SESSION['register_success'];
}

$sports = get_all_sports();
$locations = get_unique_event_locations();
// var_dump($locations);
//echo $newdate;
// var_dump($showevents);


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
  <link rel="stylesheet" type="text/css" href="../css/index.css" />
  <link rel="stylesheet" type="text/css" href="../css/events.css" />
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

  <!-- BG Overlay Section -->
  <section id="hero" class="hero-section position-relative text-light">
    <div class="bg-overlay"></div>
    <div class="container h-100 d-flex align-items-center">
      <div class="row w-100">
        <div class="col-md-7" data-aos="fade-right">
          <h1 class="hero-title display-4" style="overflow: hidden;">
            Welcome to<br />
            AUS<b class="text-light"> Sport Club</b>
          </h1>
          <p class="hero-text">
            Join us for a journey of fitness, teamwork, and sportsmanship.
          </p>
        </div>
        <div class="col-md-5 text-md-right d-flex flex-column justify-content-center" data-aos="fade-left">
          <a href="#filter-events" class="btn button-2 btn-lg mb-3">
            Get Started
          </a>
          <a href="aboutus.php" class="btn button-1 btn-lg"> Learn More </a>
        </div>
      </div>
    </div>
  </section>

  <!-- Filter Events Section -->
  <section id="filter-events" class="filter-section bg-dark py-5 text-light">
    <div class="container">
      <!-- Section Header -->
      <div class="text-center mb-5" data-aos="fade-up">
        <h2 class="section-title">Filter Events</h2>
        <p class="section-description">
          Find the events that match your interests and schedule.
        </p>
      </div>

      <!-- Filter Form -->
      <form action="index.php" method="POST" class="filter-form p-4 rounded shadow-lg bg-black" data-aos="fade-up" data-aos-delay="300">
        <div class="row g-4">
          <!-- Date Filter -->
          <div class="col-md-6">
            <label for="filter-date" class="form-label">Date</label>
            <input type="date" id="filter-date" name="filter_date" min="<?php echo $newdate ?>"
              class="form-control bg-dark text-light border-primary shadow" placeholder="Select Date" required />
          </div>

          <!-- Sport Filter -->
          <div class="col-md-6">
            <label for="filter-sport" class="form-label">Sport</label>
            <select id="filter-sport" name="filter_sport" class="form-select bg-dark text-light border-primary shadow" required>
              <option value="0" selected>All Sports Types</option>
              <?php foreach ($sports as $sport) {
                echo '<option value="' . $sport['id'] . '">' . $sport['name'] . '</option>';
              } ?>
            </select>
          </div>

          <!-- Location Filter -->
          <div class="col-md-6">
            <label for="filter-location" class="form-label">Location</label>
            <select name="filter_location" id="location-selection" class="form-select bg-dark text-light border-primary shadow" required>
              <option value="0" selected>All Event Location</option>
              <?php foreach ($locations as $location) {
                echo '<option value="' . $location['location'] . '">' . ucwords($location['location']) . '</option>';
              } ?>
            </select>
          </div>

          <!-- Age Group Filter -->
          <div class="col-md-6">
            <label for="filter" class="form-label">Age Group</label>
            <select id="filter" name="filter_agegroup" class="form-select bg-dark text-light border-primary shadow" required>
              <option value="0" selected>All age</option>
              <option value="child">Child (under 15)</option>
              <option value="teen">Teen (Between 16 and 23)</option>
              <option value="adult">Adult (Over 23)</option>
              <option value="all">No Age Limit</option>
            </select>
          </div>
        </div>

        <!-- Submit Button -->
        <div class="text-center mt-4" data-aos="fade-up" data-aos-delay="400">
          <button type="submit" name="filter_event" class="btn button-4 btn-lg shadow">
            Search Events
          </button>
        </div>
      </form>

      <!-- Filter Result Events Section -->
      <div class="container mt-5">
        <?php if ($filter) { ?>
          <h2 class="section-title text-center" data-aos="fade-up" data-aos-duration="1200">
            Upcoming Filter Events
          </h2>
          <p class="section-subtitle text-center mb-5" data-aos="fade-up" data-aos-delay="200"
            data-aos-duration="1000">
            Discover the latest events and stay updated on all upcoming sports
            activities.
          </p>
          <div class="events-grid row g-4">
            <?php if ($show_events) { ?>
              <?php foreach ($show_events as $showevent) { ?>
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="300" data-aos-duration="1500">
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
              <?php } ?>
            <?php } else { ?>
              <div class="col-12">
                <h5 class="text-center text-white mx-2">The filter events is not found</h5>
              </div>
            <?php } ?>
          </div>
        <?php } ?>
      </div>
    </div>
  </section>
  <!-- BG Overlay Section -->

  <!-- Join Our Community Section -->
  <section id="join-community" class="join-section bg-dark py-5 text-light">
    <div class="container">
      <!-- Section Header -->
      <div class="text-center mb-5" data-aos="fade-down" data-aos-delay="200">
        <h2 class="section-title text-uppercase">Join Our Community</h2>
        <p class="section-description">
          Be part of the AUS Sport Club family and experience the thrill of
          sports and friendship.
        </p>
      </div>

      <!-- Community Highlights -->
      <div class="row align-items-center">
        <!-- Left Content -->
        <div class="col-md-6 mb-4" data-aos="fade-right" data-aos-delay="300">
          <h3 class="highlight-title">Why Join Us?</h3>
          <ul class="highlight-list">
            <li data-aos="zoom-in" data-aos-delay="400">
              <i class="fas fa-check-circle text-primary"></i> Access to
              exclusive events
            </li>
            <li data-aos="zoom-in" data-aos-delay="500">
              <i class="fas fa-check-circle text-primary"></i> Opportunities
              to grow your skills
            </li>
            <li data-aos="zoom-in" data-aos-delay="600">
              <i class="fas fa-check-circle text-primary"></i> A supportive
              and inclusive community
            </li>
          </ul>
        </div>

        <!-- Right Content -->
        <div class="col-md-6 text-center" data-aos="fade-left" data-aos-delay="400">
          <img src="../../dist/img/community.png" alt="Join Community" class="img-fluid rounded shadow-lg"
            data-aos="zoom-in" data-aos-delay="500" />
        </div>
      </div>

      <!-- Call to Action -->
      <div class="text-center mt-5" data-aos="fade-up" data-aos-delay="600">
        <a href="#contact-us" class="btn button-5 btn-lg shadow">
          Get Started
        </a>
      </div>
    </div>
  </section>

  <!-- Join our Community Section -->

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
    unset($_SESSION['login_success']);
    unset($_SESSION['register_success']);
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
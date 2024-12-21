<?php

// to show error codes
ini_set("display_errors", 1);

// call dbconnection file to use
require_once("dbconnect.php");
// call sessionconfig file to use its methods
require_once("sessionconfig.php");

$showevents = null;

function getevents()
{
  try {
    $conn = $GLOBALS['conn'];
    $stmt = $conn->prepare("SELECT * FROM events ORDER BY status DESC");
    $stmt->execute();
    return $stmt->fetchAll();
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
}

function getsportname($id)
{
  try {
    $conn = $GLOBALS['conn'];
    $stmt = $conn->prepare("SELECT name FROM sports WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
}

$showevents = getevents();
//var_dump($showevents);

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <title>AUS Sport Club</title>

  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

  <!-- Bootstrap CSS link -->
  <link rel="stylesheet" href="../public/libs/css/bootstrap.min.css" />

  <!-- Font Awesome CSS link -->
  <link rel="stylesheet" href="../public/libs/font-awesome-5/css/fontawesome-all.min.css" />
  <!-- AOS CSS Link -->
  <link rel="stylesheet" href="../public/libs/css/aos.css" />

  <!-- Custom CSS link -->
  <link rel="stylesheet" href="../css/style.css" />
  <link rel="stylesheet" href="../css/event-details.css" />
</head>

<body data-spy="scroll" data-target="#navbarNav" data-offset="50">

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

  <!-- HERO -->
  <section class="hero d-flex flex-column justify-content-center align-items-center" id="home">
    <div class="bg-overlay"></div>
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto col-12">
          <div class="hero-text mt-5 text-center">
            <h6 data-aos="fade-up" data-aos-delay="300">
              New way to build a healthy lifestyle!
            </h6>
            <h1 class="text-white" data-aos="fade-up" data-aos-delay="500">
              Upgrade your body at Gymso Fitness
            </h1>
            <a href="#feature" class="btn custom-btn mt-3" data-aos="fade-up" data-aos-delay="600">Get
              started</a>
            <a href="#about" class="btn custom-btn bordered mt-3" data-aos="fade-up"
              data-aos-delay="700">Learn more</a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- EVENT DETAILS -->
  <section class="event-details section" id="event-details">
    <div class="container">
      <h2 class="section-title text-center" data-aos="fade-up">
        The Biggest Event
      </h2>
      <p class="section-subtitle text-center mb-5" data-aos="fade-up" data-aos-delay="100">
        Get ready for an unforgettable experience at Sports Fiesta 2025.
        Here’s everything you need to know.
      </p>

      <div class="details-grid">
        <!-- Event Date -->
        <div class="detail-item" data-aos="zoom-in" data-aos-delay="200">
          <div class="detail-icon">
            <i class="fas fa-calendar-alt"></i>
          </div>
          <h4 class="detail-title">Event Date</h4>
          <p class="detail-text">March 15 - March 20, 2024</p>
        </div>

        <!-- Location -->
        <div class="detail-item" data-aos="zoom-in" data-aos-delay="300">
          <div class="detail-icon">
            <i class="fas fa-map-marker-alt"></i>
          </div>
          <h4 class="detail-title">Location</h4>
          <p class="detail-text">National Sports Arena, City Center</p>
        </div>

        <!-- Participants -->
        <div class="detail-item" data-aos="zoom-in" data-aos-delay="400">
          <div class="detail-icon">
            <i class="fas fa-users"></i>
          </div>
          <h4 class="detail-title">Participants</h4>
          <p class="detail-text">
            Over 5,000 athletes from 50+ sports categories
          </p>
        </div>

        <!-- Registration Deadline -->
        <div class="detail-item" data-aos="zoom-in" data-aos-delay="500">
          <div class="detail-icon">
            <i class="fas fa-clock"></i>
          </div>
          <h4 class="detail-title">Registration Deadline</h4>
          <p class="detail-text">February 28, 2024</p>
        </div>
      </div>

      <div class="cta text-center mt-5" data-aos="fade-up" data-aos-delay="600">
        <?php if (verifysession('email')) { ?>
          <a href="profile.php" class="btn custom-btn-lg">Register Now</a>
        <?php } else { ?>
          <a href="javascript:void(0);" class="btn custom-btn-lg">Register Now</a>
        <?php } ?>
      </div>
    </div>
  </section>

  <!-- EVENTS SECTION -->
  <section class="upcoming-events-section" id="events">
    <div class="container">
      <h2 class="section-heading text-center" data-aos="fade-up">Enjoy Our Sport Events</h2>
      <p class="section-description text-center mb-5" data-aos="fade-up" data-aos-delay="100">
        Explore the exciting events lined up for Sports Fiesta 2024 and beyond.
      </p>
      <div class="row g-4">
        <?php $delay = 400; ?>
        <?php foreach ($showevents as $showevent) { ?>
          <div class="col-md-4" data-aos="zoom-in" data-aos-delay="<?php echo $delay ?>">
            <div class="event-box">
              <div class="event-image-container">
                <span class="event-status-tag upcoming"><?php echo ucwords($showevent['status']) ?></span>
                <img src="../<?php echo $showevent['image'] ?>" alt="<?php echo ucwords($showevent['name']) ?>"
                  class="event-thumbnail">
              </div>
              <div class="event-info">
                <h5 class="event-heading"><?php echo ucwords($showevent['name']) ?></h5>
                <div class="event-divider"></div>
                <ul class="event-meta">
                  <li><strong>Date:</strong> <?php echo date("F j, Y", strtotime($showevent['date'])); ?></li>
                  <li><strong>Location:</strong> <?php echo ucwords($showevent['location']) ?></li>
                  <li><strong>Sport:</strong> <?php echo ucwords(getsportname($showevent['sports_id'])['name']) ?></li>
                  <li><strong>Age Group:</strong> <?php echo ucwords($showevent['agegroup']) ?></li>
                </ul>
                <a href="event-details.php?eventid=<?php echo $showevent['id'] ?>" class="action-button mt-3">View Detail</a>
                <?php if (verifysession('email')) { ?>
                  <a href="profile.php?eventid=<?php echo $showevent['id'] ?>" class="action-button mt-3">Register Now</a>
                <?php } else { ?>
                  <a href="javascript:void(0);" class="action-button mt-3" style="background-color: #c60a11">Register Now</a>
                <?php } ?>
              </div>
            </div>
          </div>
          <?php $delay += 50; ?>
        <?php } ?>
      </div>
    </div>
  </section>

  <!-- CLASS -->
  <section class="class section" id="events">
    <div class="container">
      <div class="row">

        <div class="col-lg-12 col-12 text-center mb-5">
          <h6 data-aos="fade-up">Get Healthy Lifestyle</h6>

          <h2 data-aos="fade-up" data-aos-delay="200">Enjoy Our Sports Events</h2>
        </div>
        <?php $delay = 400; ?>
        <?php foreach ($showevents as $showevent) { ?>
          <div class="mb-5 mt-lg-0 col-lg-4 col-md-6 col-12" data-aos="fade-up" data-aos-delay="<?php echo $delay ?>">
            <div class="class-thumb">
              <div style="width: 100%; height: 280px; position: relative">
                <span class="btn btn-danger" style="font-size: 12px; position:absolute; right: 10px;top: 5px;"><?php echo ucwords($showevent['status']) ?></span>
                <img src="../<?php echo $showevent['image'] ?>" style="width: 100%;height: 100%; object-fit: cover;" alt="Class">
              </div>
              <div class="class-info">
                <h3 class="mb-1"><?php echo ucwords($showevent['name']) ?></h3>

                <span><strong>Sport Type</strong> - <?php echo getsportname($showevent['sports_id'])['name'] ?></span>

                <p class="mt-3"><?php echo ucwords($showevent['description']) ?></p>

                <a href="event-details.php?eventid=<?php echo $showevent['id'] ?>" class="btn btn-sm text-white" style="background-color: #c60a11">View Detail</a>

                <?php if (verifysession('email')) { ?>
                  <a href="profile.php?eventid=<?php echo $showevent['id'] ?>" class="btn btn-sm text-white" style="background-color: #c60a11">REGISTER</a>
                <?php } else { ?>
                  <a href="javascript:void(0);" class="btn btn-sm text-white" style="background-color: #c60a11">REGISTER</a>
                <?php } ?>
              </div>
            </div>
          </div>
          <?php $delay += 50; ?>
        <?php } ?>

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
  <script>
    AOS.init({
      duration: 1000
    });
  </script>

  <!-- Bootstrap JS link -->
  <script src="../public/libs/js/bootstrap.min.js"></script>

  <!-- JQuery JS link -->
  <script src="../public/libs/js/jquery-3.7.1.min.js"></script>

  <!-- Smoothscroll JS link -->
  <script src="../public/libs/js/smoothscroll.js"></script>

  <!-- Custom JS link -->
  <script src="../js/app.js"></script>
</body>

</html>
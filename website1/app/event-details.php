<?php

// to show error codes
ini_set("display_errors", 1);

// call dbconnection file to use
require_once("dbconnect.php");
// call sessionconfig file to use its methods
require_once("sessionconfig.php");

$event = null;

if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['eventid'])) {
  setsession('eventid', $_GET['eventid']);
}

if (!verifysession('eventid')) {
  redirectto('events.php');
}

function getevent($eventid)
{
  try {
    $conn = $GLOBALS['conn'];
    $stmt = $conn->prepare("SELECT * FROM events WHERE id=?");
    $stmt->execute([$eventid]);
    return $stmt->fetch();
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
}

$event = getevent($_SESSION['eventid']);
//var_dump($event);




?>

<!DOCTYPE html>
<html lang="en">

<head>

  <title>AUS Sport Club</title>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

  <!-- Bootstrap CSS link -->
  <link rel="stylesheet" href="../public/libs/css/bootstrap.min.css">

  <!-- Font Awesome CSS link -->
  <link
    rel="stylesheet"
    href="../public/libs/font-awesome-5/css/fontawesome-all.min.css" />
  <!-- AOS CSS Link -->
  <link rel="stylesheet" href="../public/libs/css/aos.css">

  <!-- Custom CSS link -->
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="../css/home.css">
  <link rel="stylesheet" href="../css/event-details.css">

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

  <section id="filter" class="filter-section py-5">
    <div class="container py-5 my-5">
      <div class="row">

        <div class="d-flex flex-column justify-content-center ml-lg-auto mr-lg-5 col-lg-6 col-md-6 col-12">
          <h2 class="mb-3 text-white" data-aos="fade-up"><?php echo $event['name'] ?></h2>
          <p data-aos="fade-up" data-aos-delay="200"><?php echo $event['description'] ?></p>

          <div>

            <h2 class="mb-4 text-white" data-aos="fade-up" data-aos-delay="500">Event Date & Time</h2>

            <p data-aos="fade-up" data-aos-delay="700">Date : <?php echo date("F j, Y", strtotime($event['date'])); ?></p>

            <p data-aos="fade-up" data-aos-delay="800">Time : <?php echo $event['time'] ?></p>
            <p data-aos="fade-up" data-aos-delay="900">Last Registraion : <?php echo date("F j, Y", strtotime($event['duedate'])); ?></p>
          </div>

          <div>
            <h2 class="mb-4 text-white" data-aos="fade-up" data-aos-delay="500">Limitation</h2>

            <p data-aos="fade-up" data-aos-delay="700">Age Limit : <?php echo ucwords($event['agegroup']) ?></p>

            <p data-aos="fade-up" data-aos-delay="800">Participant Limit : <?php echo $event['participantslimit'] ?> People</p>
          </div>

          <?php if (verifysession('email')) { ?>
            <a href="profile.php?eventid=<?php echo $event['id'] ?>" class="btn custom-btn bg-color mt-3" data-aos="fade-up" data-aos-delay="300" data-toggle="modal" data-target="#membershipForm">Registraion Link</a>
          <?php } else { ?>
            <a href="javascript:void(0);" class="btn custom-btn bg-color mt-3" data-aos="fade-up" data-aos-delay="300" data-toggle="modal" data-target="#membershipForm">Registraion Link</a>
          <?php } ?>
        </div>

        <div class="col-lg-6 col-md-6 col-12">
          <img src="./../public/images/event/football1.jpg" style="width: 100%; height: 100%;object-fit: cover" />
        </div>

        <div>
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

  <!-- Modal -->
  <div class="modal fade" id="membershipForm" tabindex="-1" role="dialog" aria-labelledby="membershipFormLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">

      <div class="modal-content">
        <div class="modal-header">

          <h2 class="modal-title" id="membershipFormLabel">Membership Form</h2>

          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <form class="membership-form webform" role="form">
            <input type="text" class="form-control" name="cf-name" placeholder="John Doe">

            <input type="email" class="form-control" name="cf-email" placeholder="Johndoe@gmail.com">

            <input type="tel" class="form-control" name="cf-phone" placeholder="123-456-7890" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" required>

            <textarea class="form-control" rows="3" name="cf-message" placeholder="Additional Message"></textarea>

            <button type="submit" class="form-control" id="submit-button" name="submit">Submit Button</button>

            <div class="custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input" id="signup-agree">
              <label class="custom-control-label text-small text-muted" for="signup-agree">I agree to the <a href="#">Terms &amp;Conditions</a>
              </label>
            </div>
          </form>
        </div>

        <div class="modal-footer"></div>

      </div>
    </div>
  </div>

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
</body>

</html>
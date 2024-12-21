<?php

// to show error codes
ini_set("display_errors", 1);

// call dbconnection file to use
require_once "dbconnect.php";

// creat session if not created
if (!isset($_SESSION)) {
    session_start();
}

// making default time zone
date_default_timezone_set("Asia/Yangon");

$date = date("Y-m-d");

$toastmessage = "";
$sports = null;
$locations = null;
$toshowevents = null;
$checkfilter = false;

function sportall()
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

function sportbyid($id)
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

function eventlocations()
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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["filter-btn"])) {
    $checkfilter = true;
    $arrayofcolumn = [];
    $arrayofvalues = [];
    if (isset($_POST["date-filter"])) {
        array_push($arrayofcolumn, 'date');
        array_push($arrayofvalues, $_POST["date-filter"]);
    }
    if ($_POST["sport-filter"] != 0) {
        array_push($arrayofcolumn, 'sports_id');
        array_push($arrayofvalues, $_POST["date-filter"]);
    }
    if ($_POST["location-filter"] != 0) {
        array_push($arrayofcolumn, 'location');
        array_push($arrayofvalues, $_POST["location-filter"]);
    }
    if ($_POST["age-filter"] != 0) {
        array_push($arrayofcolumn, 'agegroup');
        array_push($arrayofvalues, $_POST["age-filter"]);
    }
    //    var_dump($filer_column_array);
    //    var_dump($filter_value_array);

    try {
        $conn = connect();
        $sql = 'SELECT * FROM events WHERE ';
        for ($i = 0; $i < count($arrayofcolumn); $i++) {
            if ($i == count($arrayofcolumn) - 1) {
                $sql .= $arrayofcolumn[$i] . "=?";
            } else {
                $sql .= $arrayofcolumn[$i] . "=? AND ";
            }
        }
        $stmt = $conn->prepare($sql);
        $stmt->execute($arrayofvalues);
        $toshowevents = $stmt->fetchAll();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

if (isset($_SESSION['login-success'])) {
    $toastmessage = $_SESSION['login-success'];
} elseif (isset($_SESSION['signup-success'])) {
    $toastmessage = $_SESSION['signup-success'];
}

$sports = sportall();
$locations = eventlocations();
// var_dump($locations);
//echo $newdate;
// var_dump($showevents);


?>


<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <!-- meta data -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!--font-family-->
    <link
        href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet" />

    <link href="https://fonts.googleapis.com/css?family=Rufina:400,700" rel="stylesheet" />

    <!-- title of site -->
    <title>AUS Sport Club</title>

    <!--font-awesome.min.css-->
    <link rel="stylesheet" href="../../public/libs/fontawesome-6/css/all.min.css" />

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="../../public/libs/sweetalert/sweetalert2.min.css" />

    <!--linear icon css-->
    <link rel="stylesheet" href="../../public/libs/linearicons/linearicons.css" />

    <!--flaticon.css-->
    <link rel="stylesheet" href="../../public/libs/flaticon/flaticon.css" />

    <!--animate.css-->
    <link rel="stylesheet" href="../../public/libs/animate/animate.css" />

    <!--owl.carousel.css-->
    <link rel="stylesheet" href="../../public/libs/owl-carousel/owl.carousel.min.css" />
    <link rel="stylesheet" href="../../public/libs/owl-carousel/owl.theme.default.min.css" />

    <!--bootstrap.min.css-->
    <link rel="stylesheet" href="../../public/libs/bootstrap-5/css/bootstrap.min.css" />

    <!--style.css-->
    <link rel="stylesheet" href="../css/style.css" />

    <!--header.css-->
    <link rel="stylesheet" href="../css/header.css" />

    <!--index.css-->
    <link rel="stylesheet" href="../css/index.css" />

    <!--footer.css-->
    <link rel="stylesheet" href="../css/footer.css" />

    <!--responsive.css-->
    <link rel="stylesheet" href="../css/responsive.css" />
    <link rel="stylesheet" href="../css/toast.css" />
</head>

<body>
    <!--nav-bar start -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">AUS Sport Club</a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a href="index.php" class="nav-link smoothScroll" aria-label="Navigate to Home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="events.php" class="nav-link smoothScroll" aria-label="Navigate to Events">Events</a>
                    </li>
                    <li class="nav-item">
                        <a href="pastevents.php" class="nav-link smoothScroll" aria-label="Navigate to Past Events">Past
                            Events</a>
                    </li>
                    <li class="nav-item">
                        <a href="news.php" class="nav-link smoothScroll"
                            aria-label="Navigate to News and Announcements">News & Announcements</a>
                    </li>
                    <li class="nav-item">
                        <a href="aboutus.php" class="nav-link smoothScroll" aria-label="Navigate to About Us">About
                            Us</a>
                    </li>
                    <li class="nav-item">
                        <a href="contactus.php" class="nav-link smoothScroll"
                            aria-label="Navigate to Contact Us">Contact</a>
                    </li>
                </ul>

                <ul class="navbar-nav ml-auto d-flex align-items-center">
                    <!-- Sign In/Up Dropdown -->

                    <?php if (!isset($_SESSION['email'])) { ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="signInDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Sign In/Up
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="signInDropdown">
                                <a class="dropdown-item" href="./login.php" aria-label="Navigate to Login">Login</a>
                                <a class="dropdown-item" href="./register.php"
                                    aria-label="Navigate to Register">Register</a>
                            </div>
                        </li>
                    <?php } else { ?>
                        <!-- Profile Dropdown -->
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" id="profileDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false" aria-label="Profile Menu">
                                <img src="../../public/images/pf_logo.png" style="width: 30px" alt="Profile"
                                    class="profile-pic" />
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                                <li>
                                    <a class="dropdown-item" href="./profile.php" aria-label="Go to Member Dashboard">
                                        Profile
                                    </a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider" />
                                </li>
                                <li>
                                    <a class="dropdown-item" href="./logoutfunction.php" aria-label="Logout">
                                        Logout
                                    </a>
                                </li>
                            </ul>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Background Overlay Section -->
    <section class="bg-overlay-section">

        <div class="overlay">
            <div class="content">
                <h1>Welcome to Our Sports Club</h1>
                <p>
                    Join us in shaping a healthier, active community through sports and
                    camaraderie.
                </p>
                <div class="cta-buttons">
                    <a href="aboutus.php" class="btn btn-learn">Learn More</a>
                    <a href="#get-started" class="btn btn-start">Get Started</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Filter Events and Upcoming Events Section -->
    <section class="events-section py-5">
        <div class="container">
            <div class="row align-items-center">
                <!-- Filter Events Section -->
                <div class="col-md-6">
                    <div class="filter-events-box p-4">
                        <h4 class="text-white text-center mb-4">Filter Events</h4>
                        <form action="index.php" method="POST">
                            <div class="row mb-3">
                                <label class="col-12 text-white mb-2" for="date">Date:</label>
                                <div class="col-12">
                                    <input type="date" name="date-filter" min="<?php echo $date ?> id=" date" class="form-control" placeholder="mm/dd/yyyy" required />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-12 text-white mb-2" for="sport">Sport:</label>
                                <div class="col-12">
                                    <select id="sport" name="sport-filter" class="form-select" required>
                                        <option value="0" selected>All Sports Types</option>
                                        <?php foreach ($sports as $sport) {
                                            echo '<option value="' . $sport['id'] . '">' . $sport['name'] . '</option>';
                                        } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-12 text-white mb-2" for="location">Location:</label>
                                <div class="col-12">
                                    <select name="location-filter" id="location-selection" class="form-select" required>
                                        <option value="0" selected>All Event Location</option>
                                        <?php foreach ($locations as $location) {
                                            echo '<option value="' . $location['location'] . '">' . ucwords($location['location']) . '</option>';
                                        } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-12 text-white mb-2" for="age">Age Group:</label>
                                <div class="col-12">
                                    <select id="age" name="age-filter" class="form-select">
                                        <option value="0" selected>All age</option>
                                        <option value="child">Child (under 15)</option>
                                        <option value="teen">Teen (Between 16 and 23)</option>
                                        <option value="adult">Adult (Over 23)</option>
                                        <option value="all">No Age Limit</option>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" name="filter-btn" class="btn btn-dark w-100">
                                Filter Event
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Upcoming Events Section -->
                <div class="col-md-6">
                    <?php if ($checkfilter) { ?>
                        <div class="upcoming-events-box p-4">
                            <h4 class="text-white text-center mb-4">Upcoming Events</h4>
                            <?php if ($toshowevents) { ?>
                                <?php foreach ($toshowevents as $event) { ?>
                                    <div class="event-card bg-white mb-3 p-3 rounded d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-1"><?php echo date("F j, Y", strtotime($event['date'])); ?></h6>
                                            <p class="mb-0"><?php echo ucwords($event['name']) ?></p>
                                            <p class="text-muted mb-0"><?php echo ucwords($event['location']) ?></p>
                                        </div>
                                        <a href="eventdetails.php?eventid=<?php echo $event['id'] ?>" class="btn btn-sm btn-dark">View Detail</a>
                                    </div>
                                <?php } ?>
                            <?php } else { ?>
                                <div class="event-card bg-white mb-3 p-3 rounded">
                                        <h5 class="text-center mx-2">The filter events is not found</h5>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Innovative Section -->
    <section class="innovative-section py-5 bg-light">
        <div class="container">
            <div class="row align-items-center">
                <!-- Left: Image Display -->
                <div class="col-md-6">
                    <div class="innovative-image">
                        <img src="../../public/images/welcome-page/image2.png" alt="Sports Club Activity"
                            class="img-fluid rounded shadow-lg" />
                    </div>
                </div>

                <!-- Right: Statistics and Motivational Message -->
                <div class="col-md-6">
                    <div class="innovative-content p-4">
                        <h2 class="text-primary mb-3">Join Our Active Community!</h2>
                        <p class="lead text-dark mb-4">
                            We're not just a club. We are a lifestyle dedicated to growth,
                            fitness, and making unforgettable memories.
                        </p>
                        <div class="stats-container d-flex justify-content-between mb-4">
                            <div class="stat-item text-center">
                                <h4 class="text-success">500+</h4>
                                <p class="text-muted">Members</p>
                            </div>
                            <div class="stat-item text-center">
                                <h4 class="text-warning">120+</h4>
                                <p class="text-muted">Events Held</p>
                            </div>
                            <div class="stat-item text-center">
                                <h4 class="text-info">30+</h4>
                                <p class="text-muted">Sports Played</p>
                            </div>
                        </div>
                        <p class="text-muted mb-4">
                            Be part of something bigger. Sign up today and experience sports
                            like never before!
                        </p>
                        <a href="register.php" class="btn btn-dark btn-lg">Join Us Now</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--footer start-->
    <footer id="contact" class="footer">
        <div class="container">
            <div class="footer-top">
                <div class="row">
                    <!-- Club Info -->
                    <div class="col-md-4 col-sm-6">
                        <div class="single-footer-widget">
                            <div class="footer-logo">
                                <a href="index.html" aria-label="Navigate to Home">AUS Sport Club</a>
                            </div>
                            <p>
                                Bringing the community together through sports and recreation.
                                Join us for events, news, and updates that keep our club
                                vibrant.
                            </p>
                            <div class="footer-contact">
                                <p aria-label="Contact Email">info@ausclub.com</p>
                                <p aria-label="Contact Number">+1 (800) 555-1234</p>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div class="col-md-3 col-sm-6">
                        <div class="single-footer-widget">
                            <h2>Quick Links</h2>
                            <ul>
                                <li>
                                    <a href="index.php" aria-label="Home">Home</a>
                                </li>
                                <li>
                                    <a href="events.php" aria-label="View Upcoming Events">Events</a>
                                </li>
                                <li>
                                    <a href="pastevents.php" aria-label="View Past Events">Past Events</a>
                                </li>
                                <li>
                                    <a href="news.php" aria-label="View News and Announcements">News & Announcements</a>
                                </li>
                                <li>
                                    <a href="aboutus.php" aria-label="Learn About Us">About Us</a>
                                </li>
                                <li>
                                    <a href="contactus.php" aria-label="Contact Us">Contact Us</a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Newsletter Subscription -->
                    <div class="col-md-5 col-sm-12">
                        <div class="single-footer-widget">
                            <h2>Newsletter</h2>
                            <p>
                                Stay updated with the latest news, events, and announcements.
                            </p>
                            <form class="newsletter-form" aria-label="Subscribe to Newsletter">
                                <input type="email" class="form-control" placeholder="Enter your email"
                                    aria-label="Enter your email address" />
                                <button type="submit" class="btn btn-subscribe" aria-label="Subscribe">
                                    Subscribe
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Bottom -->
            <div class="footer-bottom">
                <div class="row">
                    <div class="col-sm-8">
                        <p>
                            &copy; 2024 AUS Sport Club. All rights reserved. Designed with
                            care by AUS Developers.
                        </p>
                    </div>
                    <div class="col-sm-6">
                        <div class="footer-social">
                            <a href="#" aria-label="Visit Facebook"><i class="fa fa-facebook"></i></a>
                            <a href="#" aria-label="Visit Instagram"><i class="fa fa-instagram"></i></a>
                            <a href="#" aria-label="Visit LinkedIn"><i class="fa fa-linkedin"></i></a>
                            <a href="#" aria-label="Visit Twitter"><i class="fa fa-twitter"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!--footer end-->

    <?php if ($toastmessage != null) { ?>
        <div class="toasts actives">
            <div class="toast-contents">
                <i class="fas fa-check check"></i>

                <div class="message">
                    <span class="text text-1">Success</span>
                    <span class="text text-2"><?php echo $toastmessage ?></span>
                </div>
            </div>
            <i class="fas fa-times closes"></i>

            <div class="progress actives"></div>
        </div>
    <?php
        unset($_SESSION['login-success']);
        unset($_SESSION['signup-success']);
        $toastmessage = '';
    }
    ?>

    <!-- SweetAlert2 JavaScript -->
    <script src="../../public/libs/sweetalert/sweetalert2.all.min.js"></script>

    <!-- jquery js link -->
    <script src="../../public/libs/jquery/jquery-3.7.1.min.js"></script>

    <!--modernizr.min.js-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>

    <!--bootstrap.min.js-->
    <script src="../../public/libs/bootstrap-5/js/bootstrap.min.js"></script>

    <!--owl.carousel.js-->
    <script src="../../public/libs/owl-carousel/owl.carousel.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>

    <!--Custom JS-->
    <script src="../js/custom.js"></script>

    <!-- header js -->
    <script src="../js/header.js"></script>

    <!-- footer js -->
    <script src="../js/footer.js"></script>
    <script src="../js/toast.js"></script>
</body>

</html>
<?php

// to show error codes
ini_set("display_errors", 1);

// call dbconnection file to use
require_once "dbconnect.php";

// creat session if not created
if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_GET['eventid'])) {
    header("Location:events.php");
}

function eventbyid($eventid)
{
    try {
        $conn = connect();
        $stmt = $conn->prepare("SELECT * FROM events WHERE id=?");
        $stmt->execute([$eventid]);
        return $stmt->fetch();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

$toshowevent = eventbyid($_GET['eventid']);

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

    <!-- For favicon png -->

    <!--font-awesome.min.css-->
    <!-- <link
      rel="stylesheet"
      href="../../public/libs/fontawesome-6/css/fontawesome.min.css"
    /> -->

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />

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

    <!--eventdetails.css-->
    <link rel="stylesheet" href="../css/eventdetails.css" />

    <!--footer.css-->
    <link rel="stylesheet" href="../css/footer.css" />

    <!--responsive.css-->
    <link rel="stylesheet" href="../css/responsive.css" />
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

    <!-- Event Details Section -->
    <section class="event-details-section" aria-labelledby="event-details-heading">
        <div class="container">
            <div class="event-details">
                <!-- Event Image (Left Side) -->
                <div class="event-image" aria-describedby="event-image-description">
                    <img src="../../<?php echo $toshowevent['image'] ?>" alt="<?php echo ucwords($toshowevent['name']) ?>"
                        aria-labelledby="event-image-description" />
                    <p id="event-image-description" class="sr-only">
                        Image showing a basketball game in action, representing the event.
                    </p>
                </div>

                <!-- Event Details (Right Side) -->
                <div class="event-info">
                    <h2 id="event-details-heading"><?php echo ucwords($toshowevent['name']) ?></h2>
                    <p class="event-description" aria-describedby="event-description">
                        <?php echo ucwords($toshowevent['description']) ?>
                    </p>

                    <div class="event-meta" aria-labelledby="event-meta">
                        <p>
                            <strong><i class="fa fa-calendar-alt"></i> Date:</strong> <?php echo date("j-F-Y", strtotime($toshowevent['date'])); ?>
                        </p>
                        <p>
                            <strong><i class="fa fa-clock"></i> Time:</strong> <?php echo $toshowevent['time'] ?>
                        </p>
                        <p>
                            <strong><i class="fa fa-calendar-check"></i> Registration
                                Deadline:</strong> <?php echo date("j-F-Y", strtotime($toshowevent['duedate'])); ?>
                        </p>
                        <p>
                            <strong><i class="fa fa-child"></i> Age Limit:</strong> <?php echo ucwords($toshowevent['agegroup']) ?>
                            years
                        </p>
                        <p>
                            <strong><i class="fa fa-users"></i> Participant Limit:</strong> <?php echo $toshowevent['participantslimit'] ?> players
                        </p>
                    </div>

                    <div class="register-btn-container">
                        <?php if (isset($_SESSION['email'])) { ?>
                            <a href="profile.php?eventid=<?php echo $toshowevent['id'] ?>" class="register-btn">
                                <button type="button">Register</button>
                            </a>
                        <?php } else { ?>
                            <a href="register.php" class="register-btn">
                                <button type="button">Register</button>
                            </a>
                        <?php } ?>
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
                    <div class="col-sm-4">
                        <div class="footer-social">
                            <a href="#" aria-label="Visit Facebook"><i class="fa-brands fa-facebook"></i></a>
                            <a href="#" aria-label="Visit Instagram"><i class="fa-brands fa-instagram"></i></a>
                            <a href="#" aria-label="Visit LinkedIn"><i class="fa-brands fa-linkedin"></i></a>
                            <a href="#" aria-label="Visit Twitter"><i class="fa-brands fa-twitter"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!--footer end-->

    <script src="../../public/libs/jquery/jquery-3.7.1.min.js"></script>

    <!--modernizr.min.js-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>

    <!--bootstrap.min.js-->
    <script src="../../public/libs/bootstrap-5/js/bootstrap.min.js"></script>

    <!--popper.min.js-->
    <script src="../../public/libs/bootstrap-5/js/popper.min.js"></script>

    <!--owl.carousel.js-->
    <script src="../../public/libs/owl-carousel/owl.carousel.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>

    <!--Custom JS-->
    <script src="../js/custom.js"></script>

    <!-- header js -->
    <script src="../js/header.js"></script>

    <!-- footer js -->
    <script src="../js/footer.js"></script>
</body>

</html>
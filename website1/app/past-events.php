<?php

// to show error codes
ini_set("display_errors", 1);

// call dbconnection file to use
require_once("dbconnect.php");
// call sessionconfig file to use its methods
require_once("sessionconfig.php");

$showevents = null;

function getevents(){
    try{
        $conn = $GLOBALS['conn'];
        $stmt = $conn->prepare("SELECT * FROM events WHERE status=? ORDER BY id DESC");
        $stmt->execute(['finished']);
        return $stmt->fetchAll();
    }catch(PDOException $e){
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
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, maximum-scale=1"
    />

    <!-- Bootstrap CSS link -->
    <link rel="stylesheet" href="../public/libs/css/bootstrap.min.css" />

    <!-- Font Awesome CSS link -->
    <link
        rel="stylesheet"
        href="../public/libs/font-awesome-5/css/fontawesome-all.min.css"
    />
    <!-- AOS CSS Link -->
    <link rel="stylesheet" href="../public/libs/css/aos.css" />

    <!-- Custom CSS link -->
    <link rel="stylesheet" href="../css/style.css" />
    <link rel="stylesheet" href="../css/past-events.css" />
</head>

<body>
<!-- MENU BAR -->
<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
        <a class="navbar-brand" href="./home.php">AUS Sport Club</a>

        <button
                class="navbar-toggler"
                type="button"
                data-toggle="collapse"
                data-target="#navbarNav"
                aria-controls="navbarNav"
                aria-expanded="false"
                aria-label="Toggle navigation"
        >
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a href="./home.php" class="nav-link smoothScroll">Home</a>
                </li>
                <li class="nav-item">
                    <a href="events.php" class="nav-link smoothScroll"
                    >Events</a
                    >
                </li>
                <li class="nav-item">
                    <a href="about-us.php" class="nav-link smoothScroll"
                    >About Us</a
                    >
                </li>
                <li class="nav-item">
                    <a href="contact-us.php" class="nav-link smoothScroll"
                    >Contact</a
                    >
                </li>
                <li class="nav-item">
                    <a href="past-events.php" class="nav-link smoothScroll"
                    >Memories</a>
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
                                    class="profile-pic"
                            />
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

<!-- PAST EVENTS -->
<section class="past-events section" id="past-events">
    <div class="container" data-aos="fade-up" data-aos-delay="300">
        <!-- Section Header -->
        <div class="section-header text-center mb-5">
            <h1 class="text-uppercase" data-aos="fade-up" data-aos-delay="400">
                Past Events
            </h1>
            <p data-aos="fade-up" data-aos-delay="500">
                Explore the memorable events hosted by AUS Sport Club over the
                years.
            </p>
        </div>

        <!-- Events Grid -->
        <div class="row">

            <?php foreach ($showevents as $showevent){ ?>
                <div
                        class="col-lg-4 col-md-6 mb-4"
                        data-aos="fade-up"
                        data-aos-delay="600"
                >
                    <div class="event-card">
                        <img
                                src="../<?php echo $showevent['image'] ?>"
                                alt="Event 1"
                                class="event-image"
                                data-aos="zoom-in"
                                data-aos-delay="700"
                        />
                        <div class="event-info">
                            <h3 class="event-title" data-aos="fade-up" data-aos-delay="800">
                                <?php echo ucwords($showevent['name']); ?>
                            </h3>
                            <p class="event-date" data-aos="fade-up" data-aos-delay="900">
                                <?php echo date("F j, Y", strtotime($showevent['date'])); ?>
                            </p>
                            <p class="event-desc" data-aos="fade-up" data-aos-delay="1000">
                                <?php echo ucfirst($showevent['description']); ?>
                            </p>
                        </div>
                    </div>
                </div>
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
                class="d-flex flex-column flex-md-row justify-content-center mx-auto col-lg-5 col-md-7 col-12"
            >
                <p class="mx-md-4 mx-lg-5 mb-2 mb-md-0">
                    <i class="fas fa-envelope mr-2" style="color: #c60a11"></i>
                    <a href="#" style="color: #a47800; text-decoration: none"
                    >aussportclub@company.co</a
                    >
                </p>
                <p>
                    <i class="fas fa-phone mr-2" style="color: #c60a11"></i>
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
</body>
</html>
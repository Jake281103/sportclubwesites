<?php

// to show error codes
ini_set("display_errors", 1);

// call dbconnection file to use
require_once("dbconnect.php");
// call sessionconfig file to use its methods
require_once("sessionconfig.php");

$message = "";

if (verifysession("send-message-success")) {
    $message = getsession("send-message-success");
}

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
    <link rel="stylesheet" href="../css/contact-us.css" />
    <link rel="stylesheet" href="../css/toast.css" />
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

    <!-- CONTACT -->
    <section class="contact section" id="contact">
        <div class="container">
            <div class="row">
                <div class="ml-auto col-lg-5 col-md-6 col-12">
                    <h2 class="mb-4 pb-2" data-aos="fade-up" data-aos-delay="200">
                        Feel free to ask anything
                    </h2>

                    <form
                        action="message-send-function.php"
                        method="post"
                        class="contact-form webform"
                        data-aos="fade-up"
                        data-aos-delay="400"
                        role="form">
                        <input
                            type="text"
                            class="form-control"
                            name="name"
                            placeholder="Name" />

                        <input
                            type="email"
                            class="form-control"
                            name="email"
                            placeholder="Email" />

                        <textarea
                            class="form-control"
                            rows="5"
                            name="message"
                            placeholder="Message"></textarea>

                        <button
                            type="submit"
                            class="form-control"
                            id="submit-button"
                            name="send-message">
                            Send Message
                        </button>
                    </form>
                </div>

                <div class="mx-auto mt-4 mt-lg-0 mt-md-0 col-lg-5 col-md-6 col-12">
                    <h2 class="mb-4" data-aos="fade-up" data-aos-delay="600">
                        Where you can <span>find us</span>
                    </h2>

                    <p data-aos="fade-up" data-aos-delay="800">
                        <i class="fa fa-map-marker mr-1"></i> 107th Street x 65th Street,
                        Mandalay, Myanmar
                    </p>
                    <!-- How to change your own map point
      1. Go to Google Maps
      2. Click on your location point
      3. Click "Share" and choose "Embed map" tab
      4. Copy only URL and paste it within the src="" field below
    -->
                    <div class="google-map" data-aos="fade-up" data-aos-delay="900">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3700.870262750139!2d96.10315237533713!3d21.939538479947586!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30cb6d00437fc6d5%3A0x7b39ed9fcb701778!2sAuston%20Mandalay%20Campus!5e0!3m2!1sen!2smm!4v1732124295133!5m2!1sen!2smm"
                            width="600"
                            height="450"
                            style="border: 0"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
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

    <?php if ($message != null) { ?>
        <div class="toasts actives">
            <div class="toast-contents">
                <i class="fas fa-check check"></i>

                <div class="message">
                    <span class="text text-1">Success</span>
                    <span class="text text-2"><?php echo $message ?></span>
                </div>
            </div>
            <i class="fas fa-times closes"></i>

            <div class="progress actives"></div>
        </div>
    <?php
        unsetsession("send-message-success");
        $message = '';
    }
    ?>

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
    <script src="../js/toast.js"></script>
</body>

</html>
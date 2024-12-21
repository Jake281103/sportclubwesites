<?php

// to show error codes
ini_set("display_errors", 1);

// call dbconnection file to use
require_once("dbconnect.php");
// call sessionconfig file to use its methods
require_once("sessionconfig.php");

// making default time zone
date_default_timezone_set("Asia/Yangon");

$date = date("Y-m-d");
$newdate = date('Y-m-d', strtotime($date . '+1 days'));

$message = "";
$sports = null;
$locations = null;
$showevents = null;
$filter = false;

if (verifysession("register-success")) {
    $message = getsession("register-success");
} elseif (verifysession("user-login-success")) {
    $message = getsession("user-login-success");
}

function getsports()
{
    try {
        $conn = $GLOBALS['conn'];
        $sql = "SELECT * FROM sports";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

function getsport($id)
{
    try {
        $conn = $GLOBALS['conn'];
        $sql = "SELECT * FROM sports WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

function getuniqueeventlocations()
{
    try {
        $conn = $GLOBALS['conn'];
        $sql = "SELECT DISTINCT location FROM events ORDER BY location;";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["event-filter"])) {
    $filer = true;
    $filercolumnarray = [];
    $filervaluearray = [];
    if (isset($_POST["filter-date"])) {
        array_push($filercolumnarray, 'date');
        array_push($filervaluearray, $_POST["filter-date"]);
    }
    if ($_POST["filter-sport"] != 0) {
        array_push($filercolumnarray, 'sports_id');
        array_push($filervaluearray, $_POST["filter-sport"]);
    }
    if ($_POST["filter-location"] != 0) {
        array_push($filercolumnarray, 'location');
        array_push($filervaluearray, $_POST["filter-location"]);
    }
    if ($_POST["filter-age"] != 0) {
        array_push($filercolumnarray, 'agegroup');
        array_push($filervaluearray, $_POST["filter-age"]);
    }
    //    var_dump($filercolumnarray);
    //    var_dump($filervaluearray);

    try {
        $conn = $GLOBALS['conn'];
        $sql = 'SELECT * FROM events WHERE ';
        for ($i = 0; $i < count($filercolumnarray); $i++) {
            if ($i == count($filercolumnarray) - 1) {
                $sql .= $filercolumnarray[$i] . "=?";
            } else {
                $sql .= $filercolumnarray[$i] . "=? AND ";
            }
        }
        $stmt = $conn->prepare($sql);
        $stmt->execute($filervaluearray);
        $showevents = $stmt->fetchAll();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

$sports = getsports();
$locations = getuniqueeventlocations();
//var_dump($locations);
//echo $newdate;
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
    <link rel="stylesheet" href="../css/home.css" />
    <link rel="stylesheet" href="../css/event-details.css" />
    <link rel="stylesheet" href="../css/toast.css" />
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
                        <h6 data-aos="fade-up" data-aos-delay="200" class="text-shadow">Ready to embrace a healthy lifestyle?</h6>

                        <h1 class="text-white display-4" data-aos="fade-up" data-aos-delay="400">Join the AUS Sport Club Today!</h1>

                        <p class="lead text-white" data-aos="fade-up" data-aos-delay="600">Get started with events, training, and more—discover your fitness potential with us.</p>

                        <div class="cta-buttons" data-aos="fade-up" data-aos-delay="800">
                            <a href="#feature" class="btn custom-btn mt-3 mx-2">Get Started</a>
                            <a href="#about" class="btn custom-btn bordered mt-3 mx-2">Learn More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FILTER SECTION -->
    <section id="filter" class="filter-section py-5">
        <div class="container">
            <h2 class="text-center text-white mb-5" data-aos="fade-up" data-aos-delay="200">
                Find Your Next Event
            </h2>
            <!-- filter section -->
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10 col-12">
                    <form action="home.php" method="post">
                        <div class="filter-options d-flex flex-wrap justify-content-between align-items-center">
                            <div class="filter-item">
                                <input
                                    type="date"
                                    name="filter-date"
                                    id="date-selection"
                                    placeholder="dd/mm/yy"
                                    class="form-control"
                                    min="<?php echo $newdate ?>"
                                    aria-label="Event Date"
                                    data-aos="fade-up" data-aos-delay="400"
                                    required />
                            </div>

                            <div class="filter-item">
                                <select
                                    name="filter-sport"
                                    id="sport-selection"
                                    class="form-select" aria-label="Event Sport" data-aos="fade-up" data-aos-delay="600"
                                    required>
                                    <option value="0" selected>All Sports</option>
                                    <?php foreach ($sports as $sport) {
                                        echo '<option value="' . $sport['id'] . '">' . $sport['name'] . '</option>';
                                    } ?>
                                </select>
                            </div>

                            <div class="filter-item">
                                <select
                                    name="filter-location"
                                    id="location-selection"
                                    class="form-select"
                                    data-aos="fade-up" data-aos-delay="700"
                                    required>
                                    <option value="0" selected>All Location</option>
                                    <?php foreach ($locations as $location) {
                                        echo '<option value="' . $location['location'] . '">' . ucwords($location['location']) . '</option>';
                                    } ?>
                                </select>
                            </div>

                            <div class="filter-item">
                                <select name="filter-age" id="age-selection" class="form-select" data-aos="fade-up" data-aos-delay="600" required>
                                    <option value="0" selected>All age</option>
                                    <option value="child">Child (under 15)</option>
                                    <option value="teen">Teen (Between 16 and 23)</option>
                                    <option value="adult">Adult (Over 23)</option>
                                    <option value="all">No Age Limit</option>
                                </select>
                            </div>

                            <div class="filter-item w-100">
                                <button type="submit" name="event-filter" class="btn custom-btn" id="filter-btn" data-aos="fade-up" data-aos-delay="800">
                                    Apply Filter
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- filter events section -->
            <div class="container mt-5">
                <?php if ($filer) { ?>
                    <h2 class="text-center text-white mb-4">Upcoming Events</h2>
                    <div class="row g-4">
                        <!-- Event Card -->
                        <?php if ($showevents != null) { ?>
                            <?php foreach ($showevents as $showevent) { ?>
                                <div class="col-md-4" data-aos="zoom-in" data-aos-delay="200">
                                    <div class="event-box">
                                        <div class="event-image-container">
                                            <span class="event-status-tag upcoming"><?php echo $showevent['status'] ?></span>
                                            <img src="../<?php echo $showevent['image'] ?>" alt="<?php echo $showevent['name'] ?>"
                                                class="event-thumbnail">
                                        </div>
                                        <div class="event-info">
                                            <h5 class="event-heading"><?php echo ucwords($showevent['name']) ?></h5>
                                            <div class="event-divider"></div>
                                            <ul class="event-meta">
                                                <li><strong>Date:</strong> <?php echo date("F j, Y", strtotime($showevent['date'])); ?></li>
                                                <li><strong>Location:</strong> <?php echo ucwords($showevent['location']) ?></li>
                                                <li><strong>Sport:</strong> <?php echo ucwords(getsport($showevent['sports_id'])['name']) ?></li>
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
        unsetsession("register-success");
        unsetsession("user-login-success");
        $message = '';
    }
    ?>

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
    <script src="../js/toast.js"></script>
</body>

</html>
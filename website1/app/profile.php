<?php


// to show error codes
use function mysql_xdevapi\getSession;

ini_set("display_errors", 1);

// call dbconnection file to use
require_once("dbconnect.php");
// call sessionconfig file to use its methods
require_once("sessionconfig.php");

// making default time zone
date_default_timezone_set("Asia/Yangon");

$date = date("Y-m-d");

$user = null;
$message = "";
$skilllevels = ['beginner','amateur','professional'];

if(!verifysession('email')){
    redirectto('home.php');
}

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update-profile'])){
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $dob = $_POST['dob'];
    $skilllevel = $_POST['skill-level'];
    $prefersport = $_POST['prefer-sport'];

    // echo $skilllevel;
    // echo $prefersport;

//    echo $id;
//    echo $name;
//    echo $email;
//    echo $phone;
//    echo $dob;

    try{
        $conn = $GLOBALS['conn'];
        $sql = "UPDATE users SET name=?, email=?, phonenumber=?, dob=?, prefersport=?, skilllevel=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$name,$email,$phone,$dob,$prefersport,$skilllevel,$id]);
        setsession('profile-update', "Your profile has been updated");
    }catch (PDOException $e){
        echo $e->getMessage();
    }


}

if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['eventid'])){
    setsession('eventid', $_GET['eventid']);
}

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])){
    $userid = $_POST['userid'];
    $eventid = $_POST['eventid'];
    $count = $_POST["count"];
    if(checkcount($eventid,$count)){
        try{
            $conn = $GLOBALS['conn'];
            $sql = "UPDATE events SET remainlimit=remainlimit-? WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$count,$eventid]);

            $sql = "INSERT INTO eventregistrations (users_id,events_id,count,date) VALUES(?,?,?,?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$userid,$eventid,$count,$date]);

            setsession('register-success','Your registration has been completed');
        }catch (PDOException $e){
            echo $e->getMessage();
        }
    }else{
        setsession('count-invalid',"Your participant count is greater than remain limit.");
    }
}

function checkcount($eventid,$count){
    try{
        $conn = $GLOBALS['conn'];
        $sql = "SELECT * FROM events WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$eventid]);
        $event = $stmt->fetch();
        $remaincount = $event["remainlimit"];
        if($count <= $remaincount){
            return true;
        }else{
            return false;
        }
    }catch (PDOException $e){
        echo $e->getMessage();
    }
}

function getusers($email){
    try{
        $conn = $GLOBALS['conn'];
        $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }catch(PDOException $e){
        echo $e->getMessage();
    }
}

function getevents($date){
    try{
        $conn = $GLOBALS['conn'];
        $stmt = $conn->prepare("SELECT * FROM events WHERE duedate >= ? AND remainlimit <> ? ");
        $stmt->execute([$date,0]);
        return $stmt->fetchAll();
    }catch (PDOException $e){
        echo $e->getMessage();
    }
}

function getevent($eventid){
    try{
        $conn = $GLOBALS['conn'];
        $stmt = $conn->prepare("SELECT * FROM events WHERE id=?");
        $stmt->execute([$eventid]);
        $event = $stmt->fetch();
        return $event;
    }catch (PDOException $e){
        echo $e->getMessage();
    }
}

function getsports(){
    try{
        $conn = $GLOBALS['conn'];
        $stmt = $conn->prepare("SELECT * FROM sports");
        $stmt->execute();
        return $stmt->fetchAll();
    }catch(PDOException $e){
        echo $e->getMessage();
    }
}

function getregistrations($userid){
    try{
        $conn = $GLOBALS['conn'];
        $stmt = $conn->prepare("SELECT DISTINCT events_id, date FROM eventregistrations WHERE users_id=?");
        $stmt->execute([$userid]);
        return $stmt->fetchAll();
    }catch (PDOException $e){
        echo $e->getMessage();
    }
}

if (verifysession("profile-update")) {
    $message = $_SESSION["profile-update"];
}elseif(verifysession("register-success")){
    $message = $_SESSION["register-success"]    ;
}elseif (verifysession("count-invalid")){
    $message = $_SESSION['count-invalid'];
}


$user = getusers($_SESSION['email']);
$events = getevents($date);
$sports = getsports();
$registrations = getregistrations($user["id"]);

// var_dump($user);
// var_dump($sports);
//echo $user['id'];
//var_dump($events);

//var_dump($registrations);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>AUS Sport Club</title>

    <meta charset="UTF-8"/>
    <meta
            name="viewport"
            content="width=device-width, initial-scale=1, maximum-scale=1"
    />

    <!-- Bootstrap CSS link -->
    <link rel="stylesheet" href="../public/libs/css/bootstrap.min.css"/>

    <!-- Font Awesome CSS link -->
    <link
            rel="stylesheet"
            href="../public/libs/font-awesome-5/css/fontawesome-all.min.css"
    />
    <!-- AOS CSS Link -->
    <link rel="stylesheet" href="../public/libs/css/aos.css"/>

    <!-- Custom CSS link -->
    <link rel="stylesheet" href="../css/style.css"/>
    <link rel="stylesheet" href="../css/profile.css"/>
    <link rel="stylesheet" href="../css/toast.css"/>
</head>

<body>
<!-- Profile Section -->
<section class="profile section">
    <div class="container">
        <div class="profile-card">
            <div class="back-btn-container">
                <a href="./home.php" class="back-btn">Back to Home</a>
            </div>

            <h2 class="section-title" data-aos="fade-up" data-aos-delay="200">
                Profile Management
            </h2>

            <form action="profile.php" method="post" class="profile-form">
                <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                            <input
                                    type="text"
                                    class="form-control"
                                    id="name"
                                    name="name"
                                    placeholder="Enter your name"
                                    value="<?php echo $user['name'] ?>"
                                    required
                            />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input
                                    type="email"
                                    class="form-control"
                                    id="email"
                                    name="email"
                                    placeholder="Enter your email"
                                    value="<?php echo $user['email'] ?>"
                                    required
                            />
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input
                                    type="text"
                                    class="form-control"
                                    id="phone"
                                    name="phone"
                                    maxlength="11"
                                    placeholder="Enter your phone number"
                                    value="<?php echo $user['phonenumber'] ?>"
                                    required
                            />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="dob">Date of Birth</label>
                            <input type="date" class="form-control" name="dob" id="dob" value="<?php echo $user['dob'] ?>" required/>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="sport-id">Prefer Sport</label>
                            <select class="form-control" id="sport-id" name="prefer-sport" required>
                                <?php if($user['prefersport'] != null){ ?>
                                    <?php foreach ($sports as $sport){ ?>
                                        <?php if($sport['id'] == $user['prefersport']){ ?>
                                            <option value="<?php echo $sport['id'] ?>" selected><?php echo ucwords($sport['name']) ?></option>
                                        <?php }else{?>
                                            <option value="<?php echo $sport['id'] ?>"><?php echo ucwords($sport['name']) ?></option>
                                        <?php } ?>
                                    <?php }?>
                                <?php } else{ ?>
                                    <?php foreach ($sports as $sport){ ?>
                                        <option value="<?php echo $sport['id'] ?>"><?php echo ucwords($sport['name']) ?></option>
                                    <?php }?>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="skill-level">Your Skill Level</label>
                            <select class="form-control" id="skill-level" name="skill-level" required>
                                <?php if($user['skilllevel'] != null){ ?>
                                    <?php foreach ($skilllevels as $skilllevel){ ?>
                                        <?php if($skilllevel == $user['skilllevel']){ ?>
                                            <option value="<?php echo $skilllevel ?>" selected><?php echo ucwords($skilllevel) ?></option>
                                        <?php }else{?>
                                            <option value="<?php echo $skilllevel ?>"><?php echo ucwords($skilllevel) ?></option>
                                        <?php } ?>
                                    <?php }?>
                                <?php } else{ ?>
                                    <?php foreach ($skilllevels as $skilllevel){ ?>
                                        <option value="<?php echo $skilllevel ?>"><?php echo ucwords($skilllevel) ?></option>
                                    <?php }?>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>

                <button type="submit" name="update-profile" class="custom-btn">Save Changes</button>
            </form>
        </div>
    </div>
</section>

<!-- Event Management Section -->
<section class="event-management section" id="event-management">
    <div class="container">
        <div class="section-header text-center mb-5">
            <h1 class="text-uppercase">Event Management</h1>
            <p>
                Register for upcoming events, manage your registrations, and track
                your participation history.
            </p>
        </div>

        <!-- Event Registration Form -->
        <div class="row">
            <div class="col-lg-6 col-md-12 mb-4">
                <div class="event-card">
                    <h3 class="event-title">Register for Upcoming Event</h3>
                    <form action="profile.php" method="POST"
                            id="event-registration-form"
                            class="event-registration-form">
                        <input type="hidden" name="userid" value="<?php echo $user['id'] ?>"/>
                        <div class="form-group">
                            <label for="event-name">Select Event</label>
                            <select class="form-control" id="event-name" name="eventid" required>
                                <?php if(verifysession('eventid')){ ?>
                                    <?php foreach ($events as $event){ ?>
                                        <?php if($event['id'] == $_SESSION['eventid']){ ?>
                                            <option value="<?php echo $event['id'] ?>" selected><?php echo $event['name'] ?></option>
                                        <?php }else{?>
                                            <option value="<?php echo $event['id'] ?>"><?php echo $event['name'] ?></option>
                                        <?php } ?>
                                    <?php }?>
                                <?php } else{ ?>
                                    <option disabled selected>Select an Event</option>
                                    <?php foreach ($events as $event){ ?>
                                        <option value="<?php echo $event['id'] ?>"><?php echo $event['name'] ?></option>
                                    <?php }?>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="participant-email">Participant Count</label>
                            <input
                                    type="number"
                                    class="form-control"
                                    id="participant-email"
                                    name="count"
                                    min="1"
                                    max="20"
                                    placeholder="Enter your email"
                                    required
                            />
                        </div>
                        <div class="form-group">
                            <button type="submit" name="register" class="btn custom-btn text-white">
                                Register
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Manage Registrations -->
            <div class="col-lg-6 col-md-12 mb-4">
                <div class="event-card">
                    <h3 class="event-title">Your Registrations</h3>
                    <div id="manage-registrations">
                        <p>You are currently registered for the following events:</p>
                        <ul>
                            <?php foreach ($registrations as $registration){
                                $checkevent = getevent($registration['events_id']);
                            ?>
                                <?php if($checkevent['status'] == "upcoming"){ ?>
                                    <li>
                                        <?php echo ucwords($checkevent['name']) ?>
                                        <button><?php echo date("F j, Y", strtotime($registration['date']));  ?></button>
                                    </li>
                                <?php } ?>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Participation History -->
        <div class="row">
            <div class="col-12">
                <div class="event-card">
                    <h3 class="event-title">Your Participation History</h3>
                    <p>Here’s a list of events you’ve participated in:</p>
                    <ul id="participation-history">
                        <?php foreach ($registrations as $registration){
                            $checkevent = getevent($registration['events_id']);
                            ?>
                            <?php if($checkevent['status'] == "finished"){ ?>
                                <li>
                                    <?php echo ucwords($checkevent['name']); ?> (Completed at <?php echo date("F j, Y", strtotime($registration['date'])); ?>)
                                </li>
                            <?php } ?>
                        <?php } ?>
                    </ul>
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
        <hr style="border-top: 1px solid #444; margin: 1.5rem 0"/>

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
            <i class="fas <?php if(verifysession('count-invalid')){ echo "fa-times bg-danger"; }else{ echo "fa-check";}?> check"></i>
            <div class="message">
                <span class="text text-1">
                    <?php if(verifysession('count-invalid')){
                        echo "Failed";
                    }else{
                        echo "Success";
                    }
                    ?>
                </span>
                <span class="text text-2"><?php echo $message ?></span>
            </div>
        </div>
        <i class="fas fa-times closes"></i>

        <div class="progress actives"></div>
    </div>
    <?php
    unsetsession("profile-update");
    unsetsession("register-success");
    unsetsession("count-invalid");
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
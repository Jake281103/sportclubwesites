<?php

// to show error codes
ini_set("display_errors", 1);

// call dbconnection file to use
require_once "dbconnect.php";

// creat session if not created
if (!isset($_SESSION)) {
  session_start();
}

if (!isset($_SESSION['email'])) {
  header("Location:login.php");
}

// making default time zone
date_default_timezone_set("Asia/Yangon");

$date = date("Y-m-d");


$member = null;
$toastmessage = null;
$arrayofskills = ['beginner', 'amateur', 'professional'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit-profile-btn'])) {
  $id = $_POST['member-id'];
  $phone = $_POST['member-phone'];
  $dob = $_POST['member-dob'];
  $skilllevel = $_POST['member-skill'];
  $prefersport = $_POST['member-prefer-sport'];


  try {
    $conn = connect();
    $sql = "UPDATE users SET phonenumber=?, dob=?, prefersport=?, skilllevel=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$phone, $dob, $prefersport, $skilllevel, $id]);
    $_SESSION['update-profile-success'] = "Your profile has been updated";
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['eventid'])) {
  $_SESSION['eventid'] = $_GET['eventid'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register-btn'])) {
  $memberid = $_POST['member-id'];
  $eventid = $_POST['event-id'];
  $participantcount = $_POST["participant-count"];
  // if(coutchecking($eventid,$participantcount)){
  //   echo "true";
  // }else{
  //   echo "false";
  // }

  if (coutchecking($eventid, $participantcount)) {
    try {
      $conn = connect();
      $sql = "UPDATE events SET remainlimit=remainlimit-? WHERE id=?";
      $stmt = $conn->prepare($sql);
      $stmt->execute([$participantcount, $eventid]);

      $sql = "INSERT INTO eventregistrations (users_id,events_id,count,date) VALUES(?,?,?,?)";
      $stmt = $conn->prepare($sql);
      $stmt->execute([$memberid, $eventid, $participantcount, $date]);

      $_SESSION['event-register-success'] = "Your registration has been completed";
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  } else {
    $_SESSION['not-valid-count'] = "Your participant count is greater than remain limit.";
  }
}

function coutchecking($id, $count)
{
  try {
    $conn = connect();
    $sql = "SELECT * FROM events WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);
    $event = $stmt->fetch();
    $remaincount = $event["remainlimit"];
    if ($count <= $remaincount) {
      return true;
    } else {
      return false;
    }
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
}

function memberbyemail($email)
{
  try {
    $conn = connect();
    $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
    $stmt->execute([$email]);
    return $stmt->fetch();
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
}

function validevents($date)
{
  try {
    $conn = connect();
    $stmt = $conn->prepare("SELECT * FROM events WHERE duedate >= ? AND remainlimit <> ? AND status=?");
    $stmt->execute([$date, 0, 'upcoming']);
    return $stmt->fetchAll();
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
}

function eventbyid($eventid)
{
  try {
    $conn = connect();
    $stmt = $conn->prepare("SELECT * FROM events WHERE id=?");
    $stmt->execute([$eventid]);
    $event = $stmt->fetch();
    return $event;
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
}

function sports()
{
  try {
    $conn = connect();
    $stmt = $conn->prepare("SELECT * FROM sports");
    $stmt->execute();
    return $stmt->fetchAll();
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
}

function registrationofeachmember($user_id)
{
  try {
    $conn = connect();
    $stmt = $conn->prepare("SELECT DISTINCT events_id, date FROM eventregistrations WHERE users_id=?");
    $stmt->execute([$user_id]);
    return $stmt->fetchAll();
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
}

if (isset($_SESSION['update-profile-success'])) {
  $toastmessage = $_SESSION["update-profile-success"];
} elseif (isset($_SESSION['event-register-success'])) {
  $toastmessage = $_SESSION["event-register-success"];
} elseif (isset($_SESSION['not-valid-count'])) {
  $toastmessage = $_SESSION["not-valid-count"];
}

$member = memberbyemail($_SESSION['email']);
$validevents = validevents($date);
$sports = sports();
$registrations = registrationofeachmember($member["id"]);

// var_dump($member);
// var_dump($registrations)

// echo $_SESSION['eventid'];
// var_dump($validevents);


?>

<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
  <!-- meta data -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

  <!-- fontawesome-->
  <link href="../../public/libs/fontawesome-6/css/all.min.css" rel="stylesheet" />

  <!--font-family-->
  <link
    href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet" />

  <link
    href="https://fonts.googleapis.com/css?family=Rufina:400,700"
    rel="stylesheet" />

  <!-- title of site -->
  <title>AUS Sport Club</title>

  <!-- SweetAlert2 CSS -->
  <link
    rel="stylesheet"
    href="../../public/libs/sweetalert/sweetalert2.min.css" />

  <!--bootstrap.min.css-->
  <link
    rel="stylesheet"
    href="../../public/libs/bootstrap-5/css/bootstrap.min.css" />

  <!--style.css-->
  <link rel="stylesheet" href="../css/style.css" />

  <!--responsive.css-->
  <link rel="stylesheet" href="../css/responsive.css" />
  <link rel="stylesheet" href="../css/toast.css" />
</head>

<body>
  <!-- User Profile and Participation History Section -->
  <section class="user-profile py-5">
    <div class="container">

      <!-- Profile Header -->
      <div class="d-flex justify-content-between align-items-center mb-5">
        <h2 class="text-primary h2">User Profile</h2>
        <button onclick="goHome()" class="btn btn-warning shadow-sm">
          <i class="bi bi-arrow-left-circle me-2"></i>Back to Home
        </button>
      </div>

      <!-- User Profile Form -->
      <form action="profile.php" method="post" class="row g-4 p-4 rounded shadow bg-white">
        <!-- Phone -->
        <input type="hidden" name="member-id" value="<?php echo $member['id'] ?>" />
        <div class="col-md-6">
          <label for="phone" class="form-label">Phone</label>
          <input
            type="text"
            id="phone"
            maxlength="11"
            name="member-phone" value="<?php echo $member['phonenumber'] ?>"
            class="form-control"
            placeholder="Enter Your Phone Number" required />
        </div>

        <!-- Date of Birth -->
        <div class="col-md-6">
          <label for="dob" class="form-label">Date of Birth</label>
          <input type="date" name="member-dob" id="dob" class="form-control" value="<?php echo $member['dob'] ?>" required />
        </div>

        <!-- Skill Level -->
        <div class="col-md-6">
          <label for="skill-level" class="form-label">Skill Level</label>
          <select id="skill-level" name="member-skill" class="form-select" required>
            <?php if ($member['skilllevel'] != null) { ?>
              <?php foreach ($arrayofskills as $skilllevel) { ?>
                <?php if ($skilllevel == $member['skilllevel']) { ?>
                  <option value="<?php echo $skilllevel ?>" selected><?php echo ucwords($skilllevel) ?></option>
                <?php } else { ?>
                  <option value="<?php echo $skilllevel ?>"><?php echo ucwords($skilllevel) ?></option>
                <?php } ?>
              <?php } ?>
            <?php } else { ?>
              <?php foreach ($arrayofskills as $skilllevel) { ?>
                <option value="<?php echo $skilllevel ?>"><?php echo ucwords($skilllevel) ?></option>
              <?php } ?>
            <?php } ?>
          </select>
        </div>

        <!-- Preferred Sport -->
        <div class="col-md-6">
          <label for="sport" class="form-label">Preferred Sport</label>
          <select id="sport" name="member-prefer-sport" class="form-select" required>
            <?php if ($user_data['prefersport'] != null) { ?>
              <?php foreach ($sports as $sport) { ?>
                <?php if ($sport['id'] == $member['prefersport']) { ?>
                  <option value="<?php echo $sport['id'] ?>" selected><?php echo ucwords($sport['name']) ?></option>
                <?php } else { ?>
                  <option value="<?php echo $sport['id'] ?>"><?php echo ucwords($sport['name']) ?></option>
                <?php } ?>
              <?php } ?>
            <?php } else { ?>
              <?php foreach ($sports as $sport) { ?>
                <option value="<?php echo $sport['id'] ?>"><?php echo ucwords($sport['name']) ?></option>
              <?php } ?>
            <?php } ?>
          </select>
        </div>

        <!-- Buttons -->
        <div class="col-12 d-flex justify-content-end gap-3">
          <button type="reset" class="btn btn-danger shadow-sm">
            <i class="bi bi-x-circle me-1"></i>Cancel
          </button>
          <button
            type="submit"
            name="edit-profile-btn"
            class="btn btn-success shadow-sm">
            <i class="bi bi-check-circle me-1"></i>Submit
          </button>
        </div>
      </form>

      <!-- Participation History -->
      <div class="mt-5 p-4 rounded shadow bg-light history">
        <h2 class="text-primary h2">Your Participation History</h2>
        <p class="text-muted my-3 h4">
          You have participated in the following events since you’ve become
          our member...
        </p>
        <ul class="list-unstyled my-3">
          <?php foreach ($registrations as $registration) {
            $finishedevent = eventbyid($registration['events_id']);
          ?>
            <?php if ($finishedevent['status'] == "finished") { ?>
              <li>
                <a href="#" class="text-primary h5"><?php echo ucwords($finishedevent['name']); ?></a>
              </li>
            <?php } ?>
          <?php } ?>
        </ul>
      </div>
    </div>
  </section>

  <!-- Register and Managing Events Section -->
  <div class="container my-5 rme-section">
    <!-- Section: Register Events -->
    <div class="row">
      <div class="col-md-6">
        <div class="card shadow p-4">
          <h4 class="text-primary mb-4">Register Events</h4>
          <form action="profile.php" method="post" id="registerForm">
            <input type="hidden" name="member-id" value="<?php echo $member['id'] ?>" />
            <div class="mb-3">
              <label for="eventSelect" class="form-label">Select Event</label>
              <select class="form-select" name="event-id" id="eventSelect" required>
                <?php if (isset($_SESSION['eventid'])) { ?>
                  <?php foreach ($validevents as $event) { ?>
                    <?php if ($event['id'] == $_SESSION['eventid']) { ?>
                      <option value="<?php echo $event['id'] ?>" selected><?php echo ucwords($event['name']) ?></option>
                    <?php } else { ?>
                      <option value="<?php echo $event['id'] ?>"><?php echo ucwords($event['name']) ?></option>
                    <?php } ?>
                  <?php } ?>
                <?php } else { ?>
                  <option disabled selected>Select an Event</option>
                  <?php foreach ($validevents as $event) { ?>
                    <option value="<?php echo $event['id'] ?>"><?php echo ucwords($event['name']) ?></option>
                  <?php } ?>
                <?php } ?>
              </select>
            </div>
            <div class="mb-3">
              <label for="count" class="form-label">Participant Count</label>
              <input
                type="number"
                class="form-control"
                id="count"
                name="participant-count"
                min="1" max="20"
                required />
            </div>
            <button type="submit" name="register-btn" class="btn btn-secondary w-100">
              Register
            </button>
          </form>
        </div>
      </div>

      <!-- Section: Manage Your Registrations -->
      <div class="col-md-6">
        <div class="card shadow p-4">
          <h4 class="text-primary mb-4">Manage Your Registrations</h4>
          <p class="mb-2">
            You are currently registered for the following events:
          </p>
          <ul class="list-group">
            <?php foreach ($registrations as $registration) {
              $registerevents = eventbyid($registration['events_id']);
            ?>
              <?php if ($registerevents['status'] == "upcoming") { ?>
                <li
                  class="list-group-item d-flex justify-content-between align-items-center">
                  <?php echo ucwords($registerevents['name']) ?>
                  <button class="btn btn-danger cancel-btn"><?php echo date("j-F-Y", strtotime($registerevents['date'])) ?></button>
                </li>
              <?php } ?>
            <?php } ?>
          </ul>
        </div>
      </div>
    </div>
  </div>

  <?php if ($toastmessage != null) { ?>
    <div class="toasts actives">
      <div class="toast-contents">
        <i class="fas <?php if (isset($_SESSION['not-valid-count'])) {
                        echo "fa-times bg-danger";
                      } else {
                        echo "fa-check";
                      } ?> check"></i>
        <div class="message">
          <span class="text text-1">
            <?php if (isset($_SESSION['not-valid-count'])) {
              echo "Failed";
            } else {
              echo "Success";
            }
            ?>
          </span>
          <span class="text text-2"><?php echo $toastmessage ?></span>
        </div>
      </div>
      <i class="fas fa-times closes"></i>

      <div class="progress actives"></div>
    </div>
  <?php
    unset($_SESSION['update-profile-success']);
    unset($_SESSION['event-register-success']);
    unset($_SESSION['not-valid-count']);
    $toastmessage = '';
  }
  ?>

  <script src="../../public/libs/jquery/jquery-3.7.1.min.js"></script>

  <!-- SweetAlert2 JavaScript -->
  <script src="../../public/libs/sweetalert/sweetalert2.all.min.js"></script>

  <!--bootstrap.min.js-->
  <script src="../../public/libs/bootstrap-5/js/bootstrap.min.js"></script>

  <!--Profile JS-->
  <script src="../js/profile.js"></script>
  <script src="../js/toast.js" type="text/javascript"></script>
</body>

</html>
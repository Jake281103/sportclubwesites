<?php

// to show error codes
ini_set("display_errors", 1);

// call dbconnection file to use
require_once("databaseconnection.php");

// creat session if not created
if (!isset($_SESSION)) {
  session_start();
}

if (!isset($_SESSION['email'])) {
  header("Location:auth.php");
}

// making default time zone
date_default_timezone_set("Asia/Yangon");

$date = date("Y-m-d");

$user_data = null;
$noti_message = null;
$skill_array = ['beginner', 'amateur', 'professional'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_profile'])) {
  $id = $_POST['id'];
  $name = $_POST['name'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  $dob = $_POST['dob'];
  $skilllevel = $_POST['skill_level'];
  $prefersport = $_POST['prefer_sport'];


  try {
    $conn = connect();
    $sql = "UPDATE users SET name=?, email=?, phonenumber=?, dob=?, prefersport=?, skilllevel=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$name, $email, $phone, $dob, $prefersport, $skilllevel, $id]);
    $_SESSION['profile_update'] = "Your profile has been updated";
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['event_id'])) {
  $_SESSION['event_id'] = $_GET['event_id'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['event_register'])) {
  $user_id = $_POST['user_id'];
  $event_id = $_POST['event_id'];
  $count = $_POST["count"];
  if (checkcount($event_id, $count)) {
    try {
      $conn = connect();
      $sql = "UPDATE events SET remainlimit=remainlimit-? WHERE id=?";
      $stmt = $conn->prepare($sql);
      $stmt->execute([$count, $event_id]);

      $sql = "INSERT INTO eventregistrations (users_id,events_id,count,date) VALUES(?,?,?,?)";
      $stmt = $conn->prepare($sql);
      $stmt->execute([$user_id, $event_id, $count, $date]);

      $_SESSION['register_success'] = "Your registration has been completed";
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  } else {
    $_SESSION['count-invalid'] = "Your participant count is greater than remain limit.";
  }
}

function checkcount($eventid, $count)
{
  try {
    $conn = connect();
    $sql = "SELECT * FROM events WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$eventid]);
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

function get_user_by_email($email)
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

function get_event_by_date($date)
{
  try {
    $conn = connect();
    $stmt = $conn->prepare("SELECT * FROM events WHERE duedate >= ? AND remainlimit <> ? AND status=?");
    $stmt->execute([$date, 0,'upcoming']);
    return $stmt->fetchAll();
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
}

function get_event($eventid)
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

function get_all_sports()
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

function get_registrations_by_userid($user_id)
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

if (isset($_SESSION['profile_update'])) {
  $noti_message = $_SESSION["profile_update"];
}elseif (isset($_SESSION['register_success'])) {
  $noti_message = $_SESSION["register_success"];
}elseif (isset($_SESSION['count-invalid'])) {
  $noti_message = $_SESSION["count-invalid"];
}

$user_data = get_user_by_email($_SESSION['email']);
$events = get_event_by_date($date);
$sports = get_all_sports();
$registrations = get_registrations_by_userid($user_data["id"]);

// var_dump($user);
// var_dump($sports);
//var_dump($events);

//var_dump($registrations);

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title>AUS Sport Club - User Profile</title>
  <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
  <link rel="icon" href="../../dist/img/admin/admin_icon.png" type="image/x-icon" />

  <!-- Fonts and icons -->
  <script src="../../dist/libraries/webfont/js/webfont.min.js"></script>
  <script>
    WebFont.load({
      google: {
        families: ["Public Sans:300,400,500,600,700"]
      },
      custom: {
        families: [
          "Font Awesome 5 Solid",
          "Font Awesome 5 Regular",
          "Font Awesome 5 Brands",
          "simple-line-icons",
        ],
        urls: ["assets/css/fonts.min.css"],
      },
      active: function() {
        sessionStorage.fonts = true;
      },
    });
  </script>

  <!-- CSS Files -->
  <link rel="stylesheet" href="../../dist/libraries/bootstrap-5.0.2/css/bootstrap.min.css" />
  <link rel="stylesheet" href="../../dist/libraries/jquery-ui/jquery-ui.css" />
  <link rel="stylesheet" href="../../dist/libraries/fontawesome-free-6.7.1-web/css/all.min.css" />
  <link rel="stylesheet" href="../css/admin.min.css" />
  <link rel="stylesheet" href="../css/toast.css" />
</head>

<body>
  <div class="container pt-5">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <div class="row">
              <div class="col-md-4">
                <div class="card-title d-flex justify-content-between">
                  <h2>User Profile</h2>
                  <button class="btn btn-warning">
                    <a href="./index.php">Back to Home</a>
                  </button>
                </div>
              </div>
            </div>
          </div>
          <form action="profile.php" method="POST">
            <div class="card-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="name">Name</label>
                    <input type="hidden" name="id" value="<?php echo $user_data['id'] ?>" />
                    <input type="text" class="form-control input-full" name="name" id="name" value="<?php echo $user_data['name'] ?>"
                      placeholder="Enter Your Name" required />
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" class="form-control" name="email" id="email" value="<?php echo $user_data['email'] ?>"
                      placeholder="Enter Your  Email" required />
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="text" class="form-control input-full" name="phone" maxlength="11" id="phone" value="<?php echo $user_data['phonenumber'] ?>"
                      placeholder="Enter Your Phone Number" required />
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label for="dob">Date of Birth</label>
                    <input type="date" name="dob" class="form-control" id="dob" value="<?php echo $user_data['dob'] ?>" required />
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="preferedSport">Prefered Sport</label>
                    <select name="prefer_sport" class="form-select form-control" id="preferedSport" required>
                      <?php if ($user_data['prefersport'] != null) { ?>
                        <?php foreach ($sports as $sport) { ?>
                          <?php if ($sport['id'] == $user_data['prefersport']) { ?>
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
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label for="skillLevel">Skill Level</label>
                    <select name="skill_level" class="form-select form-control" id="skillLevel" required>
                      <?php if ($user_data['skilllevel'] != null) { ?>
                        <?php foreach ($skill_array as $skilllevel) { ?>
                          <?php if ($skilllevel == $user_data['skilllevel']) { ?>
                            <option value="<?php echo $skilllevel ?>" selected><?php echo ucwords($skilllevel) ?></option>
                          <?php } else { ?>
                            <option value="<?php echo $skilllevel ?>"><?php echo ucwords($skilllevel) ?></option>
                          <?php } ?>
                        <?php } ?>
                      <?php } else { ?>
                        <?php foreach ($skill_array as $skilllevel) { ?>
                          <option value="<?php echo $skilllevel ?>"><?php echo ucwords($skilllevel) ?></option>
                        <?php } ?>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </div>
            </div>

            <div class="card-action">
              <button type="submit" name="update_profile" class="btn btn-success">Submit</button>
              <button type="reset" class="btn btn-danger">Cancel</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <div class="row">
              <div class="col-md-12">
                <h2>Your Participation History</h2>
              </div>
            </div>
          </div>

          <div class="card-body">
            <h4 class="text-muted mb-3">
              You have paricipated the following events since you've become
              our member...
            </h4>

            <ul id="historyList">
              <?php foreach ($registrations as $registration) {
                $check_event = get_event($registration['events_id']);
              ?>
                <?php if ($check_event['status'] == "finished") { ?>
                  <li>
                    <h5 class="text-primary"><?php echo ucwords($check_event['name']); ?></h5>
                  </li>
                <?php } ?>
              <?php } ?>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <div class="col-md-12">
              <h2>Register Events</h2>
            </div>
          </div>

          <form action="profile.php" method="POST">
            <div class="card-body">
              <div class="row">
                <div class="col-md-12">
                  <input type="hidden" name="user_id" value="<?php echo $user_data['id'] ?>" />
                  <div class="form-group">
                    <label for="selectedEvent">Select Event</label>
                    <select name="event_id" class="form-select form-control" id="selectedEvent" required>
                      <?php if (isset($_SESSION['event_id'])) { ?>
                        <?php foreach ($events as $event) { ?>
                          <?php if ($event['id'] == $_SESSION['event_id']) { ?>
                            <option value="<?php echo $event['id'] ?>" selected><?php echo ucwords($event['name']) ?></option>
                          <?php } else { ?>
                            <option value="<?php echo $event['id'] ?>"><?php echo ucwords($event['name']) ?></option>
                          <?php } ?>
                        <?php } ?>
                      <?php } else { ?>
                        <option disabled selected>Select an Event</option>
                        <?php foreach ($events as $event) { ?>
                          <option value="<?php echo $event['id'] ?>"><?php echo ucwords($event['name']) ?></option>
                        <?php } ?>
                      <?php } ?>
                    </select>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label for="participantEmail">Participant Count</label>
                    <input type="number" class="form-control" name="count" min="1" max="10"
                      id="participantEmail" placeholder="Enter Participant Count" required />
                  </div>
                </div>
              </div>
            </div>

            <div class="card-action">
              <button type="submit" name="event_register" class="btn btn-info">Register</button>
            </div>
          </form>
        </div>
      </div>

      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <div class="col-md-12">
              <h2>Manage Your Registrations</h2>
            </div>
          </div>

          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <h4 class="text-muted mb-3">
                  You are currently registered for the following events:
                </h4>

                <ul id="eventList">
                  <?php foreach ($registrations as $registration) {
                    $check_event = get_event($registration['events_id']);
                  ?>
                    <?php if ($check_event['status'] == "upcoming") { ?>
                      <li class="d-flex justify-content-between mb-3">
                        <h5 class="text-primary"><?php echo ucwords($check_event['name']) ?></h5>
                        <button class="btn btn-sm btn-danger cancel-btn">
                          <?php echo date("F j, Y", strtotime($registration['date'])) ?>
                        </button>
                      </li>
                    <?php } ?>
                  <?php } ?>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php if ($noti_message != null) { ?>
    <div class="toasts actives">
      <div class="toast-contents">
        <i class="fas <?php if (isset($_SESSION['count-invalid'])) {
                        echo "fa-times bg-danger";
                      } else {
                        echo "fa-check";
                      } ?> check"></i>
        <div class="message">
          <span class="text text-1">
            <?php if (isset($_SESSION['count-invalid'])) {
              echo "Failed";
            } else {
              echo "Success";
            }
            ?>
          </span>
          <span class="text text-2"><?php echo $noti_message ?></span>
        </div>
      </div>
      <i class="fas fa-times closes"></i>

      <div class="progress actives"></div>
    </div>
  <?php
    unset($_SESSION['profile_update']);
    unset($_SESSION['register_success']);
    unset($_SESSION['count-invalid']);
    $noti_message = '';
  }
  ?>

  <!--   Core JS Files   -->
  <script src="../../dist/libraries/jquery/jquery-3.7.1.min.js"></script>
  <script src="../../dist/libraries/bootstrap-5.0.2/js/popper.min.js"></script>
  <script src="../../dist/libraries/bootstrap-5.0.2/js/bootstrap.min.js"></script>

  <!-- jQuery Scrollbar -->
  <script src="../../dist/libraries/jquery-scrollbar/js/jquery.scrollbar.min.js"></script>

  <!-- jQuery Sparkline -->
  <script src="../../dist/libraries/jquery-sparkline/js/jquery.sparkline.min.js"></script>

  <!-- Datatables -->
  <script src="../../dist/libraries/datatables/js/datatables.min.js"></script>

  <!-- Bootstrap Notify -->
  <script src="../../dist/libraries/bootstrap-notify/js/bootstrap-notify.min.js"></script>

  <!-- Sweet Alert -->
  <script src="../../dist/libraries/sweetalert/js/sweetalert.min.js"></script>

  <!-- Kaiadmin JS -->
  <script src="../js/admin.min.js"></script>
  <script src="../js/toast.js"></script>

  <script>
    $(document).ready(function() {
      // Handle cancel button click
      $(".cancel-btn").on("click", function() {
        // Find the parent list item and remove it
        const eventItem = $(this).closest("li");
        const eventName = eventItem.find("h5").text(); // Get event name
        eventItem.remove(); // Remove the event from the list

        // Display a confirmation message
        const message = `You have successfully canceled your registration for "${eventName}".`;
        alert(message);

        // If the list is empty, show a fallback message
        if ($("#eventList").children().length === 0) {
          $("#cancelMessage")
            .removeClass("d-none")
            .text("You have no remaining event registrations.");
        }
      });
    });
  </script>
</body>

</html>
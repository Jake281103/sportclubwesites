<?php

// to show error codes
ini_set("display_errors", 1);

// call dbconnection file to use
require_once("../databaseconnection.php");

// creat session if not created
if (!isset($_SESSION)) {
  session_start();
}

if (!isset($_SESSION['email'])) {
  header("Location:../auth.php");
}

// making default time zone
date_default_timezone_set("Asia/Yangon");

$date = date("Y-m-d");
//echo $date;

$admin = null;
$sports = null;
$events = null;
$update_event = null;
$noti_message = '';


if (isset($_SESSION['email'])) {
  $email = $_SESSION['email'];
  try {
    $conn = connect();
    $sql = "SELECT * FROM admins WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$email]);
    $admin = $stmt->fetch();
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
}

function get_unread_message_count()
{
  try {
    $conn = connect();
    $sql = "SELECT COUNT(*) FROM messages WHERE status = 0";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchColumn();
    $conn = null;
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
}

function get_all_sports()
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

function get_event_by_id($eventid)
{
  try {
    $conn = connect();
    $sql = "SELECT * FROM events WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$eventid]);
    return $stmt->fetch();
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
}

function get_all_event()
{
  try {
    $conn = connect();
    $sql = "SELECT * FROM events";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
    $conn = null;
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['updateeventid'])) {
  $update_event = get_event_by_id($_GET['updateeventid']);
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['deleteeventid'])) {
  $deleteeventid = $_GET['deleteeventid'];
  try {
    $conn = connect();
    $sql = "DELETE FROM events WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$deleteeventid]);
    $_SESSION['event_delete_success'] = "Your event is successfully deleted.";
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
}

if (isset($_SESSION['event_create_success'])) {
  $noti_message = $_SESSION['event_create_success'];
} elseif (isset($_SESSION['event_update_success'])) {
  $noti_message = $_SESSION['event_update_success'];
} elseif (isset($_SESSION['event_delete_success'])) {
  $noti_message = $_SESSION['event_delete_success'];
}

$unread_message_count = get_unread_message_count();

$sports = get_all_sports();
$events = get_all_event();

// var_dump($update_event);




?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title>AUS Sport Club - Admin Dashboard</title>
  <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
  <link rel="icon" href="../../../dist/img/admin/admin_icon.png" type="image/x-icon" />

  <!-- Fonts and icons -->
  <script src="../../../dist/libraries/webfont/js/webfont.min.js"></script>
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
  <link rel="stylesheet" href="../../../dist/libraries/bootstrap-5.0.2/css/bootstrap.min.css" />
  <link rel="stylesheet" href="../../../dist/libraries/jquery-ui/jquery-ui.css" />
  <link rel="stylesheet" href="../../../dist/libraries/fontawesome-free-6.7.1-web/css/all.min.css" />
  <link rel="stylesheet" href="../../css/admin.min.css" />
</head>

<body>
  <div class="wrapper">
    <!-- Sidebar -->
    <div class="sidebar" data-background-color="dark">
      <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">
          <a href="index.php" class="logo">
            <h4 class="text-light">AUS Sport Club</h4>
          </a>
          <div class="nav-toggle">
            <button class="btn btn-toggle toggle-sidebar">
              <i class="gg-menu-right"></i>
            </button>
            <button class="btn btn-toggle sidenav-toggler">
              <i class="gg-menu-left"></i>
            </button>
          </div>
          <button class="topbar-toggler more">
            <i class="gg-more-vertical-alt"></i>
          </button>
        </div>
        <!-- End Logo Header -->
      </div>
      <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
          <ul class="nav nav-secondary">
            <li class="nav-item">
              <a href="./index.php">
                <i class="fas fa-home"></i>
                <p>Dashboard</p>
              </a>
            </li>

            <li class="nav-item active">
              <a href="events.php">
                <i class="fas fa-calendar-alt"></i>
                <p>Events</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="members.php">
                <i class="fas fa-users"></i>
                <p>Members</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="messages.php">
                <i class="fas fa-envelope"></i>
                <p>Messages</p>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <!-- End Sidebar -->

    <div class="main-panel">
      <div class="main-header">
        <div class="main-header-logo">
          <!-- Logo Header -->
          <div class="logo-header" data-background-color="dark">
            <a href="index.php" class="logo">
              <img
                src="assets/img/kaiadmin/logo_light.svg"
                alt="navbar brand"
                class="navbar-brand"
                height="20" />
            </a>
            <div class="nav-toggle">
              <button class="btn btn-toggle toggle-sidebar">
                <i class="gg-menu-right"></i>
              </button>
              <button class="btn btn-toggle sidenav-toggler">
                <i class="gg-menu-left"></i>
              </button>
            </div>
            <button class="topbar-toggler more">
              <i class="gg-more-vertical-alt"></i>
            </button>
          </div>
          <!-- End Logo Header -->
        </div>
        <!-- Navbar Header -->
        <nav
          class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
          <div class="container-fluid">
            <nav
              class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex">
              <div class="input-group">
                <div class="input-group-prepend">
                  <button type="submit" class="btn btn-search pe-1">
                    <i class="fa fa-search search-icon"></i>
                  </button>
                </div>
                <input
                  type="text"
                  placeholder="Search ..."
                  class="form-control" />
              </div>
            </nav>

            <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
              <li
                class="nav-item topbar-icon dropdown hidden-caret d-flex d-lg-none">
                <a
                  class="nav-link dropdown-toggle"
                  data-bs-toggle="dropdown"
                  href="#"
                  role="button"
                  aria-expanded="false"
                  aria-haspopup="true">
                  <i class="fa fa-search"></i>
                </a>
                <ul class="dropdown-menu dropdown-search animated fadeIn">
                  <form class="navbar-left navbar-form nav-search">
                    <div class="input-group">
                      <input
                        type="text"
                        placeholder="Search ..."
                        class="form-control" />
                    </div>
                  </form>
                </ul>
              </li>
              <li class="nav-item topbar-icon dropdown hidden-caret">
                <a
                  class="nav-link"
                  href="messages.php"
                  id="notifDropdown">
                  <i class="fa fa-message"></i>
                  <?php if ($unread_message_count > 0) {
                      echo '<span class="notification">';
                      echo $unread_message_count;
                      echo '</span>';
                    } ?>
                </a>
              </li>

              <li class="nav-item topbar-user dropdown hidden-caret">
                <a
                  class="dropdown-toggle profile-pic"
                  data-bs-toggle="dropdown"
                  href="#"
                  aria-expanded="false">
                  <div class="avatar-sm">

                    <?php if ($admin['profile'] != null) { ?>
                      <img src="../../../<?php echo $admin['profile'] ?>" alt="<?php echo $admin['name'] ?>" class="avatar-img rounded-circle" />
                    <?php } else { ?>
                      <img src="../../../dist/img/admin/profile.jpg" alt="<?php echo $admin['name'] ?>" class="avatar-img rounded-circle" />
                    <?php } ?>

                  </div>
                  <span class="profile-username">
                    <span class="op-7">Hi,</span>
                    <span class="fw-bold"><?php echo ucwords($admin['name']) ?></span>
                  </span>
                </a>
                <ul class="dropdown-menu dropdown-user animated fadeIn">
                  <div class="dropdown-user-scroll scrollbar-outer">
                    <li>
                      <div class="user-box">
                        <div class="avatar-lg">
                          <?php if ($admin['profile'] != null) { ?>
                            <img src="../../../<?php echo $admin['profile'] ?>" alt="<?php echo $admin['name'] ?>" class="avatar-img rounded" />
                          <?php } else { ?>
                            <img src="../../../dist/img/admin/profile.jpg" alt="<?php echo $admin['name'] ?>" class="avatar-img rounded" />
                          <?php } ?>
                        </div>
                        <div class="u-text">
                          <h4><?php echo ucwords($admin['name']) ?></h4>
                          <p class="text-muted"><?php echo $admin['email'] ?></p>
                          <a
                            <?php if ($admin['profile'] != null) { ?>
                            href="../../../<?php echo $admin['profile'] ?>"
                            <?php } else { ?>
                            href="../../../dist/img/admin/profile.jpg"
                            <?php } ?>
                            class="btn btn-xs btn-secondary btn-sm">View Profile</a>
                        </div>
                      </div>
                    </li>
                    <li>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="#">My Profile</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="../exit.php">Logout</a>
                    </li>
                  </div>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
        <!-- End Navbar -->
      </div>

      <div class="container">
        <div class="page-inner">
        <div
            class="page-header d-flex justify-space-between align-items-center">
            <h4 class="page-title">Events Management</h4>

            <!-- Modern Success Alert -->
            <?php if ($noti_message != null) { ?>
              <div
                class="alert alert-success alert-dismissible fade show d-flex align-items-end ms-auto me-3"
                role="alert">
                <i class="fas fa-check-circle fa-2x text-success"></i>
                <div class="alert-content flex-grow-1 mx-4">
                  <?php echo $noti_message ?>
                </div>
                <button
                  type="button"
                  class="btn-close btn-sm mt-2"
                  data-bs-dismiss="alert"
                  aria-label="Close">
                </button>
              </div>
            <?php
              $noti_message = '';
              unset($_SESSION['event_create_success']);
              unset($_SESSION['event_update_success']);
              unset($_SESSION['event_delete_success']);
            } ?>
          </div>
          <div class="page-category">
            <div class="row mb-3">
              <div class="col-md-6">
                <form action="create_event.php" method="POST" class="border border-2 p-3" enctype="multipart/form-data">
                  <h4 class="text-success">Add Upcoming Event</h4>
                  <div class="form-group">
                    <label for="name">Event Name</label>
                    <input type="text" class="form-control" name="event_name" id="name"
                      placeholder="Enter event name..." required />
                  </div>

                  <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" name="event_description" id="description" rows="5" required>
                    </textarea>
                  </div>

                  <div class="form-group">
                    <label for="largeInput">Event Date</label>
                    <input type="date" class="form-control" name="event_date" min="<?php echo $date ?>"
                      id="name" required />
                  </div>

                  <div class="form-group">
                    <label for="time">Event Time</label>
                    <input type="time" class="form-control" name="event_time"
                      id="time" required />
                  </div>

                  <div class="form-group">
                    <label for="largeInput">Event Location</label>
                    <input type="text" class="form-control" name="event_location"
                      id="name" placeholder="Enter event location..." required />
                  </div>

                  <div class="form-group">
                    <label for="largeInput">Registration Due Date</label>
                    <input type="date" class="form-control" name="event_duedate" id="name" min="<?php echo $date ?>" required />
                  </div>

                  <div class="form-group">
                    <label for="largeInput">Participant Limit</label>
                    <input type="number" class="form-control" name="event_limit" min="10"
                      id="name" placeholder="10" required />
                  </div>

                  <div class="form-group">
                    <label for="defaultSelect">Age Group</label>
                    <select class="form-select" id="defaultSelect" name="event_agegroup" required>
                      <option selected disabled>Select age group</option>
                      <option value="child">Child (under 15)</option>
                      <option value="teen">Teen (Between 16 and 23)</option>
                      <option value="adult">Adult (Over 23)</option>
                      <option value="all">No Age Limit</option>
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="exampleFormControlFile1">Event Photo</label>
                    <input type="file" class="form-control-file" name="event_photo" accept="image/png, image/jpeg, image/jpg"
                      id="exampleFormControlFile1" required />
                  </div>

                  <div class="form-group mb-3">
                    <label for="defaultSelect">Sport Type</label>
                    <select class="form-select form-control" id="defaultSelect" name="event_sporttype" required>
                      <option selected disabled>Select sport type</option>
                      <?php foreach ($sports as $sport) {
                        echo '<option value="' . $sport['id'] . '">' . $sport['name'] . '</option>';
                      } ?>
                    </select>
                  </div>

                  <div class="card-action">
                    <button type="submit" name="create_event" class="btn btn-success">Add Event</button>
                    <button type="reset" class="btn btn-secondary">Cancel</button>
                  </div>
                </form>
              </div>

              <div class="col-md-6">
                <form action="update_event.php" method="POST" class="border border-2 p-3">
                  <h4 class="text-primary">Update Event Info</h4>
                  <?php if (isset($_GET['updateeventid'])) { ?>
                    <input type="hidden" name="event_id"
                      value="<?php echo $_GET['updateeventid'] ?>" />
                  <?php } ?>
                  <div class="form-group">
                    <label for="largeInput">Event Name</label>
                    <?php if (isset($_GET['updateeventid'])) { ?>
                      <input type="text" class="form-control" name="event_name" id="name" value="<?php echo $update_event['name'] ?>"
                        placeholder="Enter event name..." required/>
                    <?php } else { ?>
                      <input type="text" class="form-control" name="event_name" id="name"
                        placeholder="Enter event name..." required/>
                    <?php } ?>
                  </div>

                  <div class="form-group">
                    <label for="description">Description</label>
                    <?php if (isset($_GET['updateeventid'])) { ?>
                      <textarea class="form-control" name="event_description" id="comment" rows="5" required>
                        <?php echo $update_event['description'] ?>
                      </textarea>
                    <?php } else { ?>
                      <textarea class="form-control" name="event_description" id="comment" rows="5" required>
                      </textarea>
                    <?php } ?>
                  </div>

                  <div class="form-group">
                    <label for="largeInput">Event Date</label>
                    <?php if (isset($_GET['updateeventid'])) { ?>
                      <input type="date" class="form-control" name="event_date" min="<?php echo $date ?>" value="<?php echo $update_event['date'] ?>"
                        id="name" required/>
                    <?php } else { ?>
                      <input type="date" class="form-control" name="event_date"
                        id="name" required/>
                    <?php } ?>
                  </div>

                  <div class="form-group">
                    <label for="largeInput">Event Time</label>
                    <?php if (isset($_GET['updateeventid'])) { ?>
                      <input type="time" class="form-control" name="event_time" value="<?php echo $update_event['time'] ?>"
                        id="name" required />
                    <?php } else { ?>
                      <input type="time" class="form-control" name="event_time"
                        id="name" required/>
                    <?php } ?>
                  </div>

                  <div class="form-group">
                    <label for="largeInput">Event Location</label>
                    <?php if (isset($_GET['updateeventid'])) { ?>
                      <input type="text" class="form-control" name="event_location" value="<?php echo $update_event['location'] ?>"
                        id="name" placeholder="Enter event location..." required/>
                    <?php } else { ?>
                      <input type="text" class="form-control" name="event_location"
                        id="name" placeholder="Enter event location..." required/>
                    <?php } ?>
                  </div>

                  <div class="form-group">
                    <label for="largeInput">Registration Due Date</label>
                    <?php if (isset($_GET['updateeventid'])) { ?>
                      <input type="date" class="form-control" name="event_duedate" id="name" min="<?php echo $date ?>" value="<?php echo $update_event['duedate'] ?>" required />
                    <?php } else { ?>
                      <input type="date" class="form-control" name="event_duedate" id="name" required />
                    <?php } ?>
                  </div>

                  <div class="form-group">
                    <label for="largeInput">Participant Limit</label>
                    <?php if (isset($_GET['updateeventid'])) { ?>
                      <input type="number" min="10" class="form-control" name="event_limit" value="<?php echo $update_event['participantslimit'] ?>"
                        id="name" placeholder="10" required />
                    <?php } else { ?>
                      <input type="number" min="10" class="form-control" name="event_limit"
                        id="name" placeholder="10" required />
                    <?php } ?>
                  </div>

                  <div class="form-group">
                    <label for="defaultSelect">Age Group</label>
                    <?php if (isset($_GET['updateeventid'])) { ?>
                      <select class="form-select" id="defaultSelect" name="event_agegroup" required>
                        <?php
                        switch ($update_event['agegroup']) {
                          case "child":
                            echo '<option value="child" selected>Child (under 15)</option>';
                            echo '<option value="teen">Teen (Between 16 and 23)</option>';
                            echo '<option value="adult">Adult (Over 23)</option>';
                            echo '<option value="all">No Age Limit</option>';
                            break;
                          case "teen":
                            echo '<option value="child">Child (under 15)</option>';
                            echo '<option value="teen" selected>Teen (Between 16 and 23)</option>';
                            echo '<option value="adult">Adult (Over 23)</option>';
                            echo '<option value="all">No Age Limit</option>';
                            break;
                          case "adult":
                            echo '<option value="child">Child (under 15)</option>';
                            echo '<option value="teen">Teen (Between 16 and 23)</option>';
                            echo '<option value="adult" selected>Adult (Over 23)</option>';
                            echo '<option value="all">No Age Limit</option>';
                            break;
                          case "all":
                            echo '<option value="child">Child (under 15)</option>';
                            echo '<option value="teen">Teen (Between 16 and 23)</option>';
                            echo '<option value="adult">Adult (Over 23)</option>';
                            echo '<option value="all" selected>No Age Limit</option>';
                            break;
                        }
                        ?>
                      </select>
                    <?php } else { ?>
                      <select name="event_agegroup" id="defaultSelect" class="form-select"
                        required>
                        <option selected disabled>Please select</option>
                        <option value="child">Child (under 15)</option>
                        <option value="teen">Teen (Between 16 and 23)</option>
                        <option value="adult">Adult (Over 23)</option>
                        <option value="all">No Age Limit</option>
                      </select>
                    <?php } ?>
                  </div>

                  <div class="form-group mb-3">
                    <label for="defaultSelect">Sport Type</label>
                    <?php if (isset($_GET['updateeventid'])) { ?>
                      <select class="form-select" id="defaultSelect" name="event_sporttype" required>
                        <?php foreach ($sports as $sport) {
                          if ($update_event['sports_id'] == $sport['id']) {
                            echo '<option selected value="' . $sport['id'] . '">' . $sport['name'] . '</option>';
                          } else {
                            echo '<option value="' . $sport['id'] . '">' . $sport['name'] . '</option>';
                          }
                        } ?>
                      </select>
                    <?php } else { ?>
                      <select class="form-select" id="defaultSelect" name="event_sporttype" required>
                        <option selected disabled>Select sport type</option>
                        <?php foreach ($sports as $sport) {
                          echo '<option value="' . $sport['id'] . '">' . $sport['name'] . '</option>';
                        } ?>
                      </select>
                    <?php } ?>
                  </div>

                  <div class="card-action">
                    <button type="submit" name="update_event" class="btn btn-primary">Update Event</button>
                    <button type="reset" class="btn btn-secondary">Cancel</button>
                  </div>
                </form>
              </div>
            </div>

            <div class="row">
              <div class="card-body">
                <table class="table table-bordered table-hover table-head-bg-warning">
                  <thead>
                    <tr>
                      <th scope="col">Name</th>
                      <th scope="col">Date</th>
                      <th scope="col">Limit</th>
                      <th scope="col">Remain Limit</th>
                      <th scope="col">Age</th>
                      <th scope="col">Sport</th>
                      <th scope="col">Due Date</th>
                      <th scope="col">Action</th>
                    </tr>
                  </thead>

                  <tbody>
                    <?php
                    foreach ($events as $event) {
                      echo '<tr>';
                      echo '<td>' . ucwords($event['name']) . '</td>';
                      echo '<td>' . date("F j, Y", strtotime($event['date'])) . ' ' . $event['time'] . '</td>';
                      echo '<td>' . $event['participantslimit'] . '</td>';
                      echo '<td>' . $event['remainlimit'] . '</td>';
                      echo '<td>' . ucwords($event['agegroup']) . '</td>';
                      foreach ($sports as $sport) {
                        if ($event['sports_id'] == $sport['id']) {
                          echo '<td>' . ucwords($sport['name']) . '</td>';
                        }
                      }
                      echo '<td>' . date("F j, Y", strtotime($event['duedate'])) . '</td>';
                      echo '<td>
                                    <a href="events.php?updateeventid=' . $event['id'] . '">
                                      <i class="fa-regular fa-pen-to-square text-info me-4"></i>
                                    </a>
                                    <a href="events.php?deleteeventid=' . $event['id'] . '">
                                      <i class="fa-solid fa-trash text-danger"></i>
                                    </a>
                            </td>';
                      echo '</tr>';
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>

      <footer class="footer">
        <div class="container-fluid d-flex justify-content-between">
          <div class="copyright">
            2024, made with <i class="fa fa-heart heart text-danger"></i> by
            <a href="javascript:void(0);">AUS Sport Club</a>
          </div>
          <div>
            Distributed by
            <a target="_blank" href="javascript:void(0);">AUS Sport Club</a>.
          </div>
        </div>
      </footer>
    </div>
  </div>
  <!--   Core JS Files   -->
  <script src="../../../dist/libraries/jquery/jquery-3.7.1.min.js"></script>
  <script src="../../../dist/libraries/bootstrap-5.0.2/js/popper.min.js"></script>
  <script src="../../../dist/libraries/bootstrap-5.0.2/js/bootstrap.min.js"></script>

  <!-- jQuery Scrollbar -->
  <script src="../../../dist/libraries/jquery-scrollbar/js/jquery.scrollbar.min.js"></script>

  <!-- Chart JS -->
  <script src="../../../dist/libraries/chart.js/js/chart.min.js"></script>

  <!-- jQuery Sparkline -->
  <script src="../../../dist/libraries/jquery-sparkline/js/jquery.sparkline.min.js"></script>

  <!-- Chart Circle -->
  <script src="../../../dist/libraries/chart-circle/js/circles.min.js"></script>

  <!-- Datatables -->
  <script src="../../../dist/libraries/datatables/js/datatables.min.js"></script>

  <!-- Bootstrap Notify -->
  <script src="../../../dist/libraries/bootstrap-notify/js/bootstrap-notify.min.js"></script>

  <!-- Sweet Alert -->
  <script src="../../../dist/libraries/sweetalert/js/sweetalert.min.js"></script>

  <!-- Kaiadmin JS -->
  <script src="../../js/admin.min.js"></script>
</body>

</html>
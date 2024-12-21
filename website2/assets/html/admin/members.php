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

$admin = null;
$noti_message = '';
$registrations = null;



if (isset($_SESSION['login_success'])) {
  $noti_message = $_SESSION['login_success'];
}

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

function get_all_users()
{
  try {
    $conn = connect();
    $sql = "SELECT * FROM users";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
}

function get_registrations($userid)
{
  try {
    $conn = connect();

    $sql = "SELECT * FROM eventregistrations     WHERE users_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$userid]);
    return $stmt->fetchAll();
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
}

function get_eventname($id)
{
  try {
    $conn = connect();
    $sql = "SELECT name FROM events WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);
    return $stmt->fetch();
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
}

$unread_message_count = get_unread_message_count();
$users = get_all_users();

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["userid"])) {
  $userid = $_GET["userid"];
  $registrations = get_registrations($userid);
}





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
              <a href="index.php">
                <i class="fas fa-home"></i>
                <p>Dashboard</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="events.php">
                <i class="fas fa-calendar-alt"></i>
                <p>Events</p>
              </a>
            </li>

            <li class="nav-item active">
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
          <div class="page-header">
            <h4 class="page-title fw-bold">Members Management</h4>
          </div>
          <div class="page-category">
            <div class="row mb-5">
              <div class="card-title text-danger">
                Users Data <i class="fa-solid fa-user-secret"></i>
              </div>
              <div class="card-body">
                <table class="table table-bordered table-hover table-head-bg-warning">
                  <thead>
                    <tr>
                      <th scope="col">No</th>
                      <th scope="col">Name</th>
                      <th scope="col">Role</th>
                      <th scope="col">Status</th>
                      <th scope="col">Features</th>
                    </tr>
                  </thead>

                  <tbody>
                    <?php foreach ($users as $user) { ?>
                      <tr>
                        <td><?php echo $user['id'] ?></td>
                        <td>
                          <p><?php echo $user['name'] ?></p>
                          <h6 class="text-muted"><?php echo $user['email'] ?></h6>
                        </td>
                        <td>
                          <button class="btn btn-disabled btn-danger">
                            Member
                          </button>
                        </td>
                        <td>
                          <div class="form-check form-switch">
                            <?php if ($user['status']) { ?>
                              <input class="form-check-input" type="checkbox" id="onOffSwitch"
                                checked />
                              <label class="form-check-label" for="onOffSwitch">On</label>
                            <?php } else { ?>
                              <input class="form-check-input" type="checkbox" id="onOffSwitch" />
                              <label class="form-check-label" for="onOffSwitch">Off</label>
                            <?php } ?>
                          </div>
                        </td>
                        <td>
                          <div class="btn-group dropdown">
                            <button class="btn btn-primary dropdown-toggle" type="button"
                              data-bs-toggle="dropdown">
                              Select Features
                            </button>
                            <ul class="dropdown-menu" role="menu">
                              <li>
                                <a class="dropdown-item" href="members.php?userid=<?php echo $user['id'] ?>">View Registration</a>
                              </li>
                            </ul>
                          </div>
                        </td>
                      </tr>
                    <?php } ?>

                  </tbody>
                </table>
              </div>
            </div>

            <div class="row mb-5">
              <div class="card-body">
                <?php if ($registrations != null && isset($_GET['userid'])) { ?>
                  <!-- DATA TABLE-->
                  <table class="table table-bordered table-hover table-head-bg-success">
                    <thead>
                      <tr>
                        <th scope="col">Registered ID</th>
                        <th scope="col">Event Name</th>
                        <th scope="col">Date</th>
                      </tr>
                    </thead>

                    <tbody>
                      <?php foreach ($registrations as $registration) { ?>
                        <tr>
                          <td><?php echo $registration['id'] ?></td>
                          <td><?php echo ucwords(get_eventname($registration['events_id'])['name']) ?></td>
                          <td><?php echo $registration['date'] ?></td>
                        </tr>
                      <?php } ?>

                    </tbody>
                  </table>
                  <!-- END DATA TABLE-->
                <?php } elseif ($registrations == null && isset($_GET['userid'])) { ?>
                  <!-- DATA TABLE-->
                    <table class="table table-bordered table-hover table-head-bg-success">
                      <thead>
                        <tr>
                          <th>Register ID</th>
                          <th>Evnent Name</th>
                          <th>Date</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td colspan="3" class="text-center py-5">The registered event is not found </td>
                        </tr>
                      </tbody>
                    </table>
                  <!-- END DATA TABLE-->
                <?php } ?>
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

  <script>
    document
      .getElementById("onOffSwitch")
      .addEventListener("change", function() {
        const label = document.querySelector("label[for='onOffSwitch']");
        label.textContent = this.checked ? "On" : "Off";
      });
  </script>

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
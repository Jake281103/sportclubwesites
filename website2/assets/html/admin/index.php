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

function totalmessagecount()
{
  try {
    $conn = connect();
    $sql = "SELECT COUNT(*) FROM messages";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchColumn();
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
}

function totalevents()
{
  try {
    $conn = connect();
    $sql = "SELECT COUNT(*) FROM events";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchColumn();
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
}

function totalmembers()
{
  try {
    $conn = connect();
    $sql = "SELECT COUNT(*) FROM users";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchColumn();
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

$total_events = totalevents();
$total_members = totalmembers();
$total_messages = totalmessagecount();
$unread_message_count = get_unread_message_count();

//echo $totalevents;
//echo $totalmembers;
//echo $totalmessages;



?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title>AUS Sport Club - Admin Dashboard</title>
  <meta
    content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
    name="viewport" />
  <link
    rel="icon"
    href="../../../dist/img/admin/admin_icon.png"
    type="image/x-icon" />

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
  <link
    rel="stylesheet"
    href="../../../dist/libraries/bootstrap-5.0.2/css/bootstrap.min.css" />
  <link
    rel="stylesheet"
    href="../../../dist/libraries/jquery-ui/jquery-ui.css" />
  <link
    rel="stylesheet"
    href="../../../dist/libraries/fontawesome-free-6.7.1-web/css/all.min.css" />
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
            <li class="nav-item active">
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
            <h4 class="page-title">Dashboard</h4>

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
              unset($_SESSION['login_success']);
            } ?>
          </div>
          <div class="page-category">
            <div class="row">
              <div class="col-sm-6 col-md-4">
                <div class="card card-stats card-round">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-icon">
                        <div
                          class="icon-big text-center icon-primary bubble-shadow-small">
                          <i class="fas fa-id-card"></i>
                        </div>
                      </div>
                      <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                          <p class="card-category">Members</p>
                          <h4 class="card-title"><?php echo $total_members ?> </h4>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-sm-6 col-md-4">
                <div class="card card-stats card-round">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-icon">
                        <div
                          class="icon-big text-center icon-info bubble-shadow-small">
                          <i class="fas fa-calendar-check"></i>
                        </div>
                      </div>
                      <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                          <p class="card-category">Events</p>
                          <h4 class="card-title"><?php echo $total_events ?></h4>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-sm-6 col-md-4">
                <div class="card card-stats card-round">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-icon">
                        <div
                          class="icon-big text-center icon-success bubble-shadow-small">
                          <i class="fas fa-comment-dots"></i>
                        </div>
                      </div>
                      <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                          <p class="card-category">Messages</p>
                          <h4 class="card-title"><?php echo $total_messages ?></h4>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="card">
                  <div class="card-header">
                    <div class="card-title">Events Bar Chart</div>
                  </div>
                  <div class="card-body">
                    <div class="chart-container">
                      <canvas id="multipleBarChart"></canvas>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="card">
                  <div class="card-header">
                    <div class="card-title">Members Pie Chart</div>
                  </div>
                  <div class="card-body">
                    <div class="chart-container">
                      <canvas
                        id="pieChart"
                        style="width: 50%; height: 50%"></canvas>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <div class="card-title">Line Chart</div>
                  </div>
                  <div class="card-body">
                    <div class="chart-container">
                      <canvas id="lineChart"></canvas>
                    </div>
                  </div>
                </div>
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
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      var ctx = document.getElementById("pieChart").getContext("2d");

      // Create the Pie chart
      var pieChart = new Chart(ctx, {
        type: "pie",
        data: {
          labels: ["Adults", "Teenagers", "Kids"],
          datasets: [{
            label: "Event Registrations",
            data: [45, 35, 20],
            backgroundColor: ["#ffc107", "#33FF57", "#3357FF"],
            borderColor: ["#fff", "#fff", "#fff"],
            borderWidth: 1,
          }, ],
        },
        options: {
          responsive: true,
          plugins: {
            legend: {
              position: "top",
            },
            tooltip: {
              callbacks: {
                label: function(tooltipItem) {
                  return tooltipItem.label + ": " + tooltipItem.raw + "%";
                },
              },
            },
          },
        },
      });

      var ctx = document.getElementById("multipleBarChart").getContext("2d");

      // Create the Multiple Bar Chart
      var multipleBarChart = new Chart(ctx, {
        type: "bar",
        data: {
          labels: ["Event 1", "Event 2", "Event 3", "Event 4"],
          datasets: [{
              label: "January",
              data: [150, 200, 120, 180],
              backgroundColor: "#007bff",
              borderColor: "#0056b3",
              borderWidth: 1,
            },
            {
              label: "February",
              data: [180, 220, 140, 210],
              backgroundColor: "#28a745",
              borderColor: "#1c7430",
              borderWidth: 1,
            },
            {
              label: "March",
              data: [200, 250, 170, 230],
              backgroundColor: "#ffc107",
              borderColor: "#e0a800",
              borderWidth: 1,
            },
          ],
        },
        options: {
          responsive: true,
          scales: {
            y: {
              beginAtZero: true,
            },
          },
          plugins: {
            legend: {
              position: "top",
            },
          },
        },
      });

      var ctx = document.getElementById("lineChart").getContext("2d");

      // Create the Line Chart
      var lineChart = new Chart(ctx, {
        type: "line",
        data: {
          labels: ["January", "February", "March", "April", "May", "June"],
          datasets: [{
            label: "Contacted Messages",
            data: [20, 50, 80, 40, 100, 70],
            fill: false,
            borderColor: "#007bff",
            borderWidth: 2,
            tension: 0.4,
            pointRadius: 5,
            pointBackgroundColor: "#007bff",
          }, ],
        },
        options: {
          responsive: true,
          scales: {
            y: {
              beginAtZero: true,
            },
          },
          plugins: {
            legend: {
              display: false,
            },
            tooltip: {
              mode: "index",
              intersect: false,
            },
          },
        },
      });
    });
  </script>

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
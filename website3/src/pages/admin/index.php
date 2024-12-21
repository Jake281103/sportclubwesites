<?php

// to show error codes
ini_set("display_errors", 1);

// call dbconnection file to use
require_once "../dbconnect.php";

// to create session if not exist
if (!isset($_SESSION)) {
  session_start();
}

if (!isset($_SESSION['email'])) {
  header("Location:../login.php");
}

$toastmessage = "";

function totalcountofmessages()
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

function totalcountofevents()
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

function totalcountofmembers()
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

if (isset($_SESSION['login-success'])) {
  $toastmessage = $_SESSION['login-success'];
}


$totalevents = totalcountofevents();
$totalmembers = totalcountofmembers();
$totalmessages = totalcountofmessages();

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta
    name="viewport"
    content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <title>Dashboard - AUS Admin</title>

  <!-- sweetalert css link -->
  <link
    rel="stylesheet"
    href="../../../public/libs/sweetalert/sweetalert2.min.css" />

  <!-- Custom css link -->
  <link href="../../css/admin.css" rel="stylesheet" />
  <link href="../../css/toast.css" rel="stylesheet" />
</head>

<body class="sb-nav-fixed">

  <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <!-- Navbar Brand-->
    <a class="navbar-brand ps-3" href="index.php">AUS Sport Club Admin</a>
    <!-- Sidebar Toggle-->
    <button
      class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0"
      id="sidebarToggle"
      href="#!">
      <i class="fas fa-bars"></i>
    </button>
    <!-- Navbar Search-->
    <form
      class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
      <div class="input-group">
        <input
          class="form-control"
          type="text"
          placeholder="Search for..."
          aria-label="Search for..."
          aria-describedby="btnNavbarSearch" />
        <button class="btn btn-primary" id="btnNavbarSearch" type="button">
          <i class="fas fa-search"></i>
        </button>
      </div>
    </form>
    <!-- Navbar-->
    <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
      <li class="nav-item dropdown">
        <a
          class="nav-link dropdown-toggle"
          id="navbarDropdown"
          href="#"
          role="button"
          data-bs-toggle="dropdown"
          aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
        <ul
          class="dropdown-menu dropdown-menu-end"
          aria-labelledby="navbarDropdown">
          <li><a class="dropdown-item" href="#">Settings</a></li>
          <li>
            <hr class="dropdown-divider" />
          </li>
          <li><a class="dropdown-item" href="../logoutfunction.php">Logout</a></li>
        </ul>
      </li>
    </ul>
  </nav>

  <div id="layoutSidenav">
    <div id="layoutSidenav_nav">
      <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
          <div class="nav">
            <a class="nav-link active" href="index.php">
              <div class="sb-nav-link-icon">
                <i class="fa-solid fa-chart-line"></i>
              </div>
              Dashboard
            </a>

            <a class="nav-link" href="events.php">
              <div class="sb-nav-link-icon">
                <i class="fa-solid fa-calendar-check"></i>
              </div>
              Events
            </a>

            <a class="nav-link" href="members.php">
              <div class="sb-nav-link-icon">
                <i class="fa-solid fa-users"></i>
              </div>
              Members
            </a>

            <a class="nav-link" href="messages.php">
              <div class="sb-nav-link-icon">
                <i class="fa-regular fa-comments"></i>
              </div>
              Message
            </a>
          </div>
        </div>
      </nav>
    </div>
    <div id="layoutSidenav_content">
      <main>
        <div class="container-fluid px-4">
          <h1 class="mt-4">Dashboard</h1>

          <!-- graphs section -->
          <div class="row">
            <div class="col-xl-4 col-md-12">
              <div class="card bg-danger text-white mb-4">
                <div
                  class="card-body d-flex align-items-center justify-content-center">
                  <span class="h2">Total Events</span>
                </div>
                <div
                  class="card-footer d-flex align-items-center justify-content-center">
                  <span class="h1 me-3"><?php echo $totalevents ?></span>
                  <i class="fa-regular fa-calendar-days h4"></i>
                </div>
              </div>
            </div>

            <div class="col-xl-4 col-md-12">
              <div class="card bg-success text-white mb-4">
                <div
                  class="card-body d-flex align-items-center justify-content-center">
                  <span class="h2">Total Members</span>
                </div>
                <div
                  class="card-footer d-flex align-items-center justify-content-center">
                  <span class="h1 me-3"><?php echo $totalmembers ?></span>
                  <i class="fa-solid fa-user-plus h4"></i>
                </div>
              </div>
            </div>

            <div class="col-xl-4 col-md-12">
              <div class="card bg-primary text-white mb-4">
                <div
                  class="card-body d-flex align-items-center justify-content-center">
                  <span class="h2">Total Messages</span>
                </div>
                <div
                  class="card-footer d-flex align-items-center justify-content-center">
                  <span class="h1 me-3"><?php echo $totalmessages ?></span>
                  <i class="fa-regular fa-message h4"></i>
                </div>
              </div>
            </div>
          </div>

          <!-- content section -->
          <div class="row">
            <div class="card mb-4">
              <div class="card-header">
                <i class="fas fa-chart-area me-1"></i>
                Total Events Chart
              </div>
              <div class="card-body">
                <canvas id="myAreaChart" width="100%" height="30"></canvas>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-6">
              <div class="card mb-4">
                <div class="card-header">
                  <i class="fas fa-chart-pie me-1"></i>
                  Members Age Chart
                </div>
                <div class="card-body">
                  <canvas id="myPieChart" width="100%" height="50"></canvas>
                </div>
              </div>
            </div>

            <div class="col-lg-6">
              <div class="card mb-4">
                <div class="card-header">
                  <i class="fas fa-chart-bar me-1"></i>
                  Contact Messages Chart
                </div>
                <div class="card-body">
                  <canvas id="myBarChart" width="100%" height="50"></canvas>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>

      <!-- footer section -->
      <footer class="py-4 bg-light mt-auto">
        <div class="container-fluid px-4">
          <div
            class="d-flex align-items-center justify-content-between small">
            <div class="text-muted">Copyright &copy; AUS Sport Club 2024</div>
            <div>
              <a href="#">Privacy Policy</a>
              &middot;
              <a href="#">Terms &amp; Conditions</a>
            </div>
          </div>
        </div>
      </footer>
    </div>
  </div>

  <?php if ($toastmessage != null) { ?>
    <div class="toasts actives">
      <div class="toast-contents">
        <i class="fas fa-check check"></i>

        <div class="message">
          <span class="text text-1">Success</span>
          <span class="text text-2"><?php echo $toastmessage ?></span>
        </div>
      </div>
      <i class="fas fa-times closes"></i>

      <div class="progress actives"></div>
    </div>
  <?php
    unset($_SESSION['login-success']);
    $toastmessage = '';
  }
  ?>

  <!-- bootstrap js link -->
  <script src="../../../public/libs/bootstrap-5/js/bootstrap.bundle.min.js"></script>

  <!-- fontawesome js link -->
  <script src="../../../public/libs/fontawesome-6/js/all.min.js"></script>

  <!-- chart.js link -->
  <script src="../../../public/libs/chart.js/js/chart.min.js"></script>

  <!-- ********** 
    chart.js data insertation here 
    ********** -->
  <script>
    // Wait for the DOM to load
    document.addEventListener("DOMContentLoaded", function() {
      // ---------- Total Events Start ----------
      // Get the canvas element
      const tec = document.getElementById("myAreaChart").getContext("2d");

      // Create the chart
      new Chart(tec, {
        type: "line", // Specify the chart type (e.g., 'line', 'bar', etc.)
        data: {
          labels: ["January", "February", "March", "April", "May", "June"], // Labels for the X-axis
          datasets: [{
            label: "Total Events", // Label for the dataset
            data: [10, 20, 15, 25, 30, 40], // Data points for the chart
            backgroundColor: "rgba(78, 115, 223, 0.2)", // Background color for the chart area
            borderColor: "rgba(78, 115, 223, 1)", // Line color
            borderWidth: 2, // Line thickness
          }, ],
        },
        options: {
          responsive: true,
          plugins: {
            legend: {
              display: true,
              position: "top",
            },
            tooltip: {
              enabled: true,
            },
          },
          scales: {
            x: {
              grid: {
                display: false,
              },
            },
            y: {
              beginAtZero: true,
            },
          },
        },
      });
      // ---------- Total Events End ----------

      // ---------- Members Age Start ----------
      // Get the canvas element
      const mac = document.getElementById("myPieChart").getContext("2d");

      // Create the Pie Chart
      new Chart(mac, {
        type: "pie", // Specify the chart type as 'pie'
        data: {
          labels: ["18-24", "25-34", "35-44", "45+"], // Age group labels
          datasets: [{
            data: [30, 50, 20, 10], // Number of members in each age group
            backgroundColor: [
              "rgba(78, 115, 223, 0.8)", // Blue
              "rgba(28, 200, 138, 0.8)", // Green
              "rgba(54, 185, 204, 0.8)", // Teal
              "rgba(246, 194, 62, 0.8)", // Yellow
            ],
            hoverBackgroundColor: [
              "rgba(78, 115, 223, 1)",
              "rgba(28, 200, 138, 1)",
              "rgba(54, 185, 204, 1)",
              "rgba(246, 194, 62, 1)",
            ],
            borderColor: "#fff", // Border color for segments
            borderWidth: 1,
          }, ],
        },
        options: {
          plugins: {
            legend: {
              position: "top", // Position of the legend (top, bottom, left, right)
            },
            tooltip: {
              enabled: true, // Enable tooltips
            },
          },
        },
      });
      // ---------- Members Age End ----------

      // ---------- Contact Messages Start ----------
      // Get the canvas element
      const cmc = document.getElementById("myBarChart").getContext("2d");

      // Create the Bar Chart
      new Chart(cmc, {
        type: "bar", // Specify the chart type as 'bar'
        data: {
          labels: ["January", "February", "March", "April", "May"], // Months
          datasets: [{
            label: "Messages Received", // Label for the dataset
            data: [50, 70, 40, 90, 60], // Data points (messages count)
            backgroundColor: [
              "rgba(78, 115, 223, 0.8)", // Blue
              "rgba(28, 200, 138, 0.8)", // Green
              "rgba(54, 185, 204, 0.8)", // Teal
              "rgba(246, 194, 62, 0.8)", // Yellow
              "rgba(231, 74, 59, 0.8)", // Red
            ],
            hoverBackgroundColor: [
              "rgba(78, 115, 223, 1)",
              "rgba(28, 200, 138, 1)",
              "rgba(54, 185, 204, 1)",
              "rgba(246, 194, 62, 1)",
              "rgba(231, 74, 59, 1)",
            ],
            borderColor: "#fff", // Border color for bars
            borderWidth: 1,
          }, ],
        },
        options: {
          plugins: {
            legend: {
              display: true, // Display the dataset label
              position: "top", // Legend position (top, bottom, etc.)
            },
            tooltip: {
              enabled: true, // Enable tooltips
            },
          },
          scales: {
            x: {
              grid: {
                display: false, // Remove gridlines for X-axis
              },
            },
            y: {
              beginAtZero: true, // Start Y-axis at zero
              ticks: {
                stepSize: 20, // Increment steps on Y-axis
              },
            },
          },
        },
      });
      // ---------- Contact Messages End ----------
    });
  </script>

  <!-- sweetalert js link -->
  <script src="../../../public/libs/sweetalert/sweetalert2.all.min.js"></script>

  <!-- datatables js link -->
  <script src="../../../public/libs/datatables/js/datatables.min.js"></script>

  <!-- custom js link -->
  <script src="../../js/admin.js"></script>
  <script src="../../js/toast.js" type="text/javascript"></script>
</body>

</html>
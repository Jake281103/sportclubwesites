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

$registrations = null;

function allmembers()
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

function registraionbyid($userid)
{
  try {
    $conn = connect();

    $sql = "SELECT * FROM eventregistrations WHERE users_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$userid]);
    return $stmt->fetchAll();
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
}

function eventname($id)
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

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["memberid"])) {
  $memberid = $_GET["memberid"];
  $registrations = registraionbyid($memberid);
}

$members = allmembers();

// var_dump($registrations);


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
  <!-- datatable css link -->
  <link
    rel="stylesheet"
    href="../../../public/libs/datatables/css/datatables.min.css" />

  <!-- sweetalert css link -->
  <link
    rel="stylesheet"
    href="../../../public/libs/sweetalert/sweetalert2.min.css" />

  <!-- Custom css link -->
  <link href="../../css/admin.css" rel="stylesheet" />
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
    <!-- Sidebar Menu -->
    <div id="layoutSidenav_nav">
      <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
          <div class="nav">
            <a class="nav-link" href="index.php">
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

            <a class="nav-link active" href="members.php">
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

    <!-- Main Content -->
    <div id="layoutSidenav_content">
      <main>
        <div class="container-fluid px-4">
          <h1 class="my-4">Members Management</h1>

          <div class="row mb-5">
            <div class="card-body">
              <table
                id="usersTable"
                class="table table-bordered table-hover table-head-bg-warning">
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
                  <?php foreach ($members as $member) { ?>
                    <tr>
                      <td><?php echo $member['id'] ?></td>
                      <td>
                        <p><?php echo ucwords($member['name']) ?></p>
                        <h6 class="text-muted"><?php echo $member['email'] ?></h6>
                      </td>
                      <td>
                        <button class="btn btn-warning btn-sm" disabled>
                          Member
                        </button>
                      </td>
                      <td>
                        <div class="form-check form-switch">
                          <?php if ($member['status']) { ?>
                            <input class="form-check-input user-toggle" type="checkbox" id="userStatus1" checked />
                            <label class="form-check-label" for="userStatus1">On</label>
                          <?php } else { ?>
                            <input class="form-check-input user-toggle" type="checkbox" id="userStatus1" />
                            <label class="form-check-label" for="userStatus1">Off</label>
                          <?php } ?>
                        </div>
                      </td>
                      <td>
                        <div class="btn-group">
                          <button
                            class="btn btn-primary btn-sm dropdown-toggle"
                            type="button"
                            data-bs-toggle="dropdown">
                            Select Features
                          </button>
                          <ul class="dropdown-menu">
                            <li>
                              <a class="dropdown-item" href="members.php?memberid=<?php echo $member['id'] ?>">View Registration</a>
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

          <hr class="h1" />

          <!-- Members Datas Table -->
          <h2 class="my-3 text-center text-danger h2">Members Data</h2>
          <div class="row mb-5">
            <div class="card-body">
              <?php if ($registrations != null && isset($_GET['memberid'])) { ?>
                <table id="membersTable" class="table table-bordered table-hover table-head-bg-success">
                  <thead>
                    <tr>
                      <th scope="col">Registered ID</th>
                      <th scope="col">Event Name</th>
                      <th scope="col">Date</th>
                      <th scope="col">Participants Count</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($registrations as $registration) { ?>
                      <tr>
                        <td><?php echo $registration['id'] ?></td>
                        <td>
                          <p><?php echo ucwords(eventname($registration['events_id'])['name']) ?></p>
                        </td>
                        <td><?php echo date('j-F-y', strtotime($registration['date'])) ?></td>
                        <td><?php echo $registration['count'] ?></td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              <?php } elseif ($registrations == null && isset($_GET['memberid'])) { ?>
                <table id="membersTable" class="table table-bordered table-hover table-head-bg-success">
                  <thead>
                    <tr>
                      <th scope="col">Registered ID</th>
                      <th scope="col">Event Name</th>
                      <th scope="col">Date</th>
                      <th scope="col">Participants Count</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td colspan="4" class="text-center py-5">The registered event is not found </td>
                    </tr>
                  </tbody>
                </table>
              <?php } ?>
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

  <!-- bootstrap js link -->
  <script src="../../../public/libs/bootstrap-5/js/bootstrap.bundle.min.js"></script>

  <!-- jquery js link -->
  <script src="../../../public/libs/jquery/jquery-3.7.1.min.js"></script>

  <!-- fontawesome js link -->
  <script src="../../../public/libs/fontawesome-6/js/all.min.js"></script>

  <!-- datatables js link -->
  <script src="../../../public/libs/datatables/js/datatables.min.js"></script>

  <!-- **********
    datatable initialization here 
    ********** -->
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      // Initialize DataTable for the membersTable
      $("#membersTable").DataTable({
        paging: true, // Enable pagination
        searching: true, // Enable search functionality
        ordering: true, // Enable column sorting
        info: true, // Show table information
        pageLength: 5, // Default rows per page
        lengthChange: true, // Allow rows per page to be changed
        columnDefs: [{
          targets: 1, // Prevent sorting for 'Event Name' column (index 1)
          orderable: false,
        }, ],
        language: {
          search: "Search:", // Customize the search bar text
          paginate: {
            previous: "Previous", // Customize previous button text
            next: "Next", // Customize next button text
          },
        },
      });
    });
  </script>

  <!-- sweetalert js link -->
  <script src="../../../public/libs/sweetalert/sweetalert2.all.min.js"></script>

  <!-- custom js link -->
  <script src="../../js/admin.js"></script>
</body>

</html>
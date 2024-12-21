<?php

// to show error codes
ini_set("display_errors", 1);

// call dbconnection file to use
require_once "../dbconnect.php";

// to create session if not exist
if (!isset($_SESSION)) {
  session_start();
}

$messages = null;


function changstatus()
{
  try {
    $conn = connect();
    $sql = "UPDATE messages SET status = 1 WHERE status = 0";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
}

function allmessages()
{
  try {
    $conn = connect();
    $sql = "SELECT * FROM messages ORDER BY id DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
}

$messages = allmessages();
changstatus();


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

            <a class="nav-link" href="members.php">
              <div class="sb-nav-link-icon">
                <i class="fa-solid fa-users"></i>
              </div>
              Members
            </a>

            <a class="nav-link active" href="messages.php">
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
          <h1 class="mt-4">Messages</h1>

          <!-- Alert Box -->
          <div id="alert-box" class="mb-4"></div>

          <!-- 
            use submitProfile(title, message)
            to display alert box with title and message
            -->

          <!-- Event Datas Table -->
          <div class="row">
            <div class="card-body">
              <table
                id="messagesTable"
                class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th scope="col">No</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Message</th>
                    <th scope="col">Status</th>
                    <th scope="col">Date</th>
                  </tr>
                </thead>

                <tbody>
                  <?php foreach ($messages as $message) { ?>
                    <tr>
                      <td><?php echo $message['id'] ?></td>
                      <td><?php echo ucwords($message['name']) ?></td>
                      <td><?php echo $message['email'] ?></td>
                      <td>
                        <p><?php echo ucwords($message['content']) ?></p>
                      </td>
                      <td>
                        <?php if (!$message['status']) { ?>
                          <button class="btn btn-disabled btn-warning">
                            Pending
                          </button>
                        <?php } else { ?>
                          <button class="btn btn-disabled btn-success">
                            Read
                          </button>
                        <?php } ?>
                      </td>
                      <td><?php echo $message['datetime'] ?></td>
                    </tr>
                  <?php } ?>

                </tbody>
              </table>
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
      // Initialize DataTable for messagesTable
      $("#messagesTable").DataTable({
        paging: true, // Enable pagination
        searching: true, // Enable search bar
        ordering: true, // Enable column sorting
        info: true, // Show table information
        pageLength: 5, // Default number of rows per page
        lengthChange: true, // Allow users to change rows per page
        columnDefs: [{
          targets: 2, // Disable sorting for the 'Status' column (3rd column, 0-indexed)
          orderable: false,
        }, ],
        language: {
          search: "Search messages:", // Custom text for the search bar
          paginate: {
            previous: "Previous", // Custom text for previous button
            next: "Next", // Custom text for next button
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
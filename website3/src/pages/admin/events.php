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

// making default time zone
date_default_timezone_set("Asia/Yangon");

$date = date("Y-m-d");
//echo $date;

$sports = null;
$events = null;
$updateevent = null;
$toastmessage = "";

function allsports()
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

function searcheventbyid($eventid)
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

function allevents()
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

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['updateid'])) {
  $updateevent = searcheventbyid($_GET['updateid']);
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['deleteid'])) {
  $deleteevent = $_GET['deleteid'];
  try {
    $conn = connect();
    $sql = "DELETE FROM events WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$deleteevent]);
    $_SESSION['eventdeletesuccess'] = "Your event is successfully deleted.";
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
}

if (isset($_SESSION['eventinsertsuccess'])) {
  $toastmessage = $_SESSION['eventinsertsuccess'];
} elseif(isset($_SESSION['eventeditsuccess'])) {
  $toastmessage = $_SESSION['eventeditsuccess'];
} elseif(isset($_SESSION['eventdeletesuccess'])) {
  $toastmessage = $_SESSION['eventdeletesuccess'];
}


$sports = allsports();
$events = allevents();

// var_dump($updateevent);

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

            <a class="nav-link active" href="events.php">
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

    <!-- Main Content -->
    <div id="layoutSidenav_content">
      <main>
        <div class="container-fluid px-4">
          <h1 class="mt-4">Events Management</h1>

          <!-- Event Creation and Editing Form -->
          <div class="row my-5">
            <div class="col-md-6">
              <form action="addnewevent.php" method="POST" enctype="multipart/form-data" class="border border-2 p-3">
                <h4 class="text-success">Add Upcoming Event</h4>
                <div class="form-group my-3">
                  <label for="largeInput">Event Name</label>
                  <input
                    type="text"
                    class="form-control form-control"
                    name="eventName"
                    id="name"
                    placeholder="Enter event name..." required />
                </div>

                <div class="form-group my-3">
                  <label for="description">Description</label>
                  <textarea
                    class="form-control"
                    name="eventDescription"
                    id="comment"
                    rows="5" required>
                    </textarea>
                </div>

                <div class="form-group my-3">
                  <label for="largeInput">Event Date</label>
                  <input
                    type="date"
                    class="form-control form-control"
                    name="eventDate"
                    min="<?php echo $date ?>"
                    id="name" required />
                </div>

                <div class="form-group my-3">
                  <label for="largeInput">Event Time</label>
                  <input
                    type="time"
                    class="form-control form-control"
                    name="eventTime"
                    id="name" required />
                </div>

                <div class="form-group my-3">
                  <label for="largeInput">Event Location</label>
                  <input
                    type="text"
                    class="form-control form-control"
                    name="eventLocation"
                    id="name"
                    placeholder="Enter event location..." required />
                </div>

                <div class="form-group my-3">
                  <label for="largeInput">Registration Due Date</label>
                  <input
                    type="date"
                    class="form-control form-control"
                    name="dueDate"
                    min="<?php echo $date ?>"
                    id="name" required />
                </div>

                <div class="form-group my-3">
                  <label for="largeInput">Participant Limit</label>
                  <input
                    type="text"
                    class="form-control form-control"
                    name="participantLimit"
                    id="name"
                    min="10"
                    placeholder="10" required />
                </div>

                <div class="form-group my-3">
                  <label for="defaultSelect">Age Group</label>
                  <select
                    class="form-select form-control"
                    id="defaultSelect"
                    name="ageGroup" required>
                    <option selected disabled>Select age group</option>
                    <option value="child">Child (under 15)</option>
                    <option value="teen">Teen (Between 16 and 23)</option>
                    <option value="adult">Adult (Over 23)</option>
                    <option value="all">No Age Limit</option>
                  </select>
                </div>

                <div class="form-group my-3">
                  <label for="exampleFormControlFile1">Event Photo</label>
                  <input
                    type="file"
                    class="form-control-file"
                    name="eventPhoto"
                    accept="image/png, image/jpeg, image/jpg"
                    id="exampleFormControlFile1" required />
                </div>

                <div class="form-group mb-3">
                  <label for="defaultSelect">Sport Type</label>
                  <select
                    class="form-select form-control"
                    id="defaultSelect"
                    name="sportType" required>
                    <option selected disabled>Select sport type</option>
                    <?php foreach ($sports as $sport) {
                      echo '<option value="' . $sport['id'] . '">' . $sport['name'] . '</option>';
                    } ?>
                  </select>
                </div>

                <div class="card-action">
                  <button type="submit" name="addNewEvent" class="btn btn-success">Add Event</button>
                  <button type="reset" class="btn btn-secondary">Cancel</button>
                </div>
              </form>
            </div>

            <div class="col-md-6">
              <form action="editevent.php" method="POST" enctype="multipart/form-data" class="border border-2 p-3">
                <h4 class="text-success">Update Event Info</h4>
                <?php if (isset($_GET['updateid'])) { ?>
                  <input type="hidden" name="eventId"
                    value="<?php echo $_GET['updateid'] ?>" />
                <?php } ?>
                <div class="form-group my-3">
                  <label for="largeInput">Event Name</label>
                  <?php if (isset($_GET['updateid'])) { ?>
                    <input type="text" class="form-control" name="eventName" id="name" value="<?php echo $updateevent['name'] ?>"
                      placeholder="Enter event name..." required />
                  <?php } else { ?>
                    <input type="text" class="form-control" name="eventName" id="name"
                      placeholder="Enter event name..." required />
                  <?php } ?>
                </div>

                <div class="form-group my-3">
                  <label for="description">Description</label>
                  <?php if (isset($_GET['updateid'])) { ?>
                    <textarea class="form-control" name="eventDescription" id="comment" rows="5" required>
                        <?php echo $updateevent['description'] ?>
                      </textarea>
                  <?php } else { ?>
                    <textarea class="form-control" name="eventDescription" id="comment" rows="5" required>
                      </textarea>
                  <?php } ?>
                </div>

                <div class="form-group my-3">
                  <label for="largeInput">Event Date</label>
                  <?php if (isset($_GET['updateid'])) { ?>
                    <input type="date" class="form-control" name="eventDate" min="<?php echo $date ?>" value="<?php echo $updateevent['date'] ?>"
                      id="name" required />
                  <?php } else { ?>
                    <input type="date" class="form-control" name="eventDate"
                      id="name" required />
                  <?php } ?>
                </div>

                <div class="form-group my-3">
                  <label for="largeInput">Event Time</label>
                  <?php if (isset($_GET['updateid'])) { ?>
                    <input type="time" class="form-control" name="eventTime" value="<?php echo $updateevent['time'] ?>"
                      id="name" required />
                  <?php } else { ?>
                    <input type="time" class="form-control" name="eventTime"
                      id="name" required />
                  <?php } ?>
                </div>

                <div class="form-group my-3">
                  <label for="largeInput">Event Location</label>
                  <?php if (isset($_GET['updateid'])) { ?>
                    <input type="text" class="form-control" name="eventLocation" value="<?php echo $updateevent['location'] ?>"
                      id="name" placeholder="Enter event location..." required />
                  <?php } else { ?>
                    <input type="text" class="form-control" name="eventLocation"
                      id="name" placeholder="Enter event location..." required />
                  <?php } ?>
                </div>

                <div class="form-group my-3">
                  <label for="largeInput">Registration Due Date</label>
                  <?php if (isset($_GET['updateid'])) { ?>
                    <input type="date" class="form-control" name="dueDate" id="name" min="<?php echo $date ?>" value="<?php echo $updateevent['duedate'] ?>" required />
                  <?php } else { ?>
                    <input type="date" class="form-control" name="dueDate" id="name" required />
                  <?php } ?>
                </div>

                <div class="form-group my-3">
                  <label for="largeInput">Participant Limit</label>
                  <?php if (isset($_GET['updateid'])) { ?>
                    <input type="number" min="10" class="form-control" name="participantLimit" value="<?php echo $updateevent['participantslimit'] ?>"
                      id="name" placeholder="10" required />
                  <?php } else { ?>
                    <input type="number" min="10" class="form-control" name="participantLimit"
                      id="name" placeholder="10" required />
                  <?php } ?>
                </div>

                <div class="form-group my-3">
                  <label for="defaultSelect">Age Group</label>
                  <?php if (isset($_GET['updateid'])) { ?>
                    <select class="form-select" id="defaultSelect" name="ageGroup" required>
                      <?php
                      switch ($updateevent['agegroup']) {
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
                    <select name="ageGroup" id="defaultSelect" class="form-select"
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
                  <?php if (isset($_GET['updateid'])) { ?>
                    <select class="form-select" id="defaultSelect" name="sportType" required>
                      <?php foreach ($sports as $sport) {
                        if ($updateevent['sports_id'] == $sport['id']) {
                          echo '<option selected value="' . $sport['id'] . '">' . $sport['name'] . '</option>';
                        } else {
                          echo '<option value="' . $sport['id'] . '">' . $sport['name'] . '</option>';
                        }
                      } ?>
                    </select>
                  <?php } else { ?>
                    <select class="form-select" id="defaultSelect" name="sportType" required>
                      <option selected disabled>Select sport type</option>
                      <?php foreach ($sports as $sport) {
                        echo '<option value="' . $sport['id'] . '">' . $sport['name'] . '</option>';
                      } ?>
                    </select>
                  <?php } ?>
                </div>

                <div class="card-action">
                  <?php if (isset($_GET['updateid'])) { ?>
                    <button type="submit" name="updateEvent" class="btn btn-success">Edit Event</button>
                  <?php } else { ?>
                    <button type="submit" name="updateEvent" class="btn btn-success" disabled>Add Event</button>
                  <?php } ?>
                  <button type="reset" class="btn btn-secondary">Cancel</button>
                </div>
              </form>
            </div>
          </div>

          <hr class="h1" />

          <!-- Event Datas Table -->
          <h2 class="my-3 text-center text-danger h2">Events Data</h2>
          <div class="row">
            <div class="card-body">
              <table
                id="eventsTable"
                class="table table-bordered table-hover table-head-bg-warning">
                <thead>
                  <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Limit</th>
                    <th scope="col">Date</th>
                    <th scope="col">Age</th>
                    <th scope="col">Sport</th>
                    <th scope="col">Due Date</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($events as $event) { ?>
                    <tr>
                      <td><?php echo ucwords($event['name']) ?></td>
                      <td><?php echo $event['participantslimit'] ?></td>
                      <td><?php echo date("j-F-Y", strtotime($event['date'])) ?></td>
                      <td><?php echo ucwords($event['agegroup']) ?></td>
                      <?php foreach ($sports as $sport) { ?>
                        <?php if ($event['sports_id'] == $sport['id']) { ?>
                          <td><?php echo ucwords($sport['name']) ?></td>
                        <?php } ?>
                      <?php } ?>
                      <td><?php echo date("j-F-Y", strtotime($event['duedate'])) ?></td>
                      <td>
                        <a href="events.php?updateid=<?php echo $event['id'] ?>"><i class="fa-regular fa-pen-to-square text-info me-4"></i></a>
                        <a href="events.php?deleteid=<?php echo $event['id'] ?>"><i class="fa-solid fa-trash text-danger"></i></a>
                      </td>
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
    unset($_SESSION['eventinsertsuccess']);
    unset($_SESSION['eventeditsuccess']);
    unset($_SESSION['eventdeletesuccess']);
    $toastmessage = '';
  }
  ?>

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
      // Initialize the DataTable
      $("#eventsTable").DataTable({
        paging: true, // Enable pagination
        searching: true, // Enable search bar
        ordering: true, // Enable column sorting
        info: true, // Show table info
        lengthChange: true, // Allow changing the number of rows per page
        pageLength: 5, // Default number of rows per page
        columnDefs: [{
          targets: 6, // Disable sorting on the 'Action' column (7th column, 0-indexed)
          orderable: false,
        }, ],
        language: {
          search: "Filter records:", // Customize search bar label
          paginate: {
            previous: "Prev", // Customize pagination buttons
            next: "Next",
          },
        },
      });
    });
  </script>

  <!-- sweetalert js link -->
  <script src="../../../public/libs/sweetalert/sweetalert2.all.min.js"></script>

  <!-- custom js link -->
  <script src="../../js/admin.js"></script>
  <script src="../../js/toast.js" type="text/javascript"></script>
</body>

</html>
<?php

// to show error codes
ini_set("display_errors", 1);

// call dbconnection file to use
require_once "dbconnect.php";

// to create session if not exist
if (!isset($_SESSION)) {
  session_start();
}

$failmessage = "";

if (isset($_SESSION['email-exit'])) {
  $failmessage = $_SESSION['email-exit'];
} elseif (isset($_SESSION['not-strong-password'])) {
  $failmessage = $_SESSION['not-strong-password'];
}

// echo $failmessage;

?>

<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
  <!-- meta data -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->


  <!--font-family-->
  <link
    href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet" />

  <link
    href="https://fonts.googleapis.com/css?family=Rufina:400,700"
    rel="stylesheet" />

  <!-- title of site -->
  <title>AUS Sport Club</title>

  <!--font-awesome.min.css-->
  <link
    rel="stylesheet"
    href="../../public/libs/fontawesome-6/css/all.min.css" />

  <!--linear icon css-->
  <link
    rel="stylesheet"
    href="../../public/libs/linearicons/linearicons.css" />

  <!--flaticon.css-->
  <link rel="stylesheet" href="../../public/libs/flaticon/flaticon.css" />

  <!--animate.css-->
  <link rel="stylesheet" href="../../public/libs/animate/animate.css" />

  <!--owl.carousel.css-->
  <link
    rel="stylesheet"
    href="../../public/libs/owl-carousel/owl.carousel.min.css" />
  <link
    rel="stylesheet"
    href="../../public/libs/owl-carousel/owl.theme.default.min.css" />

  <!--bootstrap.min.css-->
  <link
    rel="stylesheet"
    href="../../public/libs/bootstrap-5/css/bootstrap.min.css" />

  <!--register.css-->
  <link rel="stylesheet" href="../css/register.css" />
  <link rel="stylesheet" href="../css/toast.css" />
</head>

<body>
  <!-- Register Page -->
  <section class="register-section">
    <div class="container">
      <div class="register-content">
        <div class="register-image">
          <img
            src="../../public/images/welcome-page/register.png"
            alt="Sports Club" />
        </div>
        <div class="register-form">
          <h2>Create Your Account</h2>
          <form action="signupfunction.php" method="POST">
            <div class="form-group">
              <label for="name">Name</label>
              <input
                type="text"
                id="name"
                name="user-name"
                placeholder="Your Name" required />
            </div>
            <div class="form-group">
              <label for="email">Email</label>
              <input
                type="email"
                id="email"
                name="user-email"
                placeholder="Your Email" required />
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input
                type="password"
                id="password"
                name="user-password"
                placeholder="Your Password" required />
            </div>
            <button type="submit" name="signup" class="register-btn">
              Register
            </button>
          </form>
        </div>
      </div>
    </div>
  </section>

  <?php if ($failmessage != null) { ?>
    <div class="toasts actives">
      <div class="toast-contents">
        <i class="fas fa-times bg-danger check"></i>

        <div class="message">
          <span class="text text-1">Failed</span>
          <span class="text text-2"><?php echo $failmessage ?></span>
        </div>
      </div>
      <i class="fas fa-times closes"></i>

      <div class="progress actives"></div>
    </div>
  <?php
    unset($_SESSION['email-exit']);
    unset($_SESSION['not-strong-password']);
    $failmessage = '';
  }
  ?>


  <script src="../../public/libs/jquery/jquery-3.7.1.min.js"></script>

  <!--modernizr.min.js-->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>

  <!--bootstrap.min.js-->
  <script src="../../public/libs/bootstrap-5/js/bootstrap.min.js"></script>

  <!--owl.carousel.js-->
  <script src="../../public/libs/owl-carousel/owl.carousel.min.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
  <script type="text/javascript" src="../js/toast.js"></script>

</body>

</html>
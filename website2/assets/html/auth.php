<?php

// to show error codes
ini_set("display_errors", 1);

// call dbconnection file to use
require_once("databaseconnection.php");

// creat session if not created
if(!isset($_SESSION)){
    session_start();
}

$errormessage = null;

if(isset($_SESSION['password_not_strong'])){
    $errormessage = $_SESSION['password_not_strong'];
}elseif(isset($_SESSION['login_error'])){
    $errormessage = $_SESSION['login_error'];
}




?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>AUS Sport Club</title>

  <!-- Libraries CSS Links -->
  <link rel="stylesheet" href="../../dist/libraries/aos/aos.css" />
  <link rel="stylesheet" href="../../dist/libraries/bootstrap-5.0.2/css/bootstrap.min.css" />
  <link rel="stylesheet" href="../../dist/libraries/fontawesome-free-6.7.1-web/css/all.min.css" />
  <link rel="stylesheet" href="../../dist/libraries/jquery-ui/jquery-ui.css" />

  <!-- Custom CSS -->
  <link rel="stylesheet" type="text/css" href="../css/auth.css" />
  <link rel="stylesheet" type="text/css" href="../css/toast.css" />
</head>

<body>
  <!-- Authentication Section -->
  <div class="auth-container">
    <!-- Background Image with Overlay -->
    <div class="auth-overlay">
      <div class="overlay-content">
        <h1>AUS Sport Club</h1>
        <p>Join the best sports community today!</p>
      </div>
    </div>

    <!-- Sign In Form -->
    <form id="signInForm" class="auth-form active" method="POST" action="signin.php">
      <h2>Welcome Back!</h2>
      <label>
        <span>Email</span>
        <input type="email" name="email" placeholder="Enter your email..." required />
      </label>
      <label>
        <span>Password</span>
        <input type="password" name="password" placeholder="Enter your password..." required />
      </label>
      <p class="forgot-pass">Forgot password?</p>
      <button type="submit" name="signin_btn" class="btn btn-primary">Sign In</button>
      <p class="switch-form">
        Don't have an account? <a href="#" id="showSignUp">Sign Up</a>
      </p>
    </form>

    <!-- Sign Up Form -->
    <form id="signUpForm" class="auth-form" method="POST" action="signup.php">
      <h2>Join Us!</h2>
      <label>
        <span>Name</span>
        <input type="text" name="name" placeholder="Enter your name..." required />
      </label>
      <label>
        <span>Email</span>
        <input type="email" name="email" placeholder="Enter your email..." required />
      </label>
      <label>
        <span>Password</span>
        <input type="password" name="password" placeholder="Enter your password..." required />
      </label>
      <button type="submit" name="signup_btn" class="btn btn-success">Sign Up</button>
      <p class="switch-form">
        Already have an account? <a href="#" id="showSignIn">Sign In</a>
      </p>
    </form>
  </div>

  <?php if($errormessage != null) {?>
      <div class="toasts actives">
          <div class="toast-contents">
              <i class="fas fa-times bg-danger check"></i>

              <div class="message">
                  <span class="text text-1">Failed</span>
                  <span class="text text-2"><?php echo $errormessage ?></span>
              </div>
          </div>
          <i class="fas fa-times closes"></i>

          <div class="progress actives"></div>
      </div>
      <?php
      unset($_SESSION['password_not_strong']);
      unset($_SESSION['login_error']);
      $errormessage = '';
  }
  ?>

  <!-- AOS Library JS -->
  <script src="../../dist/libraries/aos/aos.js"></script>
  <script>
    AOS.init();
  </script>

  <!-- Libraries JS Links -->
  <script src="../../dist/libraries/bootstrap-5.0.2/js/bootstrap.min.js"></script>
  <script src="../../dist/libraries/jquery-ui/jquery-ui.js"></script>
  <script src="../../dist/libraries/jquery/jquery-3.7.1.min.js"></script>
  <script src="../../dist/libraries/fontawesome-free-6.7.1-web/js/all.min.js"></script>
  <script src="./../js/toast.js"></script>

  <!-- Toggle Forms -->
  <script>
    document.getElementById("showSignUp").addEventListener("click", function(e) {
      e.preventDefault();
      document.getElementById("signInForm").classList.remove("active");
      document.getElementById("signUpForm").classList.add("active");
    });

    document.getElementById("showSignIn").addEventListener("click", function(e) {
      e.preventDefault();
      document.getElementById("signUpForm").classList.remove("active");
      document.getElementById("signInForm").classList.add("active");
    });
  </script>
</body>

</html>
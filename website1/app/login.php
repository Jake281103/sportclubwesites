<?php

// to show error codes
ini_set("display_errors", 1);

// call dbconnection file to use
require_once("dbconnect.php");
// call sessionconfig file to use its methods
require_once("sessionconfig.php");

$errormessage = "";

if(verifysession("login-error")){
    $errormessage = getsession("login-error");
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login - AUS Sport Club</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="styles.css" />
  <!-- Bootstrap CSS link -->
  <link rel="stylesheet" href="../public/libs/css/bootstrap.min.css" />

  <!-- Font Awesome CSS link -->
  <link rel="stylesheet" href="../public/libs/font-awesome-5/css/fontawesome-all.min.css" />
  <!-- AOS CSS Link -->
  <link rel="stylesheet" href="../public/libs/css/aos.css" />

  <!-- Custom CSS link -->
  <link rel="stylesheet" href="../css/style.css" />
  <link rel="stylesheet" href="../css/login.css" />
  <link rel="stylesheet" href="../css/toast.css" />
</head>

<body>
  <div class="container login-container" data-aos="fade-in" data-aos-delay="300">
    <div class="row g-0">
      <!-- Image Section -->
      <div class="col-md-6 image-container"></div>

      <!-- Login Form Section -->
      <div class="col-md-6 form-container">
        <h2 class="mb-4 text-center">Login to AUS Sport Club</h2>
        <form action="loginfunction.php" method="POST">
          <!-- Email -->
          <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" name="email" class="form-control" id="email" placeholder="Enter your email" required />
          </div>

          <!-- Password -->
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" class="form-control" id="password" placeholder="Enter your password" required />
          </div>

          <!-- Remember Me and Forgot Password -->
          <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="rememberMe" />
              <label class="form-check-label" for="rememberMe">Remember me</label>
            </div>
            <a href="#">Forgot Password?</a>
          </div>

          <!-- Login Button -->
          <div class="d-grid">
            <button type="submit" name="login" class="btn btn-primary">Login</button>
          </div>

          <!-- Register Link -->
          <p class="text-center mt-4">
            Don’t have an account? <a href="register.php">Register here</a>
          </p>
        </form>
      </div>
    </div>
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
      unset($_SESSION['login-error']);
      $errormessage = '';
  }
  ?>

  <!-- AOS JS link -->
  <script src="../public/libs/js/aos.js"></script>

  <!-- Bootstrap JS link -->
  <script src="../public/libs/js/bootstrap.min.js"></script>

  <!-- JQuery JS link -->
  <script src="../public/libs/js/jquery-3.7.1.min.js"></script>

  <!-- Smoothscroll JS link -->
  <script src="../public/libs/js/smoothscroll.js"></script>

  <!-- Custom JS link -->
  <script src="../js/app.js"></script>
  <script src="../js/toast.js"></script>
</body>

</html>
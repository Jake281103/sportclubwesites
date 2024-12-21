<?php

// to show error codes
ini_set("display_errors", 1);

// call dbconnection file to use
require_once("dbconnect.php");
// call sessionconfig file to use its methods
require_once("sessionconfig.php");

$errormessage = "";

if(verifysession("password-not-strong")){
    $errormessage = getsession("password-not-strong");
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Register - AUS Sport Club</title>
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
  <link rel="stylesheet" href="../css/register.css" />
  <link rel="stylesheet" href="../css/toast.css" />
</head>

<body>
  <div class="container register-container" data-aos="fade-out" data-aos-delay="300">
    <div class="row g-0">
      <!-- Register Form Section -->
      <div class="col-md-6 form-container">
        <h2 class="mb-4 text-center">Register with Us!</h2>
        <form action="registerfunction.php" method="POST">
          <!-- Name -->
          <div class="mb-3">
            <label for="name" class="form-label">Full Name</label>
            <input type="text" name="name" class="form-control" id="name" placeholder="Enter your full name" required />
          </div>

          <!-- Email -->
          <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" name="email" class="form-control" id="email" placeholder="Enter your email" required />
          </div>

          <!-- Password -->
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" class="form-control" id="password" placeholder="Enter your password" required />
          </div>

          <!-- Register Button -->
          <div class="d-grid">
            <button type="submit" name="register" class="btn btn-primary">Register</button>
          </div>

          <!-- Login Link -->
          <p class="text-center mt-4">
            Already have an account? <a href="login.php">Login here</a>
          </p>
        </form>
      </div>

      <!-- Image Section -->
      <div class="col-md-6 image-container"></div>
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
      unset($_SESSION['password-not-strong']);
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

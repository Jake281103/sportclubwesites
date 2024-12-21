<?php

// to show error codes
ini_set("display_errors", 1);

// call dbconnection file to use
require_once("databaseconnection.php");

// creat session if not created
if (!isset($_SESSION)) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['signin_btn'])) {

    $login_email = text_check($_POST['email']);
    $login_password = md5(text_check($_POST['password']));

    if ($login_email && $login_password) {
        try {
            $conn = connect();
            $sql = "SELECT * FROM users WHERE email=? AND password=?";
            $stmt = $conn->prepare($sql);
            $status = $stmt->execute([$login_email, $login_password]);
            if ($stmt->rowCount() > 0) {
                $_SESSION['email'] = $login_email;
                $_SESSION['login_success'] = "You have successfully logged in";

                $sql = "UPDATE users SET status=1 WHERE email=?";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$login_email]);

                header("Location:index.php");
            } else {
                $sql = "SELECT * FROM admins WHERE email=? AND password=?";
                $stmt = $conn->prepare($sql);
                $status = $stmt->execute([$login_email, $login_password]);
                if ($stmt->rowCount() > 0) {
                    $_SESSION['email'] = $login_email;
                    $_SESSION['login_success'] = "You have successfully logged in";

                    $sql = "UPDATE admins SET status=1 WHERE email=?";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute([$login_email]);

                    header("Location:admin/index.php");
                } else {
                    $_SESSION['login_error'] = "Your email and password might be incorrect";
                    header("Location:auth.php");
                }
            }

            $conn = null;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    } else {
        echo "Enter Username & Password";
    }
}

function text_check($data)
{
    $data = trim($data);
    $data = htmlspecialchars($data);
    $data = stripslashes($data);
    return $data;
}

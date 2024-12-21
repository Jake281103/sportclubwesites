<?php

// to show error codes
ini_set("display_errors", 1);

// call dbconnection file to use
require_once "dbconnect.php";

// to create session if not exist
if (!isset($_SESSION)) {
    session_start(); 
}

if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['login'])){
    $email = htmlspecialchars($_POST['user-email']);
    $password = htmlspecialchars($_POST['user-password']);

    try{
        $conn = connect();
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $status = $stmt->execute([$email]);
        $member = $stmt->fetch();
        if($stmt->rowCount() > 0){
            if(password_verify($password, $member['password'])){
                $_SESSION['login-success'] = "You have successfully logged in";
                $_SESSION['email'] = $email;

                $sql = "UPDATE users SET status=1 WHERE email=?";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$email]);

                header("Location: index.php");
            }else{

                $_SESSION['login-error'] = "Your Password might be incorrect";
                header("Location:login.php");
            }
        }else{

            $sql = "SELECT * FROM admins WHERE email = ?";
            $stmt = $conn->prepare($sql);
            $status = $stmt->execute([$email]);
            $admin = $stmt->fetch();
            if($stmt->rowCount() > 0){
                if(password_verify($password, $admin['password'])){
                    $_SESSION['login-success'] = "You have successfully logged in";
                    $_SESSION['email'] = $email;

                    $sql = "UPDATE admins SET status=1 WHERE email=?";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute([$email]);

                    header("Location: admin/index.php");
                }else{
                    $_SESSION['login-error'] = "Your Password might be incorrect";
                    header("Location:login.php");
                }

            }else{
                $_SESSION['login-error'] = "Your email might be incorrect";
                header("Location:login.php");
            }
        }

        $conn = null;

    }catch(PDOException $e){
        echo $e->getMessage();
    }


}

?>

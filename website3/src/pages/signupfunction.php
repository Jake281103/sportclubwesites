<?php

// to show error codes
ini_set("display_errors", 1);

// call dbconnection file to use
require_once "dbconnect.php";

// to create session if not exist
if (!isset($_SESSION)) {
    session_start(); 
}

function ispasswordstrong($password)
{
    if (strlen($password) < 8) {
        return false;
    } elseif (isstrong($password)) {
        return true;
    } else {
        return false;
    }
}

function isstrong($password)
{
    $digitcount = 0;
    $capitalcount = 0;
    $speccount = 0;
    $lowercount = 0;
    foreach (str_split($password) as $char) {
        if (is_numeric($char)) {
            $digitcount++;
        } elseif (ctype_upper($char)) {
            $capitalcount++;
        } elseif (ctype_lower($char)) {
            $lowercount++;
        } elseif (ctype_punct($char)) {
            $speccount++;
        }
    }

    if ($digitcount >= 1 && $capitalcount >= 1 && $speccount >= 1) {
        return true;
    } else {
        return false;
    }
}

function checkemailexist($email)
{
    try{
        $conn = connect();
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$email]);
        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            $sql = "SELECT * FROM admins WHERE email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$email]);
            if ($stmt->rowCount() > 0) {
                return true;
            }else{
                return false;
            }
        }
    }catch(PDOException $e){
        echo $e->getMessage();
    }
}
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['signup'])) {

    $name = htmlspecialchars($_POST['user-name']);
    $email = htmlspecialchars($_POST['user-email']);
    $password = htmlspecialchars($_POST['user-password']);
    $hascode = null;

    try {
        if (checkemailexist($email)) {
            // echo "has be registered";
            $_SESSION['email-exit'] = "Your email has already been registered";
            header("Location:register.php");
        } else {
            // echo "new Customer";
            if (ispasswordstrong($password)) {
                $hascode = password_hash($password, PASSWORD_DEFAULT);
                $conn = connect();
                $stmt = $conn->prepare("INSERT INTO users (name,email,password) VALUES(:name, :email, :password)");
                $stmt->bindValue(':name', $name);
                $stmt->bindValue(':email', $email);
                $stmt->bindValue(':password', $hascode);
                $stmt->execute();
                $_SESSION['email'] = $email;
                $_SESSION['signup-success'] = "You have successfully registered";

                $sql = "UPDATE users SET status=1 WHERE email=?";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$email]);

                header("Location:index.php");
            }else{
                $_SESSION['not-strong-password'] = "Your password is not strong enough";
                header("Location:register.php");
            }
        }
        $conn = null;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

?>

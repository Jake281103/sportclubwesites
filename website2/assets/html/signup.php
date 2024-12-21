<?php

// to show error codes
ini_set("display_errors", 1);

// call dbconnection file to use
require_once("databaseconnection.php");

// creat session if not created
if(!isset($_SESSION)){
    session_start();
}

// check if the data from register form are sent.
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['signup_btn'])) {
    $name = text_check($_POST['name']);
    $email = text_check($_POST['email']);
    $password = text_check($_POST['password']);

    echo $name . "<br>";
    echo $email . "<br>";
    echo $password . "<br>";


    // check the password is strong ors not
    if (password_check($password)) {
        $encrypt_password = md5($password);
        try {
            $conn = connect();
            // perpare the sql statement to insert data into database
            $stmt = $conn->prepare("INSERT INTO users(name,email,password) VALUE (:name,:email,:password)");

            // use bindParam() method for security
            $stmt->bindParam(":name", $name);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":password", $encrypt_password);

            if ($stmt->execute()) {
                // session store 
                $_SESSION['email'] = $email;
                $_SESSION['register_success'] = "Your information are successfully registrated";

                $sql = "UPDATE users SET status=1 WHERE email=?";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$email]);

                //redirect to homepage
                header("Location:index.php");
            } else {
                echo "Try Again";
            }
        } catch (PDOException $e) {
            echo "Error Found :" . $e->getMessage();
        }

        $conn = null;
    } else {
        // session store
        $_SESSION['password_not_strong'] = "Your Password is not strong, Please try again";
        // redirect to register page
        header("Location:auth.php");
    }
}

function text_check($input)
{
    $input = trim($input);
    $input = htmlspecialchars($input);
    $input = stripslashes($input);
    return $input;
}

function password_check($password)
{
    if (strlen($password) < 8) {
        return false;
    } elseif (password_strong($password)) {
        return true;
    } else {
        return false;
    }
}

function password_strong($password)
{
    $digit_count = 0;
    $capital_count = 0;
    $special_count = 0;
    $lower_count = 0;
    foreach (str_split($password) as $character) {
        if (is_numeric($character)) {
            $digit_count++;
        } elseif (ctype_upper($character)) {
            $capital_count++;
        } elseif (ctype_lower($character)) {
            $lower_count++;
        } elseif (ctype_punct($character)) {
            $special_count++;
        }
    }

    if ($digit_count >= 1 && $capital_count >= 1 && $special_count >= 1) {
        return true;
    } else {
        return false;
    }
}

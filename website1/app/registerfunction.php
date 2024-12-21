<?php

// to show error codes
global $conn;
ini_set("display_errors", 1);

// call dbconnection file to use
require_once("dbconnect.php");
// call sessionconfig file to use its methods
require_once("sessionconfig.php");

// check if the data from register form are sent.
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['register'])) {
    $getname = textfilter($_POST['name']);
    $getemail = textfilter($_POST['email']);
    $password = textfilter($_POST['password']);

    // echo $getname;
    // echo $getemail;
    // echo $getpassword;

    // check if the register email and password contain
    if ($getemail && $password) {

        // check the password is strong ors not
        if(ispasswordstrong($password)){
            $getpassword = md5($password);
            try {
                // perpare the sql statement to insert data into database
                $stmt = $conn->prepare("INSERT INTO users(name,email,password) VALUE (:name,:email,:password)");
    
                // use bindParam() method for security
                $stmt->bindParam(":name", $bindname);
                $stmt->bindParam(":email", $bindemail);
                $stmt->bindParam(":password", $bindpassword);
    
                $bindname = $getname;
                $bindemail = $getemail;
                $bindpassword = $getpassword;
    
                if ($stmt->execute()) {
                    // session store  
                    setsession('email', $bindemail);
                    setsession('password', $bindpassword);
                    setsession('register-success', "Your registraion is success");

                    $sql = "UPDATE users SET status=1 WHERE email=?";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute([$getemail]);

                    //redirect to homepage
                    redirectto('home.php');
                } else {
                    echo "Try Again";
                }
            } catch (PDOException $e) {
                echo "Error Found :" . $e->getMessage();
            }
    
            $conn = null;

        }else{
            // session store
            setsession("password-not-strong","Your Password is not strong, Please try again");
            // redirect to register page
            redirectto('register.php');
        }
    }
}

function textfilter($data)
{
    $data = trim($data);
    $data = htmlspecialchars($data);
    $data = stripslashes($data);
    return $data;
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



?>
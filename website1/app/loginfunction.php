<?php

ini_set("display_errors", 1);

require_once("dbconnect.php");
require_once("sessionconfig.php");

if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['login'])){

    $getemail = textfilter($_POST['email']);
    $getpassword = md5(textfilter($_POST['password']));
    
    if($getemail && $getpassword){
        loginveriy($getemail,$getpassword);
    }else{
        echo "Enter Username & Password";
    }

}

function textfilter($data)
{
    $data = trim($data);
    $data = htmlspecialchars($data);
    $data = stripslashes($data);
    return $data;
}

function loginveriy($getemail,$getpassword){

    try{
        $conn = $GLOBALS['conn'];
        $sql = "SELECT * FROM users WHERE email=? AND password=?";
        $stmt = $conn->prepare($sql);
        $status = $stmt->execute([$getemail,$getpassword]);
        $user = $stmt->fetch();
        if($stmt->rowCount() > 0){
            setsession('email', $getemail);
            setsession('password', $getpassword);
            setsession('user-login-success',"You have successfully logged in");

            $sql = "UPDATE users SET status=1 WHERE email=?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$getemail]);

            if($user['role']){
                redirectto('admin/dashboard.php');
            }else{
                redirectto('home.php');   
            }
        }else{
            setsession('login-error', "Your email and password   might be incorrect");
            header("Location:login.php");
        }

        $conn = null;

    }catch(PDOException $e){
        echo $e->getMessage();
    }


}


?>
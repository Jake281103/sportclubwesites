<?php

// to show error codes
ini_set("display_errors", 1);

// call dbconnection file to use
require_once("databaseconnection.php");

// creat session if not created
if (!isset($_SESSION)) {
    session_start();
}

function status_off($email){
    try{
        $conn = connect();
        $sql = "UPDATE users SET status=0 WHERE email=:email";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $sql = "UPDATE admins SET status=0 WHERE email=:adminmail";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':adminmail', $email, PDO::PARAM_STR);
        $stmt->execute();


    }catch (PDOException $e){
        echo $e->getMessage();
    }
}

status_off($_SESSION['email']);
// delete email sessions
unset($_SESSION['email']);
 
if(!isset($_SESSION['email'])){
    header("Location:index.php");
}


?>
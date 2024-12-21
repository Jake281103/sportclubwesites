<?php

require_once 'dbconnect.php';

 // call sessionconfig file to use its methods
include_once "sessionconfig.php";

function changestatus($email){
    try{
        $conn = $GLOBALS['conn'];
        $sql = "UPDATE users SET status=0 WHERE email=:email";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
    }catch (PDOException $e){
        echo $e->getMessage();
    }
}

changestatus(getsession('email'));
// delete email and password sessions
unsetsession('email');
unsetsession('password');
 
if(authfailed()){
    redirectto('home.php'); 
}



?>
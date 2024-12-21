<?php

ini_set("display_errors", 1);

require_once("dbconnect.php");
require_once("sessionconfig.php");

if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['send-message'])){

    $getname = $_POST['name'];
    $getemail = $_POST['email'];
    $getmessage = $_POST['message'];

//    echo $getname;
//    echo $getemail;
//    echo $getmessage;

    try{
        $conn = $conn = $GLOBALS['conn'];
        $sql = "INSERT INTO messages (name, email, content) VALUES(:name, :email, :message)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':name', $getname);
        $stmt->bindParam(':email', $getemail);
        $stmt->bindParam(':message', $getmessage);
        $stmt->execute();
        setsession('send-message-success',"Your message was sent successfully!");
        redirectto('contact-us.php');
    }catch (PDOException $e){
        echo "Error: " . $e->getMessage();
    }

}

?>
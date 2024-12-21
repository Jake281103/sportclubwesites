<?php

ini_set("display_errors", 1);

require_once "dbconnect.php";

// creat session if not created
if (!isset($_SESSION)) {
    session_start();
}

if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['send-btn'])){

    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

//    echo $sender_name;
//    echo $sender_email;
//    echo $sendder_message;

    try{
        $conn = connect();
        $sql = "INSERT INTO messages (name, email, content) VALUES(:name, :email, :message)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':message', $message);
        $stmt->execute();
        $_SESSION['success-sending'] = "Your contact message was sent successfully!";
        header("Location:contactus.php");
    }catch (PDOException $e){
        echo "Error: " . $e->getMessage();
    }

}

?>
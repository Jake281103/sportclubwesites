<?php

ini_set("display_errors", 1);

require_once "databaseconnection.php";

// creat session if not created
if (!isset($_SESSION)) {
    session_start();
}

if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['contact_message_sent'])){

    $sender_name = $_POST['message_username'];
    $sender_email = $_POST['message_useremail'];
    $sendder_message = $_POST['message_content'];

//    echo $sender_name;
//    echo $sender_email;
//    echo $sendder_message;

    try{
        $conn = connect();
        $sql = "INSERT INTO messages (name, email, content) VALUES(:name, :email, :message)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':name', $sender_name);
        $stmt->bindParam(':email', $sender_email);
        $stmt->bindParam(':message', $sendder_message);
        $stmt->execute();
        $_SESSION['message_sending_success'] = "Your message was sent successfully!";
        header("Location:contactus.php");
    }catch (PDOException $e){
        echo "Error: " . $e->getMessage();
    }

}

?>
<?php

// to show error codes
ini_set("display_errors", 1);

// call dbconnection file to use
require_once "../dbconnect.php";

// creat session if not created
if (!isset($_SESSION)) {
  session_start();
}

if (!isset($_SESSION['email'])) {
    header("Location:../login.php");
}


// making default time zone
date_default_timezone_set("Asia/Yangon");


if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['addNewEvent'])){
    $name = $_POST['eventName'];
    $description = $_POST['eventDescription'];
    $event_date = $_POST['eventDate'];
    $event_time = $_POST['eventTime'];
    $location = $_POST['eventLocation'];
    $duedate = $_POST['dueDate'];
    $limit = $_POST['participantLimit'];
    $agegroup = $_POST['ageGroup'];
    $photo = $_FILES['eventPhoto'];
    $sporttype = $_POST['sportType'];
    $status = 'upcoming';

    // echo $name . "<br>";
    // echo $description . "<br>";
    // echo $event_date . "<br>";
    // echo $event_time . "<br>";
    // echo $location . "<br>";
    // echo $duedate . "<br>";
    // echo $limit . "<br>";
    // echo $agegroup . "<br>";
    // echo $photo['name'] . "<br>";
    // echo $sporttype . "<br>";


    $date = new DateTimeImmutable();
    $datetime = $date->format('l-jS-F-Y-');
    $rdm = rand();
    $filename = $photo['name'];
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    $fileuploadpath = "../../../public/images/events/" . $datetime . $rdm . "." . $ext;
    $dbfilepath = "public/images/events/" . $datetime . $rdm . "." . $ext;
    if (move_uploaded_file($photo['tmp_name'], $fileuploadpath)) {
        try {
            $conn = connect();
            $sql = "INSERT INTO events (name,image,description,participantslimit,remainlimit,date,time,duedate,location,agegroup,status,sports_id) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$name,$dbfilepath,$description,$limit,$limit,$event_date,$event_time,$duedate,$location,$agegroup,$status,$sporttype]);
            $_SESSION['eventinsertsuccess'] = "New Event is added successfully";
            header("Location:events.php");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }else{
        echo "Sorry, there was an error uploading your file.";
    }
}


?>
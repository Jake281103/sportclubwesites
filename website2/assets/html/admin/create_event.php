<?php

// to show error codes
ini_set("display_errors", 1);

// call dbconnection file to use
require_once("../databaseconnection.php");

// creat session if not created
if (!isset($_SESSION)) {
  session_start();
}

if (!isset($_SESSION['email'])) {
  header("Location:../auth.php");
}


// making default time zone
date_default_timezone_set("Asia/Yangon");


if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['create_event'])){
    $name = $_POST['event_name'];
    $description = $_POST['event_description'];
    $event_date = $_POST['event_date'];
    $event_time = $_POST['event_time'];
    $location = $_POST['event_location'];
    $duedate = $_POST['event_duedate'];
    $limit = $_POST['event_limit'];
    $agegroup = $_POST['event_agegroup'];
    $photo = $_FILES['event_photo'];
    $sporttype = $_POST['event_sporttype'];
    $status = 'upcoming';

    // echo $name;
    // echo $description;
    // echo $date;
    // echo $time;
    // echo $location;
    // echo $duedate;
    // echo $limit;
    // echo $agegroup;
    // var_dump($photo);
    // echo $sporttype;


    $date = new DateTimeImmutable();
    $datetime = $date->format('l-jS-F-Y-');
    $rdm = rand();
    $filename = $photo['name'];
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    $uploadpath = "../../../dist/img/events/" . $name . "-" . $datetime . $rdm . "." . $ext;
    $dbfilepath = "dist/img/events/" . $name . "-" . $datetime . $rdm . "." . $ext;
    if (move_uploaded_file($photo['tmp_name'], $uploadpath)) {
        try {
            $conn = connect();
            $sql = "INSERT INTO events (name,image,description,participantslimit,remainlimit,date,time,duedate,location,agegroup,status,sports_id) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$name,$dbfilepath,$description,$limit,$limit,$event_date,$event_time,$duedate,$location,$agegroup,$status,$sporttype]);
            $_SESSION['event_create_success'] = "Event is created successfully";
            header("Location:events.php");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }else{
        echo "Sorry, there was an error uploading your file.";
    }
}


?>
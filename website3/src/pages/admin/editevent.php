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
  header("Location:../auth.php");
}


// making default time zone
date_default_timezone_set("Asia/Yangon");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['updateEvent'])) {

    $id = $_POST['eventId'];
    $name = $_POST['eventName'];
    $description = $_POST['eventDescription'];
    $event_date = $_POST['eventDate'];
    $event_time = $_POST['eventTime'];
    $location = $_POST['eventLocation'];
    $duedate = $_POST['dueDate'];
    $limit = $_POST['participantLimit'];
    $agegroup = $_POST['ageGroup'];
    $sporttype = $_POST['sportType'];

    // echo $id . "<br>";
    // echo $name . "<br>";
    // echo $description . "<br>";
    // echo $event_date . "<br>";
    // echo $event_time . "<br>";
    // echo $location . "<br>";
    // echo $duedate . "<br>";
    // echo $limit . "<br>";
    // echo $agegroup . "<br>";
    // echo $sporttype . "<br>";


    try {
        $conn = connect();
        $sql = "UPDATE events SET name=?, description=?, participantslimit=?, date=?, time=?, duedate=?, location=?, agegroup=?, sports_id=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$name, $description, $limit, $event_date, $event_time, $duedate, $location, $agegroup, $sporttype, $id]);
        $_SESSION['eventeditsuccess'] = "Event is Updated successfully";
        header("Location:events.php");
        $conn = null;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}


?>
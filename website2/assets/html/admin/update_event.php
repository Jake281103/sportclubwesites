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

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_event'])) {

    $event_id = $_POST['event_id'];
    $event_name = $_POST['event_name'];;
    $event_description = $_POST['event_description'];
    $event_date = $_POST['event_date'];
    $event_time = $_POST['event_time'];
    $event_location = $_POST['event_location'];
    $event_duedate = $_POST['event_duedate'];
    $event_limit = $_POST['event_limit'];
    $event_agegroup = $_POST['event_agegroup'];
    $event_sporttype = $_POST['event_sporttype'];

    // echo  $event_id;
    // echo $event_name;
    // echo $event_description;
    // echo $event_date;
    // echo $event_time;
    // echo $event_location;
    // echo $event_duedate;
    // echo $event_limit;
    // echo $event_agegroup;
    // echo $event_sporttype;


    try {
        $conn = connect();
        $sql = "UPDATE events SET name=?, description=?, participantslimit=?, date=?, time=?, duedate=?, location=?, agegroup=?, sports_id=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$event_name, $event_description, $event_limit, $event_date, $event_time, $event_duedate, $event_location, $event_agegroup, $event_sporttype, $event_id]);
        $_SESSION['event_update_success'] = "Event is Updated successfully";
        header("Location:events.php");
        $conn = null;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}


?>
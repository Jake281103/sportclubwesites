<?php

// to show error codes
ini_set("display_errors", 1);

// call dbconnection file to use
require_once("./../dbconnect.php");
// call sessionconfig file to use its methods
require_once("./../sessionconfig.php");

// making default time zone
date_default_timezone_set("Asia/Yangon");

if (!isset($_SESSION['email'])) {
    redirectto("./../login.php");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['event-update'])) {

    $getevid = $_POST['id'];
    $getevname = $_POST['name'];
    $getevdesc = $_POST['description'];
    $getevdate = $_POST['date'];
    $getevtime = $_POST['time'];
    $getevlocation = $_POST['location'];
    $getevduedate = $_POST['due-date'];
    $getevlimit = $_POST['limit'];
    $geteveage = $_POST['age-group'];
    $getevsporttype = $_POST['sport'];

    echo $getevid;
    echo $getevname;
    echo $getevdesc;
    echo $getevdate;
    echo $getevtime;
    echo $getevlocation;
    echo $getevduedate;
    echo $getevlimit;
    echo $geteveage;
    echo $getevsporttype;



    try {
        $conn = $GLOBALS['conn'];
        $sql = "UPDATE events SET name=?, description=?, participantslimit=?, date=?, time=?, duedate=?, location=?, agegroup=?, sports_id=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$getevname, $getevdesc, $getevlimit, $getevdate, $getevtime, $getevduedate, $getevlocation, $geteveage, $getevsporttype, $getevid]);
        setsession('event-update-success', "Event Updated successfully");
        redirectto("eventmanagement.php");
        $conn = null;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}


?>
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

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['create-event'])){
    $getevname = $_POST['name'];
    $getevdesc = $_POST['description'];
    $getevdate = $_POST['date'];
    $getevtime = $_POST['time'];
    $getevlocation = $_POST['location'];
    $getevduedate = $_POST['due-date'];
    $getevlimit = $_POST['limit'];
    $geteveage = $_POST['age-group'];
    $getevphoto = $_FILES['image'];
    $getevsporttype = $_POST['sport'];
    $status = 'upcoming';

//    echo $getevname;
//    echo $getevdesc;
//    echo $getevdate;
//    echo $getevtime;
//    echo $getevlocation;
//    echo $getevduedate;
//    echo $getevlimit;
//    echo $geteveage;
//    var_dump($getevphoto);
//    echo $getevsporttype;


    $date = new DateTimeImmutable();
    $datetime = $date->format('l-jS-F-Y-');
    $rdm = rand();
    $filename = $getevphoto['name'];
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    $uploadpath = "./../../public/images/event/" . $getevname . "-" . $datetime . $rdm . "." . $ext;
    $dbfilepath = "public/images/event/" . $getevname . "-" . $datetime . $rdm . "." . $ext;
    if (move_uploaded_file($getevphoto['tmp_name'], $uploadpath)) {
        try {
            $conn = $GLOBALS['conn'];
            $sql = "INSERT INTO events (name,image,description,participantslimit,remainlimit,date,time,duedate,location,agegroup,status,sports_id) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$getevname,$dbfilepath,$getevdesc,$getevlimit,$getevlimit,$getevdate,$getevtime,$getevduedate,$getevlocation,$geteveage,$status,$getevsporttype]);
            setsession('event-create-success',"Event created successfully");
            redirectto("eventmanagement.php");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }else{
        echo "Sorry, there was an error uploading your file.";
    }
}


?>
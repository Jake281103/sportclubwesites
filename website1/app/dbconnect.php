<?php

// Using PDO  (PHP Data object); 

// database host 
$dbhost = "localhost";
// database user name
$dbuser = "root";
// database password
$dbpass = "mydbserver2025";
// database name
$dbname = "aus";

try {
    // connection with database by PDO
    $conn = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
    // echo "success";
} catch (PDOException $e) {
    echo "Error Found : " . $e->getMessage();
}

?>
<?php

// Using PDO  (PHP Data object); 

function connect(){
    $server = "localhost"; // database server name or ip
    $user = "root"; // database user account name
    $password = "mydbserver2025"; // database account passsword
    $databasename = "aus";  // database name

    try{
        $conn = new PDO("mysql:host=$server;port=3306;dbname=$databasename", $user, $password);
        $conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // echo "connected";
        return $conn;
    }catch(PDOException $e){
        echo $e;
    }
}

?>
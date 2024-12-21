<?php

// start the session when we need to used session
session_start();

// new session creating funciton
function setsession($key,$val){
    $_SESSION[$key] = $val;
}

// to take the session value with its name
function getsession($key){
    return $_SESSION[$key];
}

// session verify function if it exists
function verifysession($key){
    return isset($_SESSION[$key]);
}

//  session delete function with its name
function unsetsession($key){
    unset($_SESSION[$key]);
}

// delete function to delete all session and used for logout
function destroyallsession(){
    session_destroy();
}

// checking function that check the users login or not
function authfailed(){
    if(!isset($_SESSION['email']) && !isset($_SESSION['password'])){
        return true;
    }
}

// redirect function
function redirectto($url){
    header("Location:$url");
}

// used for testing to print array
function formatprint(array $array){
    echo "<pre>".print_r($array,true)."</pre>";
}



?>
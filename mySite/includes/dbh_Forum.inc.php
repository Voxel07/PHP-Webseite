<?php

$servername = "localhost";
$user ="root";
$pw = "";
$dbName ="forum";

$conn2 = mysqli_connect($servername, $user, $pw, $dbName);
mysqli_set_charset($conn2,"utf8");

if(!$conn2){
    die("Verbindung fehlgeschlafen" .mysqli_connect_error($conn2));
}


?>
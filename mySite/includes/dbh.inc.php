<?php

$servername = "localhost";
$user ="root";
$pw = "";
$dbName ="wild_rovers";

$conn = mysqli_connect($servername, $user, $pw, $dbName);
mysqli_set_charset($conn,"utf8");

if(!$conn){
    die("Verbindung fehlgeschlafen" .mysqli_connect_error());
}


?>
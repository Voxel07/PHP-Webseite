<?php
// Für den Server
// $user ="Camo";
// $pw = "59ca2ca526302e38e53ee38a3a1f36d8";
// $dbName ="Wild_Rovers";

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
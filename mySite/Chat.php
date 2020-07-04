<?php
include "Header.php";
include_once "includes/dbh.inc.php";
echo' <link rel="stylesheet" href="../Styles/chat.css">';
echo'<script src="../Skripte/chat.js"></script>';
?>

<h1>Hier Entsteht der Chat client</h1>

<?php


    // $rohDaten = file_get_contents("../test2.txt");
    $rohDaten = file_get_contents("../Bilder/Begadi.jpg");
    echo $rohDaten;
    // $bildDaten = base64_encode($rohDaten); 
    $quelle = imagecreatefromstring($rohDaten); 
    $winkel = 90; 
    // $gedreht = imagerotate($quelle, $winkel, 0); // if want to rotate the image 
    $imageName = "../BildausText1.jpg"; 
    $imageSave = imagejpeg($quelle,$imageName,100); 
    imagedestroy($quelle); 

    echo' <img src="'.$imageName.'">';



$string = str_replace("/mySite/","",$_SERVER['REQUEST_URI']);
echo $string;
?>






<?php
include_once "footer.php";
?>
<?php
include "Header.php";
include_once "includes/dbh.inc.php";
echo' <link rel="stylesheet" href="../Styles/chat.css">';
echo'<script src="../Skripte/chat.js"></script>';
?>

<h1>Hier Entsteht der Chat client</h1>

<?php



$string = str_replace("/mySite/","",$_SERVER['REQUEST_URI']);
echo $string;
?>






<?php
include_once "footer.php";
?>
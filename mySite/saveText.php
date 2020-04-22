<?php

include_once "includes/dbh_Forum.inc.php";
//Orginal unsicher
$newText = $_POST['newText'];

if($newText != " "){

$sql = " UPDATE posts SET inhalt = '".$newText."' WHERE id = 98 ";

    $stmt = mysqli_stmt_init($conn2);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        exit();
    }
    else{
    
        mysqli_stmt_execute($stmt);
    }

}


?>
<?php

$MeinText = '<p onclick=funktion() onmousehover=funktion() >Hier mein Skript<script>window.promt("Hi");</script></p><div style="text-align: center;">Mitte</div><div><font color="#006eff">Farbe</font></div><div><font size="6">Größer</font></div><div><b>Fett</b></div><div><u>Unterstrichen</u></div><div><i>Kursiv</i></div><div><a href="http://google.de">Link</a></div><div style="text-align: center;"><font color="#04ff00">Alles</font> <font size="5">auf</font> <u>einmal </u><b>in </b><i>einem </i><a href="http://google.de">text</a></div>';
// $MeinText = '<p>Hier mein Skript<script>window.promt("Hi");</script></p>';

echo'<h1>Orginal:</h1> ';
echo $MeinText;
echo'<br>';
echo htmlspecialchars($MeinText); 
echo'<br>';

echo'<h1>strip:</h1>';
echo'<br>';
$test1 = strip_tags($MeinText,'<div> <font> <i> <b> <u> <a>');
echo htmlspecialchars($test1); ;

echo'<br>';
echo'<h1>replace:</h1>';
echo'<br>';
$str     = $MeinText;
$order   = array("script","onclick=","onmousehover=");
$replace = 'nein';
$test2 = str_replace($order, $replace, $str);
echo htmlspecialchars($test2); ;
?>
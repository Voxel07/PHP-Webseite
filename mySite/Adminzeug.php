<?php
include "Header.php";
include_once "includes/dbh.inc.php";
?>

<h1>Hier werden die Nutzer verwaltet</h1>

<?php

$string = str_replace("/mySite/","",$_SERVER['REQUEST_URI']);
echo $string;
echo'<br>';

$lines = file('../Logdaten/daten.txt');

$datum = array();
$zeit= array();
$temperaturen = array();
$CPU_Last = array();
$Ram = array();


 function makeString($td){
    
    if ($td['sec'][0] == 1)
        $td['sec'][1] = 'Sekunde';
    else 
        $td['sec'][1] = 'Sekunden';
    
    if ($td['min'][0] == 1)
        $td['min'][1] = 'Minute';
    else 
        $td['min'][1] = 'Minuten';
        
    if ($td['std'][0] == 1)
        $td['std'][1] = 'Stunde';
    else 
        $td['std'][1] = 'Stunden';
        
    if ($td['day'][0] == 1)
        $td['day'][1] = 'Tag';
    else 
        $td['day'][1] = 'Tage';
    
    return $td;
    
}
 function makeDifferenz($first, $second){
    
    if($first > $second)
        $td['dif'][0] = $first - $second;
    else
        $td['dif'][0] = $second - $first;
    $td['sec'][0] = $td['dif'][0] % 60; 
    $td['min'][0] = (($td['dif'][0] - $td['sec'][0]) / 60) % 60; 
    $td['std'][0] = (((($td['dif'][0] - $td['sec'][0]) /60)- 
    $td['min'][0]) / 60) % 24; 
    $td['day'][0] = floor( ((((($td['dif'][0] - $td['sec'][0]) /60)- 
    $td['min'][0]) / 60) / 24) );  
    $td = makeString($td);  
    return $td;
    
}

$i = 0;
for ($i; $i < count($lines); $i++) 
{ 
    $daten = explode("|",$lines[$i]);
    $zeit[$i] = $daten[0];
    $startDatum[$i] = $daten[1];
    $startZeit[$i] = $daten[2];
    $temperaturen[$i] = $daten[3];
    $CPU_Last[$i] = $daten[4];
    $Ram[$i] = $daten[5];
    $Festplatte = $daten[6];
}
// var_dump($daten);

$daten = explode("|",$lines[$i-1]);
$up_date = strtotime($daten[1]." ".$daten[2]);

echo'Serverzeit: '.$zeit[$i-1];

$td = makeDifferenz(time(), $up_date);
echo' Der Server ist online seit dem '.$startDatum[$i-1].' um '.$startZeit[$i-1].' Der Server ist online seit: ';
echo $td['day'][0] . ' ' . $td['day'][1] . ', ' . $td['std'][0] . ' ' . $td['std'][1] . 
', ' . $td['min'][0] . ' ' . $td['min'][1] . ', ' . $td['sec'][0] . ' ' . $td['sec'][1]; 

echo'<br>';
echo 'Server auslastung: ';
echo'<br>';
echo'CPU Auslastung: '.$CPU_Last[$i-1].'% CPU Temperatur: '.$temperaturen[$i-1].'°C<br>';
echo'Ram: '.$Ram[$i-1].'mB = '.((100/4000)*floor($Ram[$i-1])).'%<br>';
echo'Es sind '.$Festplatte.'GB Festplattenspeicher von 32 GB belegt';



?>







<?php
include_once "footer.php";
?>

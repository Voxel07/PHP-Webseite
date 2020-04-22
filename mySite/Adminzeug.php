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
    $temperaturen[$i] = $daten[3];
    $CPU_Last[$i] = $daten[4];
    $Ram[$i] = $daten[5];
}
$daten = explode("|",$lines[$i-1]);
$up_date = strtotime($daten[1]." ".$daten[2]);


$td = makeDifferenz(time(), $up_date);
echo 'Der Server ist online seit:<br>';
echo $td['day'][0] . ' ' . $td['day'][1] . ', ' . $td['std'][0] . ' ' . $td['std'][1] . 
', ' . $td['min'][0] . ' ' . $td['min'][1] . ', ' . $td['sec'][0] . ' ' . $td['sec'][1]; 

echo'<br>';
echo 'Server auslastung: ';
echo'<br>';
echo'CPU Auslastung: '.$CPU_Last[$i-1].'% CPU Temperatur: '.$temperaturen[$i-1].'°C<br>';
echo'Ram: '.$Ram[$i-1].'mB='.((100/4000)*floor($Ram[$i-1])).'%<br>';


// content="text/plain; charset=utf-8"
require_once ('jpgraph/jpgraph.php');
require_once ('jpgraph/jpgraph_line.php');

$datay1 = array(20,15,23,15);
$datay2 = array(12,9,42,8);
$datay3 = array(5,17,32,24);

// Setup the graph
$graph = new Graph(300,250);
$graph->SetScale("textlin");

$theme_class=new UniversalTheme;

$graph->SetTheme($theme_class);
$graph->img->SetAntiAliasing(false);
$graph->title->Set('Filled Y-grid');
$graph->SetBox(false);

$graph->SetMargin(40,20,36,63);

$graph->img->SetAntiAliasing();

$graph->yaxis->HideZeroLabel();
$graph->yaxis->HideLine(false);
$graph->yaxis->HideTicks(false,false);

$graph->xgrid->Show();
$graph->xgrid->SetLineStyle("solid");
$graph->xaxis->SetTickLabels(array('A','B','C','D'));
$graph->xgrid->SetColor('#E3E3E3');

// Create the first line
$p1 = new LinePlot($datay1);
$graph->Add($p1);
$p1->SetColor("#6495ED");
$p1->SetLegend('Line 1');

// Create the second line
$p2 = new LinePlot($datay2);
$graph->Add($p2);
$p2->SetColor("#B22222");
$p2->SetLegend('Line 2');

// Create the third line
$p3 = new LinePlot($datay3);
$graph->Add($p3);
$p3->SetColor("#FF1493");
$p3->SetLegend('Line 3');

$graph->legend->SetFrameWeight(1);

// Output line
$graph->Stroke();
?>







<?php
include_once "footer.php";
?>
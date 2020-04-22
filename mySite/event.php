<?php
include "Header.php";
include_once "includes/dbh.inc.php";
echo'<link rel="stylesheet" href="../Styles/style_event.css">';
?>

<div class="kom-container">
    <div class="events-liste">


<?php

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
    
    // if($first > $second)
    //     $td['dif'][0] = $first - $second;
    // else
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



$sql ="SELECT * FROM events ORDER BY datum ASC";
$stmt = mysqli_stmt_init($conn);
    
    if(!mysqli_stmt_prepare($stmt,$sql)){
        echo'Ist nicht !'.mysqli_error($conn);
        
    }
    else {
        $maxAnz = 0;
        mysqli_stmt_execute($stmt); 
        $events = mysqli_stmt_get_result($stmt);
        while ($aktEvent = mysqli_fetch_assoc($events)){

            if($maxAnz < 4){
                $td = makeDifferenz(time(), strtotime($aktEvent['datum'])); 
                echo'
                <div id="'.$aktEvent['id'].'" class="event">
                    <div class="event-name"><a href="'.$aktEvent['link'].'">'.$aktEvent['name'].'</a></div>
                    <div class="event-date">'.date("d-m-Y",strtotime($aktEvent['datum'])).'</div>
                    <div class="event-count">'.$td['day'][0] . ' ' . $td['day'][1] . ', ' . $td['std'][0] . ' ' . $td['std'][1] . 
                    ', ' . $td['min'][0] . ' ' . $td['min'][1] .'</div>
                    <div class="event-löschen">X</div>
                </div>';
            }
            $maxAnz++;

        }
    }


?>
    </div>
    <div class="events-neu">
        <form action = "includes/event_verwaltung.inc.php?herkunft=Index.php" method="post">
            <input type="text" name="ev-name" placeholder="Eventname" maxlength="30" required > 
            <!-- <label id="label-Vorname" >Eventname</label>     -->
            <input type="url" name="ev-link" placeholder="Link zur Eventseite">
            <!-- <label id="label-Vorname" >Link zur Eventseite</label>    -->
            <input type="date" name="ev-date" placeholder="Datum" maxlength="8" required >
            <!-- <label id="label-Vorname" >Datum</label>    -->
            <button type="submit" name="Neues_Event">Neues Event eintragen</button>    
        </form>
        
    </div>
    

</div>

<!-- Git test -->
    
<?php
include_once "footer.php";
?>
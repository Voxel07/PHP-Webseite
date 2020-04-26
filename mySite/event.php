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

        // Rrueckmeldung an den Nutzer ob die eingabe erfolgreich war
        if(isset($_GET['gelöscht'])){
            echo'<div class ="rueckmeldung">
                    Event '.$_GET["gelöscht"].' wurde erfolgreich gelöscht
                </div>';
        }
        elseif(isset($_GET['eigetragen'])){
            echo'<div class ="rueckmeldung">
                    Event '.$_GET["eigetragen"].' wurde erfolgreich erstellt
                </div>';
        }
        elseif(isset($_GET['update'])){
            echo'<div class ="rueckmeldung">
                    Event '.$_GET["update"].' wurde erfolgreich aktualisiert
                </div>';
        }
        
        
      

        echo'<h1 class="insetshadow">Anstehende Events</h1>';
        while ($aktEvent = mysqli_fetch_assoc($events)){

            if($maxAnz < 10){
                $td = makeDifferenz(time(), strtotime($aktEvent['datum'])); 
                echo'
                <div class="event">
                    <div class="event-name"><a href="'.$aktEvent['link'].'">'.str_replace("-"," ",$aktEvent['name']).'</a></div>
                    <div class="event-date">'.date("d:m:Y",strtotime($aktEvent['datum'])).'</div>
                    <div class="event-count">'.$td['day'][0] . ' ' . $td['day'][1] . ', ' . $td['std'][0] . ' ' . $td['std'][1] . 
                    '</div>
                    <div class="event-editieren"><a href ="includes/event_verwaltung.inc.php?edit='.$aktEvent['id'].'&name='.$aktEvent['name'].'">Editieren</a></div>
                    <div class="event-löschen"><a href ="includes/event_verwaltung.inc.php?löschen='.$aktEvent['id'].'&name='.$aktEvent['name'].'">Löschen</a></div>
                </div>';
            }
            $maxAnz++;
            
        }
    }


?>
    </div>
    <div class="events-neu">
        <form action = "includes/event_verwaltung.inc.php?herkunft=Index.php" method="post">
           
            <?php 
            if(isset($_GET["edit"])){
              
                echo'
                <input type="text" name="ev-name" value="'.str_replace("-"," ",$_SESSION["name"]).'" placeholder="Eventname" maxlength="30" required >            
                <input type="url" name="ev-link" value='.$_SESSION["link"].' placeholder="Link zur Eventseite">         
                <input type="date" name="ev-date" value='.$_SESSION["datum"].' placeholder="Datum" maxlength="8" required >  
                <input type="hidden" name="id" value='.$_SESSION['id'].' >';
                echo'<button type="submit" name="update">Event Updaten</button>';    
            }
            else {
                echo'
                <input type="text" name="ev-name" placeholder="Eventname" maxlength="30" required >            
                <input type="url" name="ev-link" placeholder="Link zur Eventseite">         
                <input type="date" name="ev-date" placeholder="Datum" maxlength="8" required >  
                <button type="submit" name="Neues_Event">Neues Event eintragen</button>';
            }
            ?>    
        </form>
        
    </div>
    

</div>
    
<?php
include_once "footer.php";
?>
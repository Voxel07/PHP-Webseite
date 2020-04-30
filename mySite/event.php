<?php
include_once "includes/dbh.inc.php";
echo'<link rel="stylesheet" href="../Styles/style_event.css">';
echo'<script src="../Skripte/events.js"></script>';
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


//Alle einträge aus der DB holen ( nach Datum sortiert)
$sql ="SELECT * FROM events ORDER BY datum ASC";
$stmt = mysqli_stmt_init($conn);
    
    if(!mysqli_stmt_prepare($stmt,$sql)){
        echo'Keine Verbindung zu DB möglich !'.mysqli_error($conn);
    }
    else {
        mysqli_stmt_execute($stmt); 
        $events = mysqli_stmt_get_result($stmt);

        // Rrueckmeldung an den Nutzer ob die eingabe erfolgreich war
        if(isset($_GET['gelöscht'])){
            echo'<div class ="rueckmeldung">
                   Das Event <strong>'.str_replace("-"," ",$_GET["gelöscht"]).'</strong> wurde erfolgreich gelöscht.
                </div>';
        }
        elseif(isset($_GET['eingetragen'])){
            echo'<div class ="rueckmeldung">
                   Das Event <strong>'.str_replace("-"," ",$_GET["eingetragen"]).'</strong>  wurde erfolgreich erstellt.
                </div>';
        }
        elseif(isset($_GET['update'])){
            echo'<div class ="rueckmeldung">
                   Das Event <strong>'.str_replace("-"," ",$_GET["update"]).'</strong> wurde erfolgreich aktualisiert.
                </div>';
        }

        //Überschrift
        echo'<h1 class="insetshadow">Anstehende Events</h1>';
        //Alle Events aus der DB
        //max Anzahl um meherer Seiten zu erstellen
        //Dynmaischens laden mit Ajax ? 
        // $maxAnz = 0;
        echo' <div class="event-header">
        <div class="event-name">Name</div>
        <div class="event-date">Datum</div>
        <div class="event-count">Countdown</div>';
      
        if(isset($_SESSION['User']))
        {
            if($_SESSION['rang']>0)
            {
                echo'        
                <div class="event-ausklappen" onclick="eventAusklappen()"><svg class="svg-icon" viewBox="0 0 20 20">
                    <path fill="none" d="M10,1.344c-4.781,0-8.656,3.875-8.656,8.656c0,4.781,3.875,8.656,8.656,8.656c4.781,0,8.656-3.875,8.656-8.656C18.656,5.219,14.781,1.344,10,1.344z M10,17.903c-4.365,0-7.904-3.538-7.904-7.903S5.635,2.096,10,2.096S17.903,5.635,17.903,10S14.365,17.903,10,17.903z M13.388,9.624H6.613c-0.208,0-0.376,0.168-0.376,0.376s0.168,0.376,0.376,0.376h6.775c0.207,0,0.377-0.168,0.377-0.376S13.595,9.624,13.388,9.624z"></path></svg>
                </div>
                <div class="event-einklappen" onclick="eventEinklappen()"></div>';
            }
        }
        echo'</div> 
        <div class="event-liste">';
        while ($aktEvent = mysqli_fetch_assoc($events))
        {
            // if($maxAnz < 10){
                $td = makeDifferenz(time(), strtotime($aktEvent['datum'])); 
                echo'
                <div class="event">
                    <div class="event-name"><a href="'.$aktEvent['link'].'">'.str_replace("-"," ",$aktEvent['name']).'</a></div>
                    <div class="event-date">'.date("d:m:Y",strtotime($aktEvent['datum'])).'</div>
                    <div class="event-count">'.$td['day'][0] . ' ' . $td['day'][1] . ', ' . $td['std'][0] . ' ' . $td['std'][1] .'</div>';
                //Edit und löschen nur für Mitglieder
                if(isset($_SESSION['User'])){
                    if($_SESSION['rang']>0){
                        
                        echo'
                        <div class="event-editieren druecker"><a href ="includes/event_verwaltung.inc.php?edit='.$aktEvent['id'].'&name='.$aktEvent['name'].'"><svg class="svg-icon" viewBox="0 0 20 20">
                        <path fill="white" d="M10.032,8.367c-1.112,0-2.016,0.905-2.016,2.018c0,1.111,0.904,2.014,2.016,2.014c1.111,0,2.014-0.902,2.014-2.014C12.046,9.271,11.143,8.367,10.032,8.367z M10.032,11.336c-0.525,0-0.953-0.427-0.953-0.951c0-0.526,0.427-0.955,0.953-0.955c0.524,0,0.951,0.429,0.951,0.955C10.982,10.909,10.556,11.336,10.032,11.336z"></path>
                        <path fill="white" d="M17.279,8.257h-0.785c-0.107-0.322-0.237-0.635-0.391-0.938l0.555-0.556c0.208-0.208,0.208-0.544,0-0.751l-2.254-2.257c-0.199-0.2-0.552-0.2-0.752,0l-0.556,0.557c-0.304-0.153-0.617-0.284-0.939-0.392V3.135c0-0.294-0.236-0.532-0.531-0.532H8.435c-0.293,0-0.531,0.237-0.531,0.532v0.784C7.582,4.027,7.269,4.158,6.966,4.311L6.409,3.754c-0.1-0.1-0.234-0.155-0.376-0.155c-0.141,0-0.275,0.055-0.375,0.155L3.403,6.011c-0.208,0.207-0.208,0.543,0,0.751l0.556,0.556C3.804,7.622,3.673,7.935,3.567,8.257H2.782c-0.294,0-0.531,0.238-0.531,0.531v3.19c0,0.295,0.237,0.531,0.531,0.531h0.787c0.105,0.318,0.236,0.631,0.391,0.938l-0.556,0.559c-0.208,0.207-0.208,0.545,0,0.752l2.254,2.254c0.208,0.207,0.544,0.207,0.751,0l0.558-0.559c0.303,0.154,0.616,0.285,0.938,0.391v0.787c0,0.293,0.238,0.531,0.531,0.531h3.191c0.295,0,0.531-0.238,0.531-0.531v-0.787c0.322-0.105,0.636-0.236,0.938-0.391l0.56,0.559c0.208,0.205,0.546,0.207,0.752,0l2.252-2.254c0.208-0.207,0.208-0.545,0.002-0.752l-0.559-0.559c0.153-0.303,0.285-0.615,0.389-0.938h0.789c0.295,0,0.532-0.236,0.532-0.531v-3.19C17.812,8.495,17.574,8.257,17.279,8.257z M16.747,11.447h-0.653c-0.241,0-0.453,0.164-0.514,0.398c-0.129,0.496-0.329,0.977-0.594,1.426c-0.121,0.209-0.089,0.473,0.083,0.645l0.463,0.465l-1.502,1.504l-0.465-0.463c-0.174-0.174-0.438-0.207-0.646-0.082c-0.447,0.262-0.927,0.463-1.427,0.594c-0.234,0.061-0.397,0.271-0.397,0.514V17.1H8.967v-0.652c0-0.242-0.164-0.453-0.397-0.514c-0.5-0.131-0.98-0.332-1.428-0.594c-0.207-0.123-0.472-0.09-0.646,0.082l-0.463,0.463L4.53,14.381l0.461-0.463c0.169-0.172,0.204-0.434,0.083-0.643c-0.266-0.461-0.467-0.939-0.596-1.43c-0.06-0.234-0.272-0.398-0.514-0.398H3.313V9.319h0.652c0.241,0,0.454-0.162,0.514-0.397c0.131-0.498,0.33-0.979,0.595-1.43c0.122-0.208,0.088-0.473-0.083-0.645L4.53,6.386l1.503-1.504l0.46,0.462c0.173,0.172,0.437,0.204,0.646,0.083c0.45-0.265,0.931-0.464,1.433-0.597c0.233-0.062,0.396-0.274,0.396-0.514V3.667h2.128v0.649c0,0.24,0.161,0.452,0.396,0.514c0.502,0.133,0.982,0.333,1.433,0.597c0.211,0.12,0.475,0.089,0.646-0.083l0.459-0.462l1.504,1.504l-0.463,0.463c-0.17,0.171-0.202,0.438-0.081,0.646c0.263,0.448,0.463,0.928,0.594,1.427c0.061,0.235,0.272,0.397,0.514,0.397h0.651V11.447z"></path>
                        </svg></a></div>
                        <div class="event-löschen"><a href ="includes/event_verwaltung.inc.php?löschen='.$aktEvent['id'].'&name='.$aktEvent['name'].'"><svg class="svg-icon" viewBox="0 0 20 20">
                        <path fill="red" d="M13.864,6.136c-0.22-0.219-0.576-0.219-0.795,0L10,9.206l-3.07-3.07c-0.219-0.219-0.575-0.219-0.795,0c-0.219,0.22-0.219,0.576,0,0.795L9.205,10l-3.07,3.07c-0.219,0.219-0.219,0.574,0,0.794c0.22,0.22,0.576,0.22,0.795,0L10,10.795l3.069,3.069c0.219,0.22,0.575,0.22,0.795,0c0.219-0.22,0.219-0.575,0-0.794L10.794,10l3.07-3.07C14.083,6.711,14.083,6.355,13.864,6.136z M10,0.792c-5.086,0-9.208,4.123-9.208,9.208c0,5.085,4.123,9.208,9.208,9.208s9.208-4.122,9.208-9.208C19.208,4.915,15.086,0.792,10,0.792z M10,18.058c-4.451,0-8.057-3.607-8.057-8.057c0-4.451,3.606-8.057,8.057-8.057c4.449,0,8.058,3.606,8.058,8.057C18.058,14.45,14.449,18.058,10,18.058z"></path>
                        </svg></a></div>';
                    }
                }
               echo'
                </div>';//Event zu
            // }
            // $maxAnz++;      
        }
        echo'</div>'; //Eventliste zu
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
?>
     </div><!--Event Liste zu -->
    <div id="eventSchalter" class="events-neu">
        <form action = "includes/event_verwaltung.inc.php?herkunft=Index.php" method="post">
           
            <?php 
            //Wenn ein Element bearbeitet werden soll
            if(isset($_GET["edit"])){
              
                echo'
                <script>eventAusklappen()</script>
                <div class="mantel">   
                <div class="ev-input-text">
                <input type="text" name="ev-name" value="'.str_replace("-"," ",$_SESSION["name"]).'" placeholder="Eventname" maxlength="30" required />
                    <label >Eventname</label>    
                </div>
                <div class="ev-input-text">
                <input type="url" name="ev-link" value="'.$_SESSION["link"].'" placeholder="Link zur Eventseite"/> 
                    <label >Link zur Eventseite</label>    
                </div>
                <div class="ev-input-date">
                <input type="date" name="ev-date" value="'.$_SESSION["datum"].'" placeholder="Datum" maxlength="8" required /> 
                    <label >Datum</label>    
                </div>   
                <input type="hidden" name="id" value="'.$_SESSION['id'].'" >
                <div class="ev-button-update">
                <button type="submit" name="update" ></button>
                </div>
               </div>';
               
            }
            //Standardt 
            else {
                echo'
               <div class="mantel">   
                <div class="ev-input-text">
                    <input type="text" name="ev-name" placeholder="Eventname" maxlength="30" required />
                    <label >Eventname</label>    
                </div>
                <div class="ev-input-text">
                    <input type="url" name="ev-link" placeholder="Link zur Eventseite" />
                    <label >Link zur Eventseite</label>    
                </div>
                <div class="ev-input-date">
                    <input type="date" name="ev-date" placeholder="Datum" maxlength="8" required  />
                    <label >Datum</label>    
                </div>   
                <div class="ev-button-neu">
                <button type="submit" name="Neues_Event"></button>
                </div>
               </div>'; 
            }
            ?>    
        </form>
        
    </div>
    

</div>

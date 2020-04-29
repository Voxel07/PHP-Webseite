<?php
include "Header.php";
include_once "includes/dbh.inc.php";
echo'<link rel="stylesheet" href="../Styles/style_Mitglieder.css">';
?>
<div class="Das_Team">

    <div>
        <h2> GESCHICHTE: </h2>
        <p class="mitglieder"> Das Team Wild Rovers Württemberg gibt es jetzt schon seit Mitte 2006 damals als TSAT – BW gegründet. Unter diesem Namen habt ihr uns bestimmt auch schonmal angetroffen. Nach einem Jahrzehnt Airsoft auf den verschiedensten Events und Spielfeldern hat das sich das Team stark verändert. Auf der einen Seite ist das Team stark gewachsen und hat viele junge Mitglieder gewonnen. Auf der anderen Seite hat ein Großteil des Gründungsteams sich anderen Hobbys zugewendet. Um nicht in der Vergangenheit hängen zu bleiben, wurde es Zeit, den alten Relikten lebewohl zu sagen. 
                Ein neuer Name, ein neues Logo und eine Fusion mit unseren langjährigen Freunden und Partnerteam Legion Esslingen 1 später, waren die Wild Rovers geboren. </p>          

        <h2> Aktuelles: </h2> 
            <p class="mitglieder">Aktuell haben wir 30 Mitglieder und 3 Frischlinge ( Anwärter ). Wir kommen aus den unterschiedlichsten Ecken aus Deutschland. Der Hauptteil des Teams ist aber im Großraum Esslingen / Stuttgart zu finden. In den letzten Jahren haben wir viele neue junge Mitglieder dazugewonnen, dennoch ist von 18 bis 34 Jahren alles dabei.               
                Solltet ihr ein Team suchen oder ihr wollt uns näher kennen lernen, findet ihr alle weiteren Infos findet ihr unter dem Reiter Infos/Regeln.</p>       
    </div>
    <div><h2>Mitglieder: </h2></div>
</div>
    <?php

    $sql = "SELECT Nick, Profielbild, Rang, Geburtstag, Reg_Datum FROM nutzer";
    $ergebnis = mysqli_query($conn,$sql);
    if(mysqli_num_rows($ergebnis)>0){
        echo'
        <div class="mitglieder-statistik">
            <div class="statistik anzahl">
                <div class="statistik-svg"><svg class="svg-icon" viewBox="0 0 20 20">
                    <path d="M17.431,2.156h-3.715c-0.228,0-0.413,0.186-0.413,0.413v6.973h-2.89V6.687c0-0.229-0.186-0.413-0.413-0.413H6.285c-0.228,0-0.413,0.184-0.413,0.413v6.388H2.569c-0.227,0-0.413,0.187-0.413,0.413v3.942c0,0.228,0.186,0.413,0.413,0.413h14.862c0.228,0,0.413-0.186,0.413-0.413V2.569C17.844,2.342,17.658,2.156,17.431,2.156 M5.872,17.019h-2.89v-3.117h2.89V17.019zM9.587,17.019h-2.89V7.1h2.89V17.019z M13.303,17.019h-2.89v-6.651h2.89V17.019z M17.019,17.019h-2.891V2.982h2.891V17.019z"></path>
                </svg></div>
                <div class="statistik-info">'.mysqli_num_rows($ergebnis).' Mitglieder</div>
            </div>
            <div class="statistik alter">
                <div class="statistik-svg"><svg class="svg-icon" viewBox="0 0 20 20">
                    <path d="M16.557,4.467h-1.64v-0.82c0-0.225-0.183-0.41-0.409-0.41c-0.226,0-0.41,0.185-0.41,0.41v0.82H5.901v-0.82c0-0.225-0.185-0.41-0.41-0.41c-0.226,0-0.41,0.185-0.41,0.41v0.82H3.442c-0.904,0-1.64,0.735-1.64,1.639v9.017c0,0.904,0.736,1.64,1.64,1.64h13.114c0.904,0,1.64-0.735,1.64-1.64V6.106C18.196,5.203,17.461,4.467,16.557,4.467 M17.377,15.123c0,0.453-0.366,0.819-0.82,0.819H3.442c-0.453,0-0.82-0.366-0.82-0.819V8.976h14.754V15.123z M17.377,8.156H2.623V6.106c0-0.453,0.367-0.82,0.82-0.82h1.639v1.23c0,0.225,0.184,0.41,0.41,0.41c0.225,0,0.41-0.185,0.41-0.41v-1.23h8.196v1.23c0,0.225,0.185,0.41,0.41,0.41c0.227,0,0.409-0.185,0.409-0.41v-1.23h1.64c0.454,0,0.82,0.367,0.82,0.82V8.156z"></path>
                </svg></div>
                <div class="statistik-info">18-32 Jahre</div>
            </div>
            <div class="statistik neu">
                <div class="statistik-svg"><svg class="svg-icon" viewBox="0 0 20 20">
                    <path d="M12.075,10.812c1.358-0.853,2.242-2.507,2.242-4.037c0-2.181-1.795-4.618-4.198-4.618S5.921,4.594,5.921,6.775c0,1.53,0.884,3.185,2.242,4.037c-3.222,0.865-5.6,3.807-5.6,7.298c0,0.23,0.189,0.42,0.42,0.42h14.273c0.23,0,0.42-0.189,0.42-0.42C17.676,14.619,15.297,11.677,12.075,10.812 M6.761,6.775c0-2.162,1.773-3.778,3.358-3.778s3.359,1.616,3.359,3.778c0,2.162-1.774,3.778-3.359,3.778S6.761,8.937,6.761,6.775 M3.415,17.69c0.218-3.51,3.142-6.297,6.704-6.297c3.562,0,6.486,2.787,6.705,6.297H3.415z"></path>
                </svg></div>
                <div class="statistik-info">Speckhut</div>
            </div>
        </div>';

    echo'<div class="mitglieder-containter">';
        while($row = mysqli_fetch_assoc($ergebnis)){
        
            $rang = $row['Rang'];
            $nick = $row['Nick'];
            $geburtstag = $row['Geburtstag'];
            $profielbildGesetzt = $row['Profielbild'];

            //Tag und Monat des Geburztages Herausfinden
            $gebTag =  date("d", $geburtstag);
            $gebMonat =  date("m", $geburtstag);
            $alter = floor((date("Ymd") - date("Ymd", $geburtstag)) / 10000);

            //Tag und Monat aktuell herausfinden für den Vergleich
            $timestamp = time();
            $aktTag =  date("d", $timestamp);
            $aktMonat =  date("m", $timestamp);
  
            
            switch($row['Rang']){
                case 0: $rang = "nix";
                  break;
                case 1: $rang = 'Mitglied';
                 break;
                case 2: $rang = 'Sponsor';
                  break;
                case 3: $rang = 'Vorstand';
                  break;
                case 4: $rang = 'Vorstand | Admin';
                  break;
                default: $rang = "N/A";
                    break;   
               }
            
    echo'
        
            <div class="mitglied-box">';
                if($profielbildGesetzt == true){
                    // Hier muss noch auf verschiednen Bildformate geachtet werden
                    // Vielleicht mit einem Feld "Profielbild_Bezeichnung" in der DB in der der Name steht
                    echo' <div class="mitglied-bild" style="background-image: url(../Bilder/Mitglieder/'.$nick.'.PNG);"></div>';
                }
                else{
                    echo' <div class="mitglied-bild" style="background-image: url(../Bilder/Mitglieder/Logo.png);"></div>';
                }
                 echo'
                <div class="mitglied-text">
                    <!-- Nick -->
                    <div class="mitglied-info-box">
                        <div class="mitglied-svg"><svg class="svg-icon" viewBox="0 0 20 20">
                            <path d="M12.075,10.812c1.358-0.853,2.242-2.507,2.242-4.037c0-2.181-1.795-4.618-4.198-4.618S5.921,4.594,5.921,6.775c0,1.53,0.884,3.185,2.242,4.037c-3.222,0.865-5.6,3.807-5.6,7.298c0,0.23,0.189,0.42,0.42,0.42h14.273c0.23,0,0.42-0.189,0.42-0.42C17.676,14.619,15.297,11.677,12.075,10.812 M6.761,6.775c0-2.162,1.773-3.778,3.358-3.778s3.359,1.616,3.359,3.778c0,2.162-1.774,3.778-3.359,3.778S6.761,8.937,6.761,6.775 M3.415,17.69c0.218-3.51,3.142-6.297,6.704-6.297c3.562,0,6.486,2.787,6.705,6.297H3.415z"></path>
                        </svg></div>
                        <div class="mitglied-info">'.$nick.'</div>
                    </div>
                    <!-- Alter -->
                    <div class="mitglied-info-box">
                        <div class="mitglied-svg"><svg class="svg-icon" viewBox="0 0 20 20">
                            <path d="M16.557,4.467h-1.64v-0.82c0-0.225-0.183-0.41-0.409-0.41c-0.226,0-0.41,0.185-0.41,0.41v0.82H5.901v-0.82c0-0.225-0.185-0.41-0.41-0.41c-0.226,0-0.41,0.185-0.41,0.41v0.82H3.442c-0.904,0-1.64,0.735-1.64,1.639v9.017c0,0.904,0.736,1.64,1.64,1.64h13.114c0.904,0,1.64-0.735,1.64-1.64V6.106C18.196,5.203,17.461,4.467,16.557,4.467 M17.377,15.123c0,0.453-0.366,0.819-0.82,0.819H3.442c-0.453,0-0.82-0.366-0.82-0.819V8.976h14.754V15.123z M17.377,8.156H2.623V6.106c0-0.453,0.367-0.82,0.82-0.82h1.639v1.23c0,0.225,0.184,0.41,0.41,0.41c0.225,0,0.41-0.185,0.41-0.41v-1.23h8.196v1.23c0,0.225,0.185,0.41,0.41,0.41c0.227,0,0.409-0.185,0.409-0.41v-1.23h1.64c0.454,0,0.82,0.367,0.82,0.82V8.156z"></path>
                        </svg></div>
                        <div class="mitglied-info">'.$alter.' Jahre</div>';
                        if(isset($_SESSION['User'])&&$_SESSION['rang']>=1){
                            if($gebTag==$aktTag&&$gebMonat==$aktMonat){
                                echo'<div class="mitglied-svg" style="background-image: url(../Bilder/SVG/Geburtstag.svg);"></div>';
                            }
                        }
                        echo'
                    </div>
                    <!-- Status -->
                    <div class="mitglied-info-box">
                        <div class="mitglied-svg"><svg class="svg-icon" viewBox="0 0 20 20">
                            <path d="M15.94,10.179l-2.437-0.325l1.62-7.379c0.047-0.235-0.132-0.458-0.372-0.458H5.25c-0.241,0-0.42,0.223-0.373,0.458l1.634,7.376L4.06,10.179c-0.312,0.041-0.446,0.425-0.214,0.649l2.864,2.759l-0.724,3.947c-0.058,0.315,0.277,0.554,0.559,0.401l3.457-1.916l3.456,1.916c-0.419-0.238,0.56,0.439,0.56-0.401l-0.725-3.947l2.863-2.759C16.388,10.604,16.254,10.22,15.94,10.179M10.381,2.778h3.902l-1.536,6.977L12.036,9.66l-1.655-3.546V2.778z M5.717,2.778h3.903v3.335L7.965,9.66L7.268,9.753L5.717,2.778zM12.618,13.182c-0.092,0.088-0.134,0.217-0.11,0.343l0.615,3.356l-2.938-1.629c-0.057-0.03-0.122-0.048-0.184-0.048c-0.063,0-0.128,0.018-0.185,0.048l-2.938,1.629l0.616-3.356c0.022-0.126-0.019-0.255-0.11-0.343l-2.441-2.354l3.329-0.441c0.128-0.017,0.24-0.099,0.295-0.215l1.435-3.073l1.435,3.073c0.055,0.116,0.167,0.198,0.294,0.215l3.329,0.441L12.618,13.182z"></path>
                        </svg></div>
                        <div class="mitglied-info">'.$rang.'</div>
                    </div>
                    <!-- Email -->
                    <div class="mitglied-info-box">
                        <div class="mitglied-svg"><svg class="svg-icon" viewBox="0 0 20 20">
                            <path d="M17.388,4.751H2.613c-0.213,0-0.389,0.175-0.389,0.389v9.72c0,0.216,0.175,0.389,0.389,0.389h14.775c0.214,0,0.389-0.173,0.389-0.389v-9.72C17.776,4.926,17.602,4.751,17.388,4.751 M16.448,5.53L10,11.984L3.552,5.53H16.448zM3.002,6.081l3.921,3.925l-3.921,3.925V6.081z M3.56,14.471l3.914-3.916l2.253,2.253c0.153,0.153,0.395,0.153,0.548,0l2.253-2.253l3.913,3.916H3.56z M16.999,13.931l-3.921-3.925l3.921-3.925V13.931z"></path>
                        </svg></div>
                        <div class="mitglied-info">'.$nick.'@wildrovers.de</div>
                    </div>
                </div>
            </div>';
       
        
        } 
        echo'</div>';
    }
    else{
        echo'<h2>Diese Seite hat keine Nutzer</h2>';
    }


    ?>

    <?php
$meingb = 797205600;
    
   $alter = floor((date("Ymd") - date("Ymd", $meingb)) / 10000);
    


    echo $alter;

  
  
    ?>

    



<?php
include_once "footer.php"
?>
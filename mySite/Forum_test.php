<?php
include "Header.php";

echo'<link rel="stylesheet" href="../Styles/style_Forum.css">';
?>
<!-- 
1. Funktion: Posts aus der DB holen und mit den ungelesenen des Nutzers abgleichen. Ungelesene Farblich markieren
2. Funktion: Wenn ein Nutzer einen Post gelesen hat. Die DB Updaten und den Post aus ungel.. entfernen
3. Funktion: Wenn ein neuer Post erstellt wird, bei allen Nutzern außer dem Ersteller den Post in ungel.. hinzufügen
4. Funktion: Wenn sich ein neuer Nutzer Regestriert, alle ID´s der Posts aus der DB holen und in ungelesen packen.
 -->

 <?php
 //Performance Testing
function microtime_float()
{
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}
$time_start = microtime_float();

#code....
$time_end = microtime_float();
$time = $time_end - $time_start;

//Villeicht DB klasse
//Funktionen
//SQL mit prepared Statements

function dbVerbinden($db){
    //DB´s die es geben soll.
    //Nuter -> Anmeldedaten und Private Daten (Sicher)
    //Aktivitäten -> Alles was der Nutzer auf der Seite macht Gallerie / Forum
    //Gallerie -> ..Bilder und so
    //Forum -> Kategorien/Tehmen/Posts/Antworten
    $dbName = $db;
    $servername = "localhost";
    $user ="root";
    $pw = "";
    // $dbName ="wild_rovers";
    //Verbindung zu DB aufbauen
    $link = mysqli_connect($servername, $user, $pw, $dbName);
    mysqli_set_charset($link,"utf8");

    if(!$link){
    die("Verbindung fehlgeschlagen" .mysqli_connect_error());
    }
    return $link;
}

function dbLesen($dbName,$tabel,$ausWahl="*",$spalte="0",$kriterium="0"){
    $conn = dbVerbinden($dbName);
    $stmt = mysqli_stmt_init($conn);
    //Art des lesezugriffs herausfinden
    //Alles
    if($ausWahl=='*'){
        $sql="SELECT ".$ausWahl." FROM ".$tabel." ";   
    }
    //Speziell
    else{
        $sql = "SELECT ".$ausWahl." FROM ".$tabel." WHERE ".$spalte." = ? ";
    }
    //Befehl vorbereiten
    if(!mysqli_stmt_prepare($stmt,$sql)){
        echo" sql fehler ". mysqli_error($conn);
        // header("Location: index.php?error=sql_lesen".mysqli_error($conn));
        exit();
    }
    else{
        //zusätzliche Parameter binden 
        if($ausWahl != '*'){
        mysqli_stmt_bind_param($stmt,"s",$kriterium);
        }
        //Befehl ausführen
        mysqli_stmt_execute($stmt);
        //Ergebnis speichern
        $erg = mysqli_stmt_get_result($stmt);
    }
    return $erg; //Ergebnis zurückgeben
    mysqli_free_result($erg); //Ergebnis frei machen
    mysqli_close($conn); //Verbindung zur DB schließen
}
   

function dbUpdate($dbName,$tabel,$spalteZumUpdaten,$neuerWert,$reiheZumUpdaten,$kriterium){
    $conn = dbVerbinden($dbName);
    $stmt = mysqli_stmt_init($conn);
    $sql = "UPDATE ".$tabel." SET ".$spalteZumUpdaten." =? WHERE ".$reiheZumUpdaten." = ?";
    //Befehl vorbereiten
    if(!mysqli_stmt_prepare($stmt,$sql)){
        echo" sql fehler update ". mysqli_error($conn);
        // header("Location: index.php?error=sql_update".mysqli_error($conn));
        exit();
    }
    else{
        if(gettype($neuerWert)=="array")
        {
            $arrTostr = implode(",",$neuerWert);
            mysqli_stmt_bind_param($stmt,"ss",$arrTostr,$kriterium);
        }
        else{
            mysqli_stmt_bind_param($stmt,"ss",$neuerWert,$kriterium);
        }
        //Befehl ausführen
        mysqli_stmt_execute($stmt);
    }
    mysqli_close($conn); //Verbindung zur DB schließen
}

//Geht nicht
function dbEinfügen($dbName,$tabel,$spalten,$werte){
    $conn = dbVerbinden($dbName);
    $stmt = mysqli_stmt_init($conn);

    switch (count($spalten)) {
        case 1:
             $sql = "INSERT INTO ".$tabel." (".implode(",",$spalten).") VALUES (?)";
            break;
        case 2:
             $sql = "INSERT INTO ".$tabel." (".implode(",",$spalten).") VALUES (?,?)";
            break;
        case 3:
             $sql = "INSERT INTO ".$tabel." (".implode(",",$spalten).") VALUES (?,?,?)";
            break;
        
        default:
           echo'Das sollte nicht gehen';
            break;
    }
    echo $sql;

    if(!mysqli_stmt_prepare($stmt,$sql)){
        echo" sql fehler ". mysqli_error($conn);
        // header("Location: index.php?error=sql_update".mysqli_error($conn));
        exit();
    }
    else{
        $arrTostr = '"'.implode('","',$werte).'"';
        echo $arrTostr;
        //zusätzliche Parameter binden 
        switch (count($spalten)) {
            case 1:
                  mysqli_stmt_bind_param($stmt,"s",$arrTostr);
                break;
            case 2:
                   mysqli_stmt_bind_param($stmt,"ss",$arrTostr);
                break;
            case 3:
                  mysqli_stmt_bind_param($stmt,"sss",$kriterium);
                break;
            
            default:
               echo'Das sollte nicht gehen';
                break;
        }
        //Befehl ausführen
        mysqli_stmt_execute($stmt);
    }
    
    mysqli_close($conn); //Verbindung zur DB schließen
}
 ?>
<div class ="übersicht-box">
    <p>Hier siehst du alle Post welche du noch nicht gesehen hast</p>
    <?php
    $posts= dbLesen("forum","posts");
    $ung = mysqli_fetch_assoc(dbLesen("wild_rovers","nutzer","ungelesen_Beiträge","Nick","Camo"))['ungelesen_Beiträge'];
    
    echo $ung; //string
    $nichtGelesen = explode(",",$ung); //array

// if(strlen($ung)!=0){
    $i = 0;
    foreach ($posts as $aktposts) {
        if($i%2==0)
        {
            echo'<div style="background-color:grey"; class="übersicht-post">'; 
        }
        else{
            echo'<div style="background-color:lightgrey"; class= "übersicht-post">';  
        }
        if(in_Array($aktposts['id'],$nichtGelesen)){
            echo'<div class="svg-box">
                <svg class="svg-icon" viewBox="0 0 20 20">
                <path fill="black" d="M8.652,16.404c-0.186,0-0.337,0.151-0.337,0.337v2.022c0,0.186,0.151,0.337,0.337,0.337s0.337-0.151,0.337-0.337v-2.022C8.989,16.555,8.838,16.404,8.652,16.404z"></path>
                <path fill="black" d="M11.348,16.404c-0.186,0-0.337,0.151-0.337,0.337v2.022c0,0.186,0.151,0.337,0.337,0.337s0.337-0.151,0.337-0.337v-2.022C11.685,16.555,11.535,16.404,11.348,16.404z"></path>
                <path fill="red" d="M17.415,5.281V4.607c0-2.224-1.847-4.045-4.103-4.045H10H6.687c-2.256,0-4.103,1.82-4.103,4.045v0.674H10H17.415z"></path>
                <path fill="red" d="M18.089,10.674V7.304c0,0,0-0.674-0.674-0.674V5.955H10H2.585v0.674c-0.674,0-0.674,0.674-0.674,0.674v3.371c-0.855,0.379-1.348,1.084-1.348,2.022c0,1.253,2.009,3.008,2.009,3.371c0,2.022,1.398,3.371,3.436,3.371c0.746,0,1.43-0.236,1.98-0.627c-0.001-0.016-0.009-0.03-0.009-0.047v-2.022c0-0.372,0.303-0.674,0.674-0.674c0.301,0,0.547,0.201,0.633,0.474h0.041v-0.137c0-0.372,0.303-0.674,0.674-0.674s0.674,0.302,0.674,0.674v0.137h0.041c0.086-0.273,0.332-0.474,0.633-0.474c0.371,0,0.674,0.302,0.674,0.674v2.022c0,0.016-0.008,0.03-0.009,0.047c0.55,0.391,1.234,0.627,1.98,0.627c2.039,0,3.436-1.348,3.436-3.371c0-0.362,2.009-2.118,2.009-3.371C19.438,11.758,18.944,11.053,18.089,10.674z M5.618,18.089c-0.558,0-1.011-0.453-1.011-1.011s0.453-1.011,1.011-1.011s1.011,0.453,1.011,1.011S6.177,18.089,5.618,18.089z M6.629,13.371H5.474c-0.112,0-0.192-0.061-0.192-0.135c0-0.074,0.08-0.151,0.192-0.174l1.156-0.365V13.371z M8.652,12.521c-0.394,0.163-0.774,0.366-1.148,0.55c-0.061,0.03-0.132,0.052-0.2,0.076v-0.934c0.479-0.411,0.906-0.694,1.348-0.879V12.521z M5.281,10c-1.348,0-1.348-2.696-1.348-2.696h5.393C9.326,7.304,6.629,10,5.281,10z M10.674,12.296c-0.22-0.053-0.444-0.084-0.674-0.084s-0.454,0.032-0.674,0.084v-1.168C9.539,11.086,9.762,11.06,10,11.05c0.238,0.01,0.461,0.036,0.674,0.078V12.296z M12.696,13.146c-0.068-0.024-0.14-0.046-0.2-0.076c-0.374-0.184-0.754-0.386-1.148-0.55v-1.188c0.442,0.185,0.87,0.467,1.348,0.879V13.146zM14.382,18.089c-0.558,0-1.011-0.453-1.011-1.011s0.453-1.011,1.011-1.011c0.558,0,1.011,0.453,1.011,1.011S14.94,18.089,14.382,18.089z M13.371,13.371v-0.674l1.156,0.365c0.112,0.022,0.192,0.099,0.192,0.174c0,0.074-0.08,0.135-0.192,0.135H13.371z M14.719,10c-1.348,0-4.045-2.696-4.045-2.696h5.393C16.067,7.304,16.067,10,14.719,10z"></path>
                <path fill="black" d="M10,16.067c-0.186,0-0.337,0.151-0.337,0.337V19.1c0,0.186,0.151,0.337,0.337,0.337s0.337-0.151,0.337-0.337v-2.696C10.337,16.218,10.186,16.067,10,16.067z"></path>
                </svg>
            </div>';
            echo'<div class="titel-box">
                <a href = "#" onclick=ungelesenePostsUpdaten('.$aktposts['id'].')>'.$aktposts['post'].' </a> 
            </div>';
            echo'<div class="autor-box">
                '.$aktposts['ersteller'].'
            </div>';  
            echo'<div class="thema-box">
            '.$aktposts['zugThema'].'
            </div>';
            echo'<div class="antworten-box">
                Antworten: '.$aktposts['anzAntworten'].'
            </div>';
            echo'</div>';         
        }
        else{
            echo'<div class="svg-box">
                <svg class="svg-icon" viewBox="0 0 20 20">
                <path fill="black" d="M8.652,16.404c-0.186,0-0.337,0.151-0.337,0.337v2.022c0,0.186,0.151,0.337,0.337,0.337s0.337-0.151,0.337-0.337v-2.022C8.989,16.555,8.838,16.404,8.652,16.404z"></path>
                <path fill="black" d="M11.348,16.404c-0.186,0-0.337,0.151-0.337,0.337v2.022c0,0.186,0.151,0.337,0.337,0.337s0.337-0.151,0.337-0.337v-2.022C11.685,16.555,11.535,16.404,11.348,16.404z"></path>
                <path fill="white" d="M17.415,5.281V4.607c0-2.224-1.847-4.045-4.103-4.045H10H6.687c-2.256,0-4.103,1.82-4.103,4.045v0.674H10H17.415z"></path>
                <path fill="white" d="M18.089,10.674V7.304c0,0,0-0.674-0.674-0.674V5.955H10H2.585v0.674c-0.674,0-0.674,0.674-0.674,0.674v3.371c-0.855,0.379-1.348,1.084-1.348,2.022c0,1.253,2.009,3.008,2.009,3.371c0,2.022,1.398,3.371,3.436,3.371c0.746,0,1.43-0.236,1.98-0.627c-0.001-0.016-0.009-0.03-0.009-0.047v-2.022c0-0.372,0.303-0.674,0.674-0.674c0.301,0,0.547,0.201,0.633,0.474h0.041v-0.137c0-0.372,0.303-0.674,0.674-0.674s0.674,0.302,0.674,0.674v0.137h0.041c0.086-0.273,0.332-0.474,0.633-0.474c0.371,0,0.674,0.302,0.674,0.674v2.022c0,0.016-0.008,0.03-0.009,0.047c0.55,0.391,1.234,0.627,1.98,0.627c2.039,0,3.436-1.348,3.436-3.371c0-0.362,2.009-2.118,2.009-3.371C19.438,11.758,18.944,11.053,18.089,10.674z M5.618,18.089c-0.558,0-1.011-0.453-1.011-1.011s0.453-1.011,1.011-1.011s1.011,0.453,1.011,1.011S6.177,18.089,5.618,18.089z M6.629,13.371H5.474c-0.112,0-0.192-0.061-0.192-0.135c0-0.074,0.08-0.151,0.192-0.174l1.156-0.365V13.371z M8.652,12.521c-0.394,0.163-0.774,0.366-1.148,0.55c-0.061,0.03-0.132,0.052-0.2,0.076v-0.934c0.479-0.411,0.906-0.694,1.348-0.879V12.521z M5.281,10c-1.348,0-1.348-2.696-1.348-2.696h5.393C9.326,7.304,6.629,10,5.281,10z M10.674,12.296c-0.22-0.053-0.444-0.084-0.674-0.084s-0.454,0.032-0.674,0.084v-1.168C9.539,11.086,9.762,11.06,10,11.05c0.238,0.01,0.461,0.036,0.674,0.078V12.296z M12.696,13.146c-0.068-0.024-0.14-0.046-0.2-0.076c-0.374-0.184-0.754-0.386-1.148-0.55v-1.188c0.442,0.185,0.87,0.467,1.348,0.879V13.146zM14.382,18.089c-0.558,0-1.011-0.453-1.011-1.011s0.453-1.011,1.011-1.011c0.558,0,1.011,0.453,1.011,1.011S14.94,18.089,14.382,18.089z M13.371,13.371v-0.674l1.156,0.365c0.112,0.022,0.192,0.099,0.192,0.174c0,0.074-0.08,0.135-0.192,0.135H13.371z M14.719,10c-1.348,0-4.045-2.696-4.045-2.696h5.393C16.067,7.304,16.067,10,14.719,10z"></path>
                <path fill="black" d="M10,16.067c-0.186,0-0.337,0.151-0.337,0.337V19.1c0,0.186,0.151,0.337,0.337,0.337s0.337-0.151,0.337-0.337v-2.696C10.337,16.218,10.186,16.067,10,16.067z"></path>
                </svg>
            </div>';
            echo'<div class="titel-box">
                <a href = "#" >'.$aktposts['post'].' </a> 
            </div>';
            echo'<div class="autor-box">
                '.$aktposts['ersteller'].'
            </div>';  
            echo'<div class="thema-box">
            '.$aktposts['zugThema'].'
            </div>';
            echo'<div class="antworten-box">
                Antworten: '.$aktposts['anzAntworten'].'
            </div>';
            echo'</div>';     
        }
        $i++;
    }
// }
    ?>
</div>

<?php
if(isset($_POST['update']))
{
    //Empfängt die gelese ID
    $gelesen = $_POST['update'];
    // Sucht die ID im Array
    $pos = array_search($gelesen,$nichtGelesen); 
    //Löscht die Position im Array
    unset($nichtGelesen[$pos]);
    //Speichert das neue Array in der DB
    dbUpdate("wild-rovers","user","ungelesenePosts",$nichtGelesen,"Nick","Camo"); 
}

?>




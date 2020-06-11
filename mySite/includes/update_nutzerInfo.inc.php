<?php
include_once "dbh.inc.php";
session_start();


switch ($_GET['aufgabe']){
    case 'getInfo':
        getInfo();
    break;
    case 'updateInfo':
        updateInfo();
    break;
    case 'pruefen':
        pruefen();
    break;

    default:
        echo'Fehler: kein gültige GET methode';
    break;

}
//Funktionen
function dbVerbinden(){
    $dbName = "nutzer";
    $servername = "localhost";
    $user ="root";
    $pw = "";
    $dbName ="wild_rovers";
    //Verbindung zu DB aufbauen
    $link = mysqli_connect($servername, $user, $pw, $dbName);
    mysqli_set_charset($link,"utf8");
    if(!$link){
    die("Verbindung fehlgeschlafen" .mysqli_connect_error());
    }
    return $link;
}

//Update Funktion
function updateInfo(){
    $conn = dbVerbinden();
    $id = htmlspecialchars(stripcslashes(trim($_GET['benuter'])));
    $gewFeld = htmlspecialchars(stripcslashes(trim($_GET['feld'])));
    $neuerWert =  htmlspecialchars(stripcslashes(trim($_GET['wert'])));

    // echo $id;
    // echo $gewFeld;
    // echo $neuerWert;

    $sql = "SELECT Nick FROM nutzer WHERE ID = ?";
    $stmt = mysqli_stmt_init($conn);
    //Verhindert, dass der PW Hash aus der DB zu Nutzer kommt. 
    
    if(!mysqli_stmt_prepare($stmt,$sql)){
        echo'Upade vergleich '.mysqli_error($conn);
        exit();
    }
    else {
        mysqli_stmt_bind_param($stmt,"i",$id);
        mysqli_stmt_execute($stmt); 
        $erg = mysqli_stmt_get_result($stmt);
        $alles = mysqli_fetch_assoc($erg);
        $nick = $alles["Nick"]; 

        //Prüfen ob der Angemeldete Nutzer der Selbe ist wie die zugehörige ID
        if($nick == $_SESSION['User']){
            $stmt2 = mysqli_stmt_init($conn);


            switch ($gewFeld) {
                case 'Vorname':
                    $sql2 ="UPDATE nutzer SET Vorname = ? WHERE ID = ?";
                    break;
                case 'Nachname':
                    $sql2 ="UPDATE nutzer SET Nachname = ? WHERE ID = ?";
                    break;
                case 'Nick':
                    $sql2 ="UPDATE nutzer SET Nick = ? WHERE ID = ?";
                    break;
                case 'Geburtstag':
                    $sql2 ="UPDATE nutzer SET Geburtstag = ? WHERE ID = ?";
                    $neuerWert = strtotime($neuerWert);
                    break;
                case 'Emailadresse':
                    $sql2 ="UPDATE nutzer SET Emailadresse = ? WHERE ID = ?";
                    break;
                case 'Handynummer':
                    $sql2 ="UPDATE nutzer SET Handynummer = ? WHERE ID = ?";
                    break;
                case 'Passwort':
                    $sql2 ="UPDATE nutzer SET Passwort = ? WHERE ID = ?";
                    $neuerWert = password_hash($neuerWert, PASSWORD_DEFAULT); 
                    break;
                case 'Rang':
                    $sql2 ="UPDATE nutzer SET Rang = ? WHERE ID = ?";
                    break;  
                default:
                echo'feld wählen fehler';
                    exit;
                    break;
            }
            if(!mysqli_stmt_prepare($stmt2,$sql2)){
                echo '0';
                // echo'Update update'.mysqli_error($conn);
                exit();
            }
            else {     
                mysqli_stmt_bind_param($stmt2,"si",$neuerWert,$id);
                mysqli_stmt_execute($stmt2); 
                echo '1';
            }
            mysqli_stmt_close($stmt2);
            mysqli_close($conn);
            
            if($gewFeld == "Nick"){
                $_SESSION['User'] = $neuerWert;
            }
        }
        else{
            echo 'ID passt nicht zum Angemeldeten Nutzer';
        }

    }
   
    

   
}

function getInfo(){

    $conn = dbVerbinden();
    $id = htmlspecialchars(stripcslashes(trim($_GET['benuter'])));
    $gewFeld = htmlspecialchars(stripcslashes(trim($_GET['feld'])));

    //$sql = "SELECT ? FROM nutzer WHERE ID =?";
    $sql = "SELECT * FROM nutzer WHERE ID = ?";
    $stmt = mysqli_stmt_init($conn);
    //Verhindert, dass der PW Hash aus der DB zu Nutzer kommt. 
    if($gewFeld != "Passwort"){
        if(!mysqli_stmt_prepare($stmt,$sql)){
            echo'Kaputt'.mysqli_error($conn);
            exit();
        }
        else {
            mysqli_stmt_bind_param($stmt,"i",$id);
            //  mysqli_stmt_bind_param($stmt,"si",$id, $gewFeld);
            mysqli_stmt_execute($stmt); 
            $erg = mysqli_stmt_get_result($stmt);
            $alles = mysqli_fetch_assoc($erg);
            $ausgabe = $alles[$gewFeld]; //zusatz, da SELECT ? nicht geht 
            echo $ausgabe;
        }
    }   
    else{
        echo 'Passwort wird nich zurück gegeben';
    }
}

function  pruefen(){
    $conn = dbVerbinden();
    if(isset($_GET['benuter'])){
        $id = htmlspecialchars(stripcslashes(trim($_GET['benuter'])));
    }
    $zuPruefen = htmlspecialchars(stripcslashes(trim($_GET['wert'])));
    $feld = htmlspecialchars(stripcslashes(trim($_GET['feld'])));

    //  echo $id;
    //  echo $zuPruefen;
    //  echo $feld;

    switch($feld){
        case "Nick":
            $sql ="SELECT Nick FROM nutzer WHERE Nick=?";
        break;
        case "Email":
            $sql ="SELECT Emailadresse FROM nutzer WHERE Emailadresse=?";
        break;
        case "Passwort":
            $sql ="SELECT * FROM nutzer WHERE ID = ?";
            $stmt = mysqli_stmt_init($conn);
    
            if(!mysqli_stmt_prepare($stmt,$sql)){
                echo'Kaputt'.mysqli_error($conn);
                exit();
            }
            else 
            {
                mysqli_stmt_bind_param($stmt,"i",$id);
                mysqli_stmt_execute($stmt); 
                $ergebnis = mysqli_stmt_get_result($stmt);
                //Prüfen ob das Passwort zum Nutzer passt
                $row= mysqli_fetch_assoc($ergebnis);
                if(!password_verify($zuPruefen,$row['Passwort']))
                {
                echo '0';
                }
                else {
                echo '1';
                }
            }
            exit;
        break;
        default:
        echo 'Fehler beim überprüfen aufgeterten';
            break;
    } 
    
    $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("Location: ../join_us.php?error=sql_error");
            exit();
        }
        else{
            mysqli_stmt_bind_param($stmt,"s",$zuPruefen);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $ergebnis=mysqli_stmt_num_rows($stmt);
            if($ergebnis==0){
                echo'1';
            }
            else{
                echo'0'; 
            }
        }
}

?>
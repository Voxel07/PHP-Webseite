<?php
include_once "dbh.inc.php";
session_start();

switch ($_GET['aufgabe']){
    case 'getInfo':
        // echo 'getInfo()';
        getInfo();
    break;
    case 'updateInfo':
        // echo 'updateInfo()';
        updateInfo();
    break;
    case 'pwPruefen':
        // echo 'pwPruefen()';
        pwPruefen();
    break;

    default:
        echo'Fehler: kein gültige Post methode';
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
function updateInfo($table, $wert,$id){

    $conn = dbVerbinden();
    $id = htmlspecialchars(stripcslashes(trim($_GET['benuter'])));
    $gewFeld = htmlspecialchars(stripcslashes(trim($_GET['feld'])));
    $neuerWert =  htmlspecialchars(stripcslashes(trim($_GET['wert'])));

    $sql ="UPDATE nutzer SET ? = ? WHERE id = ?";
    $stmt = mysqli_stmt_init($conn);
    
    if(!mysqli_stmt_prepare($stmt,$sql)){
        echo'Kaputt'.mysqli_error($conn);
        exit();
    }
    else {
        mysqli_stmt_bind_param($stmt,"ssi",$gewFeld,$neuerWert, $id);
        mysqli_stmt_execute($stmt); 
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
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
        echo 'Hier könnte ihr Passwort stehen :D';
    }
}

function  pwPruefen(){
    $conn = dbVerbinden();
    // echo 'pwPruefen';
    $id = htmlspecialchars(stripcslashes(trim($_GET['benuter'])));
    $gegebenesPasswort = htmlspecialchars(stripcslashes(trim($_GET['passwort'])));

    // echo $id;
    // echo $gegebenesPasswort;

    $sql = "SELECT * FROM nutzer WHERE ID = ?";
    $stmt = mysqli_stmt_init($conn);
    
    if(!mysqli_stmt_prepare($stmt,$sql)){
        echo'Kaputt'.mysqli_error($conn);
        exit();
    }
    else 
    {
        mysqli_stmt_bind_param($stmt,"i",$id);
        //  mysqli_stmt_bind_param($stmt,"si",$id, $gewFeld);
        mysqli_stmt_execute($stmt); 
        $ergebnis = mysqli_stmt_get_result($stmt);
        //Prüfen ob das Passwort zum Nutzer passt
        $row= mysqli_fetch_assoc($ergebnis);

        if(!password_verify($gegebenesPasswort,$row['Passwort'])){
        echo '0';
        }
        else {
        echo '1';
        }
    }
 
    
}

?>
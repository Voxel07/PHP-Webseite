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
    $sql ="UPDATE nutzer SET ? = ? WHERE id = ?";
    $stmt = mysqli_stmt_init($conn);
    
    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("Location: ../Profil.php?error=sql_error_update".mysqli_error($conn));
        exit();
    }
    else {
        mysqli_stmt_bind_param($stmt,"ssi",$table,$wert, $id);
        mysqli_stmt_execute($stmt); 
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}

function getInfo(){

    $conn = dbVerbinden();
    $id = htmlspecialchars(stripcslashes(trim($_GET['benuter'])));
    $gewFeld = htmlspecialchars(stripcslashes(trim($_GET['feld'])));

    
    
    //  $sql = "SELECT NACHNAME FROM nutzer WHERE ID =1";
    // $sql = "SELECT NACHNAME FROM nutzer WHERE ID =?";
    $sql = "SELECT * FROM nutzer WHERE ID = ?";
    $stmt = mysqli_stmt_init($conn);
    
    if(!mysqli_stmt_prepare($stmt,$sql)){
        echo'Kaputt'.mysqli_error($conn);
        // header("Location: ../index.php?error=sql_error_edit");
        exit();
    }
    else {
        mysqli_stmt_bind_param($stmt,"i",$id);
        //  mysqli_stmt_bind_param($stmt,"i",$id);
        mysqli_stmt_execute($stmt); 
        $erg = mysqli_stmt_get_result($stmt);
        $alles = mysqli_fetch_assoc($erg);
        $ausgabe = $alles[$gewFeld];
        echo $ausgabe;
       
       
      
    }
}

?>
<?php
include_once "includes/dbh.inc.php";
// Überprüfen ob über GET gesendet wurde.
if (isset($_GET["suchbegriff"])) {

    $suchbegriff=$_GET["suchbegriff"];
    $kategorie=$_GET["Kategorie"];

    switch($kategorie){
        case "Nick":
            $sql ="SELECT Nick FROM nutzer WHERE Nick=?";
        break;
        case "Email":
            $sql ="SELECT Emailadresse FROM nutzer WHERE Emailadresse=?";
        break;
    }

        // Den Zeichensatz über header() senden,
        // sonst werden Umlaute ggf. nicht richtig angezeigt.
        header('Content-Type: text/plain; charset=utf-8');
        // $sql = "SELECT Nick FROM user WHERE Nick=?";
        // Eine Verbindung zur Datenbank aufbauen
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("Location: ../join_us.php?error=sql_error");
            exit();
        }
        //Parameter binden und schauen ob bereits vorhanden
        else{
            // Den Platzhalter in der Anweisung mit dem Suchbegriff ersetzen
            mysqli_stmt_bind_param($stmt,"s",$suchbegriff);
            // Die vorbereitete Anweisung ausführen
            mysqli_stmt_execute($stmt);
            // Datensätze holen
            mysqli_stmt_store_result($stmt);
            // Alle gefundenen Datensätze ausgeben oder hier nur anzahl prüfen
            $ergebnis=mysqli_stmt_num_rows($stmt);
            //Wenn schon vorhanden, dann:
            if($ergebnis>0){
                echo'0';
              
            }
            //sonst
            else{
                echo'1';
                
            }
        }
    }

?>
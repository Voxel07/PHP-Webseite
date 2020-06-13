<?php
//Prüfen ob die Seite mit dem Knopf erreicht wird
if(isset($_POST['login-submit'])){
    
    //DB Verbindung 
    require 'dbh.inc.php';

    //Alle Variablen für Login abfangen
    $mailuid =  htmlspecialchars(stripcslashes(trim($_POST['mailuid'])));
    $passwort =  htmlspecialchars(stripcslashes(trim($_POST['passwort'])));
    $herkunft = htmlspecialchars(stripcslashes(trim($_GET['herkunft'])));
  
    //Prüfen ob alles ausgefüllt ist
    if(empty($mailuid) || empty($passwort)){
        header("Location: ../$herkunft?error=nicht alles ausgefüllt&mailuid=".$mailuid);
        exit();
    }
    //Wenn nicht, dann:
    //Befehl vorbereiten
    else{
        $sql ="SELECT * FROM nutzer WHERE Emailadresse = ? OR Nick = ?;";
        $stmt = mysqli_stmt_init($conn);
        //Eintrag Prüfen
        //Wenn es fehlschlägt:
        if(!mysqli_stmt_prepare($stmt,$sql)){
            header("Location: ../$herkunft?error=sql_error_login".mysqli_error($conn));
            exit();
        }
        //Wenn es klappt:
        else{
            mysqli_stmt_bind_param($stmt,"ss",$mailuid,$mailuid);
            mysqli_stmt_execute($stmt);
            $ergebnis = mysqli_stmt_get_result($stmt);
            //Prüfen ob das Passwort zum Nutzer passt
            if($row= mysqli_fetch_assoc($ergebnis)){
              if(!password_verify($passwort,$row['Passwort'])){
                header("Location: ../$herkunft?error=ungültiges_passwort");
                exit();
              }
              //Wenn das Passwort stimmt nutzer Einloggen
              else if (password_verify($passwort,$row['Passwort'])){
                session_start();
                $_SESSION['User'] = $row['Nick'];
                $_SESSION['rang'] = $row['Rang'];
                $_SESSION['id'] = $row['ID'];
                
                $stmt2 = mysqli_stmt_init($conn);
                $sql2 = "UPDATE nutzer SET letzterLogin = ? WHERE ID = ?";
                $neuerWert = time();
                $id =  $row['ID'];
                if(!mysqli_stmt_prepare($stmt2,$sql2)){
                    header("Location: ../$herkunft?error=prepare");
                    exit();
                }
                else {     
                   if( !mysqli_stmt_bind_param($stmt2,"si",$neuerWert,$id)){
                        header("Location: ../$herkunft?error=bind");
                        exit();
                   }
                   else{
                       mysqli_stmt_execute($stmt2); 
                   }
                }
                    $filename = 'Logins.txt';
                    $date = date("d.m.Y - H:i", time());
                    $nutzer =  $row['Nick'];
                    $somecontent = "$date | Nutzer: $nutzer\n";
               
                    
                    // Sichergehen, dass die Datei existiert und beschreibbar ist.
                    if (is_writable("../../Logdaten/$filename")) {
                    
                        // Wir öffnen $filename im "Anhänge" - Modus.
                        // Der Dateizeiger befindet sich am Ende der Datei, und
                        // dort wird $somecontent später mit fwrite() geschrieben.
                        if (!$handle = fopen("../../Logdaten/$filename", "a")) {
                             print "Kann die Datei $filename nicht öffnen";
                             exit;
                        }
                    
                        // Schreibe $somecontent in die geöffnete Datei.
                        if (!fwrite($handle, $somecontent)) {
                            print "Kann in die Datei $filename nicht schreiben";
                            exit;
                        }
                        fclose($handle);
                    
                    } else {
                        print "Die Datei $filename ist nicht schreibbar";
                    }

                header("Location: ../$herkunft?login=success");
                exit();
                
              } 
            }
            //Wenn die Email noch nicht regestriert ist.
            else{
                header("Location: ../$herkunft?error=nutzer_nicht_gefunden");
                exit();
            }
        }
    }

}
//Wenn die Seite dur eingebe des Links erreicht wurde.
else{
    header("Location: ../$herkunft");
    exit(); 
}




?>
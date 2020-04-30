<?php
// Schaut dass mit der butten die Seite erreicht wird
if(isset($_POST['signeup-submit'])){

    //DB verbindung einbinden
    require 'dbh.inc.php';

    //Alle Variablen "einsammeln"
    $nick = htmlspecialchars(stripcslashes(trim($_POST['nick'])));
    $email = htmlspecialchars(stripcslashes(trim($_POST['mail'])));
    $passwort = htmlspecialchars(stripcslashes(trim($_POST['passwort'])));
    $passwort_wdh = htmlspecialchars(stripcslashes(trim($_POST['passwort-wdh'])));
    $vName = htmlspecialchars(stripcslashes(trim($_POST['vName'])));
    $nName = htmlspecialchars(stripcslashes(trim($_POST['nName'])));
    $geb=htmlspecialchars(stripcslashes(trim($_POST['geb'])));

    //Aktuelles Datum abfragen für Regestriert am...
    $Datum = time();
    $gebTimestap = strtotime($geb);

     //Einzigartige Nummer erstellen
     $nummer = (bin2hex(random_bytes(30)));

    //Überprüfung der eingaben
    //Ob alles ausgefüllt ist
    if (empty($nick)||empty($email)||empty($passwort)||empty($passwort_wdh)||empty($vName)||empty($nName)||empty($geb)){
        header("Location: ../join_us.php?error=leerfelder&vName=".$vName."&nName=".$nName."&nick=".$nick."&mail=".$email);
        exit();
    }
    //Ob Vorname richtig ist
    else if(!preg_match("/^[äöü ÄÖÜ a-zA-Z]*$/",$vName)){
    header("Location: ../join_us.php?error=ungültige_Zeichen_Vorname&nName=".$nName."&nick=".$nick."&mail=".$email."&geb=".$geb);
    exit();
    }
    //Ob Nachname richtig ist
    else if(!preg_match("/^[äöü ÄÖÜ a-zA-Z]*$/",$nName)){
    header("Location: ../join_us.php?error=ungültige_Zeichen_Nachname&vName=".$vName."&nick=".$nick."&mail=".$email."&geb=".$geb);
    exit();
    }
    //Ob Email gültig ist
    else if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
        header("Location: ../join_us.php?error=ungültige_emai&vName=".$vName."&nName=".$nName."&nick=".$nick."&geb=".$geb);
        exit();
    }
    //Ob Nick richtig ist
    else if(!preg_match("/^[äöü ÄÖÜ a-zA-Z0-9]*$/",$nick)){
        header("Location: ../join_us.php?error=ungültige_Zeichen_Nick&vName=".$vName."&nName=".$nName."&email=".$email."&geb=".$geb);
        exit();
    }
    // Ob Geburtsdatum sinvoll ist
    // else if(!$gebTimestap>10){
    //     header("Location: ../join_us.php?error=ungültiges_Geburtsdatdum&vName=".$vName."&nName=".$nName."&mail=".$emmail."&=nick".$nick);
    //     exit();
    // }
    //Ob PW1 und PW2 übereinstimmen
    else if($passwort !==  $passwort_wdh){
        header("Location: ../join_us.php?error=passwörter_unterschiedlich&nick=".$nick."&mail=".$email."&vName=".$vName."&nName=".$nName);
        exit();
    }
    //Wenn das alles passt, dann:
    //Nick oder Email auf Doppelt prüfen
    else{
        $sql = "SELECT Nick,Emailadresse FROM nutzer WHERE Nick=? OR Emailadresse=?";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("Location: ../join_us.php?error=sql_error_hier" .mysqli_connect_error($conn));
            exit();
        }
        //Parameter binden und schauen ob bereits vorhanden
        else{
            mysqli_stmt_bind_param($stmt,"ss",$nick,$email);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $ergebnis=mysqli_stmt_num_rows($stmt);
            //Wenn schon vorhanden, dann:
            if($ergebnis>0){
                header("Location: ../join_us.php?error=doppelt&Nick_oder_Email_bereits_regestriert&vName=".$vName."&nName=".$nName."&geb=".$geb);
                exit();
            }
            //Wenn Nick nicht bekannt, dann:
            else{
                $ProfielbildGesetzt = 0;
                //Wenn ein Profielbild mitgegeben wurde
                if(!empty($_FILES['DateiZumHochladen'])){
                    require_once 'Upload_Bilder.inc.php';
                    $ProfielbildGesetzt = 1;
                }
                $sql = "INSERT INTO nutzer (Vorname, Nachname, Nick, Emailadresse, Passwort, Profielbild, Reg_Datum, Geburtstag, verID) VALUES (?,?,?,?,?,?,?,?,?)";

                $stmt = mysqli_stmt_init($conn);
                //Prüfen ob der Befehl und das Statement zusammen funktionieren
                //Wenn nicht:
                if(!mysqli_stmt_prepare($stmt, $sql)){
                    header("Location: ../join_us.php?error=sql_error2".mysqli_connect_error($conn));
                    exit();
                }
                //Wenn doch, PW Haschen und in DB eintragen
                else{
                    $hasedPwd = password_hash($passwort, PASSWORD_DEFAULT);                    
                    mysqli_stmt_bind_param($stmt,"sssssisss",$vName,$nName,$nick,$email,$hasedPwd,$ProfielbildGesetzt,$Datum,$gebTimestap,$nummer);
                    mysqli_stmt_execute($stmt);   
                    //Schauen ob schon eine Session läuft (Wegen Pop up ding)
                    if(!(session_status()===PHP_SESSION_ACTIVE)){
                        session_start();
                    }
                    else{
                       
                    }
                    $_SESSION['User'] = $nick;
                    $_SESSION['rang'] = 0;

                    //Verifizierungs Mail erstellen
                   
                    //Email Vorbereiten
                    $empfaenger =  $email;
                    $betreff = 'WRW-Regestriertung am:'.date("d.m.Y H:i").'';
                    $header = 'From: webmaster@example.com' . "\r\n" . 'Reply-To: webmaster@example.com' . "\r\n" . 'X-Mailer: PHP/' . phpversion();
                    //Email inhalt
                    $nachricht = "Hallo".$nick."\n\n"."Willkommen bei den Wild Rovers."."\n\n"." Bitte bestätige deine Email durch klicken auf diesen ".'<a target="blank" href="http://   xxxxx   /mySite/verifizierung.php?verify=success&id='.$nummer.'&nutzer='.$nick.'">Link</a>' ;

                    //Email versenden
                    // mail($empfaenger, $betreff, $nachricht, $header);

                    //Logdatei eintrag
                    $filename = 'Regestriertungen.txt';
                    $date = date("d.m.Y - H:i", time());
                    
                    $somecontent = "Datum: $date | Nutzer:$nick | Email:$email \n";
                    
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
                    header("Location: ../verifizierung.php?signeup=success&email=$email");
                    exit();                
                }
            }
        }
    }
    //DB verbindung trennen
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
//Wenn die Seite durch eingabe der URL wird er zurückgeschickt
else{
    header("Location: ../join_us.php");
    exit(); 
}















?>
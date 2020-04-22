<?php
include_once "dbh_Forum.inc.php";
session_start();
?>
<?php



if(isset($_POST['Löschen-Thema'])&&$_SESSION['rang']>2)
{
    $löschen = htmlspecialchars(stripcslashes(trim($_POST['TheZumLöschen'])));
    $Kategorie = htmlspecialchars(stripcslashes(trim($_POST['Kategorie'])));
    $herkunft = htmlspecialchars(stripcslashes(trim($_GET['herkunft'])));
    echo $löschen;

    //Alle Posts zum Thema Finden
    $sql = "SELECT * FROM posts WHERE zugThema = ?";
    $stmt = mysqli_stmt_init($conn2);
    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("Location: ../".$herkunft."?error=sql_error_ThemenHolen" .mysqli_error($conn2));
        exit();
    }
    else{
        
        //Alle Posts in Array Speichern
        $allePosts = array();
        $arrayPos = 0;
        mysqli_stmt_bind_param($stmt,"s",$löschen);
        mysqli_stmt_execute($stmt);
        $ergebnis=mysqli_stmt_get_result($stmt);
        while ($row = mysqli_fetch_assoc($ergebnis)){
            $allePosts[$arrayPos] = $row['post'];
            $arrayPos++;
         }

        var_dump($allePosts);
        
        //Antworten löschen
        foreach($allePosts as $Post):
            $sql2 = "DELETE FROM `antworten` WHERE `zugPost` = ?";
            $stmt = mysqli_stmt_init($conn2);
            if(!mysqli_stmt_prepare($stmt,$sql2)){
                header("Location: ../".$herkunft."?error=sql_error_AntwortLöschen".mysqli_error($conn2));
                exit();
            }
            else {
                mysqli_stmt_bind_param($stmt,"s",$Post);
                mysqli_stmt_execute($stmt);
            }
            endforeach;
        //Posts löschen
        $sql3 = "DELETE FROM `posts` WHERE `zugThema` = ?";
        $stmt = mysqli_stmt_init($conn2);
        if(!mysqli_stmt_prepare($stmt,$sql3)){
            header("Location: ../".$herkunft."?error=sql_error_PostLöschen".mysqli_error($conn2));
            exit();
        }
        else {
            mysqli_stmt_bind_param($stmt,"s",$löschen);
            mysqli_stmt_execute($stmt);
        }
        //Thema löschen
        $sql4 = "DELETE FROM `themen` WHERE `thema` = ?";
        $stmt = mysqli_stmt_init($conn2);
        if(!mysqli_stmt_prepare($stmt,$sql4)){
            header("Location: ../".$herkunft."?error=sql_error_ThemenLöschen".mysqli_error($conn2));
            exit();
        }
        else {
            mysqli_stmt_bind_param($stmt,"s",$löschen);
            mysqli_stmt_execute($stmt);

            //Themananzahl in Kategorie aktualisieren
            //Themenzahl herausfinden
            $sql5="SELECT * FROM themen WHERE zugKategorie = ?";
            $stmt = mysqli_stmt_init($conn2);
            if(!mysqli_stmt_prepare($stmt,$sql5)){
                header("Location: ../".$herkunft."?error=sql_error_anzUpdate".mysqli_error($conn2));
                exit();
            }
            else {
                mysqli_stmt_bind_param($stmt,"s",$Kategorie);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                $ergebnis=mysqli_stmt_num_rows($stmt);
              
                //Themenzahl updaten
                $anz = $ergebnis;
                $sql6 ="UPDATE kategorien SET anz_Themen = ? WHERE kategorie = ?";
                $stmt = mysqli_stmt_init($conn2);
                if(!mysqli_stmt_prepare($stmt,$sql6)){
                    header("Location: ../".$herkunft."?error=sql_error_PostLöschen".mysqli_error($conn2));
                    exit();
                }
                else {
                    mysqli_stmt_bind_param($stmt,"is",$anz,$Kategorie);
                    mysqli_stmt_execute($stmt);

                    $filename = 'Forum_Löschen.txt';
                    $date = date("d.m.Y - H:i", time());
                    $somecontent = "$date | Nutzer: $_SESSION[User] Löschte Thema: $löschen welches die Posts ".implode(',',$allePosts )." beinhaltete\n";
                    
                    if (is_writable("../../Logdaten/$filename")) {
                        if (!$handle = fopen("../../Logdaten/$filename", "a")) {
                                print "Kann die Datei $filename nicht öffnen";
                                exit;
                        }
                        if (!fwrite($handle, $somecontent)) {
                            print "Kann in die Datei $filename nicht schreiben";
                            exit;
                        }
                        fclose($handle);
        
        } else {
            print "Die Datei $filename ist nicht schreibbar";
        }
                }
            }
        }
            
        header("Location: ../".$herkunft."?Löschen=Erfolgreich&kategorie=".$Kategorie."");
    }

}
else{
    header("Location: ../".$herkunft."?error=Löschen is nicht");
}

?>
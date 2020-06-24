<?php
include_once "dbh.inc.php";
session_start();
?>

<?php

//Uploads für die Galerie
if(isset($_POST['upload-Galerie']))
{

    $Nutzer = $_SESSION['User'];
    $Datum = date("Y-m-d");
    // $newFileName = $_POST['dateiname'];
    // //Wenn kein Name gesetzt wurden, wird ein Standartwert gesetzt
    // if(empty($newFileName)){
    //     $newFileName ="gallery";
    // }
    // //Wenn der Name leerzeichen enthält werden diese ersetzt dur - 
    // else{
    // $newFileName=strtolower(str_replace(" ","-",$newFileName));
    // }
    
    //Infos aus dem Form abgreifen
    $titel = htmlspecialchars(stripcslashes(trim($_POST['titel'])));
    $beschreibung = htmlspecialchars(stripcslashes(trim($_POST['beschreibung'])));

    $newFileName=strtolower(str_replace(" ","_",$titel));
    
    $file = $_FILES['DateiZumHochladen'];

    $dateiName = $file['name'];
    $dateiTyp = $file['type'];
    $dateiTempName = $file['tmp_name'];
    $dateiError = $file['error'];
    $dateiSize = $file['size'];

    $fileExt = explode(".",$dateiName); // trennt den dateinamen auf um an die dateiendung zu kommen
    $fileActualExt = strtolower(end($fileExt));//JPG ind jpg ändern

    $allowed = array("jpg","jpeg","png","JPG","PNG");
    
    if(in_array( $fileActualExt,$allowed)){
        if($dateiError === 0){
            //Dateigröße 20mb
            if($dateiSize < 2000000000){
                $dateinameServer = "galerie_".  $newFileName. "." . uniqid("",true) . "." . $fileActualExt; //Dateiname unterdem Sie gespeichert wird
                $pfad = "../../Uploads/Bilder_Galerie/Vollbild_Bilder/". $dateinameServer; //Wo soll die Datei gespeichert werdem

                if(empty($titel)||empty($beschreibung)){ //Prüft ob Titel und beschreibung gegeben sind
                    // header("Location: ../Galerie.php?upload=empty");
                     echo'1 Tietel und Beschreibung dürfen nicht lehr sein.';
                    exit();
                }
                else{
                    $sql = "SELECT * FROM gallerie";//Sql befehl 
                    $stmt = mysqli_stmt_init($conn);
                    if(!mysqli_stmt_prepare($stmt,$sql)){
                        // header("Location: ../Galerie.php?upload=sqlStatementError");//
                         echo'2 Titel schon vorhanden';
                        exit();
                    }
                    else{
                        mysqli_stmt_execute($stmt);
                        $result =  mysqli_stmt_get_result($stmt);
                        $rowCount = mysqli_num_rows($result); //Anzahl der Bilder
                        $reihenfolge = $rowCount + 1; //Setzt den Index für die Reihenfolge
                        
                        $sql2 = "INSERT INTO gallerie (Titel, Beschreibung, Pfad, Reihenfolge, uploadDatum, Ersteller) VALUES (?, ?, ?, ?, ?, ?);";
                        // $sql2 = "INSERT INTO gallerie (titelGallerie, beschGallerie, dateinameServer, reihenfolgeGallerie) VALUES (?, ?, ?, ?);";
                        if(!mysqli_stmt_prepare($stmt,$sql2)){
                            echo'3 Einfügen ist fehlgeschlagen';
                            // header("Location: ../Galerie.php?upload=sqlStatementError2");
                            exit();
                        }
                        else{
                           
                            mysqli_stmt_bind_param($stmt,"ssssss",$titel,$beschreibung,$dateinameServer,$reihenfolge,$Datum,$Nutzer);
                            // mysqli_stmt_bind_param($stmt,"ssss",$titel,$beschreibung,$dateinameServer,$reihenfolge);
                            mysqli_stmt_execute($stmt); 
                            //Orginalbild verschieben
                            move_uploaded_file($dateiTempName,$pfad);

                            //Vorschaubild erstellen für Gallerie
                            include "bildskalierung.inc.php";
                             $Ziel ='../../Uploads/Bilder_Galerie/'.$dateinameServer;
                             $image_dimension = 500;
                             createResizedImage ($pfad, $Ziel, $image_dimension, $scale_mode = 0);


                              // Anzahl der Bereits geposteten Bilder herausfinden
                              $sql3 = "SELECT * FROM nutzer WHERE Nick=?";
                              $stmt = mysqli_stmt_init($conn);

                              if(!mysqli_stmt_prepare($stmt,$sql3)){
                              echo "SQL Fehler beim Nutzer herausfinden";
                              exit();
                              }
                              else{
                                  mysqli_stmt_bind_param($stmt,"s",$Nutzer);
                                  mysqli_stmt_execute($stmt);
                                  $ergebnis = mysqli_stmt_get_result($stmt);
                                  $row= mysqli_fetch_assoc($ergebnis);
                                  $anzahl = $row['anz_Bilder'];
                                  
                                  $anzNeu = $anzahl +1;

                                // Anzahl der Bereits geposteten Bilder aktualisieren
                                $sql4 = " UPDATE nutzer SET anz_Bilder = '$anzNeu' WHERE Nick = ?;";
                                $stmt = mysqli_stmt_init($conn);
                                    if(!mysqli_stmt_prepare($stmt,$sql4)){
                                        echo "SQL Fehler beim Nutzer updaten";

                                        // header("Location: ../index.php?error=sql_error2");
                                        exit();
                                    }
                                //Wenn es klappt:
                                else{
                                    mysqli_stmt_bind_param($stmt,"s",$Nutzer);
                                    mysqli_stmt_execute($stmt);

                                    $filename = 'Galerie_Upload.txt';
                                    $date = date("d.m.Y - H:i", time());
                                    $somecontent = " $date | upload der Datei: $dateinameServer vom Nutzer: $Nutzer\n";
                                    
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
                            header("Location: ../Galerie.php?upload=success?&anz =".$anzahl."&anzNeu=".$anzNeu);
                            echo'Datei erfolgreich hochgeladen';
                        }
                    }
                }
            }
            else{
                header("Location: ../Galerie.php?upload=Datei zu groß");
                 echo'Datei zu groß';
                exit();
            }
        }
        else{
            header("Location: ../Galerie.php?upload=Fehler beim Upload");
             echo'Fehler beim Upload';
            exit();
        }
    }
    else{
        header("Location: ../Galerie.php?upload=Ungültiges Bildformat");
         echo'Ungültiges Bildformat';
        exit();
    }
}
else {
    header("Location: ../Galerie.php?falsch");
    exit();
}
?>
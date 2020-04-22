<?php
include_once "dbh_Forum.inc.php";
session_start();
?>
<?php
if(isset($_POST['Forum-Thema'])){
    $neuesThema = htmlspecialchars(stripcslashes(trim($_POST['thema'])));
    $neuesThema = str_replace(" ","_",$neuesThema);
    $beschreibung = htmlspecialchars(stripcslashes(trim($_POST['beschreibung'])));
    $Kategorie = $_POST['Kategorie'];
    $Nutzer = $_SESSION['User'];
    $Datum = time();

    $herkunft= $_GET['herkunft'];

    //Prüfen ob Thema bereits vorhanden
    $sql = "SELECT * FROM themen WHERE thema = ?";
    $stmt = mysqli_stmt_init($conn2);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("Location: ../".$herkunft."?error=sql_error_Themen");
        exit();
    }
    else{
          //Prüfen ob name Kategorie bereits vorhanden
        mysqli_stmt_bind_param($stmt,"s",$neuesThema);
        mysqli_stmt_execute($stmt);
        $ergbnis = mysqli_stmt_get_result($stmt);
        $anzReihen=mysqli_num_rows($ergbnis);
        
        //Wenn schon vorhanden, dann:
        if($anzReihen>0){
            header("Location: ../".$herkunft."?error=Thema_existiert_bereits");
            exit();
        }
        else
        {
            //Thema einfügen
            $reihenfolge = $anzReihen+1;
            $sql2 = "INSERT INTO themen (thema, beschreibung, reihenfolge, erstellungsDatum, ersteller, zugKategorie) VALUES (?,?,?,?,?,?)";
            if(!mysqli_stmt_prepare($stmt, $sql2)){
                header("Location: ../".$herkunft.".php?error=sql_error beim einfuegen");
                exit();
            }
            else
            {
                mysqli_stmt_bind_param($stmt,"ssisss",$neuesThema,$beschreibung,$reihenfolge,$Datum,$Nutzer, $Kategorie);
                mysqli_stmt_execute($stmt);   
                //Zugehörige Kategorie Updaten
                // Zugehörige Tehmenen villeicht unnötig ! 22.02.2020
                // $sql3 = "SELECT anz_Themen,Themen FROM kategorien WHERE kategorie = ?";
                $sql3 = "SELECT anz_Themen FROM kategorien WHERE kategorie = ?";
                $stmt = mysqli_stmt_init($conn2);
                if(!mysqli_stmt_prepare($stmt,$sql3)){
                    header("Location: ../Forum.php?error=sql_error_anzHolen" .mysqli_connect_error($conn2));
                    exit();
                }
                else
                {
                    mysqli_stmt_bind_param($stmt,"s",$Kategorie);
                    mysqli_stmt_execute($stmt);
                    $ergebnis=mysqli_stmt_get_result($stmt);
                    $array = mysqli_fetch_assoc($ergebnis);
                    $anz = $array['anz_Themen'];
                    // $them_arr = explode(",",$array['Themen']);
                    // array_push($them_arr,$neuesThema);
                    // $them_str=implode(",",$them_arr);
                    $anz++;

                    // $sql4 = " UPDATE kategorien SET anz_Themen = ?,Themen = ? WHERE kategorie = ?";
                    $sql4 = " UPDATE kategorien SET anz_Themen = ? WHERE kategorie = ?";
                    if(!mysqli_stmt_prepare($stmt,$sql4)){
                        header("Location: ../Forum.php?error=sql_error_anzUpdate" .mysqli_connect_error($conn2));
                        exit();
                    }
                    else {
                        mysqli_stmt_bind_param($stmt,"ss",$anz,$Kategorie);
                        mysqli_stmt_execute($stmt);

                        $filename = 'Forum_Beitrag.txt';
                        $date = date("d.m.Y - H:i", time());
                        $somecontent = "$date | Thema: $neuesThema vom Nutzer: $Nutzer in Kategorie: $Kategorie erstellt\n";
                        
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
        }
    }
    // header("Location: ../join_us.php?error=passwörter_unterschiedlich&nick=".$nick."&mail=".$email."&vName=".$vName."&nName=".$nName);

     header("Location: ../".$herkunft."?&kategorie=".$Kategorie."&herkunft=".$herkunft);

}
else{
    header("Location: ../Forum.php?error=was willst du hier ?");
}

?>
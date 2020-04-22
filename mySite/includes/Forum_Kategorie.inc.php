<?php
include_once "dbh_Forum.inc.php";
session_start();
?>
<?php
if(isset($_POST['Forum-Kategorie'])){
    $neueKategorie = htmlspecialchars(stripcslashes(trim($_POST['Kategorie'])));
    $neueKategorie=str_replace(" ","_",$neueKategorie);
    $Nutzer = $_SESSION['User'];
    $Datum = time();

    $herkunft= $_GET['herkunft'];

    $sichtbarkeit = 0;
   
    switch ($_POST['sichtbarkeit']) {
        case '0':
            $sichtbarkeit = 0;
            break;
        case '1':
            $sichtbarkeit = 1;
            break;
        case '2':
            $sichtbarkeit = 2;
            break;
    
        default:
            $sichtbarkeit = 0;
            break;
    }

    // $sql = "SELECT kategorie FROM kategorien WHERE kategorie=?";
    $sql = "SELECT kategorie FROM kategorien";

    $stmt = mysqli_stmt_init($conn2);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("Location: ../".$herkunft."?error=sql_error_Kattegorie");
        exit();
    }
    //Parameter binden und schauen ob bereits vorhanden
    else{
        // mysqli_stmt_bind_param($stmt,"s",$neueKategorie);
        mysqli_stmt_execute($stmt);
        // mysqli_stmt_store_result($stmt);
        $ergbnis = mysqli_stmt_get_result($stmt);
        $anzReihen=mysqli_num_rows($ergbnis);
        $i = 0;
        //Prüfen ob name Kategorie bereits vorhanden
        while ($reihen = mysqli_fetch_assoc($ergbnis))
        {
            if($reihen['kategorie']==$neueKategorie){
                $i++;
            break;
            }
        }
        //Wenn schon vorhanden, dann:
        if($i>0){
            header("Location: ../".$herkunft.".php?error=Kategorie_existiert_bereits");
            exit();
        }
        else{
            $reihenfolge = $anzReihen+1;
            $sql2 = "INSERT INTO kategorien (kategorie, reihenfolge, erstellungsDatum, ersteller, Sichtbarkeit) VALUES (?,?,?,?,?)";
            // $stmt = mysqli_stmt_init($conn2);
            //Prüfen ob der Befehl und das Statement zusammen funktionieren
            //Wenn nicht:
            if(!mysqli_stmt_prepare($stmt, $sql2)){
                header("Location: ../".$herkunft."?error=sql_error beim einfuegen");
                exit();
            }
            
            else{
                mysqli_stmt_bind_param($stmt,"sissi",$neueKategorie,$reihenfolge,$Datum,$Nutzer,$sichtbarkeit);
                mysqli_stmt_execute($stmt);  
                
                $filename = 'Forum_Beitrag.txt';
                $date = date("d.m.Y - H:i", time());
                $somecontent = "$date | Kategorie: $neueKategorie vom Nutzer: $Nutzer erstellt\n";
                
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
    header("Location: ../".$herkunft."?succsess=Kategorie");

}
else{
    header("Location: ../Forum.php?error=was willst du hier ?");
}

?>
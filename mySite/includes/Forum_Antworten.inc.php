<?php
include_once "dbh_Forum.inc.php";
include_once "dbh.inc.php";
session_start();
?>
<?php
if(isset($_POST['Post-Antwort']))
{
    $neuerKommentar = htmlspecialchars(stripcslashes(trim($_POST['inhalt'])));
    $post = htmlspecialchars(stripcslashes(trim($_POST['post'])));
    $Nutzer = $_SESSION['User'];
    $Datum = time();
  
    //Villeicht gefährlich
    $herkunft= $_GET['herkunft'];
    $zugThem=$_GET['zugThema'];


    //Anzahl Updaten
     //Bissherige zahl herausfinden
     $sql ="SELECT * from posts WHERE post = ? && zugThema = ? ";
     $stmt = mysqli_stmt_init($conn2);
     if(!mysqli_stmt_prepare($stmt, $sql)){
          header("Location: ../".$herkunft."?error=sql_error_anzahl_herausfinden");
         exit();
     }
     else
     {
         mysqli_stmt_bind_param($stmt,"ss",$post,$zugThem);
         mysqli_stmt_execute($stmt);
         $erg =  mysqli_stmt_get_result($stmt);
         $zwischending = mysqli_fetch_assoc($erg);
         $AnzAntwort = $zwischending['anzAntworten'];
         $neueAnzAntwort = $AnzAntwort+1;
         $ID = $zwischending['id'];   
         
         echo $AnzAntwort, $neueAnzAntwort;
     }

    //Anzahl in Posts table updaten
    $sql2 = "UPDATE posts SET anzAntworten = ? WHERE post = ? && zugThema = ? ";
    $stmt = mysqli_stmt_init($conn2);
    if(!mysqli_stmt_prepare($stmt, $sql2)){
        header("Location: ../".$herkunft."?error=sql_error_anzUpdaten");
        exit();
    }
    else{
        mysqli_stmt_bind_param($stmt,"sss",$neueAnzAntwort,$post,$zugThem);
        mysqli_stmt_execute($stmt);
    }

    //Post in Antwort DB einfügen
    $sql3 = "INSERT INTO antworten (inhalt, erstellungsdatum, ersteller, zugPost, PostID ) VALUES (?,?,?,?,?)";
    $stmt2 = mysqli_stmt_init($conn2);
    if(!mysqli_stmt_prepare($stmt2, $sql3)){
        header("Location: ../".$herkunft."?error=sql_error beim einfuegen");
        exit();
    }
    else{
        mysqli_stmt_bind_param($stmt2,"ssssi",$neuerKommentar,$Datum,$Nutzer, $post, $ID);
        mysqli_stmt_execute($stmt2);   
    }
    //User Updaten  

     //user Table aktualisieren
    //Bissherige zahl herausfinden
    $sql4 ="SELECT * from nutzer WHERE Nick = ? ";
    $stmt3 = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt3, $sql4)){
        header("Location: ../".$herkunft."?error=sql_error_anzahl_user");
        exit();
    }
    else
    {
        mysqli_stmt_bind_param($stmt3,"s",$Nutzer);
        mysqli_stmt_execute($stmt3);
        $erg =  mysqli_stmt_get_result($stmt3);
        $zwischending = mysqli_fetch_assoc($erg);
        $AnzAntwort = $zwischending['anz_Antworten'];
        $neueAnzAntwort = $AnzAntwort+1;
        var_dump($AnzAntwort);
        var_dump($neueAnzAntwort);

        //Anzahl updaten
        $sql5 = " UPDATE nutzer SET anz_Antworten = ? WHERE Nick = ?";
        if(!mysqli_stmt_prepare($stmt3, $sql5)){
            header("Location: ../".$herkunft."?error=sql_error_anzUpdate_user");
            exit();
        }
        else{
            mysqli_stmt_bind_param($stmt3,"ss",$neueAnzAntwort,$Nutzer);
            mysqli_stmt_execute($stmt3);

            $filename = 'Forum_Beitrag.txt';
            $date = date("d.m.Y - H:i", time());
            $somecontent = "$date | Antwort vom Nutzer: $Nutzer auf Post: $post\n";
            
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
    header("Location: ../".$herkunft."?&zugThema=".$thema."&post=".$post);

}
else{
    header("Location: ../Forum.php?error=was willst du hier ?");
}

?>
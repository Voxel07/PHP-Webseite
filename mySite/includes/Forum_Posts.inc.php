<?php
include_once "dbh_Forum.inc.php";
include_once "dbh.inc.php";
session_start();
?>
<?php

   var_dump($_POST);



if(true){

if(isset($_POST['Forum-Post']))
{
    $neuerPost = htmlspecialchars(stripcslashes(trim($_POST['post'])));
    $inhalt =$_POST['inhalt'];
    $thema = $_POST['thema'];
    $kategorie = $_POST['kategorie'];
    $Nutzer = $_SESSION['User'];
    $Datum = time();

    $herkunft= $_GET['herkunft'];
  
    //Alle Posts durchsuchen um doppelte zu vermeiden
    $sql = "SELECT * FROM posts WHERE post = ? ";
    $stmt = mysqli_stmt_init($conn2);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("Location: ../".$herkunft."?error=sql_error_posts");
        exit();
    }
    else{
        //Prüfen ob post bereits vorhanden
        mysqli_stmt_bind_param($stmt,"s",$neuerPost);
        mysqli_stmt_execute($stmt);
        $ergbnis = mysqli_stmt_get_result($stmt);
        $anzReihen=mysqli_num_rows($ergbnis);
        //Wenn schon vorhanden, dann zurück
        if($anzReihen>0){
            header("Location: ../".$herkunft."?error=Post_existiert_bereits&thema=".$thema);
            exit();
        }
        else{
            $reihenfolge = $anzReihen+1;
            $stmt = mysqli_stmt_init($conn2);
            $sql2 = "INSERT INTO posts (post, inhalt, reihenfolge, erstellungsDatum, ersteller, zugThema, zugKategorie) VALUES (?,?,?,?,?,?,?)";
            if(!mysqli_stmt_prepare($stmt, $sql2)){
                header("Location: ../".$herkunft."?error=sql_error beim einfuegen".mysqli_error($conn2));
                exit();
            }
            else{
                mysqli_stmt_bind_param($stmt,"ssissss",$neuerPost,$inhalt,$reihenfolge,$Datum,$Nutzer,$thema,$kategorie);
                mysqli_stmt_execute($stmt);   
            }
        
            //Themen aktualisieren
            $sql2 = "SELECT anzPosts FROM themen WHERE thema = ? ";
            $stmt = mysqli_stmt_init($conn2);
            if(!mysqli_stmt_prepare($stmt, $sql2)){
                header("Location: ../".$herkunft."?error=sql_anz_abfrage");
                exit();
            }
            else{
                mysqli_stmt_bind_param($stmt,"s",$thema);
                mysqli_stmt_execute($stmt);
                $ergbnis = mysqli_stmt_get_result($stmt);
                $ert=mysqli_fetch_assoc($ergbnis);
                
            }
            $neueAnzAntworten = $ert['anzPosts']+1;
            $sql3 = " UPDATE themen SET anzPosts = ? WHERE thema = ?";
            $stmt = mysqli_stmt_init($conn2);
            if(!mysqli_stmt_prepare($stmt, $sql3)){
                header("Location: ../".$herkunft."?error=sql_error_anzUpdate");
                exit();
            }
            else{
                mysqli_stmt_bind_param($stmt,"ss",$neueAnzAntworten,$thema);
                mysqli_stmt_execute($stmt);
            }

            //Anzahl der Post vom Nutzer aktualiseren

            //Bissherige zahl herausfinden
            $sql4 ="SELECT * from nutzer WHERE Nick = ? ";
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt, $sql4)){
                header("Location: ../".$herkunft."?error=sql_error_postaktualisierung");
                exit();
            }
            else
            {
                mysqli_stmt_bind_param($stmt,"s",$Nutzer);
                mysqli_stmt_execute($stmt);
               
            }
            //Anzahl updaten
            $erg =  mysqli_stmt_get_result($stmt);
            $zwischending = mysqli_fetch_assoc($erg);
            $anzPosts = $zwischending['anz_Beiträge'];
            $neueAnzPosts = $anzPosts+1;
            $sql5 = " UPDATE nutzer SET anz_Beiträge = ? WHERE Nick = ? ";
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt, $sql5)){
                header("Location: ../".$herkunft."?error=sql_error_anzUpdate");
                exit();
            }
            else{
                mysqli_stmt_bind_param($stmt,"ss",$neueAnzPosts,$Nutzer);
                mysqli_stmt_execute($stmt);

                $filename = 'Forum_Beitrag.txt';
                $date = date("d.m.Y - H:i", time());
                $somecontent = "$date | Post: $neuerPost vom Nutzer: $Nutzer in Thema: $thema erstellt\n";
                
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
        header("Location: ../".$herkunft."?&thema=".$thema);
    }
}
else{
    header("Location: ../Forum.php?error=was willst du hier ?");
}

}
?>
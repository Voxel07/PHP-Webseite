<?php
include_once "dbh_Forum.inc.php";
session_start();
?>
<?php



if(isset($_POST['Löschen-Post'])&&$_SESSION['rang']>2)
{
    $herkunft = htmlspecialchars(stripcslashes(trim($_GET['herkunft'])));
    $löschen = htmlspecialchars(stripcslashes(trim($_POST['PostZumLöschen'])));
    $Thema = htmlspecialchars(stripcslashes(trim($_POST['Thema'])));
   
    

    //Thema des Posts herausfiunden
    $sql1 = "SELECT zugThema FROM posts WHERE post = ?";
    $stmt = mysqli_stmt_init($conn2);
    if(!mysqli_stmt_prepare($stmt,$sql1)){
        header("Location: ../".$herkunft."?error=sql_error_ThemenHolen" .mysqli_error($conn2));
        exit();
    }
    else{

        mysqli_stmt_bind_param($stmt,"s",$löschen);
        mysqli_stmt_execute($stmt);
        $ergebnis = mysqli_stmt_get_result($stmt);
        $erg = mysqli_fetch_assoc($ergebnis)['zugThema'];
        

        //Anzahl an Posts im Thema herausfinden

        $sql2 = "SELECT * FROM posts WHERE zugThema = ?";
        $stmt = mysqli_stmt_init($conn2);
        if(!mysqli_stmt_prepare($stmt,$sql2)){
            header("Location: ../".$herkunft."?error=sql_error_anzHolen" .mysqli_error($conn2));
            exit();
        }
        else{
            // echo $erg;
            mysqli_stmt_bind_param($stmt,"s",$erg);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $anz=mysqli_stmt_num_rows($stmt);
            $anz--;

            //Anzahl Updaten

            $sql3 = "UPDATE themen SET anzPosts = ? WHERE thema = ?";
            $stmt = mysqli_stmt_init($conn2);
            if(!mysqli_stmt_prepare($stmt,$sql3)){
                header("Location: ../".$herkunft."?error=sql_error_anzHolen" .mysqli_error($conn2));
                exit();
            }
            else{
                
                mysqli_stmt_bind_param($stmt,"is",$anz,$erg);
                mysqli_stmt_execute($stmt);

                //Post löschen
                $sql4 = "DELETE FROM posts WHERE post = ?";
                $stmt = mysqli_stmt_init($conn2);
                if(!mysqli_stmt_prepare($stmt,$sql4)){
                    header("Location: ../".$herkunft."?error=sql_error_Post_holen" .mysqli_error($conn2));
                    exit();
                }
                else{
                    mysqli_stmt_bind_param($stmt,"s",$löschen);
                    mysqli_stmt_execute($stmt);

                    //Log schreiben
                    $filename = 'Forum_Löschen.txt';
                    $date = date("d.m.Y - H:i", time());
                    $somecontent = "$date | Nutzer: $_SESSION[User] Löschte Post: $löschen\n";
                    
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
    header("Location: ../".$herkunft."?Löschen=Erfolgreich&thema=".$Thema."");
}
else{
    header("Location: ../".$herkunft."?error=Löschen is nicht");
}

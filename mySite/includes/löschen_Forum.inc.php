<?php
include_once "dbh_Forum.inc.php";
session_start();
?>
<?php



if(isset($_POST['Löschen-Kategorie'])&&$_SESSION['rang']>2)
{
    $löschen = htmlspecialchars(stripcslashes(trim($_POST['KatZumLöschen'])));
    // echo $löschen;

    //Themen holen die glöscht werden müssen
    $sql = "SELECT * FROM kategorien WHERE kategorie = ?";
    $stmt = mysqli_stmt_init($conn2);
    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("Location: ../Forum.php?error=sql_error_ThemenHolen" .mysqli_error($conn2));
        exit();
    }
    else 
    {
        mysqli_stmt_bind_param($stmt,"s",$löschen);
        mysqli_stmt_execute($stmt);
        $ergebnis=mysqli_stmt_get_result($stmt);
        $array = mysqli_fetch_assoc($ergebnis);
        //erstes , löschen
        $themen_zum_löschen = $str1 = substr($array['Themen'], 1); 
        //sting in array
        $them_arr = explode(",",$themen_zum_löschen);
        // var_dump( $them_arr);

        //leeres array für alle Posts
        $allePosts = array();
        $arrayPos = 0;

        //für jedes Thema die Posts holen
        foreach($them_arr as $Thema):
        // echo $element;
            //Posts in den Themen holen
            $sql2 = "SELECT post FROM posts WHERE zugThema = ?";
            $stmt = mysqli_stmt_init($conn2);
            if(!mysqli_stmt_prepare($stmt,$sql2)){
                header("Location: ../Forum.php?error=sql_error_PostsHolen".mysqli_error($conn2));
                exit();
            }
            else {
                mysqli_stmt_bind_param($stmt,"s",$Thema);
                mysqli_stmt_execute($stmt);
                $ergebnis=mysqli_stmt_get_result($stmt);
                //Alle Posts in einem Array Speichern
                while ($row = mysqli_fetch_assoc($ergebnis)){
                    $allePosts[$arrayPos] = $row['post'];
                    $arrayPos++;
                 }
            }
        endforeach;
        // var_dump($allePosts);
        //Alle antworten zu den Posts Finden
        //------------------------------------------------Vermutlich unnötig !!!!!!
        // $alleAntworten = array();
        // $arrayPos = 0;
        // foreach($allePosts as $Post):
        //     //Antworten in den Posts holen
        //     $sql3 = "SELECT id FROM antworten WHERE zugPost = ?";
        //     $stmt = mysqli_stmt_init($conn2);
        //     if(!mysqli_stmt_prepare($stmt,$sql3)){
        //         header("Location: ../Forum.php?error=sql_error_Antworten");
        //         exit();
        //     }
        //     else {
        //         mysqli_stmt_bind_param($stmt,"s",$Post);
        //         mysqli_stmt_execute($stmt);
        //         $ergebnis=mysqli_stmt_get_result($stmt);
        //         //Alle Posts in einem Array Speichern
        //         while ($row = mysqli_fetch_assoc($ergebnis)){
        //             $alleAntworten[$arrayPos] = $row['id'];
        //             $arrayPos++;
        //         }
        //     }
        // endforeach;
        // var_dump($alleAntworten);

        //Antworten löschen
        foreach($allePosts as $Post):
        $sql4 = "DELETE FROM `antworten` WHERE `zugPost` = ?";
        $stmt = mysqli_stmt_init($conn2);
        if(!mysqli_stmt_prepare($stmt,$sql4)){
            header("Location: ../Forum.php?error=sql_error_AntwortLöschen".mysqli_error($conn2));
            exit();
        }
        else {
            mysqli_stmt_bind_param($stmt,"s",$Post);
            mysqli_stmt_execute($stmt);
        }
        endforeach;
        //Posts löschen
        foreach($them_arr as $Thema):
            $sql5 = "DELETE FROM `posts` WHERE `zugThema` = ?";
            $stmt = mysqli_stmt_init($conn2);
            if(!mysqli_stmt_prepare($stmt,$sql5)){
                header("Location: ../Forum.php?error=sql_error_PostLöschen".mysqli_error($conn2));
                exit();
            }
            else {
                mysqli_stmt_bind_param($stmt,"s",$Thema);
                mysqli_stmt_execute($stmt);
            }
            endforeach;
        //Thema löschen
        $sql6 = "DELETE FROM `themen` WHERE `zugKategorie` = ?";
        $stmt = mysqli_stmt_init($conn2);
        if(!mysqli_stmt_prepare($stmt,$sql6)){
            header("Location: ../Forum.php?error=sql_error_ThemenLöschen".mysqli_error($conn2));
            exit();
        }
        else {
            mysqli_stmt_bind_param($stmt,"s",$löschen);
            mysqli_stmt_execute($stmt);
        }
        //Kategorie löschen
        $sql6 = "DELETE FROM `kategorien` WHERE `kategorie` = ?";
        $stmt = mysqli_stmt_init($conn2);
        if(!mysqli_stmt_prepare($stmt,$sql6)){
            header("Location: ../Forum.php?error=sql_error_KategorieLöschen".mysqli_error($conn2));
            exit();
        }
        else {
            mysqli_stmt_bind_param($stmt,"s",$löschen);
            mysqli_stmt_execute($stmt);
        }
        $filename = 'Forum_Löschen.txt';
        $date = date("d.m.Y - H:i", time());
        $somecontent = "$date | Nutzer: $_SESSION[User] Löschte Kategorie: $löschen welche die Themen: ".implode(',',$them_arr )." beinhaltete. Die Posts ".implode(',',$allePosts )." wurden gelöscht \n";
        
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
        header("Location:../Forum.php?=Kategorie_löschen=erfolgreich");
    

  
    }
}
else {
    header("Location: ../Forum.php?error=Löschen is nicht");
}


?>

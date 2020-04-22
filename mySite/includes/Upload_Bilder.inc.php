<?php
include_once "dbh.inc.php";
session_start();
?>

<?php

//Uploads für das Profielbild entweder aus dem Profiel oder beim sign up
if(isset($_POST['upload-ProfilBild'])||isset($_POST['signeup-submit'])){

    //Wenn sign-up
    if(isset($_POST['signeup-submit'])){
        $usr= htmlspecialchars(stripcslashes(trim($_POST['nick'])));
    }
    //Wenn aus Profiel
    else{
        $usr = $_SESSION['User'];
    }
    $file = $_FILES['DateiZumHochladen'];

    $fileName =$_FILES['DateiZumHochladen']['name'];
    $fileTmpName =$_FILES['DateiZumHochladen']['tmp_name'];
    $fileSize =$_FILES['DateiZumHochladen']['size'];
    $fileError =$_FILES['DateiZumHochladen']['error'];
    $fileType =$_FILES['DateiZumHochladen']['type'];

    $fileExt = explode('.',$fileName);
    $fileActExt = strtolower(end($fileExt));

    $allowd = array('jpg','jpeg','png');

    if(in_array($fileActExt,$allowd)){
        if($fileError === 0){
            if($fileSize < 8*1024*1024*16){

                $filenNameNew = $usr.".".$fileActExt;
                $Ziel = '../../Uploads/Bilder_Profil/Orginaleuploads/'.$filenNameNew;
                //Orginalbild Verschieben
                move_uploaded_file($fileTmpName,$Ziel); 
                  
                //Vorschaubild erstellen        
                include "bildskalierung.inc.php";           
                $filepath_new ='../../Uploads/Bilder_Profil/'.$filenNameNew;
                $image_dimension = 300;
                createResizedImage ($Ziel, $filepath_new, $image_dimension, $scale_mode = 0); 
                
                
                header("Location: ../Profil.php?upload=success");
                //villeicht noch 
                // header("Location: ../join_us.php?upload=success");

                // Statusupdate zum Bild änderne
                $sql = " UPDATE user SET status = 1 WHERE Nick = ?;";
                $stmt = mysqli_stmt_init($conn);

                    if(!mysqli_stmt_prepare($stmt,$sql)){
                        header("Location: ../index.php?error=sql_error");
                        exit();
                    }
                    //Wenn es klappt:
                    else{
                        mysqli_stmt_bind_param($stmt,"s",$usr);
                        mysqli_stmt_execute($stmt);
                    }
                
            }
            else{
                echo "Das Bild ist zu groß";
            }
        }
        else{
            echo $fileError;
            echo "Fehler beim Hochladen";
        }

    }
    else{
        echo "Ungültiges Bildformat";
    }
}
?>
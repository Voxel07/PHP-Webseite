<?php
session_start();
include_once "dbh.inc.php";
$usr = $_SESSION['User'];

$dateiname = "../../Uploads/Bilder_Profil/".$usr."*";
$dateiInfo = glob($dateiname);
$dateiEndung= explode(".",$dateiInfo[0]);
$echteDateiEndung = $dateiEndung[5];

$file="../../Uploads/Bilder_Profil/".$usr.".".$echteDateiEndung;
$file2="../../Uploads/Bilder_Profil/Orginaleuploads/".$usr.".".$echteDateiEndung;

if(!unlink($file)||!unlink($file2)){
echo'Fehler beim Löschen';
header("Location: ../Profil.php?delete=fehlgeschlagen");
}
else{
    // echo'Bild gelöscht';

    // Statusupdate zum Bild änderne 
    $status = 0;
    $sql = " UPDATE nutzer SET Profielbild = ? WHERE Nick = ?;";
    $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt,$sql)){
            header("Location: ../index.php?error=sql_error".mysqli_errno($conn));
            exit();
        }
        //Wenn es klappt:
        else{
            mysqli_stmt_bind_param($stmt,"is",$status,$usr);
            mysqli_stmt_execute($stmt);
    
        
        }
    header("Location: ../Profil.php?delete=success");
}

?>
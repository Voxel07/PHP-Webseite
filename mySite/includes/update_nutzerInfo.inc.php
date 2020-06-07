<?php
include_once "dbh.inc.php";
session_start();
?>


<?php //Funktionen
//Update Funktion
function updateInfo($table, $wert,$id){
    $sql ="UPDATE nutzer SET ? = ? WHERE id = ?";
    $stmt = mysqli_stmt_init($conn);
    
    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("Location: ../Profil.php?error=sql_error_update".mysqli_error($conn));
        exit();
    }
    else {
        mysqli_stmt_bind_param($stmt,"ssi",$table,$wert, $id);
        mysqli_stmt_execute($stmt); 
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>
<?php 
if (isset($_POST['kjp'])&&isset($_SESSION['User'])&&$_SESSION['rang']>=0){
    $id = $_SESSION['id'];
    $feldName= htmlspecialchars(stripcslashes(trim($_GET['update-feld'])));
    $neuerWert= htmlspecialchars(stripcslashes(trim($_GET['update-wert'])));
    
    updateInfo($feldName,$neuerWert,$id);
    
    header("Location: ../index.php?update=$feldName ");
    exit();
}
else{
    header("Location: ../Profil.php?was willst du hier");
    exit();
}


?>
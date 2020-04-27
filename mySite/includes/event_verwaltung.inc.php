<?php
include_once "dbh.inc.php";
session_start();
?>



<?php
// Events einfügen
if(isset($_POST['Neues_Event'])&&isset($_SESSION['User'])&&$_SESSION['rang']>0){

    $eventName = htmlspecialchars(stripcslashes(trim($_POST['ev-name'])));
    $eventName = str_replace(" ","-",$eventName);
    if(isset($_POST["ev-link"])){
        $eventLink = htmlspecialchars(stripcslashes(trim($_POST['ev-link'])));
    }
    else{
        $eventLink ="#";
    }
    $eventDate = htmlspecialchars(stripcslashes(trim($_POST['ev-date'])));
    $evErsteller = $_SESSION['User'];
    
    $sql = "INSERT INTO events (name, link, datum, ersteller) VALUES (?,?,?,?)";
    $stmt = mysqli_stmt_init($conn);
    
    if(!mysqli_stmt_prepare($stmt,$sql)){
        echo'Kaputt';
        header("Location: ../index.php?error=sql_error_insert".mysqli_error($conn));
        exit();
    }
    else {
        mysqli_stmt_bind_param($stmt,"ssss",$eventName,$eventLink,$eventDate,$evErsteller);
        mysqli_stmt_execute($stmt); 

        $filename = 'Events.txt';
        $date = date("d.m.Y - H:i", time());
        $somecontent = "$date | Event: $eventName vom Nutzer: $evErsteller eingetragen\n";
        
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
    header("Location: ../index.php?eingetragen=$eventName");
    exit();
}

// Events löschen
//elseif (isset($_GET['löschen'])) {
elseif (isset($_GET['löschen'])&&isset($_SESSION['User'])&&$_SESSION['rang']>0) {

    $id = htmlspecialchars(stripcslashes(trim($_GET['löschen'])));
    $evZumLöschen = htmlspecialchars(stripcslashes(trim($_GET['name'])));
    $löscher = $_SESSION['User'];

    $sql = "DELETE FROM events WHERE id = ?";
    $stmt = mysqli_stmt_init($conn);
    
    if(!mysqli_stmt_prepare($stmt,$sql)){
        echo'Kaputt';
        header("Location: ../index.php?error=sql_error_löschen");
        exit();
    }
    else {
        mysqli_stmt_bind_param($stmt,"i",$id);
        mysqli_stmt_execute($stmt); 

        $filename = 'Events.txt';
        $date = date("d.m.Y - H:i", time());
    
        $somecontent = "$date | Event: $evZumLöschen vom Nutzer: $löscher gelöscht\n";
        
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

        header("Location: ../index.php?gelöscht=$evZumLöschen");
    }
}

//Event updaten
elseif ($_GET['edit']&&isset($_SESSION['User'])&&$_SESSION['rang']>=0) {
//elseif(isset($_GET['edit'])){
    $id = htmlspecialchars(stripcslashes(trim($_GET['edit'])));
    $evZumÄndern = htmlspecialchars(stripcslashes(trim($_GET['name'])));

    $sql ="SELECT * FROM events WHERE id =?";
    $stmt = mysqli_stmt_init($conn);
    
    if(!mysqli_stmt_prepare($stmt,$sql)){
        echo'Kaputt';
        header("Location: ../index.php?error=sql_error_edit");
        exit();
    }
    else {
        mysqli_stmt_bind_param($stmt,"i",$id);
        mysqli_stmt_execute($stmt); 
      
        $event = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($event);
       
        if($row != NULL){
            // $row = mysqli_fetch_assoc($event);
            $_SESSION['name'] = $row['name'];
            $_SESSION['link'] = $row['link'];
            $_SESSION['datum'] = $row['datum'];
            $_SESSION['id']=$row['id'];

          header("Location: ../index.php?edit=true");
        }
    }
}
elseif (isset($_POST['update'])&&isset($_SESSION['User'])&&$_SESSION['rang']>0) {
//elseif (isset($_POST['update'])) {
    $id = htmlspecialchars(stripcslashes(trim($_POST['id'])));
    $editor = $_SESSION['User']; 

    $eventName = htmlspecialchars(stripcslashes(trim($_POST['ev-name'])));
    $eventName = str_replace(" ","-",$eventName);
    $eventLink = htmlspecialchars(stripcslashes(trim($_POST['ev-link'])));
    $eventDate = htmlspecialchars(stripcslashes(trim($_POST['ev-date'])));

    $sql ="UPDATE events SET name = ?, link = ?, datum = ? WHERE id = ?";
    $stmt = mysqli_stmt_init($conn);
    
    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("Location: ../index.php?error=sql_error_update".mysqli_error($conn));
        exit();
    }
    else {
        mysqli_stmt_bind_param($stmt,"sssi",$eventName,$eventLink,$eventDate, $id);
        mysqli_stmt_execute($stmt); 

        
        $filename = 'Events.txt';
        $date = date("d.m.Y - H:i", time());
        $somecontent = "$date | Event: $eventName vom Nutzer: $editor bearbeitet\n";
        
        if (is_writable("../../Logdaten/$filename")) {
            if (!$handle = fopen("../../Logdaten/$filename", "a")) {
                    print "Kann die Datei $filename nicht öffnen";
                    exit();
            }
            if (!fwrite($handle, $somecontent)) {
                print "Kann in die Datei $filename nicht schreiben";
                exit();
            }
            fclose($handle);
        
        } else {
            print "Die Datei $filename ist nicht schreibbar";
        }
        header("Location: ../index.php?update=$eventName ");
    }
}

else {
    header("Location: ../index.php?was willst du hier");
}

?>
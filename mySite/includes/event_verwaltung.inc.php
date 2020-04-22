<?php
include_once "dbh.inc.php";
session_start();
?>



<?php
if(isset($_POST['Neues_Event'])&&isset($_SESSION['User'])){

    $eventName = htmlspecialchars(stripcslashes(trim($_POST['ev-name'])));
    $eventLink = htmlspecialchars(stripcslashes(trim($_POST['ev-link'])));
    $eventDate = htmlspecialchars(stripcslashes(trim($_POST['ev-date'])));
    $evErsteller = $_SESSION['User'];
    
    $sql = "INSERT INTO events (name, link, datum, ersteller) VALUES (?,?,?,?)";
    $stmt = mysqli_stmt_init($conn);
    
    if(!mysqli_stmt_prepare($stmt,$sql)){
        echo'Kaputt';
        header("Location: ../event.php?error=sql_error_insert".mysqli_error($conn));
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
    header("Location: ../event.php?Event eingetragen");
    exit();
}
elseif ($_POST['Event_Löschen']&&isset($_SESSION['User'])) {

    $evZumLöschen = htmlspecialchars(stripcslashes(trim($_POST['ev-name'])));

    $sql = "DELETE FROM events WHERE event = ?";
    $stmt = mysqli_stmt_init($conn);
    
    if(!mysqli_stmt_prepare($stmt,$sql)){
        echo'Kaputt';
        header("Location: ../event.php?error=sql_error_insert");
        exit();
    }
    else {
        mysqli_stmt_bind_param($stmt,"s",$evZumLöschen);
        mysqli_stmt_execute($stmt); 

        $filename = 'Events.txt';
        $date = date("d.m.Y - H:i", time());
        $somecontent = "$date | Event: $evZumLöschen vom Nutzer: $evErsteller gelöscht\n";
        
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
else {
    header("Location: ../event.php?läuft");
}

?>
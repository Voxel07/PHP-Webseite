<?php 

include_once "header.php";

echo'<link rel="stylesheet" href="../Styles/verifizierung.css">';
?>

<?php

    echo'<div class="bestätigungs-box">';

    //Für das erfolgreiche Regestrieren
    if(isset($_GET['signeup']))
    {
        if($_GET['signeup'] == "success"){
            echo'

            <div class="erfolgreich-registriert">
                <p>Du hast dich erfolgreich Registrert.</p>
                <p>Es wurde eine Bestätigungsmail an <strong>'.$_GET['email'].'</strong> gesendet.</p>
                    <p> Bitte bestätige diese um dein Konto zu verifizieren.</p>  
            </div>';
        }    
    }
    //Für das Bestätigen der Email
    if (isset($_GET['verify'])) 
    {
        //Nur wenn jemand eingeloggt ist
        if(!isset($_SESSION['User']))
        {
            echo'Du musst angemeldet sein um dein Konto zu bestätigen';
        }
        else
        {
            include_once "includes/dbh.inc.php";
            
            //ID und Namen aus dem Link holen
            $idExtern = $_GET['id'];
            $nutzer = $_GET['nutzer'];

            //Vergleichen ob der Angemeldete auch der freiszuschaltende ist
            if($_SESSION['User']!=$nutzer)
            {
                echo'Fehler Nutzer nicht gleich';
            }
            else
            {
                //Daten des Freizuschaltenden aus der DB Holen
                $sql ="SELECT verID, Verifiziert FROM nutzer WHERE Nick = ?";
                $stmt = mysqli_stmt_init($conn);
                if(!mysqli_stmt_prepare($stmt, $sql)){
                    header("Location: ../join_us.php?error=verifizieren" .mysqli_connect_error($conn));
                    exit();
                }
                else
                {
                    mysqli_stmt_bind_param($stmt,"s",$nutzer);
                    mysqli_stmt_execute($stmt);
                    $ergebnis = mysqli_stmt_get_result($stmt);
                    $row= mysqli_fetch_assoc($ergebnis);

                    $status = $row['Verifiziert'];
                    
                    //Prüfen ob der Nutzer schon Regestirert ist dann hier ende
                    if($status==true)
                    {
                        echo
                        '<div class="erfolgreich-verifiziert">
                            <p>Kontoverivizierung abgeschlossen</p>
                            <p>Wenn duch dich Vorstellen möchtest steht dir das Forum jetzt zur verfügung</p>
                            <p>Wenn du ein Mitglied bist wende dich an einen Admin, damit er deinen Status anpasst.</p>
                        </div>';
                    }
                    else
                    {
                        $idIntern = $row['verID'];
                        //Id´s vergleichen
                        if($idIntern!=$idExtern)
                        {
                            echo'Verifikation fehlgeschlagen !';
                        }
                        else
                        {
                            //Status in der DB ändern
                            $status = 1;
                            $sql2 = " UPDATE nutzer SET Verifiziert = ? WHERE Nick = ?";
                            if(!mysqli_stmt_prepare($stmt, $sql2))
                            {
                                echo'sql fehler update';
                                // header("Location: ../".$herkunft."?error=sql_error_anzUpdate_user");
                                exit();
                            }
                            else
                            {
                                mysqli_stmt_bind_param($stmt,"is",$status,$nutzer);
                                mysqli_stmt_execute($stmt);

                                echo' 
                                <div class="erfolgreich-verifiziert">
                                    <p>Kontoverivizierung abgeschlossen</p>
                                    <p>Wenn duch dich Vorstellen möchtest steht dir das Forum jetzt zur verfügung</p>
                                    <p>Wenn du ein Mitglied bist wende dich an einen Admin, damit er deinen Status anpasst.</p>
                                </div>';
                                
                                mysqli_stmt_close($stmt);
                                mysqli_close($conn);
                            }
                        }
                    }
                }
            }
        }
    }
    echo'</div>';



?>
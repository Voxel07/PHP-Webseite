<?php
include "Header.php";
include_once "includes/dbh_Forum.inc.php";
include_once "includes/dbh.inc.php";
echo'<link rel="stylesheet" href="../Styles/style_Forum.css">';
?>


<?php
// if(isset($_GET['post'])&&isset($_GET['zugThema'])){
if(isset($_GET['post'])){

    //Pfusch
    $postZumAufrufen = $_GET['post'];
    // $zugThema = $_GET['zugThema'];
    // $zugKat = $_GET['zugKat'];
   
    //Post aus DB holen neu, da keine doppelten erlaubt
    // $sql1 ="SELECT * FROM posts WHERE post = ? && zugThema = ? ";
    $sql1 ="SELECT * FROM posts WHERE post = ?";
    $stmt = mysqli_stmt_init($conn2);
    if(!mysqli_stmt_prepare($stmt,$sql1)){
    echo "SQL Fehler !!".mysqli_error($conn2);
    }
    else
    {
        // mysqli_stmt_bind_param($stmt,"ss",$postZumAufrufen,$zugThema);
        mysqli_stmt_bind_param($stmt,"s",$postZumAufrufen);
        mysqli_stmt_execute($stmt);
        $beitrag = mysqli_stmt_get_result($stmt);
        $post= mysqli_fetch_assoc($beitrag);
    }

    //Nutzer der den Post geschrieben hat aus DB holen
    $sql2 = "SELECT * FROM nutzer WHERE nick = ? ";
    $stmt2 = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt2,$sql2)){
        echo "SQL Fehler !!".mysqli_error($conn2);
    }
    else
    {
        mysqli_stmt_bind_param($stmt2,"s",$post["ersteller"]);
        mysqli_stmt_execute($stmt2);
        $nutzerErg = mysqli_stmt_get_result($stmt2);
        $nutzer= mysqli_fetch_assoc($nutzerErg);
    }
    //Menü ausgeben
    echo'
    <div class="Form_Nav">
        <a href="Forum.php">Forum</a>
        <a href="#">Neuste Posts</a>
    </div>';
    //Navigation ausgeben
    echo'
    <div class="Form_Pfad">
        <a href="Forum.php">Home</a>
        <p>=></p>
        <a href="Forum_Kategorie.php?kategorie='.$post["zugKategorie"].'">'.$post["zugKategorie"].'</a>
        <p>=></p>
        <a href="Forum_Themen.php?thema='.$post["zugThema"].'">'.$post["zugThema"].'</a>
        <p>=></p>
        <p>'.$postZumAufrufen.'</p>
    </div>';

    //Den Infobalken ausgeben
    echo'
    <div class="Form_Info_Post">
        <h2>'.$postZumAufrufen.'</h2>
        <p>Erstellt von: <strong>'.$post["ersteller"].'</strong>. Erstellt am: <strong>'.date("d.m.Y - H:i",$post["erstellungsdatum"]).'</strong>. In der Kategorie: <a href="Forum_Themen.php?thema='.$post["zugThema"].'"><strong>'.$post["zugThema"].'</strong></a>. Antworten: <strong>'.$post["anzAntworten"].'</strong> </p>
    </div>';

    //Den Post ausgeben
    echo'<div class = "Forum_Box">';
        echo'
       
        <div class = "Post_Box">
            
            <div class ="Post_Ersteller" >';
                echo'<div class="Autor_Profielbild" style ="background-image: url(../Bilder/Mitglieder/Logo.png)"></div>';
                echo'<div class="Autor_Name">'.$nutzer["Nick"].'</div>';
                echo'<div class="Autor_Posts">Anz.Beiträge:'.$nutzer["anz_Beiträge"].'</div>';
                echo'<div class="Autor_Posts">Anz.Antworten'.$nutzer["anz_Antworten"].'</div>';
                echo'
            </div>
            <div class ="Post_Inhalt" >
                <p>'.($post['inhalt']).'</p>
            </div>';
                echo'
        </div><!--Titel des Tehmas & Beschreibung Box zu -->';
        
        //Antworten zum Post aus der DB holen
        // $sql3 ="SELECT * FROM antworten WHERE PostID = '".$post['id']."'";
        $sql3 ="SELECT * FROM antworten WHERE PostID = ? ";
        $stmt = mysqli_stmt_init($conn2);
        if(!mysqli_stmt_prepare($stmt,$sql3)){
            echo "SQL Fehler !!";
        }
        else
        {
            mysqli_stmt_bind_param($stmt,"s",$post['id']);
            mysqli_stmt_execute($stmt);
            $antworten = mysqli_stmt_get_result($stmt);
            while($row = mysqli_fetch_assoc($antworten))
            {
                //Jedes mal Nutzer für den Post aus der DB holen 
                // $sql4 = "SELECT * FROM nutzer WHERE nick ='".$row["ersteller"]."' ";
                $sql4 = "SELECT * FROM nutzer WHERE nick =? ";
                $stmt2 = mysqli_stmt_init($conn);
                if(!mysqli_stmt_prepare($stmt2,$sql4)){
                    echo "SQL Fehler !!";
                }
                else
                {
                    mysqli_stmt_bind_param($stmt2,"s",$row["ersteller"]);

                    mysqli_stmt_execute($stmt2);
                    $nantwoErg = mysqli_stmt_get_result($stmt2);
                    $antworter= mysqli_fetch_assoc($nantwoErg);
                }
            echo'<div class ="Antwort_Box">'; 
                echo'<div class="Antwort_Autor">';
                //Bild einfügen
                    echo'<div class="Autor_Profielbild" style ="background-image: url(../Bilder/Mitglieder/Logo.png)">  </div>';
                    echo'<div class="Autor_Name">'.$antworter["Nick"].'</div>';
                        echo'<div class="Autor_Posts">Beiträge: '.$antworter["anz_Beiträge"].'</div>';
                        echo'<div class="Autor_Posts">Antworten: '.$antworter["anz_Antworten"].'</div>';
                echo'</div>';
                        echo'<div class="Antwort_Text">'.$row['inhalt'].'</div> ';
                
            echo'</div>';
            }
        } 
        // include "texteditor.php";
 
        if(isset($_SESSION['User']) && $_SESSION['rang']>0)
        {
        echo'<div class="">';
            echo'<form action = "includes/Forum_Antworten.inc.php?herkunft=Forum_Posts.php&zugThema='.$post["zugThema"].'" method="post">             
                    <input type="text" name ="inhalt" placeholder="Schreibe eine Antwort" autofocus maxlength="50"/>
                    <input type ="hidden" name ="post" placeholder="pfusch" value="'.$postZumAufrufen.'" readonly></input>
                    <button type="submit" name="Post-Antwort"/>Antworten</button>    
                </form>';
        echo'</div>'; 
        }  

    echo'</div>'; //Forum zu
}
else{
    // header("Location:Forum.php?Hier nur mit Post & zugThema !!");   
}
?>




<?php
include_once "footer.php";
?>
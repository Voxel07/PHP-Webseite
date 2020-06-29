<?php
include_once "Header.php";
include_once "includes/dbh_Forum.inc.php";
echo'<link rel="stylesheet" href="../Styles/style_Forum.css">';

?>



<?php

if(isset( $_GET['kategorie'])){
   
    //Pfusch
    //Übergibt die aufzurufende Kategorie an die nächste Seite
    $KategorieZumAufrufen = htmlspecialchars(stripcslashes(trim($_GET['kategorie'])));
    
    //Alle Infos zur Kategorie aus der DB Holen
    $sql ="SELECT * FROM kategorien WHERE kategorie = ?";
    $stmt = mysqli_stmt_init($conn2);
    if(!mysqli_stmt_prepare($stmt,$sql)){
    echo "SQL Fehler !!". mysqli_error($conn2);
    }
    else
    {
        mysqli_stmt_bind_param($stmt,"s",$KategorieZumAufrufen);
        mysqli_stmt_execute($stmt);
        $array = mysqli_stmt_get_result($stmt);
        $kategorien = mysqli_fetch_assoc($array);
    }
    //Alle Themen der Kategorie aus der DB holen
    $sql1 ="SELECT * FROM themen WHERE zugKategorie = ? ORDER BY reihenfolge DESC";
    $stmt = mysqli_stmt_init($conn2);
    if(!mysqli_stmt_prepare($stmt,$sql1)){
        echo "SQL Fehler !!";
    }
    else
    {
        //Navigation
        mysqli_stmt_bind_param($stmt,"s",$KategorieZumAufrufen);
        mysqli_stmt_execute($stmt);
        $ausgabe = mysqli_stmt_get_result($stmt);

        echo'
        <div class="Form_Nav">
            <a href="Forum.php">Forum</a>
            <a href="#">Neuste Posts</a>
        </div>
        <div class="Form_Pfad">
            <a href="Forum.php">Home</a>
            <p>=></p>
            <p>'.str_replace("_"," ",$kategorien["kategorie"]).'</p>
        </div>';
        
        
        echo'<div class = "Forum_Box">';
        echo'
        <div class = "Kategorie">
        <div class= Kategorie-Titel>
        
        <h2>'.str_replace("_"," ",$kategorien["kategorie"]).'</h2> 
         Erstellt am: '.date("d.m.Y - H:i",$kategorien["erstellungsdatum"]).' Anzahl Themen: '.$kategorien["anz_Themen"].'';
          //Kategorie Löschen Butten für Vorsände
          if(isset($_SESSION['rang'])>=3){
            echo'<form action = "includes/löschen_Forum.inc.php?herkunft=Forum.php" method="post"> 
             <button type="submit" name="Löschen-Kategorie"/>Kategorie löschen</button>
             <input type="hidden" name="KatZumLöschen" value="'.$kategorien["kategorie"].'" readonly>
             </form>';
            }
                echo'
        </div>';
    
        //Themen ausgeben
        while ($reiheThe = mysqli_fetch_assoc($ausgabe))
        {
            echo'
                <div class ="Thema">
                    <div class =Thema-test>
                        <div class = "gelesen"><svg class="svg-icon" viewBox="0 0 20 20">
                            <path d="M3.183,9.381H0.704v1.239h2.479V9.381z M2.989,16.135l0.876,0.877l1.752-1.754l-0.876-0.875L2.989,16.135z
                                M17.012,3.866l-0.877-0.876l-1.752,1.752l0.875,0.876L17.012,3.866z M10.62,0.705H9.38v2.479h1.239V0.705z M5.618,4.742
                            L3.865,2.989L2.989,3.866l1.753,1.752L5.618,4.742z M14.383,15.258l1.752,1.754l0.877-0.877l-1.754-1.752L14.383,15.258z
                            M9.38,19.297h1.239v-2.48H9.38V19.297z M16.816,9.381v1.239h2.479V9.381H16.816z M10,5.042c-2.738,0-4.958,2.22-4.958,4.958
                            c0,2.738,2.22,4.959,4.958,4.959c2.738,0,4.958-2.221,4.958-4.959C14.958,7.263,12.738,5.042,10,5.042z M10,13.727
                            c-2.058,0-3.726-1.668-3.726-3.727c0-2.058,1.668-3.726,3.726-3.726c2.059,0,3.727,1.668,3.727,3.726
                            C13.727,12.059,12.059,13.727,10,13.727z"></path>
                            </svg>
                        </div>
                        <div  class ="Thema-Titel">
                            <h3><a href="Forum_Themen.php?thema='.$reiheThe["thema"].'">'.str_replace("_"," ",$reiheThe["thema"]).'</a></h3>
                            <p>'.$reiheThe["beschreibung"].'</p>
                        </div>
                    </div><!--Titel des Tehmas & Beschreibung Box zu -->
                    <div  class ="Thema-Info">
                        <h4>'.$reiheThe["anzPosts"].'</h4>
                        <p>Posts</p>
                    </div><!--Anzahl der Beiträge zum Thema Box zu -->
                    <div class ="Thema-LB">
                        <a href="#">Link zum neusten Beitrag</a>
                        <p>vom '.date("d.m.Y - H:i",$reiheThe["erstellungsdatum"]).'</p>
                    </div>
                    <div>';
                    //Thema Löschen Butten für Vorsände
                    if(isset($_SESSION['rang'])>=3){
                        echo'<form action = "includes/löschen_Forum_Thema.inc.php?herkunft=Forum_Kategorie.php" method="post"> 
                        <button type="submit" name="Löschen-Thema"/>Thema löschen</button>
                        <input type="hidden" name="TheZumLöschen" value="'.$reiheThe["thema"].'" readonly>
                        <input type="hidden" name="Kategorie" value="'.$reiheThe["zugKategorie"].'" readonly>
                        </form>';
                    }
                    else {                          
                        //Wenn der Nutzer der Ersteller ist und Keine Posts vorhenden sind darf er löschen
                        if(isset($_SESSION['User'])==$reiheThe["ersteller"]&&$reiheThe["anzPosts"]==0){

                            if($reiheThe["anzPosts"]==0){
                                echo'<form action = "includes/löschen_Forum_Thema.inc.php?herkunft=Forum_Kategorie.php" method="post"> 
                                <button type="submit" name="Löschen-Thema"/>Thema löschen</button>
                                <input type="hidden" name="TheZumLöschen" value="'.$reiheThe["thema"].'" readonly>
                                <input type="hidden" name="Kategorie" value="'.$reiheThe["zugKategorie"].'" readonly>
                                </form>';
                            }
                            else{
                                echo'Als Ersteller des Tehmas darfst du es nur löschen, wenn keine Beiträge drin sind';
                            }
                        }
                        else{
                            echo'Admin oder Ersteller dürfen löschen';
                        }
                    }                        
            echo'</div>
                </div><!--Thema Box zu -->';         
        } 

        if(isset($_SESSION['User']) && $_SESSION['rang']>0){
            echo'<div class="Add-Thema">';
            echo'<div class="Add-Thema-Butten" onclick="addThema(0)">
                     </div>';
                echo'<div id="addThema-0" class="Add-Thema-Form"><form action = "includes/Forum_Thema.inc.php?herkunft=Forum_Kategorie.php" method="post">             
                        <input tyxpe="text" name ="thema" placeholder="Name des Themas" autofocus maxlength="35"/>
                        <input tyxpe="text" name ="beschreibung" placeholder="Beschreibe worum es geht"  maxlength="50"/>
                        <input type ="hidden" name ="Kategorie" placeholder="pfusch" readonly value="'.$kategorien["kategorie"].'" ></input>
                        <button type="submit" name="Forum-Thema"/>Neue Thema erstellen</button>    
                    </form></div>';
            echo'</div>'; 
            }

        echo'</div>';  //Kategorien zu
    }
        

    echo'</div>'; //Forum zu
}
else{
    header("Location:Forum.php?Hier nur mit Kategorie !!");   
}
?>




<?php
include_once "footer.php";
?>
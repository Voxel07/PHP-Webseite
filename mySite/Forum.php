<?php
include "Header.php";
include_once "includes/dbh_Forum.inc.php";
echo'<link rel="stylesheet" href="../Styles/style_Forum.css">';
?>
<?php

$sql1 ="SELECT * FROM kategorien ORDER BY reihenfolge ASC";

$stmt = mysqli_stmt_init($conn2);
if(!mysqli_stmt_prepare($stmt,$sql1)){
echo "SQL Fehler !!". mysqli_error($conn2);
}
else
{
    mysqli_stmt_execute($stmt);
    $kategorien = mysqli_stmt_get_result($stmt);
    //Navigationsleiste
    echo'
    <div class="Form_Nav">
        <a href="Forum.php">Forum</a>
        <a href="#">Neuste Posts</a>
        <a href="texteditor.php">Texteditor</a>
        <a href="Forum_test.php">Ungelesene Posts</a>
    </div>
    <div class="Form_Pfad">
        <a href="Forum.php">Home</a>
    </div>';
    

    echo'<div class = "Forum_Box">';
    $zahl = 0;
    //Kategorien ausgeben
    while ($reiheKat = mysqli_fetch_assoc($kategorien))
    { $zahl ++;
        //Entscheiden ob der aktive nutzer das sehen darf
        if(isset($_SESSION['rang'])>=$reiheKat['Sichtbarkeit'])
        {
            echo'
            <div class = "Kategorie">
            <div class= Kategorie-Titel>
                <h2><a href="Forum_Kategorie.php?kategorie='.$reiheKat["kategorie"].'">'.str_replace("_"," ",$reiheKat["kategorie"]).'</a></h2>  ';
                echo'Erstellt am: '.date("d.m.Y - H:i",$reiheKat["erstellungsdatum"]).'
                Anzahl Themen: '.$reiheKat["anz_Themen"].'
                ';
            //Kategorie Löschen Butten für Vorsände
            if(isset($_SESSION['rang'])>=3){
            echo'<form action = "includes/löschen_Forum.inc.php?herkunft=Forum.php" method="post"> 
             <button type="submit" name="Löschen-Kategorie"/>Kategorie löschen</button>
             <input type="hidden" name="KatZumLöschen" value="'.$reiheKat["kategorie"].'" readonly>
             </form>';
            }
                echo'</div>';
            $sql2 ="SELECT * FROM themen WHERE zugKategorie = '".$reiheKat["kategorie"]."' ORDER BY reihenfolge DESC";
            if(!mysqli_stmt_prepare($stmt,$sql2)){
            echo "SQL Fehler bei Thema!!". mysqli_error($conn2);
            }
            else
            {
                mysqli_stmt_execute($stmt);
                $thema = mysqli_stmt_get_result($stmt);
                //Themen der einzelnen Kategorien ausgeben
                while ($reiheThe = mysqli_fetch_assoc($thema))
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
                 </svg></div>
                        <div  class ="Thema-Titel">
                        
                            <h3><a href="Forum_Themen.php?thema='.$reiheThe["thema"].'&kat='.$reiheKat["kategorie"].'">'.str_replace("_"," ",$reiheThe["thema"]).'</a></h3>
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
                            echo'<form action = "includes/löschen_Forum_Thema.inc.php?herkunft=Forum.php" method="post"> 
                            <button type="submit" name="Löschen-Thema"/>Thema löschen</button>
                            <input type="hidden" name="TheZumLöschen" value="'.$reiheThe["thema"].'" readonly>
                            <input type="hidden" name="Kategorie" value="'.$reiheThe["zugKategorie"].'" readonly>
                            </form>';
                        }
                        
                        echo'</div>
                    </div><!--Thema Box zu -->';
                }
            } 

            //Thema hinzufügen
            if(isset($_SESSION['User']) && $_SESSION['rang'] > 0){
                echo'<div class="Add-Thema">';
                echo'<div class="Add-Thema-Butten" onclick="addThema('.$zahl.')">
                     </div>';
                        echo'<div id="addThema-'.$zahl.'" class="Add-Thema-Form"><form action = "includes/Forum_Thema.inc.php?herkunft=Forum.php" method="post">             
                                <input tyxpe="text" name ="thema" placeholder="Name des Themas" autofocus maxlength="35"/>
                                <input tyxpe="text" name ="beschreibung" placeholder="Beschreibe worum es geht" maxlength="50"/>
                                <input type ="text" name ="Kategorie" placeholder="pfusch" value="'.$reiheKat["kategorie"].'" readonly></input>
                                <button type="submit" name="Forum-Thema"/>Neue Thema erstellen</button>    
                            </form></div>';
                echo'</div>'; 
                }
        
            echo'</div>';  //Kategorien zu
        }
    }
     //Kategorie hinzufügen
    if(isset($_SESSION['User']) && $_SESSION['rang'] > 0){
        echo'<div class="Add-Kategorie">
        <div class="Add-Kategorie-Butten" onclick="addKategorie()"><svg class="svg-icon" viewBox="0 0 20 20">
        <path fill="white" d="M13.388,9.624h-3.011v-3.01c0-0.208-0.168-0.377-0.376-0.377S9.624,6.405,9.624,6.613v3.01H6.613c-0.208,0-0.376,0.168-0.376,0.376s0.168,0.376,0.376,0.376h3.011v3.01c0,0.208,0.168,0.378,0.376,0.378s0.376-0.17,0.376-0.378v-3.01h3.011c0.207,0,0.377-0.168,0.377-0.376S13.595,9.624,13.388,9.624z M10,1.344c-4.781,0-8.656,3.875-8.656,8.656c0,4.781,3.875,8.656,8.656,8.656c4.781,0,8.656-3.875,8.656-8.656C18.656,5.219,14.781,1.344,10,1.344z M10,17.903c-4.365,0-7.904-3.538-7.904-7.903S5.635,2.096,10,2.096S17.903,5.635,17.903,10S14.365,17.903,10,17.903z"></path>
        </svg>
        </div>';
            echo' <div id="addKat" class="Add-Kategorie-Form"><form action = "includes/Forum_Kategorie.inc.php?herkunft=Forum.php" method="post">             
                    <input tyxpe="text" name ="Kategorie" placeholder="Name der Kategorie" autofocus maxlength="35" />
                    Wer dar das sehen ?
                    <input type="radio" id="Jeder" name="sichtbarkeit" value="0" checked>
                    <label for="Jeder"> Jeder</label> 
                    <input type="radio" id="Mitglieder" name="sichtbarkeit" value="1">
                    <label for="Mitglieder"> Mitglieder</label>';
                    //Adminthemen erstellen
                    if($_SESSION['rang'] >= 3){
                        echo'
                        <input type="radio" id="Vorstand" name="sichtbarkeit" value="2">
                        <label for="Vorstand"> Vorstand</label>';
                    }
                    echo'
                    <button type="submit" name="Forum-Kategorie"/>Neue Kategorei erstellen</button>    
                </form></div>';
        echo'</div>'; 
        }
}
echo'</div>'; //Forum zu
?>




<?php
include_once "footer.php";
?>
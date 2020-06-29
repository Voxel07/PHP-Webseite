<?php
include "Header.php";
include_once "includes/dbh_Forum.inc.php";
echo'<link rel="stylesheet" href="../Styles/style_Forum.css">';
// echo'<script src="../Skripte/Texteditor.js"></script>';
?>




<?php
if(isset($_GET['thema'])){

    //Pfusch
    $themaZumAufrufen = htmlspecialchars(stripcslashes(trim($_GET['thema'])));
    // $kateg=htmlspecialchars(stripcslashes(trim($_GET['kat'])));
    
    //Alle Infos zum Thema aus der DB Holen
    $sql ="SELECT * FROM themen WHERE thema = ?";
    $stmt = mysqli_stmt_init($conn2);
    if(!mysqli_stmt_prepare($stmt,$sql)){
    echo "SQL Fehler !!". mysqli_error($conn2);
    }
    else
    {
        mysqli_stmt_bind_param($stmt,"s",$themaZumAufrufen);
        mysqli_stmt_execute($stmt);
        $array = mysqli_stmt_get_result($stmt);
        $thema = mysqli_fetch_assoc($array);
    }
    
    //all Posts zum Thema aus der DB holen
    $sql1 ="SELECT * FROM posts WHERE zugThema = ? ORDER BY reihenfolge DESC";

    $stmt = mysqli_stmt_init($conn2);
    if(!mysqli_stmt_prepare($stmt,$sql1)){
        echo "SQL Fehler !!". mysqli_error($conn2);
    }
    else
    {
        //Navigation
        mysqli_stmt_bind_param($stmt,"s",$themaZumAufrufen);
        mysqli_stmt_execute($stmt);
        $themen = mysqli_stmt_get_result($stmt);
        echo'
        <div class="Form_Nav">
            <a href="Forum.php">Forum</a>
            <a href="#">Neuste Posts</a>
            
        </div>
        <div class="Form_Pfad">
            <a href="Forum.php">Home</a>
            <p>=></p>
            <a href="Forum_Kategorie.php?kategorie='.$thema['zugKategorie'].'">'.$thema['zugKategorie'].'</a>
            <p>=></p>
            <p>'.$themaZumAufrufen.'</p>
        </div>';
        

        
        echo'<div class = "Forum_Box">';
        echo'
        <div class = "Kategorie">
        <div class = Kategorie-Titel>
        
        <h2>'.str_replace("_"," ",$thema["thema"]).'</h2> 
         Erstellt am: '.date("d.m.Y - H:i",$thema["erstellungsdatum"]).' Anzahl Posts: '.$thema["anzPosts"].'';
          //Themen Löschen Butten für Vorsände
          if(isset($_SESSION['rang'])>=3){
            echo'<form  action = "includes/löschen_Forum_Thema.inc.php?herkunft=Forum_Kategorie.php" method="post"> 
             <button type="submit" name="Löschen-Thema"/>Thema löschen</button>
             <input type="hidden" name="TheZumLöschen" value="'.$thema["thema"].'" readonly>
             <input type="hidden" name="Kategorie" value="'.$thema["zugKategorie"].'" readonly>
             </form>';
            }
            else {                          
                //Wenn der Nutzer der Ersteller ist und Keine Posts vorhenden sind darf er löschen
                if(isset($_SESSION['User'])==$thema["ersteller"]){
                    if($thema["anzPosts"]==0){
                        echo'<form  action = "includes/löschen_Forum_Thema.inc.php?herkunft=Forum_Kategorie.php" method="post"> 
                        <button type="submit" name="Löschen-Thema"/>Thema löschen</button>
                        <input type="hidden" name="TheZumLöschen" value="'.$thema["thema"].'" readonly>
                        <input type="hidden" name="Kategorie" value="'.$thema["zugKategorie"].'" readonly>
                        </form>';
                    }
                    else{
                        echo'Als Ersteller des Tehmas darfst du es nur löschen, wenn keine Beiträge drin sind';
                    }
                  
                }
                else{
                    echo'Löschen nur Admin oder Ersteller';
                }
            }  
    echo'</div>';
    
        //Alle Post zum Thema ausgeben
        if(mysqli_num_rows($themen)== 0)
        {
            echo'Es gibt noch keine Posts. Sei der erste';
        }
        else{

        
        while ($reihepos = mysqli_fetch_assoc($themen))
        {
            echo'
            <div class ="Thema">
                <div class ="Thema-test">
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
                            <div  class ="Thema-Titel-Themen">
                                <h3><a href="Forum_Posts.php?post='.$reihepos["post"].'">'.str_replace("_"," ",$reihepos["post"]).'</a></h3>
                            </div>
                        </div><!--Titel des Tehmas & Beschreibung Box zu -->
                <div class ="Thema-Info">
                    <h4>'.$reihepos["anzAntworten"].'</h4>
                    <p>Antworten</p>
                </div><!--Anzahl der Beiträge zum Thema Box zu -->
                <div>';
                    //Post Löschen Butten für Vorsände
                    if(isset($_SESSION['rang'])>=3){
                        echo'<form action = "includes/löschen_Forum_Posts.inc.php?herkunft=Forum_Themen.php" method="post"> 
                        <button type="submit" name="Löschen-Post"/>Post löschen</button>
                        <input type="hidden" name="PostZumLöschen" value="'.$reihepos["post"].'" readonly>
                        <input type="hidden" name="Thema" value="'.$reihepos["zugThema"].'" readonly>
                        </form>';
                    }
                    else {                          
                        //Wenn der Nutzer der Ersteller ist darf er löschen
                        if(isset($_SESSION['User'])==$reihepos["ersteller"]){
                            echo'<form action = "includes/löschen_Forum_Posts.inc.php?herkunft=Forum_Themen.php" method="post"> 
                            <button type="submit" name="Löschen-Post"/>Post löschen</button>
                            <input type="hidden" name="PostZumLöschen" value="'.$reihepos["post"].'" readonly>
                            <input type="hidden" name="Thema" value="'.$reihepos["zugThema"].'" readonly>
                            </form>';
                        }
                        else{
                            echo'Nur der Ersteller';
                        }
                    }                        
            echo'</div>

            
            </div><!--Thema Box zu -->';     
            
        }
    }
        if(isset($_SESSION['User']) && isset($_SESSION['rang'])>0)
        {
            echo'
            <div class="postSchreiben-Button" onclick="addPost()"></div>
            ';
          
         
         echo'<div id="postSchreiben"class="postSchreiben">';
     
            echo'<form  id ="PostuploadForm" action = "#" method="post">             
                    <input type="text" name ="post" placeholder="Tielel deines Posts" autofocus maxlength="35"/>
                    <input  type ="hidden" name ="thema" placeholder="pfusch" value="'.$themaZumAufrufen.'" readonly></input>
                    <input  type ="hidden" name ="kategorie" placeholder="pfusch" value="'.$thema['zugKategorie'].'" readonly></input>';
                    
                     include_once "texteditor.php";

                    echo'
                    <button type="submit" name="Forum-Post" onclick="textSpeichern()"/>Neue Beitrag Posten</button>    
                </form>';
        echo'</div>'; 
        }
        else{
            echo'Bitte melde dich an !';
        }
            echo'</div>';  //Kategorien zu
    }
    

    echo'</div>'; //Forum zu
}
else{
    header("Location:Forum.php?Hier nur mit Thema !!");   
}
?>




<?php
include_once "footer.php";
?>
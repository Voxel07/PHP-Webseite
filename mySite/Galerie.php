<?php
include "Header.php";
include_once 'includes/dbh.inc.php';

echo'<link rel="stylesheet" href="../Styles/Galerie.css">';
?>




<div class="galerie-kopf">
<div class="galerie-statistik">
    <div class="galerie-statistik-svg"></div>
<?php

    $sql = "SELECT * FROM gallerie ORDER BY Reihenfolge DESC";//Sql befehl 
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql)){
    echo"<p>Keine Verbindung zu DB möglich </p>";
    exit();
    }
    else{
        mysqli_stmt_execute($stmt);
        $result =  mysqli_stmt_get_result($stmt);
        $rowCount = mysqli_num_rows($result); //Anzahl der Bilder
        echo' <div class="galerie-statistik-text">'.$rowCount.' Bilder</div>
        </div>';//Galerie Statsitik zu
        echo'
        <div class="galerie-wechseln"><a href="#">zu den Alben</a></div>
        <div class="galerie-suche">
            <div class="galerie-suche-svg"></div>
            <div class="galerie-suche-suche"><input  type="text" placeholder="In der Galerie suchen"></div>
        </div>'; //Galerie Suche und Alben wechsel
        echo'
        <div class="galerie-upload" >
        <div class="galerie-upload-butten" onclick="uploadMenue()">
        <div class="galerie-upload-svg"></div>
            <div class="galerie-upload-text">Hochladen</div>
            </div>';
        if(isset($_SESSION['User'])&&isset($_SESSION['rang'])&&$_SESSION['rang']>2){
          echo' <div class="galerie-upload-upload"> 
                 <p>Lade ein Bild hoch</p>
                <form id ="uploadForm" action = "includes/Upload_Galerie.inc.php" method="post" enctype="multipart/form-data">                     
                    <input type="file" name="DateiZumHochladen" required  id="inpFile">             
                    <button type="submit" name="upload-Galerie-einzel">Upload</button>    
                </form>
                <div class="progress-bar" id="progressBar">
                    <div class="progress-bar-fill"><span class="progress-bar-text">0%</span></div>
                </div>    
                <div class="progress-bar-fortschritt"></div>
                <div class="progress-bar-geschw"></div>
            </div>
            ';
        }
        else{
          echo'<div class="galerie-upload-upload">   Nur Mitglieder dürfen Bidler hochladen</div>';       
        }
     
       
      echo'
    </div>';//Einzelbilder Upload


    echo'
    <div class="galerie-album">
    <div class="galerie-album-butten" onclick="albumMenue()">
        <div class="galerie-album-svg"></div>
        <div class="galerie-album-text">Erstellen</div>
    </div>';
    if(isset($_SESSION['User'])&&isset($_SESSION['rang'])&&$_SESSION['rang']>2){
      echo'<div class="galerie-album-upload"> 
      <p style="color: orange;">Das geht noch nicht</p>
      <!--
          <form id="uploadFormAlbum" action = "#" method="post"enctype="multipart/form-data">                     
              <input type="file" name="DateiZumHochladen"  data-multiple-caption="{count} files selected" multiple  id="inpFile2">             
              <input tyxpe="text" name ="titel" placeholder="Albumtitel" maxlength="22" />
             <input tyxpe="text" name ="beschreibung" placeholder="Beschreibe dein Bild" />           
              <button type="submit" name="upload-Galerie">Upload</button>    
          </form>
          
          <div class="progress-bar" id="progressBar2">
              <div class="progress-bar-fill"><span class="progress-bar-text">0%</span></div>
          </div>
              <div class="progress-bar-fortschritt"></div>
              <div class="progress-bar-geschw"></div>
        -->  
      </div>';
    }
    else{
      echo'<div class="galerie-album-upload">   Nur Mitglieder dürfen Bidler hochladen</div>';
    }
    echo'  </div>';  //Album Upload
    
      
     echo'</div>'; //Galerie Kopf ende
    //  echo'<div class="galerie-box">';
     echo' <div class="gallery">';//Bilder beginn
     while ($row = mysqli_fetch_assoc($result)){

          $pfad = $row['Pfad'];

          $dateiname = "../Uploads/Bilder_Galerie/Vollbild_Bilder/".$pfad."*";
          $dateiInfo = glob($dateiname);
          $dateiEndung= explode(".",$dateiInfo[0]);
          $echteDateiEndung = $dateiEndung[4];

        //   echo $echteDateiEndung;
          switch($echteDateiEndung){
              case "jpg":
                $bild =  imagecreatefromjpeg("../Uploads/Bilder_Galerie/Vollbild_Bilder/".$pfad ); 
              break;
              case"png":
                $bild =  imagecreatefrompng("../Uploads/Bilder_Galerie/Vollbild_Bilder/".$pfad ); 
              break;
              echo'doof';
              default:

            break;
          }

         
          $width = imagesx($bild);
          $height = imagesy($bild);
          $verh = $width/$height;
        //  $größe = filesize("../Uploads/Bilder_Galerie/Vollbild_Bilder/".$pfad );
        // Wird nicht benötigt, da die Daten per JS geladen werden müssen
        // $width =10;
        if($verh > 1 && $verh < 2){
            // echo $verh;

            echo'<figure class="normal"><img onclick="big(\''.$row['Pfad'].'\')" src="../Uploads/Bilder_Galerie/'.$row['Pfad'].'" alt="Galerie Bild '.$row['Reihenfolge'].'"></figure>';
        }
        else if($verh >= 2 && $verh < 3){ 
            // echo $verh;
            echo'<figure class="landscape"><img onclick="big(\''.$row['Pfad'].'\')" src="../Uploads/Bilder_Galerie/'.$row['Pfad'].'" alt="Galerie Bild '.$row['Reihenfolge'].'"></figure>';
        }
        else if($verh >= 3){ 
            // echo $verh;
            echo'<figure class="panorama"><img onclick="big(\''.$row['Pfad'].'\')" src="../Uploads/Bilder_Galerie/'.$row['Pfad'].'" alt="Galerie Bild '.$row['Reihenfolge'].'"></figure>';
        }
        else{
            // echo $verh;

            echo'<figure><img onclick="big(\''.$row['Pfad'].'\')" src="../Uploads/Bilder_Galerie/'.$row['Pfad'].'" alt="Galerie Bild '.$row['Reihenfolge'].'"></figure>';
        }
     }
     echo'</div>';//Bilder Ende
    //  echo'</div>';
     echo'
     <div id="vollBild-Box">
        <div class="previous" onclick="previos()"></div>
    
        <div id="vollBild" class="vollBild">
        
            <div id="infoSideBar">
                <div class="infoSideBar-menue">
                    <div class="infoVollBild menue-schliesen" onclick="hideDetails()"></div>
                    <div class="infoVollBild menue-zoom" ></div>
                    <div class="infoVollBild menue-löschen"></div>
                </div>
                <div id="ladetext"></div>
                <div class="infoSideBar-infos">
                    <div>Infos: Das geht noch nicht :D
                    </div>
                    <div class="infoBox">
                        <div class="infoBox-svg date"></div>
                        <div class="infoBox-infos ">24.06.2020

                        </div>
                    </div>
                    <div class="infoBox">
                        <div class="infoBox-svg details"></div>
                        <div class="infoBox-infos">Auflösung: 1920x1080
    
                        </div>
                    </div>
                    <div class="infoBox">
                        <div class="infoBox-svg album"></div>
                        <div class="infoBox-infos"> vom Album Veckring 2018
    
                        </div>
                    </div>
                    <div class="infoBox">
                        <div class="infoBox-svg uploader"></div>
                        <div class="infoBox-infos">Hochgeladen von Camo
    
                        </div>
                    </div>
                </div>


            </div>
            <div class="vollBildMenue">
                <div class="infoVollBild" onclick="showDetails()"></div>
                <div class="vollBildSchließen"  onclick="small()"></div>
            </div>
                        
        </div>
        <div class="next" onclick="next()"></div>
     </div>
     ';     
    }
?>

<script src="../Skripte/Galerie.js"></script>
</div><!--gallerie_box zu -->
<?php
// include "footer.php";
?>
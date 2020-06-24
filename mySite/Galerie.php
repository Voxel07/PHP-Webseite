<?php
include "Header.php";
include_once 'includes/dbh.inc.php';

echo'<link rel="stylesheet" href="../Styles/Galerie.css">';
?>


<div class ="galerie_box">
  <div class ="galerie_titel">   
  <p>Super duper Galerie. </p>  
  <?php 
   $sql = "SELECT * FROM gallerie";//Sql befehl 
   $stmt = mysqli_stmt_init($conn);
   if(!mysqli_stmt_prepare($stmt,$sql)){
      echo"<p>Keine Verbindung zu DB möglich </p>";
      exit();
   }
   else{
       mysqli_stmt_execute($stmt);
       $result =  mysqli_stmt_get_result($stmt);
       $rowCount = mysqli_num_rows($result); //Anzahl der Bilder
      echo"<p>Aktuell sind $rowCount Bilder in der Galerie </p>";
   }
  ?>

  </div>

  <div class="galerie_bilder">
  <?php

    $sql ="SELECT * FROM gallerie ORDER BY Reihenfolge DESC";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql)){
      echo "SQL Fehler !!";
    }
    else{
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);

      while ($row = mysqli_fetch_assoc($result)){
        echo'
        <div class="Bild-Container"  onclick="vergrößern(this)" onmouseover="mehr(this)" onmouseout="weniger(this)">
        <div class="Löschen"></div>
        <div class="Bild">
             <img src="../Uploads/Bilder_Galerie/Vollbild_Bilder/'.$row["Pfad"].'" alt="Bild_3">
        </div>
        <div class ="Titel">'.$row["Titel"].'</div>
    </div>



       ';
    
      }
    }
    echo'
    <div id="vollbild" onclick="verkleinern()">
    <img src="../Bilder/Galerie/Bild_3.jpg" alt="">

</div>';
  ?>
  </div><!--gallerie_Bilder zu -->

<?php 
  if(isset($_SESSION['User'])){
    if($_SESSION['rang']>0 && ($_SESSION['rang']!=2)){
      echo'<div class="galerie_upload">';
      // echo' <form class ="form" id="uploadForm"> 
      //Fortschrittsbalken geht noch nicht, warum kp. 

      //id entfernen dann geht der upload, allerdings ohne fortschrittsbalken
      echo'<form id="uploadForm" action = "includes/Upload_Galerie.inc.php" method="post" enctype="multipart/form-data">
     
     
     
      <input tyxpe="text" name ="titel" placeholder="Titel" maxlength="22" />
      <input tyxpe="text" name ="beschreibung" placeholder="Beschreibe dein Bild" />
      <input type="file" name="DateiZumHochladen"  id="inpFile"> 

      <button type="submit" name="upload-Galerie"/>Upload</button>    
       
      </form>';
          //Upload fortschirtt
          echo'
          <div class="progress-bar" id="progressBar">
            <div class="progress-bar-fill">
              <span class="progress-bar-text">0%</span>
            </div>
            <div class="progress-bar-fortschritt">0mb</div>
            <div class="progress-bar-geschw">0mb</div>
          </div>';
      echo'</div>'; //gallerie_upload zu
    }
    else{
      echo'<p style=color:red;>Nur Mitgleder dürfen Bilder hochladen. </p>';
      echo'</div>'; 
    }
  }
  else{
    echo'<div class="galerie_upload">';
    echo'<p style=color:red;>Um Bilder hochladen zu könnnen musst du angemeldet sein. </p>';
    echo'</div>'; //gallerie_upload zu
  }
  ?>

<script src="../Skripte/Galerie.js"></script>
</div><!--gallerie_box zu -->
<?php
// include "footer.php";
?>
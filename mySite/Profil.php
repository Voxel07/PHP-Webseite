<?php
include "Header.php";
include_once "includes/dbh.inc.php";
echo' <link rel="stylesheet" href="../Styles/style_Profil.css">';
?>

<!-- echo'<div></div>'; -->
<!-- echo'<div>';
echo'</div>'; -->


<?php 
// Überprüfen ob jemand angemeldet ist
  if(isset($_SESSION['User'])){

    // Aktiver Nutzer herausfinden und begrüßen
    $usr= $_SESSION['User']; 
    echo'<div class="Profiel_box">';
    echo'<div class="Profiel_begrüsung">';
    echo "Hallo "."<strong>".$usr."</strong> Das ist dein Profil. Hier kannst du alle Informationen über dich einsehen und dein Profil bearbeiten.";
    echo'</div>';
      
        // Alle weiteren infos aus der Datenbak abgreifen
        // Anfrage vorbereiten
        $sql = "SELECT * FROM nutzer WHERE Nick = ?";
        $stmt = mysqli_stmt_init($conn);
        // Wenns nicht klappt
        if(!mysqli_stmt_prepare($stmt,$sql)){
            header("Location: ../index.php?error=sql_error");
            exit();
        }
        //Wenn es klappt:
        else{
          mysqli_stmt_bind_param($stmt,"s",$usr);
          mysqli_stmt_execute($stmt);
          $ergebnis = mysqli_stmt_get_result($stmt);
          $row= mysqli_fetch_assoc($ergebnis);
         
          //Abfrage ob ein Profielbild gesetzt wurde.
          echo'<div class="Profiel_Profielbild">';
            echo'<div class="Profiel_Profielbild_Bild">';

              if($row['Profielbild']==0){
                  echo '<img src="/Uploads/Bilder_Profil/Default.png" alt="">';
              }
              else{
              
                $dateiname = "../Uploads/Bilder_Profil/".$usr."*";
                $dateiInfo = glob($dateiname);
                $dateiEndung= explode(".",$dateiInfo[0]);
                $echteDateiEndung = $dateiEndung[3];
                
                echo "<img src='/Uploads/Bilder_Profil/".$usr.".".$echteDateiEndung."?".mt_rand()."'>";
              }
              if(isset($_GET['upload'])){
                if($_GET['upload'] =="success"){
                    echo' <p>Bild erfolgreich hochgeladen</p> ';
                }
              }
              echo'<div class="Profiel_Bild_ändern">';
              echo'
              <form action = "includes/Upload_Bilder.inc.php" method="post" enctype="multipart/form-data">
              <input type="file" name="DateiZumHochladen">
              <input type="submit" value="Upload" name="upload-ProfilBild"/>    
              </form> <br>';
              echo'
              <form action = "includes/profilBildLöschen.inc.php" method="post">
              <input type="submit" value="Profil Bild Löschen" name="upload-ProfilBild"/>    
              </form> <br>';    
            echo'</div>';
            echo'</div>'; //Rahmen für Profielbild
            }
         
            // Alle infos über den nutzer
            echo'<div class="Prfiel_User_Info">';
              echo"Emailadresse: "."<strong>".$row['Emailadresse']."</strong> <br>";
              echo"ID: "."<strong>".$row['ID']."</strong> <br>";
              echo"Vorname "."<strong>".$row['Vorname']."</strong> <br>";
              echo"Nachname: "."<strong>".$row['Nachname']."</strong> <br>";
              echo"Nick: "."<strong>".$row['Nick']."</strong> <br>";
              echo"Regestriert am: "."<strong>".date("d.m.Y - H:i", $row['Reg_Datum'])."</strong> <br>";
              echo"Geburtstag am: "."<strong>".date("d.m.Y", $row['Geburtstag'])."</strong> <br>";
              echo"Kontoverivizierung: <strong>";
              if($row['Verifiziert']==0){
                echo'Bestätigung ausstehend';
              }
              else{
                echo'Echtheit bestätigt';
              }
            echo "</strong>";
            echo'</div>'; //Nutzerinfo zu
            
            echo'<div class= "Profiel_Zusatz">';
             echo'Hier stehen dein Rang: ';
             switch($row['Rang']){
              case 0: echo'nix';
                break;
              case 1: echo'Mitglied';
               break;
              case 2: echo'Sponsor';
                break;
              case 3: echo'Vorstand';
                break;
              case 4: echo'Admin';
                break;

             }

            //  echo'<p>Deine Rolle ( Rechte )</p>';
            echo'</div>';

      
          echo'</div>';  // Profielheader zu   
      


        echo'<div class="Profiel_Sonstiges">';
          echo'<h2>Hier eine Übersicht deiner Aktivitäten auf der Webseite</h2>';

          echo'<div class="Profiel_Sonstiges_Forum">';
          echo'<h3>Forum</h3>';
          echo'<p>Du hast bissher:'.$row["anz_Beiträge"].' Beiträge gepostet</p>';
          echo'<p>Du hast bissher:'.$row["anz_Antworten"].' Antworten gepostet</p>';
          echo'</div>';
          
          echo'<div class="Profiel_Sonstiges_Galerie">';//Aktivitäten in der Gallerie
          echo'<h3>Galerie</h3>';
          
          
          echo'<p>Du hast aktuell '.$row["anz_Bilder"].' Bilder in die Gallerie geposted</p>';
       
          $sql = "SELECT * FROM gallerie WHERE Ersteller = '$usr' ORDER BY Reihenfolge DESC";//Sql befehl 
          $stmt = mysqli_stmt_init($conn);
          if(!mysqli_stmt_prepare($stmt,$sql)){
             echo"<p style=color:red; >Keine Verbindung zu Gallerie DB möglich </p>";
             exit();
          }
          else{
              mysqli_stmt_execute($stmt);
              $ergebniss =  mysqli_stmt_get_result($stmt);
              // $anzBilder = mysqli_num_rows($ergebniss); //Anzahl der Bilder
              // echo"<p>Du hast aktuell $anzBilder Bilder in die Gallerie geposted </p>";
            
              $row = mysqli_fetch_assoc($ergebniss);
              if($row>0)
              {
              echo'<p>Das ist das Letzte Bild, welches du am '. $row["uploadDatum"].' in die Gallerie geposted hast </p>';
                echo'
                <a href ="#">
                  <div style ="background-image: url(../Uploads/Bilder_Galerie/'.$row["Pfad"].')"></div>
                  <h3>'.$row["Titel"].'</h3>
                  <p>'.$row["Beschreibung"].'</p>
                </a>';
              }
              else{
                echo'<p>Los poste was</p>';
              }
          }
          echo'</div>'; //Ender der Gallerie
          
          echo'<div class="Profiel_Sonstiges_Reviews">';
          echo'<h3>Reviews</h3>';

          echo'</div>';
        
        echo'</div>';
    echo'</div>'; //Profielbox zu

    }
    //Wird angezeigt, wenn der Nutzer nicht angemeldet ist.
  else{
    echo'<div class = "p_nichtangemeldet">
      <p>Du bist nich Angemeldet. <br> Um dein Profil zu bearbeiten musst du dich Anmelden!</p>      ';
      echo'<form action="includes/login.inc.php?herkunft=Profil.php" method="POST">  
          <input class="user-input" type="text" name="mailuid" placeholder="Email/Username"  ><br>
          <input class="user-input" type="password" name="passwort" placeholder="Passwort" ><br>
          <button class="p_signin-button" type="submit" name ="login-submit">Login</button><br>
          </form>';

    echo'</div>';
   
  }


?>

<?php
include "footer.php";
?>
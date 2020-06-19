<?php
include "Header.php";
include_once "includes/dbh.inc.php";
echo' <link rel="stylesheet" href="../Styles/style_Profil.css">';
echo'<script src="../Skripte/Profil.js"></script>';
?>



  
<?php
 if(isset($_SESSION['User']))
 {
  $usr = $_SESSION['User']; 
  echo'
  <div class="PersonalData-Box">
    <div class="Data-Box">
      <div class="Data-Titel">
          <h2>Hallo '.$usr.' das ist dein Profil.</h2>  
          <div class="löschen-button"  onclick="löschenPopUpShow()">Profil löschen</div>
      </div>
      ';
        // Alle weiteren infos aus der Datenbak abgreifen
      // Anfrage vorbereiten
      $sql = "SELECT * FROM nutzer WHERE Nick = ?";
      $stmt = mysqli_stmt_init($conn);
      // Wenns nicht klappt
      if(!mysqli_stmt_prepare($stmt,$sql)){
          header("Location: ../index.php?error=nutzerSuchen".mysqli_errno($conn));
          exit();
      }
      //Wenn es klappt:
      else
      {
        mysqli_stmt_bind_param($stmt,"s",$usr);
        mysqli_stmt_execute($stmt);
        $ergebnis = mysqli_stmt_get_result($stmt);
        $row= mysqli_fetch_assoc($ergebnis);
        echo'
        <div class="header">
            <div class="header-Bild">
                <div>';
        if($row['Profielbild']==0){
          echo'
          <img class="header-Bild-Bild" src="/Uploads/Bilder_Profil/Default.png" alt="--Benutzer--Profilbild" border-radius="5px" > 
          </div>';
        }
        else 
        {
          $dateiname = "../Uploads/Bilder_Profil/".$usr."*";
          $dateiInfo = glob($dateiname);
          $dateiEndung= explode(".",$dateiInfo[0]);
          $echteDateiEndung = $dateiEndung[3];
          
          echo '<img class="header-Bild-Bild" src="/Uploads/Bilder_Profil/'.$usr.'.'.$echteDateiEndung.'?'.mt_rand().'alt="--Benutzer--Profilbild" border-radius="5px">
          </div>';
        }
        if(isset($_GET['upload'])){
          if($_GET['upload'] =="success"){
              echo'
              <div class="upload">
                <p>Bild erfolgreich hochgeladen</p> 
              </div>';
          }
        }
        echo' 
          <div class="Profil_Bild_ändern">
             <p> Profilbild ändern </p>
              
              <form action = "includes/Upload_Bilder.inc.php" method="post" enctype="multipart/form-data">
                <input type="file" name="DateiZumHochladen" required>
                <input type="submit" value="Upload" name="upload-ProfilBild"/>    
              </form> <br>
              
              <form action = "includes/deleteProfilePic.inc.php" method="post">
                <input type="submit" value="Profil Bild Löschen" name="upload-ProfilBild"/>    
              </form> <br>   
            </div>
          </div>
             <div class="header-Info">
                Hier sind alle Daten über dich erfasst wurden aufgelistet. 
                <p>Einige Infos sind für alle Besucher der Seite sichtbar. Diese sind mit einem ! gekennzeichnet. </p>
                <p>Alle von dir Veränderbaren Daten sind mit einem Zahnrad gekennzeichnet.</p>
                <p>Es sind manche Felder noch nicht befüllt. Diese Daten werden bei der Regestirerung nicht erfasst und sind für die Benutzung der Seite nicht unbeding notwendig.
                    Diese Daten können aber benutz werden um ein besseres miteinander im Team zu ermöglichen. Diese Daten werden nicht an dritte weiter gegeben und können auch nicht von anderen Teammitgliedern eingesehen werden. Lediglich der Administrator der Seite kann diese Infos einsehen.
              </p>
              </div>
             
          </div>
        </div>
      

        <div class="Data-Box">
            <div class="Data-Überschrift">
                <h2>Profil</h2>
                <p>Hier sind alle Personenbezogenen Daten die über dich gespeichert werden aufgelistet. Alle mit einem ! versehenen Felder beinhalten Daten, welche allen Besucher der Rovers Webseite frei einsehbar sind.</p>
            </div>
            <div class="PersonalData">
            <div class="Info-Box">
                    <div class="PersonalData-Name">Kontoverivizierung</div>   <div class="PersonalData-Info">';
                    if($row['Verifiziert']==0){echo'Bestätigung ausstehend</div> <div class="Info-SVG"></div>' ;}else{echo'Echtheit bestätigt</div> ';}
                echo' 
                </div>
                <div class="Info-Box">
                    <div class="PersonalData-Name">ID</div>   <div class="PersonalData-Info" id="NutzerID">'.$row['ID'].'</div> 
                </div>
                <div class="Info-Box">
                    <div class="PersonalData-Name">Vorname</div>   <div class="PersonalData-Info" id="ProfilVorname">'.$row['Vorname'].'</div> <div class="Info-SVG" onclick="toggleUpdateField(\'Vorname\',\'Profil\')"></div>
                </div>
                <div class="Info-Box">
                    <div class="PersonalData-Name">Nachname</div>   <div class="PersonalData-Info" id="ProfilNachname">'.$row['Nachname'].'</div>  <div class="Info-SVG" onclick="toggleUpdateField(\'Nachname\',\'Profil\')"></div>
                </div>
                <div class="Info-Box">
                    <div class="PersonalData-Name">Geburtstag</div>   <div class="PersonalData-Info" id="ProfilGeburtstag">'.date("d.m.Y", $row['Geburtstag']).'</div>   <div class="Info-SVG" onclick="toggleUpdateField(\'Geburtstag\',\'Profil\')"></div>
                </div>
                <div class="Info-Box">
                    <div class="PersonalData-Name">Alter</div>   <div class="PersonalData-Info" id="ProfilAlter">'.floor((date("Ymd") - date("Ymd", $row['Geburtstag'])) / 10000).'</div>    <div class="sichtbar">!</div>  
                </div>
                <div class="Info-Box">
                    <div class="PersonalData-Name">Passwort</div>   <div class="PersonalData-Info" id="ProfilPasswort">*********</div>  <div class="Info-SVG" onclick="toggleUpdateField(\'Passwort\',\'Profil\')"></div>
                </div>
                <div class="Info-Box">
                    <div class="PersonalData-Name">Regestrierdatum</div>   <div class="PersonalData-Info">'.date("d.m.Y - H:i", $row['Reg_Datum']).'</div> 
                </div>
                <div class="Info-Box">
                    <div class="PersonalData-Name">Letzer Login</div>   <div class="PersonalData-Info">'.date("d.m.Y - H:i", $row['letzterLogin']).'</div> 
                </div>

              

            <div id="infoSchalter-Profil" class="info-neu">
                <div class="update">

                    <div class="update-box">
                        <div  class="info-input-text">
                            <input id="FeldName-Profil" type="text" name="elmZumUpdaten"  readonly />
                            <label >Für update gewählt</label>
                        </div>
                        <div id="hintFeldName-Profil" class="hint-text-Profil"></div>
                    </div>

                    <div class="update-box">
                        <div  class="info-input-text">  
                            <input id="WertAlt-Profil" type="text" name="elmZumUpdaten" readonly maxlength="30" />
                            <label >Alt</label>
                        </div>
                        <div id="hintWertAlt-Profil" class="hint-text-Profil"></div>
                    </div>

                    <div class="update-box">
                        <div  class="info-input-text">
                            <input id="WertNeu-Profil" type="text" name="neueInfo" maxlength="30" />
                            <label >Neu</label>
                        </div>
                        <div id="hintWertNeu-Profil" class="hint-text-Profil"></div>
                    </div>
                    
                    <div class="update-box">
                        <div  class="info-input-text">
                            <input id="WertNeuWDH-Profil" type="password" name="neueInfo" placeholder="Passwort wiederholen" maxlength="30"  />
                            <label >Wiederholen</label>
                        </div>
                        <div id="hintWertWDH-Profil" class="hint-text-Profil"></div>
                    </div>

                    <div class="info-button-update">
                        <button type="submit" name="update" onclick=datenUpdaten(\'Profil\')></button> 
                    </div>
                </div>
            </div>



               
            </div>
        </div>

        <div class="Data-Box">
            <div class="Data-Überschrift">
                <h2>Kontaktdaten</h2>
                <p>Hier sind sind alle Kontacktdaten die über dich gespeichert werden aufgelistet. Alle mit einem ! versehenen Felder beinhalten Daten, welche allen Besucher der Rovers Webseite frei einsehbar sind.</p>
            </div>
            <div class="PersonalData">
                <div class="Info-Box">
                    <div class="PersonalData-Name">E-mail Privat</div>   <div class="PersonalData-Info" id="KontaktdatenEmailadressePrivat">'.$row['Emailadresse'].'</div>  <div class="Info-SVG" onclick="toggleUpdateField(\'Emailadresse\',\'Kontaktdaten\')"></div>
                </div>
                <div class="Info-Box">
                    <div class="PersonalData-Name">E-mail Team</div>   <div class="PersonalData-Info" id="KontaktdatenEmailadresseTeam">camo@wildrovers.de</div>  <div class="sichtbar" >!</div>  
                </div>
                <div class="Info-Box">
                    <div class="PersonalData-Name">Handynummer</div>   <div class="PersonalData-Info" id="KontaktdatenHandynummer">'.$row['Handynummer'].'</div> <div class="Info-SVG" onclick="toggleUpdateField(\'Handynummer\',\'Kontaktdaten\')"></div>
                </div>


<div id="infoSchalter-Kontaktdaten" class="info-neu">
<div class="update">

    <div class="update-box">
        <div  class="info-input-text">
            <input id="FeldName-Kontaktdaten" type="text" name="elmZumUpdaten"  readonly />
            <label >Für update gewählt</label>
        </div>
        <div id="hintFeldName-Kontaktdaten" class="hint-text-Profil"></div>
    </div>

    <div class="update-box">
        <div  class="info-input-text">  
            <input id="WertAlt-Kontaktdaten" type="text" name="elmZumUpdaten" readonly maxlength="30" />
            <label >Alt</label>
        </div>
        <div id="hintWertAlt-Kontaktdaten" class="hint-text-Profil"></div>
    </div>

    <div class="update-box">
        <div  class="info-input-text">
            <input id="WertNeu-Kontaktdaten" type="text" name="neueInfo" maxlength="30" />
            <label >Neu</label>
        </div>
        <div id="hintWertNeu-Kontaktdaten" class="hint-text-Profil"></div>
    </div>

    <div class="info-button-update">
        <button type="submit" name="update" onclick=datenUpdaten(\'Kontaktdaten\')></button> 
    </div>
</div>
</div>


          </div>
        </div>

        <div class="Data-Box">
            <div class="Data-Überschrift">
                <h2>Team</h2>
                <p>Hier sind sind alle Daten die über dich zum Thema Airsoft. Alle mit einem ! versehenen Felder beinhalten Daten, welche allen Besucher der Rovers Webseite frei einsehbar sind.</p>
            </div>
            <div class="PersonalData">
                <div class="Info-Box">
                    <div class="PersonalData-Name">Nick</div>   <div class="PersonalData-Info" id="TeamNick">'.$row['Nick'].'</div>   <div class="sichtbar">!</div>   <div class="Info-SVG" onclick="toggleUpdateField(\'Nick\',\'Team\')"></div>
                </div>
                <div class="Info-Box">
                    <div class="PersonalData-Name">Teamstatus</div>   <div class="PersonalData-Info">';
                    
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

                    echo'
                    </div>     <div class="sichtbar">!</div>  
                </div>
                <div class="Info-Box">
                    <div class="PersonalData-Name">Mitgliedsbeitrag</div>   <div class="PersonalData-Info">';
                    if($row['Mitgliedsbeitrag']==0){
                        echo'Noch nicht gezahlt';
                    }
                    else{
                        echo'Gezahlt am: '.date("d.m.Y", $row['Mitgliedsbeitrag']).'';
                    }
                 echo'
                    </div>  
                </div> 

                  


<div id="infoSchalter-Team" class="info-neu">
<div class="update">

    <div class="update-box">
        <div  class="info-input-text">
            <input id="FeldName-Team" type="text" name="elmZumUpdaten"  readonly />
            <label >Für update gewählt</label>
        </div>
        <div id="hintFeldName-Team" class="hint-text-Profil"></div>
    </div>

    <div class="update-box">
        <div  class="info-input-text">  
            <input id="WertAlt-Team" type="text" name="elmZumUpdaten" readonly maxlength="15" />
            <label >Alt</label>
        </div>
        <div id="hintWertAlt-Team" class="hint-text-Profil"></div>
    </div>

    <div class="update-box">
        <div  class="info-input-text">
            <input id="WertNeu-Team" type="text" name="neueInfo" maxlength="30" />
            <label >Neu</label>
        </div>
        <div id="hintWertNeu-Team" class="hint-text-Profil"></div>
    </div>

    <div class="info-button-update">
        <button type="submit" name="update" onclick=datenUpdaten(\'Team\')></button> 
    </div>
</div>
</div>



            </div>
        </div>

        <div class="Data-Box">
            <div class="Data-Überschrift">
                <h2>Aktivitäten</h2>
                <p>Hier steht was du so beiträgst</p>
            </div>
            <div class="PersonalData">
                <div class="Info-Box">
                    <div class="PersonalData-Name">Foren Beiträge</div>   <div class="PersonalData-Info">'.$row["anz_Beiträge"].'</div>   
                </div>
                <div class="Info-Box">
                    <div class="PersonalData-Name">Foren Antworten</div>   <div class="PersonalData-Info">'.$row["anz_Antworten"].'</div>     
                </div>
                <div class="Info-Box">
                    <div class="PersonalData-Name">Uploads in die Galerie</div>   <div class="PersonalData-Info">'.$row["anz_Bilder"].'</div> 
                </div>
                <div class="Info-Box">
                    <div class="PersonalData-Name">Anzahl Reviews</div>   <div class="PersonalData-Info">'.$row["anz_Reviews"].'</div> 
                </div> 
                <div class="Info-Box">
                    <div class="PersonalData-Name">Anzahl News</div>   <div class="PersonalData-Info">'.$row["anz_News"].'</div> 
                </div>
                
            </div>
          </div>
    </div>
    
    
    
    
    <div  id="löschenPopUp" class = "löschenPopUpContainer">
    <div  class="löschen-PopUp">
        <div class="PopUp-kopf">
            <div><p>Bist du dir ganz sicher ?</p></div>
            <div class="PopUp-schließen"  onclick="löschenPopUpHide()"><svg class="svg-icon" viewBox="0 0 20 20">
                <path  d="M15.898,4.045c-0.271-0.272-0.713-0.272-0.986,0l-4.71,4.711L5.493,4.045c-0.272-0.272-0.714-0.272-0.986,0s-0.272,0.714,0,0.986l4.709,4.711l-4.71,4.711c-0.272,0.271-0.272,0.713,0,0.986c0.136,0.136,0.314,0.203,0.492,0.203c0.179,0,0.357-0.067,0.493-0.203l4.711-4.711l4.71,4.711c0.137,0.136,0.314,0.203,0.494,0.203c0.178,0,0.355-0.067,0.492-0.203c0.273-0.273,0.273-0.715,0-0.986l-4.711-4.711l4.711-4.711C16.172,4.759,16.172,4.317,15.898,4.045z"></path>
            </svg></div>
        </div>
        <div class="löschen-warnung"><p>Bitte lies dir den folgenden Hinnweis gut durch.</p></div>
        <div class="löschen-text">
            <p>Diese Aktion kann <strong>nicht</strong> rückgängig gemacht werden ! Dein Profil wird unwiederruflich gelöscht.
                Es gibt keine Sicherheitskopie deiner Daten. 
            </p>
            <p>
                Dein Persönlichen Daten, sowie dein Profilbild werden gelöscht. Deine Beiträge in Foren und der Gallerie bleiben jedoch bestehen.
            </p>
        </div>
        <div class="löschen-aufforderung">
            <p>Bitte tippe <strong>löschen</strong> zum Bestätigen</p>
        </div>
        
        <input id="löschenInput"  class="löschen-eingabe " type="text" maxlength="7" autocomplete="off" pattern="[lL][öÖ][sS][cC][hH][eE][nN]">
        <form action="../mySite/includes/update_nutzerInfo.inc.php?aufgabe=löschen" method="GET">
            <input type="text" value='.$row['ID'].' hidden name="id">
            <button id="löschen-fkbutton" class="löschen-fkbutton" name="aufgabe" type="submit" value="löschen" >Profil unwiederruflich  löschen</button>
        </form>    
    </div>
</div>
    
    
    
    
    ';

    }
 }
 else
 { 
  echo'<div class = "p_nichtangemeldet">
        <p>Du bist nich Angemeldet. <br> Um dein Profil zu bearbeiten musst du dich Anmelden!</p>   
      ';
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
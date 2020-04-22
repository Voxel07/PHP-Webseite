<!DOCTYPE html>

<html>   
<head>
    <style>
     
     .test{
        background-color: lightgray;
        display: inline-block;
        color: black;
        width: 50%;
        margin-left:25%;
        border-radius:10px;
        padding: 5px;
        
        
      }
    </style>

</head>
    <body>
     
        <?php // Variablen von form.html auffangen
        
        // $f_nName=$_POST["nName"];
        // $f_vName = $_POST["vName"];
        // $f_Nick = $_POST["nick"];
        // $f_Geb = $_POST["geb"];
        
        $f_Passwort = htmlspecialchars(stripcslashes(trim( $_POST["passwort"])));
        $f_Email = htmlspecialchars(stripcslashes(trim($_POST["mail"])));
        $f_anmeld = $_POST["anmeldeart"];
        ?>

        <?php
        class USER // Benutzerklasse die verschiedene Dinge speichert
        {


        // Variablen

        // public $nachname;
        // public $vorname;
        // public $nick;
        // public $alter;
        // public $geburtsDatum;
        // public $ID;
        // public $regDatum;
        // private $letzteAnmeldung;
        // private $Forumsbeiträge;
        // private $emailBestätigt;
        public $email;
        public $passwort;

        //Konstruktor
            function __construct($Email, $Passwort){
            //$this->nachname = $vName;
            //$this->vorname =$nName;
            //$this->nick = $Nick; 
            //$this->regDatum = date('Y-m-d');
            //$this->geburtsDatum = $Geb;
            //$this->alter = $Geb - date('Y-m-d');
            $this->email = $Email;
            $this->passwort = $Passwort;
            }
        
        }
        ?>


        <?php 
        class Benutzerverwaltung // Hiermit werden Nutzer angelegt und verwaltet
        {
            private $anzahl;

            private $servername = "localhost";
            private $user ="root";
            private  $pw = "";
            private  $db ="wild-rovers";

            
            
            function regestrieren($usr){
                echo "Der User möchte siche regestrieren". "<br>";
                $doppelt = 0;
                $con = new mysqli($this->servername,$this->user,$this->pw,$this->db);//Verbingund zum Server

                if($con->connect_error){ //Prüft ob eine verbindug zur Datenbank steht.
                    die("Keine verbindung".$con->connect_error);
                }

                $sql = "SELECT Emailadresse FROM user"; //SQL Befehl 1
                $gibtsdenschon = $con->query($sql); //holt alle Mailadressen aus der DB

                
                while($i = $gibtsdenschon->fetch_assoc()){ //Vergleicht alle Mailadressen mit der eben eingegbenen
                    $ausdb = $i["Emailadresse"];
                    $ausForm =  $_POST["mail"];                  
                    if($ausdb==$ausForm){
                        echo "Die Mailadresse ist bereits regestriert. Login ? oder passwort vergessen ? ". "<br>";
                        $doppelt = 1;
                    }
                }
                if ($doppelt == 0){   //wenn die Email noch nicht vorhanden ist, wird der neue Nutzer gespeichert.
                    $sql = "INSERT INTO user (Emailadresse,Passwort) VALUES ('$usr->email','$usr->passwort')"; //Legt einen neuen User in der DB an
                    if($con->query($sql)===TRUE){ //Speichert den Benutzer in der DB und prüft gleich ob das geklappt hat.
                        echo "Der Benutzer: ". $usr->email . " wurde erfolgreich regestriert";
                    }
                    else{
                        echo "Das hat nicht geklappt".$con->error;
                    }
                }
            $con->close();
            }     


            function logIN(){
                echo "Der User möchte siche anmelden". "<br>";              
                $gibtes = 0;
                $con = new mysqli($this->servername,$this->user,$this->pw,$this->db);
                if($con->connect_error){ //Prüft ob eine verbindug zur Datenbank steht.
                    die("Keine verbindung".$con->connect_error);
                }
                //Auslesen
                $sql2 = "SELECT Emailadresse FROM user"; 
                $ausgabe = $con->query($sql2);
                        
                while($i = $ausgabe->fetch_assoc()){
                    $ausdb = $i["Emailadresse"];
                    $ausForm =  $_POST["mail"];
                    
                    if($ausdb==$ausForm){
                        echo "gefunden". "<br>";
                        $gibtes = 1;
                    }
                }
                if($gibtes==1){
                  //  $pwausdb = $sql3 = "SELECT Passwort"
                  $pwausdb = "79132fac156b39b94329fe0b993a51329a2878840cc1417e58";  
                  $hashed = hash("sha512",$_POST["mail"]);

                    if( $hashed == $pwausdb)
                    {
                        echo "Erfolgreich eingelogt";
                    }
                    else    
                        echo "PW oder Nutzername falsch ! ";
                      
                }
                else
                    echo "keine user mit der Email gefunden !";
                
                $con->close();
            }

            function auslesen(){
                $con = new mysqli($this->servername,$this->user,$this->pw,$this->db);
                if($con->connect_error){ //Prüft ob eine verbindug zur Datenbank steht.
                    die("Keine verbindung".$con->connect_error);
                }
                //Auslesen
                $sql2 = "SELECT * FROM user"; 
                $ausgabe = $con->query($sql2);
                
                if($ausgabe->num_rows > 0){
                    while($i = $ausgabe->fetch_assoc()){
                        echo '<p class= "test">';
                        echo " Email: ".$i["Emailadresse"];
                        echo "</p>";
                        echo "<br>";
                    }
                }
                $con->close();            
            }                           
            function löschen(){}
        }
    
        ?> <!--Ende der Benutzerverwaltung -->


    <?php

    $Admin = new Benutzerverwaltung();

    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $hashed = hash("sha512",$f_Passwort); //Hashed das Passwort
        $usr = new USER($f_Email, $hashed); //
        //$usr->print();
    }

    switch ($f_anmeld){
        case 'r': $Admin->regestrieren($usr);
        break;
        case 'a': $Admin->logIN();
        break;
        case 'k': $Admin->auslesen();
        break;
        default: echo "Default";
    }
    
    ?>
    
    </body>

</html>
<?php
	//if($_SERVER["REQUEST_METHOD"]=="POST"){} // zusatz wenn Forum und Auswertung auf der Selben Seite sind
	if(isset($_POST["submit"]))
	{
	// die(ini_get('upload_tmp_dir') ? ini_get('upload_tmp_dir'): sys_get_temp_dir());
	
		$ziel = "Uploads/";
		$zieldatei = $ziel . basename($_FILES["DateiZumHochladen"]["name"]);
		$error = 0;

		$bildgröße = getimagesize($_FILES["DateiZumHochladen"]["tmp_name"]);
		if($bildgröße === false){
			$error = 1;
			echo "kein bild!";
		}
		else {
			$bildgröße["mime"];
		}
		$endung = pathinfo($zieldatei, PATHINFO_EXTENSION);
		if($endung != "jpg" && $endung != "png")
		{
			$error =1;
			echo "format ungültig";
		}

		if(file_exists($zieldatei))
		{
			$error = 1;
			echo "Bild exestiert bereits";
		}
		if($_FILES["DateiZumHochladen"]["size"] > 8*1024*1024){
			$error = 1;
			echo "Datei ist zu groß";
		}

		if($error != 1)
		{
			if(move_uploaded_file($_FILES["DateiZumHochladen"]["tmp_name"],$zieldatei))
			{
				echo "Datei hochgeladen";
			}
			else{ echo "ist nicht"; }
		}
	}
?>
<!-- ------------------------------------------------------------------------------------------------------ -->

<?php //Fürs Forum Dateien Lesen und schriben

	$file = fopen("Forum/Texte/test.txt", "w"); // w-write, a-append, r-ride, x-überschreibt nicht, r+ schreiben und lesen Datei bleibt , w+ schreiben und lesen datei wird gelöscht, a+ schreiben am ende der datei, x+ datei zum lesen und schreiben
	fwrite($file,"Hier steht mein Text\n");

	fclose($file);

	readfile("Forum/Texte/test.txt");

?>
<!-- ------------------------------------------------------------------------------------------------------ -->


<?php //Cookies
	//Cookie muss vor dem <html> tag gesetzt werden.
    setcookie("user","Camo", time()+86400*31,"/"); //Cookie erstellen 
    setcookie("user","", time()+86400*31,"/"); //Metohe 1 zum Löschen
    setcookie("user","Camo", time()+ 1,"/"); //Metohe 2 zum Löschen

    if(isset($_COOKIE["user"]))
    {
        echo "Willkommen zurück " . $_COOKIE["user"];
    }
?>



<!-- ------------------------------------------------------------------------------------------------------ -->

<?php //Klassen
        // abstract class Print(){
        //     //Abstrakte Klasse eingebunden mit extends Beinhalten abstrakte und normale funktionen
        //     abstract public function print(); //Muss so als abstrakte funktiion gekennzeichnet werden
        // }
        interface Printable{ //Rein Virtuelle Klasse. Interface benötigt implements
            public function print(); //Wie C++ Abstrakte Klassen
        }
        class User implements Printable{
            private $ID; //Ohne schlüsselwort ist alles Public und Variablebn müssen mit var gekennzeichent werden 
            var $nName;
            var $vName;
            var $nick;

            function __construct($setID, $setnName){
                $this->ID=$setID;
                $this->nName = $setnName;
            }

            function print(){

                echo $this->ID . " " . $this->nName;
                echo "<br>";
            }
            //Set, Get
            function setID($nID){
                if($nID > 0){
                    $this->ID = $nID;
                }
            }
            function getID(){
                return $ID;
            }
        }

        
        //Vererbung
        class Admin extends User{

            private $tolleVar;

            function Admintools(){
                echo "Wichtig und so";
                echo "<br>";
            }
            function print(){ // Überschreibt print funktion in User
                echo $this->ID . " " . $this->nName . "Ist Admin";
                echo "<br>";
            }
            function __construct($setID,$setNname,$neueVar){
                parent::__construct($setID,$setName); //Aufruf des parent Konstruktors
                $this->tolleVar = $neueVar;
            }
        }
        
        class Sponsor extends User{
            function werbung(){
                echo "Ich kann werbung schalten";
                echo "<br>";
            }
        }
        
        $usr1 = new Admin(2,"Schneider");
        $usr2 = new Sponsor(1,"Camo");
        
        
        // $usr1->print();
        // $usr1->Admintools();
        // $usr2->print();
        // $usr2->werbung();

        $myArray = array($usr1,$usr2);

        for($i=0; $i<2;$i++){
            $myArray[$i]->print();
        }

        ?>
<!-- ------------------------------------------------------------------------------------------------------ -->     
//   // Nacheinander
//   $url = (empty($_SERVER['HTTPS'])) ? 'http' : 'https';
//   $url .= $_SERVER['HTTP_HOST'];
//   $url .= $_SERVER['REQUEST_URI']; // $url enthält jetzt die komplette URL

//   // Als Einzeiler mit Funktion
//   function getCurrentUrl() {
//       return ((empty($_SERVER['HTTPS'])) ? 'http' : 'https') . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
//   }


// $url = getCurrentUrl();
// $pieces = parse_url($url);
//  $scheme = $pieces['scheme']; // enthält "http"
// $host = $pieces['host']; // enthält "www.example.com"
// $path = $pieces['path']; // enthält "/dir/dir/file.php"
//  $query = $pieces['query']; // enthält "arg1=foo&arg2=bar"
//  $fragment = $pieces['fragment']; // ist leer, da getCurrentUrl() diesen Wert nicht zurückgibt

// echo $host."<br>";
// echo $path."<br>";

// $ort = explode('/',$path);
// $ziel = end($ort);
// echo $ziel;


//header("Location: ../".$ziel); 



$datum = Date("d-m-Y");

echo $datum;

$ts = strtotime($datum);

echo '</br>'.$ts;

$back = date("d-m-Y",$ts);

echo '</br>'.$back;
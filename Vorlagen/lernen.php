<!Doctype html>

<html>
	<body>

        <?php

    // Grundlagen
            //	echo "Das geht";

            $myVar = "Inhalt der Variable";
            $x = 7;
            //echo "Hier steht die Variable x: " .$x. "asdasd" .$myVar ."!!"; //Variablen mit . in der Ausgabe verbinden.
            echo "<h1>".$myVar."</h1>";		
            echo "<h2>".$myVar."</h2>";	
            var_dump($x);//Datentyp und wert ausgeben


            $bed1 =true;
            $bed2 = false;
            $erg= ($bed1 and $bed2);
            $erg= ($bed1 or $bed2);
            $erg= ($bed1 xor $bed2);

            var_dump($erg);			

            if(true) {
                echo "Wie in C++";
            }

            //if("1" === 1) //vergleicht wert und Datentyp

            switch($x) {
                case 1: echo "Case1";
                break;
                case 2: echo "Case2";
                break;

                default: echo "default";
            }
            //Schleifen wie C++

            echo "</br>";
            //arrays

            $usr = array("f","m");
            echo "Ich bin " . $usr[0];

            echo "</br>";
            echo count($usr);//Gib die Länge des Array aus

            for($i = 0; $i <count($usr); $i++) {
                echo "</br>";
                echo $usr[$i];	
            }	
            foreach($usr as $ausgabe){
                echo "</br>";
            echo $ausgabe;
            }	
            echo "</br>";


            //sort	Werte im Array aufsteigend Sortieren
            //rsort	Werte im Array absteigend Sortieren		
            //asort | arsort wie sort, nur für die Werte von Assoziative Arrays
            //ksort | krsort sortiert die keys


            //Assoziative Arrays
            $assi = array("Wert1"=>50, "Wert2"=>75);
            echo $assi["Wert1"];
            foreach($assi as $key => $wert){
                echo 	"</br>" .$key ." = " .$wert;
            }
            //Strings
            //strlen($string); //Anzahl der Zeichen im string
            //str_word_count(); // Duch leerzeichen getrennte wörter;
            //strrev() //dreht den string um
            //str_split($str, 6) //Zerlegt den String nach 6 Zeichen einzelne Blöcke werden als Array zurückgeben
            //str_replace("abc","klaus",$str) // Suche im str nach abc und ersetzt es mit klaus
            //$str = "Hello \" World!" stripcslashes($str) // entfernt \

            echo "<p>"."Was geht"."</p>";

            die(); exit(); // Beendet das Skript
            

        //Funktionen

        function myFunc($a){
            echo "Ich gebe was aus ". $a;
        }

        
        for($i = 0; $i<=10;$i++)
        {
            echo "</br>";
            myFunc($i);
            echo "</br>";
        }
        //Defaultwerte und Rückgabewerte wie in C++


        //Zeiten

            echo "Heuteiges Datum: ". date("d.m.Y - H:i:s"); //Gibt das aktuelle Datum aus
			echo "in sekunden" .time(); // Gibt das Datum in sekunden aus seit x
			echo "<br>";
			echo date("d.m.Y - H:i:s", 1470055229);//erste hälfte ist zum Formatieren. Das zweite ist der Rückgabewert von .time()
            //die .time() beim Anmelden speichern und dann 
            
        ?>


        
       
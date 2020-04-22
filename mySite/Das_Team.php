<?php
include "Header.php";
include_once "includes/dbh.inc.php";
echo'<link rel="stylesheet" href="../Styles/style_Mitglieder.css">';
?>

<div>
    <h2> GESCHICHTE: </h2>
      <p class="mitglieder"> Das Team Wild Rovers Württemberg gibt es jetzt schon seit Mitte 2006 damals als TSAT – BW gegründet. Unter diesem Namen habt ihr uns bestimmt auch schonmal angetroffen. Nach einem Jahrzehnt Airsoft auf den verschiedensten Events und Spielfeldern hat das sich das Team stark verändert. Auf der einen Seite ist das Team stark gewachsen und hat viele junge Mitglieder gewonnen. Auf der anderen Seite hat ein Großteil des Gründungsteams sich anderen Hobbys zugewendet. Um nicht in der Vergangenheit hängen zu bleiben, wurde es Zeit, den alten Relikten lebewohl zu sagen. 
            Ein neuer Name, ein neues Logo und eine Fusion mit unseren langjährigen Freunden und Partnerteam Legion Esslingen 1 später, waren die Wild Rovers geboren. </p>          

    <h2> Aktuelles: </h2> 
        <p class="mitglieder">Aktuell haben wir 30 Mitglieder und 3 Frischlinge ( Anwärter ). Wir kommen aus den unterschiedlichsten Ecken aus Deutschland. Der Hauptteil des Teams ist aber im Großraum Esslingen / Stuttgart zu finden. In den letzten Jahren haben wir viele neue junge Mitglieder dazugewonnen, dennoch ist von 18 bis 34 Jahren alles dabei.               
            Solltet ihr ein Team suchen oder ihr wollt uns näher kennen lernen, findet ihr alle weiteren Infos findet ihr unter dem Reiter Infos/Regeln.</p>       
</div>  <br><br><br><br><br>

<?php

$zähler = 1;
$sql = "SELECT * FROM nutzer";
$ergebnis = mysqli_query($conn,$sql);
if(mysqli_num_rows($ergebnis)>0){
    echo'
    <div><h2>Mitglieder: </h2></div>
    <div>
    <ul class="mitglieder ">';
    
    while($row = mysqli_fetch_assoc($ergebnis)){
       
        $id = $row['ID'];
        $nick = $row['Nick'];
        $email = $row['Emailadresse'];
     //   $hatProfielbild = $row['Profilbild'];
     $hatProfielbild = false;
        echo'<li>';
        if($hatProfielbild == true){
            echo '<img src="/Bilder/Mitglieder/tobi.PNG" alt="">';
        }
        else{
            echo '<img src="/Bilder/Mitglieder/Logo.png" alt="">';
        }
        echo ' 
        <p><strong>Name: </strong>'.$nick.' </p>
        <p><strong>Alter: </strong>'.$zähler.'</p>
        <p><strong>Sonstiges: </strong>Zitat: '.$id.'</p>
        </li>';
        // echo "Mittglied Nr.: ".$zähler." mit der ID: ".$id."hat den Nick: ".$nick."<br>";
        $zähler++;
    } 
}
else{
    echo'<h2>Diese Seite hat keine Nutzer</h2>';
}


?>

<?php
$timestamp = time();
$datum = date("d.m.Y - H:i", $timestamp);
echo $datum;
echo '<br>';
$time =strtotime("1995-04-07");
echo $time;
echo '<br>';
$datum = date("d.m.Y - H:i", $time);
echo $datum;
?>

   


    </body>

</html>
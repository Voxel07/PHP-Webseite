<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Layout</title>
    <link rel="stylesheet" href="../Styles/layout.css">  
    <script src="../Skripte/layout.js"></script> 



</head>
 
<body>
 <?php

    $width = 0;
    $height = 0;
    $size = 0;

    $bild =  imagecreatefromjpeg("../Bilder/Galerie/Bild_1.jpg"); 
    $width = imagesx($bild);
    $height = imagesy($bild);
   
    $größe = filesize("../Bilder/Galerie/Bild_1.jpg");
    echo round(($größe/1000000),2)."MB"; 
    echo "Höhe: ".$height;
    echo " Breite: ".$width;

  
    echo "Zuletzt modifiziert: " . date ("F d Y H:i:s.", filemtime("../Bilder/Galerie/Bild_1.jpg"));
    echo "erstellt ?" . date ("F d Y H:i:s.", filectime("../Bilder/Galerie/Bild_1.jpg"));
    
     
   
    
 ?>


</body>
</html>
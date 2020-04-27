<?php
session_start();//Damit der Login Seitenübergreifen gespeichert werden kann
?>

<!DOCTYPE html> 
<html>
    <head>
        <title>Wild Rovers</title><!--Tabname-->
        <link rel="stylesheet" href="../Styles/style.css">     
        <link rel="stylesheet" href="../Styles/Siedebar_style.css">
        <link rel="shortcut icon" href="../Bilder/Tab_Logo.png" type="image/x-icon"/>
        <meta charset="utf-8">
        <script src="../Skripte/scripts.js"></script>
        <script src="../Skripte/Forum.js"></script>
    </head>   
<body> <!--Alles was auf der Webseite angezeigt werden soll--> 
  
<?php 
    if(isset($_SESSION['User'])){
// Login Banner wenn nutzer angemeldet
        echo'
        <div class="Loged_in-Banner">
            <div class="Loged_in-Bild"></div>
            <div class="Loged_in-Name"><a href="Profil.php">'.$_SESSION["User"].'</a></div>
            <div class="Loged_in-Butten"><a href="includes/logout.inc.php">Logout</a></div>
            <div class="Loged_in-SVG"> <a href="Disclaimer.html"><svg class="svg-icon" viewBox="0 0 20 20">
                <path d="M18.344,16.174l-7.98-12.856c-0.172-0.288-0.586-0.288-0.758,0L1.627,16.217c0.339-0.543-0.603,0.668,0.384,0.682h15.991C18.893,16.891,18.167,15.961,18.344,16.174 M2.789,16.008l7.196-11.6l7.224,11.6H2.789z M10.455,7.552v3.561c0,0.244-0.199,0.445-0.443,0.445s-0.443-0.201-0.443-0.445V7.552c0-0.245,0.199-0.445,0.443-0.445S10.455,7.307,10.455,7.552M10.012,12.439c-0.733,0-1.33,0.6-1.33,1.336s0.597,1.336,1.33,1.336c0.734,0,1.33-0.6,1.33-1.336S10.746,12.439,10.012,12.439M10.012,14.221c-0.244,0-0.443-0.199-0.443-0.445c0-0.244,0.199-0.445,0.443-0.445s0.443,0.201,0.443,0.445C10.455,14.021,10.256,14.221,10.012,14.221"></path>
                </svg></a></div>
        </div>
        ';    
    }
    else{
        // Login Banner wenn nutzer nicht angemeldet
        echo'  <div class="Loged_out-Banner">
        <div class="Loged_out-Login">
            <form action="includes/login.inc.php?herkunft='.str_replace("/mySite/","",$_SERVER['REQUEST_URI']).'" method="POST">
                <input class="user-input" type="text" name="mailuid" placeholder="Email/Username">
                <input class="user-input" type="password" name="passwort" placeholder="Passwort">           
                <button class="bannerbutton" type="submit" name ="login-submit">Login</button>   
            </form>
        </div>
        <div class="Loged_out-Butten"><a  href="#" onclick=document.getElementById("id01").style.display="block" >Registrieren</a></div>
        <div class="Loged_out-SVG"> <a href="Disclaimer.html"><svg class="svg-icon" viewBox="0 0 20 20">
            <path d="M18.344,16.174l-7.98-12.856c-0.172-0.288-0.586-0.288-0.758,0L1.627,16.217c0.339-0.543-0.603,0.668,0.384,0.682h15.991C18.893,16.891,18.167,15.961,18.344,16.174 M2.789,16.008l7.196-11.6l7.224,11.6H2.789z M10.455,7.552v3.561c0,0.244-0.199,0.445-0.443,0.445s-0.443-0.201-0.443-0.445V7.552c0-0.245,0.199-0.445,0.443-0.445S10.455,7.307,10.455,7.552M10.012,12.439c-0.733,0-1.33,0.6-1.33,1.336s0.597,1.336,1.33,1.336c0.734,0,1.33-0.6,1.33-1.336S10.746,12.439,10.012,12.439M10.012,14.221c-0.244,0-0.443-0.199-0.443-0.445c0-0.244,0.199-0.445,0.443-0.445s0.443,0.201,0.443,0.445C10.455,14.021,10.256,14.221,10.012,14.221"></path>
            </svg></a></div>
    
    </div>';
    }
?>
<!-- Navigationsbar -->
<header>
    <nav>
        <ul>
            <li><a id="1" href="index.php">Home</a></li>
            <li><a id="2" href="Das_Team.php">Das Team</a></li>
            <li><a id="3" href="Infos&Regeln.php">Infos/Regeln</a></li>
            <li class="logo"><a href="index.php">Logo</a></li>
            <li><a id="4" href="Gallerie.php">Gallerie</a></li>
            <li><a id="5" href="Sponsoren.php">Sponsoren</a></li>  
            <li><a id="6" href="Forum.php">Forum</a></li>  
        </ul>
    </nav>   
</header>
<script>
const link = window.location.pathname;
let elm ="leer";
switch (link) {
    
    case "/mySite/index.php":
        elm = document.getElementById("1");
        break;
    case "/mySite/Das_Team.php":
        elm = document.getElementById("2");      
        break;
    case "/mySite/Infos&Regeln.php":
        elm = document.getElementById("3");
    break;
        case "/mySite/Gallerie.php":
         elm = document.getElementById("4"); 
    break;
        case "/mySite/Sponsoren.php":
        elm = document.getElementById("5");  
        break;
        case "/mySite/Forum.php":
        case "/mySite/Forum_Kategorie.php":
        case "/mySite/Forum_Themen.php":
        case "/mySite/Forum_Posts.php":
        elm = document.getElementById("6");
        break; 
    default:
        break;
      
}
elm.style.color = "#fc9403";
elm.style.textDecoration = "underline";
elm.style.fontSize  = "x-large";

</script>

<!-- Siedebar -->
<div id="sidebar">
    <div class="toggle-btn" onclick="toggleSidebar()" >
        <a>
            <span></span><span></span><span></span>
        </a>
    </div>
    <!-- Logo -->
    <img class="sb_bild" src="../Bilder/Logo_hell.png" alt="WRW_Logo">
    <?php 
        //Wird ausgegeben wenn der Nutzer nicht angemeldet ist
        if(isset($_SESSION['User']))
        {
        echo '
            <ul>                
                <li><a href="#">Home</a></li>
                <li><a href="Profil.php">Mein Profil</a></li>';
        // zusätzliche Inhalte wenn der Nutzer Mitglied ist
        if($_SESSION['rang']>0)
        {
            echo'<li><a href="Chat.php">Chat</a></li>
                 <li><a href="Forum.php">Forum</a></li>';              
        }     
        //Admin, vorstand zusatz
        if($_SESSION['rang']>2)
        {
            echo'<li><a href="Adminzeug.php">Adminzeug</a></li>
            </ul>'; 
            //Optionen Liste zu               
        }
        }
        //Wenn der Nutzer nicht angemeldet ist.
        else 
        {
        echo '
        <form action="includes/login.inc.php?herkunft='.str_replace("/mySite/","",$_SERVER['REQUEST_URI']).'" method="POST">  
            <input type="text" name="mailuid" placeholder="Email/Username"  ><br>
            <input type="password" name="passwort" placeholder="Passwort" ><br>
            <button type="submit" name ="login-submit">Login</button><br>
        </form>
        ';                   
        }
    ?>
</div>
<!-- PopUp Sign Up -->
<?php 
if(strpos($_SERVER['REQUEST_URI'], 'join_us.php') == false )
{
echo'
    <div id="id01" class="modal">
        <div class="modal-content animate">'; 

    //Ist noch nicht perfekt
    include_once "join_us_popUp.php";
    
echo'    </div>     
    </div> 

<script>
// Get the modal
var modal = document.getElementById("id01");
// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>';   
}   
?>                     





function JoinInpuTest(element){


    //ID holen um richtige Überprüfung auszuführen
    var ID = element.getAttribute("id");
 
    //Element zum Fehlermeldung ausgeben holen
    var hint = document.getElementById("hint-"+ID);
    hint.style.display = "inline";

    //Checkbox holen
    var Checkbox = document.getElementById("input-"+ID);
    Checkbox.style.backgroundImage = "url('../Bilder/SVG/spinner.svg')";

    //Style des aktivenelements ändern
    var lable = document.getElementById("label-"+ID);
   
    //Ebentlistener auf das Aktuelle feld. Wenn eine taste gedrückt wird, wird der Inhalt des Feldes überprüft
    element.addEventListener('keyup', function(){

    //Variablen für kontrolle
    var inputLänge = element.value.length;
    
    //unterschiedliche überprüfungen je nach ID
    switch(ID){
        //Vor-Nachname nur auf Länge überprüfen
        case "Vorname":;
        case "Nachname": 
            
            if(inputLänge<3){
                hint.innerHTML = "Nicht genug Zeichen";
                lable.style.color = "lightcoral"; 
            }
            else if(inputLänge>=3&&inputLänge<25){            
                hint.innerHTML = "Name Passt";
                lable.style.color = "Aquamarine";
                Checkbox.style.backgroundImage = "url('../Bilder/SVG/check.svg')";
            }
            else if(inputLänge==25)
            {          
                hint.innerHTML = "Max Anzahl an Zeichen erreicht";
            }
            break;
        //Nick auf länge und ob bereits vorhanden
        case "Nick":
            if(inputLänge<3){
                hint.innerHTML = "Nicht genug Zeichen";
                lable.style.color = "lightcoral"; 
                
            }
            else if(inputLänge>=3&&inputLänge<15){            
                hint.innerHTML = "Nick Passt";
                lable.style.color = "Aquamarine";
                Checkbox.style.backgroundImage = "url('../Bilder/SVG/check.svg')";
            }
            else if(inputLänge==15)
            {          
                hint.innerHTML = "Max Anzahl an Zeichen erreicht";
            }
            //Prüfen ob name vergeben
            break;
        case "Email":
            if((element.value).search("@") != -1){
                hint.innerHTML = "Email Passt";
                lable.style.color = "Aquamarine";
                Checkbox.style.backgroundImage = "url('../Bilder/SVG/check.svg')";
            }
            else{
                lable.style.color = "lightcoral"; 
                hint.innerHTML = "Email ist ungültig";
            }
            case "Geburtstag":
                if(element.value.length>=10){
                    const date = new Date(element.value);
                    console.log(date);
                    if(date.getFullYear()>=new Date().getFullYear()-17)
                    {
                        hint.innerHTML = "Midestalter 18 Jahre. Schreib uns ne Mail";
                        lable.style.color = "lightcoral"; 
                        Checkbox.style.backgroundImage = "url('../Bilder/SVG/fail.svg')";
                    }
                    else{ 
                        hint.innerHTML = "Geburtstag passt";
                        lable.style.color = "Aquamarine";
                        Checkbox.style.backgroundImage = "url('../Bilder/SVG/check.svg')";

                    }
                }
                break;

        case "Passwort": 
            if(inputLänge<=6){
                hint.innerHTML = "Dein Passwort sollte länger sein";
                lable.style.color = "lightcoral"; 
                
            }
            else if(inputLänge>6){          
                hint.innerHTML = "Passwort passt";
                lable.style.color = "Aquamarine";
            }
            break;
        case "Passwort-WDH":
            //Passwort holen
             var pwEntered = document.getElementById("Passwort").value;
    
            if(element.value != pwEntered){
                hint.innerHTML = "Passwörter stimmen nicht überein";
                lable.style.color = "lightcoral";
            }
            else{
                hint.innerHTML = "Passwörter stimmen überein";
                lable.style.color = "Aquamarine";
            }
            break;
        default: console.log("def"); 
            break;
    }

    },true);
  
}

function fu(element){
    //ID holen um richtige Überprüfung auszuführen
    var ID = element.getAttribute("id");
    //Element zum Fehlermeldung ausgeben holen
    var hint = document.getElementById("hint-"+ID);
    //Variablen für kontrolle
    var inputLänge = element.value.length;
     //Checkbox holen
     var Checkbox = document.getElementById("input-"+ID);
     //Style des aktivenelements ändern
     var lable = document.getElementById("label-"+ID);

     switch(ID){
         case"Nachname":;
         case"Vorname":
         if(inputLänge>=3&&inputLänge<15){            
            hint.style.display = "none";
            lable.style.color = "Aquamarine";
            Checkbox.style.backgroundImage = "url('../Bilder/SVG/check.svg')";
        }
        else{
            hint.innerHTML = "Zu wenig Zeichen";
            lable.style.color = "lightcoral";
            Checkbox.style.backgroundImage = "url('../Bilder/SVG/fail.svg')";
        }
         break;
         case "Geburtstag":
            if(element.value.length>=10){
                const date = new Date(element.value);
                console.log(date);
                if(date.getFullYear()>=new Date().getFullYear()-17)
                {
                    hint.innerHTML = "Midestalter 18 Jahre. Schreib uns ne Mail";
                    lable.style.color = "lightcoral"; 
                    Checkbox.style.backgroundImage = "url('../Bilder/SVG/fail.svg')";
                }
                else{ 
                    hint.style.display = "none";
                    lable.style.color = "Aquamarine";
                    Checkbox.style.backgroundImage = "url('../Bilder/SVG/check.svg')";

                }
            }
             break;
         case"Passwort":
        if(inputLänge == 0){
            hint.innerHTML = "Zu wenig Zeichen";
            lable.style.color = "lightcoral"; 
            Checkbox.style.backgroundImage = "url('../Bilder/SVG/fail.svg')";
        }
         else if(inputLänge<=6){
            hint.innerHTML = "Dein Passwort sollte länger sein";
            lable.style.color = "Aquamarine"; 
            Checkbox.style.backgroundImage = "url('../Bilder/SVG/check.svg')";
        }
        else if(inputLänge>6){          
            hint.style.display = "none";
            lable.style.color = "Aquamarine";
        }
         break;
         case"Passwort-WDH":
           //Passwort holen
           var pwEntelightcoral = document.getElementById("Passwort").value;
    
           if(inputLänge == 0){
            hint.innerHTML = "Zu wenig Zeichen";
            lable.style.color = "lightcoral"; 
            Checkbox.style.backgroundImage = "url('../Bilder/SVG/fail.svg')";
            }
           else if(element.value != pwEntelightcoral){
               hint.innerHTML = "Passwörter stimmen nicht überein";
               lable.style.color = "lightcoral";
           }
           else{
               hint.innerHTML = "Passwörter stimmen überein";
               lable.style.color = "Aquamarine";
               hint.style.display = "none";
               Checkbox.style.backgroundImage = "url('../Bilder/SVG/check.svg')";
           }
         break;
         case"Nick":
         
            // Ein XMLHTTP-Request-Objekt erzeugen.
            var xhr = new XMLHttpRequest();    
                // Den Inhalt des Eingabefeldes auslesen
                var suchbegriff = element.value;
                // Überprüfen ob der Suchbegriff mehr als 3 Zeichen enthält.
                if (suchbegriff.length > 3) {  
                    // XMLHTTP-Request zur Datei: antwort.php öffnen und den Suchbegriff anhängen.
                    xhr.open("POST", "Ajax-anfragen.php?suchbegriff=" + suchbegriff +"&Kategorie=Nick", true);
                    // xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded" );
                    // XMLHTTP-Request senden.
                    xhr.send();
                    // Auf eine Antwort warten
                    xhr.onreadystatechange = function() {
                        // Überprüfen ob der Server eine Antwort geliefert hat.
                        if (xhr.readyState == 4 && xhr.status == 200) {
                            // Die Antwort des Servers ausgeben
                            // document.getElementById("hint-Nick").innerHTML = xhr.responseText;
                            console.log("server hat geantwortet: "+ xhr.responseText);
                            if(xhr.responseText=="1"){
                                Checkbox.style.backgroundImage = "url('../Bilder/SVG/check.svg')";
                                hint.style.display = "none";
                            }
                            else{
                                Checkbox.style.backgroundImage = "url('../Bilder/SVG/fail.svg')";
                                hint.innerHTML = "Name ist bereits vergeben";
                                lable.style.color = "lightcoral";
                            }
                        }
                    }
                }
                if(inputLänge == 0){
                    hint.innerHTML = "Zu wenig Zeichen";
                    lable.style.color = "lightcoral"; 
                    Checkbox.style.backgroundImage = "url('../Bilder/SVG/fail.svg')";
                }
            
         break;
         case "Email":
            if((element.value).search("@") != -1){
                hint.innerHTML = "Email Passt";
                lable.style.color = "Aquamarine";
                Checkbox.style.backgroundImage = "url('../Bilder/SVG/check.svg')";

            // Ein XMLHTTP-Request-Objekt erzeugen.
            var xhr = new XMLHttpRequest();
            // Den Inhalt des Eingabefeldes auslesen
            var suchbegriff = element.value;
            // Überprüfen ob der Suchbegriff mehr als 3 Zeichen enthält.
            if (suchbegriff.length > 3) {
                // XMLHTTP-Request zur Datei: antwort.php öffnen und den Suchbegriff anhängen.
                xhr.open("POST", "Ajax-anfragen.php?suchbegriff=" + suchbegriff +"&Kategorie=Email", true);
                // xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded" );
                // XMLHTTP-Request senden.
                xhr.send();
                // Auf eine Antwort warten
                xhr.onreadystatechange = function() {

                    // Überprüfen ob der Server eine Antwort geliefert hat.
                    if (xhr.readyState == 4 && xhr.status == 200) {

                        // Die Antwort des Servers ausgeben
                        // document.getElementById("hint-Nick").innerHTML = xhr.responseText;
                        console.log("server hat geantwortet: "+ xhr.responseText);
                        if(xhr.responseText=="1"){
                            Checkbox.style.backgroundImage = "url('../Bilder/SVG/check.svg')";
                            hint.style.display = "none";
                        }
                        else{
                            Checkbox.style.backgroundImage = "url('../Bilder/SVG/fail.svg')";
                            hint.innerHTML = "Email ist bereits vergeben";
                            lable.style.color = "lightcoral";
                        }
                    }
                }
            }
            }
            else{
                lable.style.color = "lightcoral"; 
                hint.innerHTML = "Email ist ungültig";
                Checkbox.style.backgroundImage = "url('../Bilder/SVG/fail.svg')";
            }
                  
         break;
     }
     
}

function anfrage(suchebegriff,kategorie){


}
function toggleUpdateField(feld,bereich){
    const schalter = document.getElementById("infoSchalter-"+bereich);
    const feldName = document.getElementById("FeldName-"+bereich);
  

    if (schalter.style.display == "flex" && feldName.value == feld){
        schalter.style.display="none";
    }
    else{
        schalter.style.display="flex";
    }
    feldName.value=feld;
    // schalter.style.display="flex";
    
    console.log("Wert: "+feld+" aus Berreich: "+bereich);

    datenHolen(feld,bereich);

}


//Holt die Daten per Ajax vom Server
//Daten werden dann in das Alt Feld geschrieben
//Typ des Feldes wird ja nach Datentyp angepasst
function datenHolen(feld,bereich){

    const Nutzer = document.getElementById("NutzerID").innerHTML;
    console.log("Es soll das Feld " +feld+" für den Nutzer "+Nutzer+" geänder werden");

    //XMLHTTP-Request
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "includes/update_nutzerInfo.inc.php?aufgabe=getInfo&benuter="+Nutzer+"&feld="+feld, true);
    xhr.send();
    xhr.onreadystatechange = function() {
        // Überprüfen ob der Server eine Antwort geliefert hat.
        if (xhr.readyState == 4 && xhr.status == 200) {

            // Die Antwort des Servers ausgeben
            // document.getElementById("hint-Nick").innerHTML = xhr.responseText;
            console.log("server hat geantwortet: "+ xhr.responseText);
            const alterWert = document.getElementById("WertAlt-"+bereich);
            const neuerWert = document.getElementById("WertNeu-"+bereich);
            const alterWertBox = alterWert.parentElement;

            switch(feld){
                case "Passwort": 
                    // console.log("PW");
                    neuerWert.type = "password";
                    neuerWert.value ="";
                    neuerWert.placeholder = "neues "+feld;
                    alterWert.readOnly = false;
                    alterWert.type = "password";
                    alterWert.value = "";
                    alterWert.placeholder = "altes Passwort";
                    alterWert.focus();
                    alterWert.addEventListener('blur', pruefen,true);                  
                    neuerWert.addEventListener('keyup',vergleichen,true);
                break;
                case"Geburtstag": 
                    // console.log("GB");        
                    var date = new Date(xhr.responseText *1000);
                    alterWert.removeEventListener("blur", pruefen,true);
                    alterWert.value = ('0' + date.getDate()).slice(-2) + '.' + ('0' + (date.getMonth()+1)).slice(-2) + '.'+ date.getFullYear();
                    alterWert.type = "text";
                    alterWert.readOnly = true;
                    alterWertBox.style.borderBottom ="1px solid #b3b3b3";
                    neuerWert.type = "date";
                    neuerWert.parentElement.style.borderBottom = '1px solid #b3b3b3';
                    neuerWert.addEventListener('keyup',vergleichen,true);
                    neuerWert.value = date.getFullYear() + '-' + ('0' + (date.getMonth()+1)).slice(-2) + '-'+('0' + date.getDate()).slice(-2); 
                break;
                case "Emailadresse":
                case "Nick":
                    alterWert.type = "text";
                    alterWert.value = xhr.responseText;
                    alterWert.readOnly = true;
                    alterWertBox.style.borderBottom ="1px solid #b3b3b3";
                    neuerWert.parentElement.style.borderBottom = '1px solid #b3b3b3';
                    neuerWert.type = "text";
                    neuerWert.placeholder = "neuer "+feld;
                    neuerWert.value = "";
                    neuerWert.focus();
                    neuerWert.addEventListener('blur', pruefen,true);     
                break;
                default:
                    alterWert.removeEventListener("blur", pruefen,true);
                    alterWert.type = "text";
                    alterWert.value = xhr.responseText;
                    alterWert.readOnly = true;
                    alterWertBox.style.borderBottom ="1px solid #b3b3b3";
                    neuerWert.parentElement.style.borderBottom = '1px solid #b3b3b3';
                    neuerWert.type = "text";
                    neuerWert.placeholder = "neuer "+feld;
                    neuerWert.value = "";
                    neuerWert.focus();
                    neuerWert.addEventListener('keyup',vergleichen,true);
                    break;
            }
        }   
    }
}

//PW Prüft ob das eingegebene Passwort mit dem Gespeicherten übereinstimmt
//Nick/Email Prüft ob Nick und Email bereits auf dem Server Vorhanden sind
//Die Alter Wert Box wird ja nach ergeniss eingefärbt
function pruefen(){
    var bereich = this.getAttribute("id").split("-")[1];
    console.log("Prüfen in Bereich "+bereich);
    const Nutzer = document.getElementById("NutzerID").innerHTML;
    const alterWert = document.getElementById("WertAlt-"+bereich);
    // const neuerWert = document.getElementById("WertNeu-"+bereich);
    const alterWertBox = alterWert.parentElement;
    const feld = document.getElementById("FeldName-"+bereich).value;
    const neuerWert = document.getElementById("WertNeu-"+bereich);
    const neuerWertBox = neuerWert.parentElement;
    
    // console.log("Wert aus fled: "+feld);
    //Je nach Überprüfung wird ein anderer Link gebaut.
    var anfrage = new XMLHttpRequest();
    if(feld == "Passwort"){
    anfrage.open("GET", "includes/update_nutzerInfo.inc.php?aufgabe=pruefen&benuter="+Nutzer+"&feld="+feld+"&wert="+alterWert.value, true);
    }
    else if(feld == "Emailadresse"){
    // console.log("Das Feld "+feld+"vom Nutzer"+Nutzer +"soll auf den wert auf den wert: "+ neuerWert.value+"aktualiseirt");
    anfrage.open("GET", "includes/update_nutzerInfo.inc.php?aufgabe=pruefen&benuter="+Nutzer+"&feld="+feld+"&wert="+neuerWert.value, true);
    }
    else if(feld == "Nick"){
    anfrage.open("GET", "includes/update_nutzerInfo.inc.php?aufgabe=pruefen&benuter="+Nutzer+"&feld="+feld+"&wert="+neuerWert.value, true);
    }
    else{
        console.log("Warum");
    }
    anfrage.send();
    anfrage.onreadystatechange = function() {
        // Überprüfen ob der Server eine Antwort geliefert hat.
        if (anfrage.readyState == 4 && anfrage.status == 200) {
            console.log("Überprüfung vom Server ergab: "+ anfrage.responseText);

            const antwort = anfrage.responseText;
            switch(feld){
                case "Emailadresse":
                case "Nick":
                    if(antwort==0){neuerWertBox.style.borderBottom = "1px solid red";}
                    else{neuerWertBox.style.borderBottom = "1px solid green";}
                break;
                case "Passwort":
                    if(antwort==0){alterWertBox.style.borderBottom = "1px solid red";}
                    else{alterWertBox.style.borderBottom = "1px solid green";}
                break;

            }
         
          
        }
    }   
}

//Vergleicht auf der User seite den Alten und Neuen wert und gibt feedback dazu
// Hier noch einbauen feedback zu allen anderen Werten auser PW :D
function vergleichen(){

    var bereich = this.getAttribute("id").split("-")[1];
    console.log("Vergleichen in Bereich "+bereich);
    

    const alterWert = document.getElementById("WertAlt-"+bereich);
    const neuerWert = document.getElementById("WertNeu-"+bereich);
    const feld = document.getElementById("FeldName-"+bereich).value;

    switch (feld) {
        case "Passwort":
            if(alterWert.value == neuerWert.value){
                neuerWert.parentElement.style.borderBottom = '1px solid green';
            }
            else{
                neuerWert.parentElement.style.borderBottom = '1px solid red';
            }
            break;
        case "Geburtstag":
            break;
    
        default:
            break;
    }
}

function datenLoeschen(){

}


//Schickt die neuen Daten in die Datenbank
// Aktuallisiert bei erfolg das Feld mit dem neuen Wert
//Farbiges Feedback an den Nutzer fehlt noch
function datenUpdaten(bereich){
    const Nutzer = document.getElementById("NutzerID").innerHTML;
    const feldName = document.getElementById("FeldName-"+bereich).value;
    const alterWert = document.getElementById("WertAlt-"+bereich).value;
    var neuerWert = document.getElementById("WertNeu-"+bereich).value;

    // Ein XMLHTTP-Request-Objekt erzeugen.
    var update = new XMLHttpRequest();
    update.open("GET", "includes/update_nutzerInfo.inc.php?aufgabe=updateInfo&benuter="+Nutzer+"&feld="+feldName+"&wert="+neuerWert, true);
    update.send();
    // Auf eine Antwort warten
    update.onreadystatechange = function() {
        if (update.readyState == 4 && update.status == 200) {
            // console.log("Update versuch ergab: "+ update.responseText);
            if(update.responseText==1)
            {
                if(feldName=="Geburtstag")
                {            
                    var date =  neuerWert.split("-");            
                    neuerWert =  date[2] + '.' + date[1] + '.'+ date[0]; 
                    //Muss noch berechnet werden
                    var alterUpdate = document.getElementById("PrfilAlter");
                    alterUpdate.innerHTML = "KP wie das mit JS geht lad die Seite neu :)";
                }
                //Verhindert, dass das Passwort im Klartext angezeigt wird.
                else if(feldName =="Emailadresse"){
                    // console.log(bereich+feldName);
                    document.getElementById(bereich+feldName+"Privat").innerHTML = neuerWert;
                }
                else if(feldName != "Passwort"){
                    console.log(bereich);
                    console.log(feldName);
                    console.log(bereich+feldName);
                    document.getElementById(bereich+feldName).innerHTML = neuerWert;
                }
                //  console.log("Das Feld "+feldName+"im Bereich"+bereich+"wurder erfolgreich auf den wert: "+ neuerWert+"aktualiseirt");
               
            }
            else{
                console.log("Update fehlgeschlagen")
            }
        }
    }
}

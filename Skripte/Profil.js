function ProfilInfoToggel(wert){
    const schalter = document.getElementById("infoSchalter-Profil");
    const feldName = document.getElementById("ProfilFeldName");
    feldName.value=wert;
    schalter.style.display="flex";
    datenHolen(wert);
}
function ProfilKontaktdatenToggel(){
    const schalter = document.getElementById("infoSchalter-Kontaktdaten");
    console.log(schalter);
    if (schalter.style.display == "flex"){
        schalter.style.display="none";
    }
    else{
        schalter.style.display="flex";
    }
}
function ProfilTeamToggel(){
    const schalter = document.getElementById("infoSchalter-Team");
    console.log(schalter);
    if (schalter.style.display == "flex"){
        schalter.style.display="none";
    }
    else{
        schalter.style.display="flex";
    }
}

//Holt die Daten per Ajax vom Server
//Daten werden dann in das Alt Feld geschrieben
//Typ des Feldes wird ja nach Datentyp angepasst
function datenHolen(feld){

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
            const alterWert = document.getElementById("ProfilWertAlt");
            const neuerWert = document.getElementById("ProfilWertNeu");
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

    const Nutzer = document.getElementById("NutzerID").innerHTML;
    const alterWert = document.getElementById("ProfilWertAlt");
    const neuerWert = document.getElementById("ProfilWertNeu");
    const alterWertBox = alterWert.parentElement;
    const feld = document.getElementById("ProfilFeldName").value;
    
    // console.log("Wert aus fled: "+feld);
    //Je nach Überprüfung wird ein anderer Link gebaut.
    var anfrage = new XMLHttpRequest();
    if(feld == "Passwort"){
    anfrage.open("GET", "includes/update_nutzerInfo.inc.php?aufgabe=pruefen&benuter="+Nutzer+"&feld="+feld+"&wert="+alterWert.value, true);
    }
    else if(feld == "Email"){
    anfrage.open("GET", "includes/update_nutzerInfo.inc.php?aufgabe=pruefen&benuter="+Nutzer+"&feld="+feld+"&wert="+alterWert.value, true);
    }
    else if(feld == "Nick"){
    anfrage.open("GET", "includes/update_nutzerInfo.inc.php?aufgabe=pruefen&benuter="+Nutzer+"&feld="+feld+"&wert="+alterWert.value, true);
    }
    else{
        console.log("Warum");
    }
    anfrage.send();
    anfrage.onreadystatechange = function() {
        // Überprüfen ob der Server eine Antwort geliefert hat.
        if (anfrage.readyState == 4 && anfrage.status == 200) {
            console.log("Passwortüberprüfung vom Server ergab: "+ anfrage.responseText);

            const pwRichtig = anfrage.responseText;
            // console.log(pwRichtig);
            if(pwRichtig==0){
                alterWertBox.style.borderBottom = "1px solid red";
            }
            else if (pwRichtig==1){
                alterWertBox.style.borderBottom = "1px solid green";

            }
        }
    }   
}

//Vergleicht auf der User seite den Alten und Neuen wert und gibt feedback dazu
// Hier noch einbauen feedback zu allen anderen Werten auser PW :D
function vergleichen(){
    const alterWert = document.getElementById("ProfilWertAlt");
    const neuerWert = document.getElementById("ProfilWertNeu");
    const alterWertBox = alterWert.parentElement;
    const feld = document.getElementById("ProfilFeldName").value;

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
function datenUpdaten(){
    const Nutzer = document.getElementById("NutzerID").innerHTML;
    const feldName = document.getElementById("ProfilFeldName").value;
    const alterWert = document.getElementById("ProfilWertAlt").value;
    var neuerWert = document.getElementById("ProfilWertNeu").value;

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
                console.log("Das Feld "+feldName+"wurder erfolgreich auf den wert: "+ neuerWert+"aktualiseirt");
                document.getElementById("Prfil"+feldName).innerHTML = neuerWert;
            }
            else{
                console.log("Update fehlgeschlagen")
            }
        }
    }
}
var updateMoeglich = false;
var fehlerMeldungen = ['unbekannter Fehler','Email exestiert','Nick exestiert','ungültige Eingabe','illgaler Zugriff'];

function toggleUpdateField(feld,bereich){
    const schalter = document.getElementById("infoSchalter-"+bereich);
    const feldName = document.getElementById("FeldName-"+bereich);
    const alterWert = document.getElementById("WertAlt-"+bereich);
    const neuerWert = document.getElementById("WertNeu-"+bereich);
    
    if (schalter.style.display == "flex" && feldName.value == feld){
        schalter.style.display="none";
    }
    else{
        schalter.style.display="flex";
        datenHolen(feld,bereich);
        feldName.value=feld;
    } 
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
            const wertWDH = document.getElementById("WertNeuWDH-"+bereich);
            const hintAlt = document.getElementById("hintWertAlt-"+bereich);
            const hintNeu = document.getElementById("hintWertNeu-"+bereich);
            const hintWDH = document.getElementById("hintWertWDH-"+bereich);

            switch(feld){
                case "Passwort": 
                    neuerWert.type = "password";
                    neuerWert.value ="";
                    neuerWert.placeholder = "neues "+feld;
                    neuerWert.addEventListener('keyup',vergleichen,true);
                    neuerWert.style.borderBottom ="1px solid #b3b3b3";
                    alterWert.readOnly = false;
                    alterWert.type = "password";
                    alterWert.value = "";
                    alterWert.style.borderBottom ="1px solid #b3b3b3";
                    alterWert.placeholder = "altes Passwort";
                    alterWert.focus();
                    alterWert.addEventListener('blur', pruefen,true);                  
                    wertWDH.addEventListener('keyup',vergleichen,true);
                    wertWDH.style.borderBottom ="1px solid #b3b3b3";
                    wertWDH.parentElement.style.display ="flex";
                    wertWDH.value = "";
                    hintAlt.innerHTML="";
                    hintNeu.innerHTML="";
                    hintWDH.innerHTML="";
                break;
                case"Geburtstag": 
                    // console.log("GB");        
                    var date = new Date(xhr.responseText *1000);
                    alterWert.removeEventListener("blur", pruefen,true);
                    alterWert.value = ('0' + date.getDate()).slice(-2) + '.' + ('0' + (date.getMonth()+1)).slice(-2) + '.'+ date.getFullYear();
                    alterWert.type = "text";
                    alterWert.readOnly = true;
                    alterWert.style.borderBottom ="1px solid #b3b3b3";
                    neuerWert.type = "date";
                    neuerWert.style.borderBottom = '1px solid #b3b3b3';
                    neuerWert.addEventListener('keyup',vergleichen,true);
                    neuerWert.value = date.getFullYear() + '-' + ('0' + (date.getMonth()+1)).slice(-2) + '-'+('0' + date.getDate()).slice(-2); 
                    wertWDH.parentElement.style.display ="none";
                    wertWDH.value = "";
                   
                    hintAlt.innerHTML="";
                    hintNeu.innerHTML="";
                    hintWDH.innerHTML="";
                break;
                case "Emailadresse":
                case "Nick":
                    alterWert.type = "text";
                    alterWert.value = xhr.responseText;
                    alterWert.readOnly = true;
                    alterWert.style.borderBottom ="1px solid #b3b3b3";
                    neuerWert.style.borderBottom = '1px solid #b3b3b3';
                    neuerWert.type = "text";
                    neuerWert.placeholder = "neuer "+feld;
                    neuerWert.value = "";
                    neuerWert.focus();
                    neuerWert.addEventListener('blur', pruefen,true); 
                    wertWDH.parentElement.style.display ="none";
                    wertWDH.value = "";

                    hintAlt.innerHTML="";
                    hintNeu.innerHTML="";
                    hintWDH.innerHTML="";    
                break;
               
                default:
                    alterWert.removeEventListener("blur", pruefen,true);
                    alterWert.type = "text";
                    alterWert.value = xhr.responseText;
                    alterWert.readOnly = true;
                    alterWert.style.borderBottom ="1px solid #b3b3b3";
                    neuerWert.style.borderBottom = '1px solid #b3b3b3';
                    neuerWert.type = "text";
                    neuerWert.placeholder = "neuer "+feld;
                    neuerWert.value = "";
                    neuerWert.focus();
                    neuerWert.addEventListener('keyup',vergleichen,true);
                    wertWDH.parentElement.style.display ="none";
                    wertWDH.value = "";
                    hintAlt.innerHTML="";
                    hintNeu.innerHTML="";
                    hintWDH.innerHTML="";
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
    
    const Nutzer = document.getElementById("NutzerID").innerHTML;
    const alterWert = document.getElementById("WertAlt-"+bereich);
    const feld = document.getElementById("FeldName-"+bereich).value;
    const neuerWert = document.getElementById("WertNeu-"+bereich);
    const hintAlt = document.getElementById("hintWertAlt-"+bereich);
    const hintNeu = document.getElementById("hintWertNeu-"+bereich);
    const hintWDH = document.getElementById("hintWertWDH-"+bereich);
    console.log("Prüfen in Bereich "+bereich+"im Feld:"+feld); 
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
    //Keine Anfrage Senden wenn beide Werte leer sind
    if(alterWert.value != ""&&neuerWert.value!=""){
        anfrage.send();
    }
    //Keine Anfrage Senden wenn der neue Wert leer ist
    else if(neuerWert.value!=""){
        anfrage.send();
    }
    anfrage.onreadystatechange = function() {
        // Überprüfen ob der Server eine Antwort geliefert hat.
        if (anfrage.readyState == 4 && anfrage.status == 200) {
            console.log("Überprüfung vom Server ergab: "+ anfrage.responseText);

            const antwort = anfrage.responseText;
            switch(feld){
                case "Emailadresse":
                case "Nick":
                    if(antwort==0&&neuerWert.value != alterWert.value){
                        neuerWert.style.borderBottom = "1px solid red";
                        hintNeu.style.color = "red";
                        hintNeu.innerHTML = "Bereits vorhanden";
                        updateMoeglich = false;
                    }
                    else if(neuerWert.value == alterWert.value){
                        neuerWert.borderBottom ="1px solid #b3b3b3";
                        hintNeu.style.color = "orange";
                        hintNeu.innerHTML = "kein Update nötig";
                        updateMoeglich = false;
                    }

                    else {
                        neuerWert.style.borderBottom = "1px solid green";
                        hintNeu.style.color = "green";
                        hintNeu.innerHTML = "Gültig";
                        updateMoeglich = true;
                    }
                break;
                case "Passwort":
                    if(antwort==0){
                        alterWert.style.borderBottom = "1px solid red";
                        hintAlt.style.color = "red";
                        hintAlt.innerHTML = "Falsches Passwort";
                        updateMoeglich = false;
                    }   
                    else{
                        alterWert.style.borderBottom = "1px solid green";
                        hintAlt.style.color = "green";
                        hintAlt.innerHTML = "Passwort passt";
                        updateMoeglich = false;
                    }
                break;

            }
         
          
        }
    }   
}

//Vergleicht auf der User seite den Alten und Neuen wert und gibt feedback dazu
// Hier noch einbauen feedback zu allen anderen Werten auser PW :D
function vergleichen(fu){
    //ermöglicht, dass man die vergleichen Funktion auch mit parametern von der update Funktion aufzurufen
    if(fu.type == "keyup")
    {
        var bereich = this.getAttribute("id").split("-")[1];
    }
    else{
        var bereich = fu;
    }

   
    const alterWert = document.getElementById("WertAlt-"+bereich);
    const neuerWert = document.getElementById("WertNeu-"+bereich);
    const feld = document.getElementById("FeldName-"+bereich).value;
    const hintNeu = document.getElementById("hintWertNeu-"+bereich);
    const hintAlt = document.getElementById("hintWertAlt-"+bereich);
    const hintWDH = document.getElementById("hintWertWDH-"+bereich);
    const wertWDH = document.getElementById("WertNeuWDH-"+bereich);
    console.log("Vergleichen in Bereich "+bereich+"mit dem Feld:"+feld+"Update möglich = "+updateMoeglich);

    //Gibt hinweise für die verscheidenen Elemente
    switch (feld) {
        case "Vorname":
        case "Nachname":
            if(neuerWert.value.length < 30)
            {
                if(neuerWert.value == "")
                {
                    updateMoeglich = false;
                    hintNeu.style.color = "red";
                    hintNeu.innerHTML = "Eingabe nötig";
                    updateMoeglich = false;
                }
                else if(neuerWert.value == alterWert.value)
                {
                    hintNeu.style.color = "orange";
                    hintNeu.innerHTML = "kein Update nötig";
                    updateMoeglich = false;
                } 
                else
                {
                    hintNeu.style.color = "green";
                    hintNeu.innerHTML = "Passt";
                    updateMoeglich = true;
                }
            }
            else{
                hintNeu.style.color = "red";
                hintNeu.innerHTML = "Max. läng erreicht";
            }
        break;
        case "Passwort":
            if(neuerWert.value == ""&&wertWDH.value == ""&&alterWert.value==""){
                hintNeu.style.color = "red";
                hintNeu.innerHTML = "Eingabe nötig";
                hintWDH.style.color = "red";
                hintWDH.innerHTML = "Eingabe nötig";
                hintAlt.style.color = "red";
                hintAlt.innerHTML = "Eingabe nötig";          
            }
            //Wenn beid Felder einen Wert haben
            if((neuerWert.value != "")&&(alterWert.value !="")){
                if(alterWert.value == neuerWert.value){
                    neuerWert.style.borderBottom = '1px solid red';
                    hintNeu.style.color = "red";
                    hintNeu.innerHTML = "Muss sich unterscheiden";
                    updateMoeglich = false;
                }
                else{
                    neuerWert.style.borderBottom = '1px solid green';
                    hintNeu.style.color = "green";
                    hintNeu.innerHTML = "Passwort ist neu";
                    updateMoeglich = false;
                }
            }
            //Damit kein unnötige überprüfung stattfindet wenn wdh leer ist
            if(wertWDH.value != ""){
                if(wertWDH.value == neuerWert.value){
                    wertWDH.style.borderBottom = '1px solid green';
                    hintWDH.style.color = "green";
                    hintWDH.innerHTML = "Stimmen überein";
                    updateMoeglich = true;
                }
                else{
                    wertWDH.style.borderBottom = '1px solid red';
                    hintWDH.style.color = "red";
                    hintWDH.innerHTML = "Stimmen nicht";
                    updateMoeglich = false;
                }
            }
        break;
        case 'Nick':
            if(neuerWert.value.length < 15)
            {
                if(neuerWert.value == "")
                {
                    updateMoeglich = false;
                    hintNeu.style.color = "red";
                    hintNeu.innerHTML = "Eingabe nötig";
                    updateMoeglich = false;
                }
                else if(neuerWert.value == alterWert.value)
                {
                    neuerWert.style.borderBottom ="1px solid #b3b3b3";
                    hintNeu.style.color = "orange";
                    hintNeu.innerHTML = "kein Update nötig";
                    updateMoeglich = false;
                } 
                // else
                // {
                //     hintNeu.style.color = "green";
                //     hintNeu.innerHTML = "Passt";
                //     updateMoeglich = true;
                // }
            }
            else{
                hintNeu.style.color = "red";
                hintNeu.innerHTML = "Max. läng erreicht";
            }
        break;
        case "Geburtstag":
            updateMoeglich = true;
            break;

        case 'Handynummer':
            if(!isNaN(neuerWert.value))
            {
                if(neuerWert.value.length < 30)
                {
                    if(neuerWert.value == "")
                    {
                        hintNeu.style.color = "red";
                        hintNeu.innerHTML = "Eingabe nötig";
                        updateMoeglich = false;
                    }
                    else if(neuerWert.value == alterWert.value)
                    {
                        hintNeu.style.color = "orange";
                        hintNeu.innerHTML = "kein Update nötig";
                        updateMoeglich = false;
                    } 
                    else
                    {
                        hintNeu.style.color = "green";
                        hintNeu.innerHTML = "Passt";
                        updateMoeglich = true;
                    }
                }
                else{
                    hintNeu.style.color = "red";
                    hintNeu.innerHTML = "nur Zahlen";
                    updateMoeglich = false;

                }
            }
            else{
                hintNeu.style.color = "red";
                hintNeu.innerHTML = "Nur Zahlen";
                updateMoeglich = false;
            }

        break;    
    
        default:
            break;
    }
}

//Schickt die neuen Daten in die Datenbank
// Aktuallisiert bei erfolg das Feld mit dem neuen Wert
//Farbiges Feedback an den Nutzer fehlt noch
function datenUpdaten(bereich){
    const Nutzer = document.getElementById("NutzerID").innerHTML;
    const feldName = document.getElementById("FeldName-"+bereich).value;
    // const alterWert = document.getElementById("WertAlt-"+bereich).value;
    var neuerWert = document.getElementById("WertNeu-"+bereich).value;
    const hintWDH = document.getElementById("hintWertWDH-"+bereich);
    const hintNeu = document.getElementById("hintWertNeu-"+bereich);

    // Ein XMLHTTP-Request-Objekt erzeugen.
    var update = new XMLHttpRequest();
    if(feldName == "Geburtstag"){
        updateMoeglich = true;
    }
    if(updateMoeglich){
        update.open("GET", "includes/update_nutzerInfo.inc.php?aufgabe=updateInfo&benuter="+Nutzer+"&feld="+feldName+"&wert="+neuerWert, true);
        update.send();
        updateMoeglich = false;
    }
    else{
         vergleichen(bereich);
        
    }
    // Auf eine Antwort warten
    update.onreadystatechange = function() {
        if (update.readyState == 4 && update.status == 200) {
            // console.log("Update versuch ergab: "+ update.responseText);
            var ergebnis = update.responseText;
            if(ergebnis==1)
            {
                if(feldName=="Geburtstag")
                {            
                    var date =  neuerWert.split("-");            
                    neuerWert =  date[2] + '.' + date[1] + '.'+ date[0]; 
                    //Muss noch berechnet werden
                    var alterUpdate = document.getElementById("ProfilAlter");
                    // alterUpdate.innerHTML = "KP wie das mit JS geht lad die Seite neu :)";
                    location.reload();
                }
                //Verhindert, dass das Passwort im Klartext angezeigt wird.
                else if(feldName =="Emailadresse"){
                    // console.log(bereich+feldName);
                    document.getElementById(bereich+feldName+"Privat").innerHTML = neuerWert;
                }
                else if(feldName != "Passwort"){
                    // console.log("Das Feld soll geändert werden: "+ document.getElementById(bereich+feldName));
                    document.getElementById(bereich+feldName).innerHTML = neuerWert;
                    //Beim Nick muss die Seit neu geladen werden
                    if(feldName == "Nick"){
                        location.reload();
                    }
                }    
                //  console.log("Das Feld "+feldName+"im Bereich"+bereich+"wurder erfolgreich auf den wert: "+ neuerWert+"aktualiseirt");
                //Hier muss noch das Feld zu geklappt werden und die Werte gelöscht werden
                const schalter = document.getElementById("infoSchalter-"+bereich);
                schalter.style.display = "none";
            }
            else{
                var meldung = fehlerMeldungen[ergebnis];

                console.log("Update fehlgeschlagen"+ meldung+"fehler="+ergebnis);
            }
        }
    }
}


var darfLöschen = false;

function löschenPopUpShow(){
    var box = document.getElementById("löschenPopUp");
    var input = document.getElementById("löschenInput");
    var button = document.getElementById("löschen-fkbutton");
    button.disabled = true;
    box.style.display = "flex"; 
    input.focus();
   
    
    input.addEventListener("keyup",function(){
       
        if(input.value == "löschen"){
            button.style.opacity = "100%";
            darfLöschen = true;
            button.style.cursor = "pointer"
            button.disabled = false;
        }
        else{
            button.style.opacity = "30%";
            darfLöschen = false;
            button.style.cursor = "not-allowed"
            button.disabled = true;
        }
    })
}
function löschenPopUpHide(){
    var box = document.getElementById("löschenPopUp");
    var input = document.getElementById("löschenInput");
    var button = document.getElementById("löschen-fkbutton");
    box.style.display = "none"; 
    input.value ="";   
    darfLöschen = false;
    button.style.cursor = "not-allowed"
    button.style.opacity = "30%";
}

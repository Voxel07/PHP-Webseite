function ProfilInfoToggel(wert){
    const schalter = document.getElementById("infoSchalter-Profil");
    const Nutzer = document.getElementById("NutzerID").innerHTML;

    const feldName = document.getElementById("ProfilFeldName");
    const alterWert = document.getElementById("ProfilWertAlt");
  
    feldName.value=wert;
    alterWert
   
    schalter.style.display="flex";
    datenHolen(Nutzer,wert);
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

function datenHolen(benutzer,feld){

    console.log("Es soll das Feld " +feld+" für den Nutzer "+benutzer+" geänder werden");

    // Ein XMLHTTP-Request-Objekt erzeugen.
    var xhr = new XMLHttpRequest();
    // XMLHTTP-Request zur Datei: antwort.php öffnen und den Suchbegriff anhängen.
    xhr.open("GET", "includes/update_nutzerInfo.inc.php?aufgabe=getInfo&benuter="+benutzer+"&feld="+feld, true);
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
            const alterWert = document.getElementById("ProfilWertAlt");
            const neuerWert = document.getElementById("ProfilWertNeu");
            const alterWertBox = alterWert.parentElement;

            switch(feld){
                case "Passwort": console.log("PW");
                var pfusch = xhr.responseText;
                    neuerWert.type = "password";
                    neuerWert.placeholder = "neues "+feld;
                    alterWert.readOnly = false;
                    alterWert.type = "password";
                    alterWert.value = "";
                    alterWert.placeholder = "altes Passwort";
                    alterWert.focus();
                    alterWert.addEventListener('keyup',function(){
                        console.log("Wert aus alterWert: "+alterWert.value);
                        var anfrage = new XMLHttpRequest();
                        anfrage.open("GET", "includes/update_nutzerInfo.inc.php?aufgabe=pwPruefen&benuter="+benutzer+"&passwort="+alterWert.value, true);
                        anfrage.send();
                        anfrage.onreadystatechange = function abfrage() {
                    
                            // Überprüfen ob der Server eine Antwort geliefert hat.
                           
                            if (anfrage.readyState == 4 && anfrage.status == 200) {
                                console.log("server hat geantwortet: "+ anfrage.responseText);

                                const pwRichtig = anfrage.responseText;
                                console.log(pwRichtig);
                                if(pwRichtig==0){
                                    alterWertBox.style.borderBottom = "1px solid red";
                                }
                                else if (pwRichtig==1){
                                    alterWertBox.style.borderBottom = "1px solid green";

                                }
                            }
                        }   
                    })
                    neuerWert.addEventListener('keyup',function(){
                        if(alterWert.value == neuerWert.value){
                            neuerWert.parentElement.style.borderBottom = '1px solid green';
                        }
                        else{
                            neuerWert.parentElement.style.borderBottom = '1px solid red';
                        }
                    })

                   
                    
                break;
                case"Geburtstag": console.log("GB");        
                    var date = new Date(xhr.responseText *1000);
                    alterWert.value = date.toLocaleDateString();
                    neuerWert.type = "date";
                    alterWert.readOnly = true;
                    alterWertBox.style.borderBottom ="1px solid #b3b3b3";
                    neuerWert.parentElement.style.borderBottom = '1px solid #b3b3b3';
                break;
                default:
                    neuerWert.type = "text";
                    neuerWert.placeholder = "neuer "+feld;
                    neuerWert.value = "";
                    neuerWert.focus();
                    alterWert.value = xhr.responseText;
                    alterWert.readOnly = true;
                    alterWertBox.style.borderBottom ="1px solid #b3b3b3";
                    neuerWert.parentElement.style.borderBottom = '1px solid #b3b3b3';

                    break;
            }
        }   
    }
}
function datenLoeschen(){

}

function datenUpdaten(){

    const Nutzer = document.getElementById("NutzerID").innerHTML;
    const feldName = document.getElementById("ProfilFeldName").value;
    const alterWert = document.getElementById("ProfilWertAlt").value;
    const neuerWert = document.getElementById("ProfilWertNeu").value;

    console.log("Es soll das Feld: " +feldName+" für den Nutzer "+Nutzer+" geänder von "+alterWert+" auf neuer Wert: "+neuerWert);

    // // Ein XMLHTTP-Request-Objekt erzeugen.
    // var xhr = new XMLHttpRequest();
    // // XMLHTTP-Request zur Datei: antwort.php öffnen und den Suchbegriff anhängen.
    // xhr.open("GET", "includes/update_nutzerInfo.inc.php?aufgabe=updateInfo&benuter="+benutzer+"&feld="+feld+"&wert="+wert, true);
    // // xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded" );
    // // XMLHTTP-Request senden.
    // xhr.send();
    // // Auf eine Antwort warten
    // xhr.onreadystatechange = function() {

    //     // Überprüfen ob der Server eine Antwort geliefert hat.
       
    //     if (xhr.readyState == 4 && xhr.status == 200) {
        
    //     }
    // }
}
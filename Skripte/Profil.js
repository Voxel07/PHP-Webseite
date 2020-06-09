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

            switch(feld){
                case "Nachname": console.log("PW");
                break;
            }

            const alterWert = document.getElementById("ProfilWertAlt");
            alterWert.value = xhr.responseText;
           
        }
    }
    
}

function datenLoeschen(){}
function datenUpdaten(){}






// var zahl = 7; // variablendeklaration. Typ egal. JS macht das selber.
// var string = " waafasfbadaba";
// zahl +=2;
// document.getElementById("head1").innerHTML = "Geändert mit JS"; //ändert den angezeigten Text des mit id ausgewählten Elements
// document.write("Ausgabe mit JS"); //Einfache ausgabe. Wird dort ausgegeben wo es steht. Z.B. in einem Div
// window.alert("Alarm!!"); //Warnausgabe ( Pop up )
// window.alert(zahl +  string);


/* Strings
//document.write( string.length) ; // Länge des strings herausfinden
//var string2 = "Text\"2\""; // mit \ werden alle sachen ausgegeben
//document.write(string2);
var string3 = "Wubabibbla";
document.write(string3.search("bib")); //sucht im text das suchwort. Z.b.: Passwort darf nicht den Beutzernahmen enthalten
window.alert(string3.split("")); // Teilt den string auf und erstellt ein array
window.alert(string3.split("b")); //Teil den String am gewählten Buchstaben. Der Buchstabe fehlt im array.
*/    
/* Bool
var1 =42;
var2= "hallo";
var bool = Boolean (42 == 42); // normaler vergleicht
// Normale Operationen möglich
bool = Boolean(var1===var2); //Vergleicht auch noch den Datentyp
var x = (42 == 7) ? 15:35; //prüft die abfrage. Wenn richtig vor : wenn falsch dann nach:
window.alert(x);
*/
// IF| case wie bei c++  
// Datum new Date().getDay(); // Gibt den Tag aus 0 = sonntag
/*arrays wie vectoren in c++

window.alert(users[0]); //an stelle 0
window.alert(users.length);    //länge
users.push("Test"); // am ende hinzufügen
users[5] = "hugo"; // an stelle 5 hinzufügen
users.pop(); // Gibt das letzt element zurück und löscht es danach 
window.alert(users); // gibt das gesammte array aus;
var users = ["Camo","Voxel","Matze"];
users.join("; ");//Trennzeichen einfügen beeinflusst nicht die länge
users.unshift("neu"); // Fügt ein neues element am anfgang ein
users.shift();//löscht das erste element und gibt es zurück
users.sort();//Sortiert isnt alphabet oder aufsteigende größe
window.alert( users);
*/
// for wie c++ | for each in c++ = for in  in java
// while | do while gleich
// schleifen können mit break komplett angebrochen werden mit continue wird der aktuelle durchgang übersprungen
/* funktionen

*/ 

function name()
{ 
// window.alert("tut");
// document.getElementById("test").innerHTML="ajklsdbfiöuawbfuöwaebfuiwebgf";  
//document.body.style.background="blue";
// var x = document.getElementById("test");
// x.innerHTML = "bla";
// var x = document.getElementsByTagName("p"); // gibt ein array zurück
// x[1].innerHTML="neuer text"
document.getElementById("test").style.color="red";
//Element bewegen durch erhöhung des Margin
var x = document.getElementById("test");
var add = 0;
var weg = setInterval(function  (){
    if (add>=500)
    {
        clearInterval(weg);
    }
    else{
        x.style.marginLeft = add + `px`;
        add++;
    }
    },1);
}
//Eventlistener hinzufügen
//Z.B. eine funtkion wird erst freigeschaltet, wenn davor etwas anderes bestätigt wurde.
function thistest(elm){
    elm.innerHTML ="blablabla";
    document.getElementById("evl").addEventListener("mouseover",name);
}

//Dynamisch neue elemente erzeuigen. Allerdings bissher nur auf der User seite. Diese werden noch nicht gespeichert.
function elmHinzufügen(){
    var x = document.getElementById("dyn"); //Parrent finden
    var para = document.createElement("p"); //Element erstellen
    var eingabe = window.prompt("Hier eingeben was im Paragraph stehen soll"); //Benutzereingabe über promt
    para.innerHTML = eingabe; //Element befüllen
    x.appendChild(para); //Kind, hier neuer para, an parent anhängen. 
}


//Klassen in JS
function myClass(){

    function User (name,nick,alter){
        
        //Variablen
        this.name =name;
        this.nick=nick;
        this.alter=alter;  
        this.geb = new Date("27 Jun 2019");
        //Methoden
        this.altern = function(jahre){
            this.alter+=jahre;
            return 1;
        };
    }

    var usr1 = new User("Matthias","Camo",24);

    // if(usr1.geb.getDay() == Date.getDay() && usr1.geb.getMonth()==Date.getMonth())
    // {
    //     window.alert("Happay");
    // }
 
    //Abfrage ob ein Mitglied Geburtstag hat 
    if(usr1.geb.getDate()==new Date().getDate()){
        window.alert("Happy Gebur");
        usr1.altern(1);
    }else{

        window.alert("geht noch");
    }

    
}
window.alert(usr1.alter);

usr1.altern(5);
window.alert(usr1.alter);

User.prototype.neueMethode =function (){ //Eine möglichkeit Methoden auserhalb der Klasse zu deklarieren.
    this.alter -=15;
};
usr1.neueMethode();
window.alert(usr1.alter);

//Try / Catch 
try{
    test();
}
catch(a){
    window.alert(a);
    
}
function  test(){
      throw "noch nicht eingebaut";
  }





const editorButtons = document.getElementsByClassName('editor-button');
const editorCanvas = document.getElementById('canvas');
const option = document.getElementsByClassName("option");
var farbe  = "";
var groeße = 3;

const setAttribute = (element) => {

    switch (element.dataset.attribute){
        case "createlink":const url = prompt("Enter the link here: ", "http:\/\/");
                if (url===null) { console.log("Link leer"); break; }
                else{document.execCommand( element.dataset.attribute, false,url);}
            break;
        case "insertImage": console.log("Bild einfügen");
            break;
        case "enableObjectResizing": console.log("enableObjectResizing");
            break;
        case "black": console.log("black");
            break;
        case "fontSize": 
            switch (element.dataset.dataset){
                case "2":groeße=2;document.execCommand( element.dataset.attribute, false,groeße);break;
                case "3":groeße=3;document.execCommand( element.dataset.attribute, false,groeße);break;
                case "4":groeße=4;document.execCommand( element.dataset.attribute, false,groeße);break;
                case "5":groeße=5;document.execCommand( element.dataset.attribute, false,groeße);break;
                case "6":groeße=6;document.execCommand( element.dataset.attribute, false,groeße);break;
                case "7":groeße=7;document.execCommand( element.dataset.attribute, false,groeße);break;
                default: console.log("default font");break;
        }
            break;
        case "foreColor":  
            switch (element.dataset.dataset){
                case "red":farbe="#ff0000";document.execCommand( element.dataset.attribute, false,farbe);break;
                case "green":farbe="#04ff00";document.execCommand( element.dataset.attribute, false,farbe);break;
                case "blue":farbe="#006eff";document.execCommand( element.dataset.attribute, false,farbe);break;
                case "black":farbe="#000000";document.execCommand( element.dataset.attribute, false,farbe);break;
                case "white":farbe="#ffffff";document.execCommand( element.dataset.attribute, false,farbe);break;
                case "orange":farbe="#ffad08";document.execCommand( element.dataset.attribute, false,farbe);break;
                default: console.log("default color");break;
            }
        
         break;
        default:
            document.execCommand( element.dataset.attribute, true,);
            console.log(element.dataset.attribute);
            break;
    }
}

for(let i = 0; i<editorButtons.length;i++) {
    editorButtons[i].addEventListener('click',function()
    {     
		setAttribute(this);	
    }
    , true);
}


for(let i = 0; i<option.length;i++) {
    option[i].addEventListener('click',function()
    {    
		setAttribute(this);
    }
    , true);
}

function option_toggle(gewOption){
  
    var target = document.getElementById(gewOption);
   
    if(target.className == "versteckt"){  
        target.className = "zeigen";
        target.style.display = "inline-block";
    }
    else if(target.className == "zeigen"){
        target.className = "versteckt";
        target.style.display = "none";
    }

}

//Bilder Upload

function dateiauswahl(bla) {
    var dateien = bla.target.files; // FileList object

    // Auslesen der gespeicherten Dateien durch Schleife
    for (var i = 0, f; f = dateien[i]; i++) {
       
      // nur Bild-Dateien
      if (!f.type.match('image.*')) {
       
        continue;
      }

      var reader = new FileReader();

      reader.onload = (function(theFile) {
        return function(e) {
          // erzeuge Thumbnails.
        //   var vorschau = document.createElement('img');
          let image = new Image();
          //  console.log(e);
        image.onload = function () {
            console.log ("Height:" + this.naturalHeight);
            console.log ("Width:" + this.naturalWidth);
            // Mach was mit dem Bild
            var höhe = this.naturalHeight;
            var breite =this.naturalWidth;
            var asbRatio = höhe/breite;
            console.log (asbRatio);

            var neuBreite = 200;
            var neuHöhe = neuBreite*asbRatio;
            console.log ("Breite:" + neuBreite, "Höhe:" +neuHöhe);
            image.height = neuHöhe;
            image.width = neuBreite;
            image.className="test";
            image.innerText =image.naturalHeight //Text zwischen den Tags
            image.setAttribute("onmouseover","bildoptionen(this)");
            image.setAttribute("onclick","test(this)");

       };
       image.src = e.target.result;
         
          
      
          document.getElementById('list').insertBefore(image, null);
        };
      })(f);

      // Bilder als Data URL auslesen.
      reader.readAsDataURL(f);
    }
  }

  // Auf neue Auswahl reagieren und gegebenenfalls Funktion dateiauswahl neu ausführen.
//   document.getElementById('dateien').addEventListener('change', dateiauswahl, false);

//   function test(elm){
//     var größe = prompt("Neue Breite Eingeben: ");
//     if(größe<50){
//       console.log("zu klein");
//       console.log(größe);
//     }
    
//     else{
//     console.log ("Height:" + elm.naturalHeight);
//     console.log ("Width:" + elm.naturalWidth);
//     // Mach was mit dem Bild
//     var höhe = elm.naturalHeight;
//     var breite =elm.naturalWidth;
//     var asbRatio = höhe/breite;
//     console.log (asbRatio);

//     var neuBreite = größe;
//     var neuHöhe = neuBreite*asbRatio;
   
//     elm.height = neuHöhe;
//     elm.width = neuBreite;
//     console.log("göße:" + größe);
//     console.log("geht");
//   }
// }

function bildoptionen(bild){

  //Neues Element einfügen hier falscher ansatz

  //  var newItem = document.createElement("div");
  //  var textnode = document.createTextNode("Optionen");
  //  newItem.appendChild(textnode);
  // var list = document.getElementById("list");
   
  //Optionen anzeigen



 
  console.log(bild.height);

}

function textSpeichern() {
		
  var xhr = new XMLHttpRequest();

  var daten = new FormData(document.getElementById("PostuploadForm"));
  // var daten = new FormData();
  xhr.open("POST", "includes/Forum_Posts.inc.php?herkunft=Forum_Themen.php" );
  xhr.setRequestHeader("enctype", "multipart/form-data", "charset=utf-8 ");

  daten.append("inhalt",document.getElementById("list").innerHTML);
  // daten.append("post",document.getElementById("inputPost").value);
  // daten.append("thema",document.getElementById("inputKategorie").value);
  // daten.append("kategorie",document.getElementById("inputThema").value);
  daten.append("Forum-Post","1");
  xhr.send(daten);

  xhr.onreadystatechange = function() {
  console.log("XHR State:"+xhr.readyState+"XHR Satus:"+xhr.status);
  if (xhr.readyState == 4 && xhr.status == 200) {
       
    console.log(xhr.responseText);
    // console.log("fertig");
     location.reload();
  }
}
}
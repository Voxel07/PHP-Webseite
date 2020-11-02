

var lastSize = 0;
var lastTime = Date.now();
var currentTime = Date.now();



uploadForm.addEventListener("submit",uploadFile);

function uploadFile (e){

  const uploadForm = document.getElementById("uploadForm");
  const inpFile = document.getElementById("inpFile");
  const progressBarFill = document.querySelector(".progress-bar-fill");
  const progressBarText = progressBarFill.querySelector(".progress-bar-text");
  const progressBarfortschritt = document.querySelector(".progress-bar-fortschritt");
  const progressBargeschw = document.querySelector(".progress-bar-geschw");


    e.preventDefault();
    const xhr = new XMLHttpRequest();
    xhr.open("post","../mySite/includes/Upload_Galerie.inc.php");

    xhr.upload.addEventListener("progress",e => {
        const percent = e.lengthComputable ? (e.loaded / e.total) * 100 : 0;
        //Anzeig für xxmb von xxmb
        progressBarfortschritt.textContent = ((e.loaded)/1000000).toFixed(2) +" mB"+ " / "+((e.total)/1000000).toFixed(2) +" mB";
        //Upload geschw 
        currentTime = Date.now()
         var dtime= currentTime-lastTime;
         var dsize = e.loaded-lastSize;
        // console.log("Hochgeladen in diesem Tick: "+ dtime);
        // console.log("Vergange Zeit: "+ dsize);

        lastSize = e.loaded;
        lastTime = currentTime;
      
        var uploadGeschw = dsize/dtime;
        if(uploadGeschw<1024){
            progressBargeschw.textContent = uploadGeschw.toFixed(2)+" kb/s";
        }
        else{
            progressBargeschw.textContent = (uploadGeschw/1000).toFixed(2)+" mb/s";
        }
        //Fortschrittsbalken
        progressBarFill.style.width = percent.toFixed(2) + "%";
        progressBarText.textContent = percent.toFixed(2) + "%";
        //  console.log(e);
    });



    xhr.setRequestHeader("enctype", "multipart/form-data")
    const daten = new FormData( document.getElementById("uploadForm"));
    // const daten = new FormData();
    // daten.append("file", document.querySelector("#inpFile").value);
    daten.append("upload-Galerie-einzel" , "1")
    xhr.send(daten);

    xhr.onreadystatechange = function() {
        // console.log("test"+e);
      // console.log("xhr Stat: "+xhr.readyState);
      // console.log("xhr Status: "+xhr.status);
      
      if (xhr.readyState == 4 && xhr.status == 200) {
       
        // console.log(e);
        location.reload();
      }
    }
}
function big(name){
    var w = window.innerWidth;
    var h = window.innerHeight;
    // console.log("Fenstergröße Width: " + w + " Height: " + h);
    const vollBildBox = document.getElementById("vollBild-Box");
    const vollBild = document.getElementById("vollBild");
   
    // vollBild. addEventListener("click",small);
    var containerBreite = ( w*0.80);
    //Bildabmaße für Seitenverhältnis
    var height = 0;
    var width = 0;
    var aspectRatio = 0;
    var bild = new Image();
    bild.onloadstart= function(){
        console.log("test");
    }
    bild.src ='../Uploads/Bilder_Galerie/Vollbild_Bilder/'+name;

    //Vorschau solange das Bild läd
    vollBild.style.width= 300+"px";
    vollBild.style.height= 300+"px";
    vollBildBox.style.display="flex";
    vollBild.style.backgroundColor="gray";
    vollBild.style.backgroundImage ="url('../Bilder/SVG/spinner.svg')";

    var testsd = document.getElementById("ladetext");
    testsd.innerHTML="Fortschrittsbalken kommt sobad ich weiß wie das geht O.o";
    

    bild.onload = function(){
        height = bild.naturalHeight;
        width = bild.naturalWidth;
        aspectRatio = width/height;
        testsd.innerHTML="";

        vollBild.style.width = containerBreite+"px";
        var Containerhöhe = containerBreite/aspectRatio;
        vollBild.style.height = Containerhöhe+"px";
        if(Containerhöhe>(h-50)){
            Containerhöhe = h-50;
            // console.log("beschränkt ! auf:"+Containerhöhe);
            vollBild.style.height = Containerhöhe+"px";
            containerBreite = h*aspectRatio;
            vollBild.style.width = containerBreite+"px";
           
        }
        vollBildBox.style.display="flex";
        // console.log("Bilder Daten: Höhe: "+height+" Breite: "+height+" AR: "+aspectRatio);
        // console.log("Box breite: "+containerBreite+" Containerhöhe: "+ Containerhöhe);
        // console.log(vollBild.scrollWidth);
        vollBild.style.backgroundImage ="url('../Uploads/Bilder_Galerie/Vollbild_Bilder/"+name+"')";
    }
}
function small(){
const vollBildBox = document.getElementById("vollBild-Box");
const vollBild = document.getElementById("vollBild");

    vollBildBox.style.display="none";
    vollBild.style.backgroundImage = "none";
}
function next(){
    // console.log("next");   
   
  
}
function previos(){
    // console.log("previos");
}
function showDetails(){
    const vollBild = document.getElementById("vollBild");
    const slider =  document.getElementById("infoSideBar");

    slider.style.height = vollBild.style.height;
    slider.style.display="flex";
}
function hideDetails(){
    const slider =  document.getElementById("infoSideBar");
    slider.style.display="none";
}

function uploadMenue(){
    const menue = document.querySelector(".galerie-upload-upload");
    const menue2 = document.querySelector(".galerie-album-upload");
    menue2.style.display="none";
    // console.log( menue.style.display);
    if(  menue.style.display== "none"|| menue.style.display==""){
        menue.style.display="block";
    }
    else{
        menue.style.display="none";
    }

}
function albumMenue(){
    const menue = document.querySelector(".galerie-album-upload");
    const menue2 = document.querySelector(".galerie-upload-upload");
    menue2.style.display="none";
    // console.log( menue.style.display);
    if(  menue.style.display== "none"|| menue.style.display==""){
        menue.style.display="block";
    }
    else{
        menue.style.display="none";
    }

}
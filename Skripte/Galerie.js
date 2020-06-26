const uploadForm = document.getElementById("uploadForm");
const inpFile = document.getElementById("inpFile");
const progressBarFill = document.querySelector(".progress-bar-fill");
const progressBarText = progressBarFill.querySelector(".progress-bar-text");
const progressBarfortschritt = document.querySelector(".progress-bar-fortschritt");
const progressBargeschw = document.querySelector(".progress-bar-geschw");

var lastSize = 0;
var lastTime = Date.now();
var currentTime = Date.now();



uploadForm.addEventListener("submit",uploadFile);

function uploadFile (e){
    e.preventDefault();
    const xhr = new XMLHttpRequest();
    xhr.open("post","../mySite/includes/Upload_Galerie.inc.php");
    xhr.upload.addEventListener("progress",e => {
      const percent = e.lengthComputable ? (e.loaded / e.total) * 100 : 0;
     
      //Anzeig für xxmb von xxmb
      progressBarfortschritt.textContent = ((e.total)/1000000).toFixed(2) + "/"+((e.loaded)/1000000).toFixed(2) +" mB";
      //Upload geschw 
      currentTime = Date.now()
      var dtime= currentTime-lastTime;
      var dsize = e.loaded-lastSize;
      console.log("Hochgeladen in diesem Tick: "+ dtime);
      console.log("Vergange Zeit: "+ dsize);
      
      
      lastSize = e.loaded;
      lastTime = currentTime;
      progressBargeschw.textContent = +(dsize/dtime).toFixed(2)+" kb/s";
      //Fortschrittsbalken
      progressBarFill.style.width = percent.toFixed(2) + "%";
      progressBarText.textContent = percent.toFixed(2) + "%";
        console.log(e);
    });
    xhr.setRequestHeader("enctype", "multipart/form-data")
    xhr.send(new FormData(uploadForm));

    xhr.onreadystatechange = function() {
      // console.log("xhr Stat: "+xhr.readyState);
      // console.log("xhr Status: "+xhr.status);
     
      if (xhr.readyState == 4 && xhr.status == 200) {
          var ergebnis = xhr.responseText;
          console.log(ergebnis);
      }
    }
}


function vergrößern(gewählt){
  const element = document.getElementById("vollbild");
  const link = gewählt.querySelector("img").src;
 
  // console.log("geklickt:"+gewählt);
  // console.log("hier hin"+element);
  element.style.display = "block";
  // console.log(element);
  element.querySelector("img").src = link;
}
function verkleinern(){
  document.getElementById("vollbild").style.display = "none";
}
function mehr(gewählt){
  const e = gewählt.querySelector(".Titel");
  e.style.display ="block";
  const a = gewählt.querySelector(".Löschen");
  a.style.display ="block";
}
function weniger(gewählt){
  const e = gewählt.querySelector(".Titel");
  e.style.display ="none";
  const a = gewählt.querySelector(".Löschen");
  a.style.display ="none";
}
function löschen(){
  console.log("gelöscht");
}

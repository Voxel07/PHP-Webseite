const uploadForm = document.getElementById("uploadForm");
const inpFile = document.getElementById("inpFile");
const progressBarFill = document.querySelector(".progress-bar-fill");

const progressBarText = progressBarFill.querySelector(".progress-bar-text");

uploadForm.addEventListener("submit",uploadFile);

function uploadFile (e){
    e.preventDefault();
    const xhr = new XMLHttpRequest();
    xhr.open("post","../mySite/includes/Upload_Gallerie.inc.php");
    xhr.upload.addEventListener("progress",e => {
      const percent = e.lengthComputable ? (e.loaded / e.total) * 100 : 0;

      progressBarFill.style.width = percent.toFixed(2) + "%";
      progressBarText.textContent = percent.toFixed(2) + "%";
        console.log(e);
    });
    xhr.setRequestHeader("enctype", "multipart/form-data")
    xhr.send(new FormData(uploadForm));
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

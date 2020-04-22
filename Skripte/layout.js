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
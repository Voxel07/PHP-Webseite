
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
    
    bild.src ='../Uploads/Bilder_Galerie/Vollbild_Bilder/'+name;

    console.log(bild.attributes);
    bild.onload= function(){
        height = bild.naturalHeight;
        width = bild.naturalWidth;
        aspectRatio = width/height;

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
    console.log("next");   
   
  
}
function previos(){
    console.log("previos");
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
function addKategorie() {
    var elm = document.getElementById("addKat");
    if(window.getComputedStyle(elm).display == "none"){
        elm.style.display = "block";
        }
        else{
             elm.style.display = "none";
        }
}
function addThema(zahl){
    var elm = document.getElementById("addThema-"+zahl);
    if(window.getComputedStyle(elm).display == "none"){
    elm.style.display = "block";
    }
    else{
         elm.style.display = "none";
    }
}
function addPost(){
    var elm = document.getElementById("postSchreiben");
    if(window.getComputedStyle(elm).display == "none"){
        elm.style.display = "block";
        }
        else{
             elm.style.display = "none";
        }

}
function ungelesenePostsUpdaten(id) {	
    var xr = new XMLHttpRequest();
    var url = "Forum_test.php";
   
    var vars = "update=" +id;

    xr.open("POST", url ,true)
    xr.setRequestHeader("Content-type", "application/x-www-form-urlencoded" );
    xr.send(vars);
    
}
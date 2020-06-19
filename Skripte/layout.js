var darfLöschen = false;

function löschenPopUpShow(){
    var box = document.getElementById("löschenPopUp");
    var input = document.getElementById("löschenInput");
    var button = document.getElementById("löschn-fkbutton");
    button.disabled = true;
    box.style.display = "flex"; 
    
    input.addEventListener("keyup",function(){
       
        if(input.value == "löschen"){
            button.style.opacity = "100%";
            darfLöschen = true;
            button.style.cursor = "pointer"
            button.disabled = false;
        }
        else{
            button.style.opacity = "30%";
            darfLöschen = false;
            button.style.cursor = "not-allowed"
            button.disabled = true;
        }
    })
}
function löschenPopUpHide(){
    var box = document.getElementById("löschenPopUp");
var input = document.getElementById("löschenInput");
var button = document.getElementById("löschn-fkbutton");
    box.style.display = "none"; 
    input.value ="";   
    darfLöschen = false;
    button.style.cursor = "not-allowed"
    button.style.opacity = "30%";
}
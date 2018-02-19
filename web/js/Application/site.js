// *************
//* Popup Stuff *
// *************
function popup(message) {
    showPopup(message);
    setTimeout(function(){
        var popup = document.getElementById("myPopup");
        popup.classList.toggle("hide");
    }, 3000);
}

function showPopup(message){
    var popup = document.getElementById("myPopup");
    document.getElementById("popup_message").innerHTML = message;
    popup.classList.toggle("show");
}
// Get the modal
var modal = document.getElementById('myModal');


// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

var img_header = document.getElementsByClassName("img_header")[0];
// When the user clicks the button, open the modal 
modal.style.display = "block";

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
    window.location.href;
}
 function myImg() {
    modal.style.display = "none";
    window.location.href;
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
        window.location.href;
    }
}
if($('#myModal').css('display') !== 'none')
{
    document.getElementById('#hidden_el').value = 1;
}


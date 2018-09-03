/* $('#confirmationModal').on('shown.bs.modal', function () {
             $('#confirmationModal').trigger('focus')
         })*/
// Get the modal
let modal = document.getElementById('confirmationModal');

// Get the button that opens the modal
let btn = document.getElementById("btnModalRemove");

// Get the <span> element that closes the modal
let span = document.getElementsByClassName("close")[0];

// Get the <span> element that closes the modal
let returnBtn = document.getElementById("returnBtn");

// When the user clicks the button, open the modal
btn.onclick = function () {
    modal.style.display = "block";
};

returnBtn.onclick = function () {
    modal.style.display = "none";
};

// When the user clicks on <span> (x), close the modal
span.onclick = function () {
    modal.style.display = "none";
};

// When the user clicks anywhere outside of the modal, close it
window.onclick = function (event) {
    if (event.target === modal) {
        modal.style.display = "none";
    }
};
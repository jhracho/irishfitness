window.onload = function() {

    
    var passModal = document.getElementById("password-modal");
    var passBtn = document.getElementById("password-button");
    var passSpan = document.getElementsByClassName("close")[1];

    var editModal = document.getElementById("edit-modal");
    var editBtn = document.getElementById("edit-button");
    var editSpan = document.getElementsByClassName("close")[0];

    // open modal
    passBtn.onclick = function() {
        passModal.style.display = "block";
    }

    editBtn.onclick = function() {
        editModal.style.display = "block";
    }

    passSpan.onclick = function() {
        passModal.style.display = "none";
    }

    editSpan.onclick = function() {
        editModal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == editModal) {
            editModal.style.display = "none";
        }
        if (event.target == passModal) {
            passModal.style.display = "none";
        } 
    } 
    


}


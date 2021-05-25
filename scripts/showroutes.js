window.onload = function(){
	var viewModal  = document.getElementById("");
	var viewButton = document.getElementByID("get-running-routes");
	var viewClose  = document.getElementByClassName("view-close")[0];

	// Open Modal
	viewButton.onclick = function(){
		viewModal.style.display = "block";
	}

	// Close Modal
	viewClose.onclick = function(){
		viewModal.style.display = "none";
	}
	window.onclick = function(event){
		if (event.target == viewModal){
			viewModal.style.display = "none";
		}
	}

}

var calModal = document.getElementById("calories-modal");
var calButton = document.getElementById("calories-modal-button");
var calLabel = document.getElementById("calories-modal-label");
var calClose = document.getElementById("calories-close");

if(calButton != null) {
	calButton.onclick = function() {
		calModal.style.display = "block";
	}
}

if(calLabel != null) {
	calLabel.onclick = function() {
		calModal.style.display = "block";
	}
}

if(calClose != null) {
	calClose.onclick = function() {
		calModal.style.display = "none";
	}
}

var proModal = document.getElementById("protein-modal");
var proButton = document.getElementById("protein-modal-button");
var proLabel = document.getElementById("protein-modal-label");
var proClose = document.getElementById("protein-close");

if(proButton != null) {
	proButton.onclick = function() {
		proModal.style.display = "block";
	}
}

if(proLabel != null) {
	proLabel.onclick = function() {
		proModal.style.display = "block";
	}
}

if(proClose != null) {
	proClose.onclick = function() {
		proModal.style.display = "none";
	}
}

var carModal = document.getElementById("carbs-modal");
var carButton = document.getElementById("carbs-modal-button");
var carLabel = document.getElementById("carbs-modal-label");
var carClose = document.getElementById("carbs-close");

if(carButton != null) {
	carButton.onclick = function() {
		carModal.style.display = "block";
	}
}

if(carLabel != null) {
	carLabel.onclick = function() {
		carModal.style.display = "block";
	}
}

if(carClose != null) {
	carClose.onclick = function() {
		carModal.style.display = "none";
	}
}

var fatModal = document.getElementById("fat-modal");
var fatButton = document.getElementById("fat-modal-button");
var fatLabel = document.getElementById("fat-modal-label");
var fatClose = document.getElementById("fat-close");

if(fatButton != null) {
	fatButton.onclick = function() {
		fatModal.style.display = "block";
	}
}

if(fatLabel != null) {
	fatLabel.onclick = function() {
		fatModal.style.display = "block";
	}
}

if(fatClose != null) {
	fatClose.onclick = function() {
		fatModal.style.display = "none";
	}
}

var burnedModal = document.getElementById("burned-modal");
var burnedButton = document.getElementById("burned-modal-button");
var burnedLabel = document.getElementById("burned-modal-label");
var burnedClose = document.getElementById("burned-close");

if(burnedButton != null) {
	burnedButton.onclick = function() {
		burnedModal.style.display = "block";
	}
}

if(burnedLabel != null) {
	burnedLabel.onclick = function() {
		burnedModal.style.display = "block";
	}
}

if(burnedClose != null) {
	burnedClose.onclick = function() {
		burnedModal.style.display = "none";
	}
}

var reviewModal = document.getElementById("review-modal");
var reviewButton = document.getElementById("daily-review-button");
var reviewClose = document.getElementById("review-close");

if(reviewButton != null) {
	reviewButton.onclick = function() {
		reviewModal.style.display = "block";
		initMacros();
		initActivity();
	}
}

if(reviewClose != null) {
	reviewClose.onclick = function() {
		reviewModal.style.display = "none";
	}
}

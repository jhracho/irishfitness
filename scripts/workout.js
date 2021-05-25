var showRoutesModal = document.getElementById('get-running-routes');
if(typeof(showRoutesModal) != 'undefined' && showRoutesModal != null) {
	showRoutesModal.onclick = function() {
		document.getElementById('view-routes-modal').style.display = 'block';
	}
}

var closeRoutesModal = document.getElementById('close-routes-modal');
if(typeof(closeRoutesModal) != 'undefined' && closeRoutesModal != null) {
	closeRoutesModal.onclick = function() {
		document.getElementById('view-routes-modal').style.display = 'none';
	}
}

var target = window.location.search;
if(target != "" && target.search('workout') == -1 && target.search('name') == -1 && target.search('routes') == -1) {
	if(target.search("location") == -1) {
		target = target.split("25")[1].split("%")[0];
		var element = document.getElementById(target);
		element.selected = 'selected';
	}
	else if(target.search("target") == -1) {
		var loc = target.split("=")[1].split("%")[0];
        var element = document.getElementById(loc);
		element.selected = 'selected';
	}
	else {
		var loc = target;
		target = target.split("=")[2].split("5")[1].split("%")[0];
		loc = loc.split("&")[0].split("=")[1].split("%")[0];
		var element = document.getElementById(target);
		element.selected = 'selected';
		element = document.getElementById(loc);
		element.selected = 'selected';
	}
}

function addExercise(evt) {
	var exercise = evt['target']['innerHTML'];
	var exercise_target = evt['path'][1]['lastElementChild']['innerHTML'];
	var target = document.getElementById("target-dropdown").value;
	var loc = document.getElementById("location-dropdown").value;
	if(target != "") {
		if(loc != "") {	
			var url = 'scripts/workoutEdit.php?method=A&exercise=' + exercise + "&exerciseTarget=" + exercise_target + "&target=" + target + "&location=" + loc;
		}
		else {
			var url = 'scripts/workoutEdit.php?method=A&exercise=' + exercise + "&exerciseTarget=" + exercise_target + "&target=" + target;
		}
	}
	else {
		if(loc != "") {
			var url = 'scripts/workoutEdit.php?method=A&exercise=' + exercise + "&exerciseTarget=" + exercise_target + "&location=" + loc;
		}
		else {
			var url = 'scripts/workoutEdit.php?method=A&exercise=' + exercise + "&exerciseTarget=" + exercise_target;
		}
	}

	url = encodeURI(url);
	window.location.href = url;
}

function removeExercise(evt) {
	var exercise = evt['target']['innerHTML'];
	var exercise_target = evt['path'][1]['lastElementChild']['innerHTML'];
	var target = document.getElementById('target-dropdown').value;
	var loc = document.getElementById('location-dropdown').value;
	if(target != "") {
		if(loc != "") {	
			var url = 'scripts/workoutEdit.php?method=R&exercise=' + exercise + "&exerciseTarget=" + exercise_target + "&target=" + target + "&location=" + loc;
		}
		else {
			var url = 'scripts/workoutEdit.php?method=R&exercise=' + exercise + "&exerciseTarget=" + exercise_target + "&target=" + target;
		}
	}
	else {
		if(loc != "") {
			var url = 'scripts/workoutEdit.php?method=R&exercise=' + exercise + "&exerciseTarget=" + exercise_target + "&location=" + loc;
		}
		else {
			var url = 'scripts/workoutEdit.php?method=R&exercise=' + exercise + "&exerciseTarget=" + exercise_target;
		}
	}

	url = encodeURI(url);
	window.location.href = url;
}

function updateAvailableByTarget(target) {
	var local = document.getElementById('location-dropdown').value;
	if (local == ""){
		var url = 'workout.php?target=' + "%" + target + "%";
	}
	else{
		var url = 'workout.php?location=' + local + '&target=%' + target + "%";
	}
	url = encodeURI(url);
	window.location.href = url;
}

function updateAvailableByLocation(local) {
	var target = document.getElementById('target-dropdown').value;
	if (target == ""){
		var url = 'workout.php?location=' + local;
	}
	else{
		var url = 'workout.php?location=' + local + '&target=%' + target + "%";
	}

	url = encodeURI(url);
	window.location.href = url;
}

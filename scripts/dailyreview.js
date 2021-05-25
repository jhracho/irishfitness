function initMacros() {
	var itemName = ["Total", "Protein", "Carbs", "Fats"];
	var tracked_cals = parseInt(document.getElementById("tracked_cals").innerHTML);
	var tracked_protein = parseInt(document.getElementById("tracked_protein").innerHTML * 4);
	var tracked_carbs = parseInt(document.getElementById("tracked_carbs").innerHTML * 4);
	var tracked_fat = parseInt(document.getElementById("tracked_fat").innerHTML * 9);
	var itemValue = [tracked_cals, tracked_protein, tracked_carbs, tracked_fat];

	var chart = new CanvasJS.Chart("macros-canvas", {
		animationEnabled: true,
		theme: "light11",
		title: {
			text: ""
		},
		axisY: {
			title: "Calories",
			includeZero: true
		},
		data: [{
			type: "column",
			legendMarkerColor: "grey",
			dataPoints: [
			{y: itemValue[0], label: itemName[0]},
			{y: itemValue[1], label: itemName[1]},
			{y: itemValue[2], label: itemName[2]},
			{y: itemValue[3], label: itemName[3]}
			]
		}]
	});
	chart.render();
}

function initActivity() {
	var itemName = ["Net", "Consumed", "Burned", "BMR"];
	var tracked_cals = parseInt(document.getElementById("tracked_cals").innerHTML);
	var tracked_burned = parseInt(document.getElementById("tracked_burned").innerHTML);
	var BMR = parseInt(document.getElementById("recommended_cals").innerHTML);

	var chart = new CanvasJS.Chart("activity-canvas", {
		animationEnabled: true,
		theme: "light1",
		title: {
			text: ""
		},
		axisY: {
			title: "Calories",
			includeZero: true
		},
		data: [{
			type: "column",
			legendMarkerColor: "grey",
			dataPoints: [
			{y: tracked_cals - BMR - tracked_burned, label: itemName[0]},
			{y: tracked_cals, label: itemName[1]},
			{y: tracked_burned, label: itemName[2]},
			{y: BMR, label: itemName[3]}
			]
		}]
	});
	chart.render();
}

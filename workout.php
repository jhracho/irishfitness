<?php
include('scripts/fetchExercises.php');
?>

<?php
$first_name = $_SESSION['first_name'];
$last_name = $_SESSION['last_name'];
$username = $_SESSION['username'];
$user_id = $_SESSION['user_id'];
if(empty($username)) {
	$_SESSION['msg'] = "You must log in to view this page!";
	header("location: login.php");
}

if(isset($_GET['target'])) {
	if(strcmp($target, 'All') == 0) {
		$target = "";
	}
	else {
		$target = $_GET['target'];
	}
}
else {
	$target = "";
}

if(isset($_SESSION['msg'])) {
	echo "{$_SESSION['msg']}";
	unset($_SESSION['msg']);
}

$workouts_query = mysqli_prepare($con, "SELECT workout.workout_name, workout.workout_id FROM workout WHERE workout.created_by_user = ?");
mysqli_stmt_bind_param($workouts_query, "i", $user_id);
mysqli_stmt_execute($workouts_query);
mysqli_stmt_bind_result($workouts_query, $workout_name, $workout_id);
mysqli_stmt_store_result($workouts_query);
$rows = mysqli_stmt_num_rows($workouts_query);
$workouts = array();
$workout_ids = array();
while(mysqli_stmt_fetch($workouts_query)) {
	array_push($workouts, $workout_name);
	array_push($workout_ids, $workout_id);
}
mysqli_stmt_close($workouts_query);
?>

<html>
<head>
<title>Workouts - <?php echo $first_name; ?> <?php echo $last_name; ?></title>
<link rel="stylesheet" href="assets/css/workout.css">
<link rel="shortcut icon" type="image/x-icon" href="assets/icons/favicon.ico">
</head>
<?php 
if(isset($_GET['routes'])) {
	echo "<body onload='init()'>";
}
else {
	echo "<body>";
}
?>
<div class="top-banner">
	<h3>Irish Fitness - Notre Dame's Fitness Hub</h3>
	<h4>CSE 30246 - Database Concepts</h4>
</div>
<div class="topnav">
	<!--<h3><a href="about.html">About Us</a></h3>-->
	<h3><a href="home.php" class="inactive">Home Page</a></h3>
	<h3><a href="meal.php" class="inactive">Meals</a></h3>
	<h3><a href="workout.php" class="active">Workouts</a></h3>
	<h4><a href="logout.php" class="inactive">Sign Out</a></h4>
	<h4><a href="profile.php" class="inactive">Profile</a></h4>
</div>
<div class="top-container">
	<h2>Workouts</h2>
	<hr>
	<div class="create-workout">
		<h3>Create a workout</h3>
		<p>Click on a workout name to select/deselect</p>
		<form action='scripts/workoutEdit.php' method='post' class='routes-form'>
			<button class='routes-button' align='center' name='show-running-routes'>Create Running Route</button>
		</form>
		<form class="create-form" action='scripts/workoutEdit.php' method='post'>
			<label for="workout-name">Workout Name:</label>
			<br>
			<input type="text" placeholder="Name" name="workout-name">
			<div class="custom-list custom-list-left">
				<label for="used-list">Selected Exercises:</label>
				<div class="exercise-list">
					<table>
						<thead>
							<tr>
								<th style='width: 50%'>Exercise Name</th>
								<th style='width: 50%'>Exercise Target</th>
							</tr>
						</thead>
						<tbody>
<?php
for($i = 0; $i <= max(array_keys($_SESSION['exercises'])); $i++) {
	if(array_key_exists($i, $_SESSION['exercises'])) {
		echo "<tr><td class='clickable' onclick='removeExercise(event)'>{$_SESSION['exercises'][$i]}</td><td>{$_SESSION['exercise_targets'][$i]}</td></tr>";
	}
}
?>
						</tbody>
					</table>
				</div>
			</div>
			<div class="middle-list">
				<label for="location-dropdown">Workout Location:</label>
				<select onchange="updateAvailableByLocation(this.value)" id="location-dropdown">
					<option value="" hidden></option>
					<option value="Dunne" id="Dunne">Dunne Hall</option>
					<option value="Johnson Family" id="Johnson Family">JFam Hall</option>
					<option value="Lewis" id="Lewis">Lewis Hall</option>
					<option value="McGlinn" id="McGlinn">McGlinn Hall</option>
					<option value="Rockne" id="Rockne">Rockne Gym</option>
					<option value="Smith" id="Smith">Smith Center</option>
					<option value="Sorin" id="Sorin">Sorin Hall</option>
					<option value="Zahm" id="Zahm">Zahm Hall</option>
				</select>
				<label for="target-dropdown">Exercise Target:</label>
				<select onchange="updateAvailableByTarget(this.value)" id="target-dropdown">
					<option value="" hidden></option>
					<option id="All">All</option>
					<option id="Abs">Abs</option>
					<option id="Back">Back</option>
					<option id="Biceps">Biceps</option>
					<option id="Calves">Calves</option>
					<option id="Cardio">Cardio</option>
					<option id="Chest">Chest</option>
					<option id="Glutes">Glutes</option>
					<option id="Hamstrings">Hamstrings</option>
					<option id="Quads">Quads</option>
					<option id="Shoulders">Shoulders</option>
					<option id="Triceps">Triceps</option>
				</select>
				<button class="button" name="reset-workout-button">Reset</button>
				<button class="button" name="create-workout-button">Create</button>
			</div>
			<div class="custom-list custom-list-right">
				<label for="unused-list">Exercises Available:</label>
				<div class="exercise-list">
					<table>
						<thead>
							<tr>
								<th style='width: 50%'>Exercise Name</th>
								<th style='width: 50%'>Exercise Target</th>
							</tr>
						</thead>
						<tbody>
<?php
for($i = 0; $i < count($exercises_array); $i++) {
	if(!(in_array($exercises_array[$i], $_SESSION['exercises']))) {
		echo "<tr><td class='clickable' onclick='addExercise(event)'>{$exercises_array[$i]}</td><td>{$exercises_target_array[$i]}</td></tr>";
	}
}
?>
						</tbody>
					</table>
				</div>
			</div>
		</form>
	</div>
	<hr>
	<div class="choose-workout">
		<h3>See workout details</h3>
		<p>Click on a workout name to view details</p>
		<table>
			<tr>
				<th style='width: 55%'>Workout Name</th>
				<th style='width: 30%'>Number of Exercises</th>
				<th style='width: 15%'>Remove</th>
			</tr>

<?php
foreach($workouts as $workout_name) {
	$workouts_key = array_search($workout_name, $workouts);
	$workout_id = $workout_ids[$workouts_key];
	$exercise_count_query = mysqli_prepare($con, "SELECT count(exercise_name) FROM workout_comprised_of WHERE workout_id = ?");
	mysqli_stmt_bind_param($exercise_count_query, "i", $workout_id);
	mysqli_stmt_execute($exercise_count_query);
	mysqli_stmt_bind_result($exercise_count_query, $exercise_count);
	mysqli_stmt_fetch($exercise_count_query);
	echo 
		"<tr>
			<td><a href='workout.php?workout={$workout_id}'><strong>{$workout_name}</strong></a></td>
			<td>{$exercise_count}</td>
			<td><a class='remove' href='scripts/workoutEdit.php?method=R&workout={$workout_id}'>&#10006;</a></td>
		</tr>";
	mysqli_stmt_close($exercise_count_query);
}
?>
		</table>
		<div align='center' style='position:relative;top:20px'>
			<button class='routes-button' align='center' id='get-running-routes' data-toggle='modal' data-target='#view-routes-modal'>View Running Routes</button>
		</div>
	</div>
	
	<hr style='position:relative;top:18px'>
	<div class="track-workout">
		<h3>Track a workout</h3>
		<p>Enter data about your workout</p>
		<form class='track-form' action='scripts/workoutEdit.php' method='post'>
			<div class='column-3 column-3-1'>
				<label for='calories-burned-input'>Calories Burned: </label>
				<br>
				<input type='number' min='0' name='calories-burned-input'>
			</div>
			<div class='column-3'>
				<label for='workout-type-input'>Workout Type: </label>
				<select name='workout-type-input'>
					<option value="" hidden></option>
					<option value="Traditional Weightlifting">Traditional Weightlifting</option>
					<option value="Functional Weightlifting">Functional Weightlifting</option>
					<option value="HIIT">HIIT</option>
					<option value="LISS">LISS</option>
					<option value="Cardio">Cardio</option>
				</select>
				<button class='button' name='submit-track-button'>Submit</button>
			</div>
			<div class='column-3'>
				<label for='workout-name-input'>Workout Used: </label>
				<br>
				<input type='text' name='workout-name-input' placeholder='Optional'>
			</div>
			<div class='column-3'>
			</div>
			<br>
		</form>
	</div>
</div>

	<!-- View Routes Modal -->
	<div class="modal" role="dialog" id="view-routes-modal" style='display:none'>
		<div class="modal-content">
			<div class="modal-header">
				<h4 style='color: #0c2340'>View Routes</h4>
				<a class='close' aria-label='Close' id='close-routes-modal'><span aria-hidden='true'>&times;</span></a>
			</div>
			<div class="view-modal-body">
				<?php include('scripts/populateRoutes.php') ?>
			</div>
		</div>
	</div>

<?php
if(isset($_GET['workout'])) {
	$selected_workout = $_GET['workout'];
	$workout_name_query = mysqli_prepare($con, "SELECT workout.workout_name, workout.created_by_user FROM workout WHERE workout.workout_id = ?");
	mysqli_stmt_bind_param($workout_name_query, "i", $selected_workout);
	mysqli_stmt_execute($workout_name_query);
	mysqli_stmt_bind_result($workout_name_query, $workout_name, $workout_owner);
	mysqli_stmt_fetch($workout_name_query);
	mysqli_stmt_close($workout_name_query);

	if($workout_owner != $user_id) {
		header("Refresh:0, url=workout.php");
	}
	else{

	echo
		"<div class='modal' tabindex='-1' role='dialog' id='workout-modal'>
		<div class='modal-content'>
		<div class='modal-header'>
		<h4>Selected Workout: {$workout_name}</h4>
		<button class='close' aria-label='Close'><a href='workout.php'><span aria-hidden='true'>&#10006;</span></a></button>
		</div>
		<div class='modal-body'>
		<table>
		<thead>
		<tr>
		<th style='width: 40%'>Exercise</th>
		<th style='width: 20%'>Sets</th>
		<th style='width: 20%'>Reps</th>
		<th style='width: 20%'></th>
		</tr>
		</thead>
		<tbody>";
	$exercises_query = mysqli_prepare($con, "SELECT workout_comprised_of.exercise_name, workout_comprised_of.num_sets, workout_comprised_of.num_reps, exercise.demo_link FROM workout_comprised_of, exercise WHERE workout_id = ? and workout_comprised_of.exercise_name = exercise.exercise_name ORDER BY workout_order");
	mysqli_stmt_bind_param($exercises_query, "i", $selected_workout);
	mysqli_stmt_execute($exercises_query);
	mysqli_stmt_bind_result($exercises_query, $exercises, $num_sets, $num_reps, $demo_link);
	while(mysqli_stmt_fetch($exercises_query)) {
		echo
			"<tr>
			<td>{$exercises}</td>
			<td>{$num_sets}</td>
			<td>{$num_reps}</td>
			<td><a href='{$demo_link}' target='_blank'>Demo Link</a></td>
			</tr>";
	}
	echo
		"</tbody>
		</table>
		</div>
		</div>
		</div>";
	unset($_GET['workout']);
	}
}

if(isset($_GET['name'])) {
	$workout_name = $_GET['name'];
	echo
		"<div class='modal' tabindex='-1' role='dialog' id='create-workout-modal'>
		<div class='modal-content'>
		<div class='modal-header'>
		<h4>Create Workout: {$workout_name}</h4>
		<button class='close' aria-label='Close'><a href='workout.php'><span aria-hidden='true'>&#10006;</span></a></button>
		</div>
		<div class='modal-body'>
		<form action='scripts/workoutEdit.php?workout-name={$workout_name}' method='post'>";
	foreach($_SESSION['exercises'] as $selected_exercise) {
		echo 
			"<div class='row'>
			<p>{$selected_exercise}</p>
			<label for='sets-input'>Sets: </label>
			<input type='number' name='sets-input[]' min=0>
			<br>
			<label for='reps-input'>Reps/Distance: </label>
			<input type='text' name='reps-input[]'>
			</div>";
	}
	//Submit workout button
	echo
		"<button class='button' name='submit-workout-button'><a href='workout.php'><span aria-hidden='true'>Submit</span></a></button>
		</div>
		</div>
		</div>";
	unset($_GET['name']);
}
?>

<?php
if(isset($_GET['routes'])) {
	echo"
<div class='modal' tabindex='-1' role='dialog' id='running-routes-modal'>
	<div class='modal-content-routes'>
		<div class='modal-header'>
			<h4>Running Route</h4>
			<a class='close' aria-label='Close' id='routes-close' href='workout.php'><span aria-hidden='true'>&times;</span></a>
		</div>
		<div class='modal-body'>
			<form action='scripts/workoutEdit.php' method='post'>
   	        	<script type='text/javascript'>
   		    		var canvas, ctx, flag = false,
       				prevX = 0,
        			currX = 0,
        			prevY = 0,
        			currY = 0,
					dot_flag = false;
					var miles = 0;

    				var x = 'red',
					y = 2;

					var pixels = 0;
					var cutoff = true;
    
    				function init() {
        				canvas = document.getElementById('can');
        				ctx = canvas.getContext('2d');
        				w = canvas.width;
						h = canvas.height;


						var background = new Image();
						background.src = 'CampusMapND.png';
						background.style.width=w;
						background.style.height=h;
						background.onload = function(){
							ctx.drawImage(background,0,0);
						}
    
        				canvas.addEventListener('mousemove', function (e) {
            				findxy('move', e)
        				}, false);
        				canvas.addEventListener('mousedown', function (e) {
            				findxy('down', e)
        				}, false);
        				canvas.addEventListener('mouseup', function (e) {
            				findxy('up', e)
        				}, false);
        				canvas.addEventListener('mouseout', function (e) {
            				findxy('out', e)
        				}, false);
    				}
    
					function draw() {
        				ctx.beginPath();
        				ctx.moveTo(prevX, prevY);
        				ctx.lineTo(currX, currY);
        				ctx.strokeStyle = x;
						ctx.lineWidth = y;
        				ctx.stroke();
        				ctx.closePath();
    				}
    
    				function erase() {
        				var m = confirm('Clear drawing?');
        				if (m) {
            				ctx.clearRect(0, 0, w, h);
            				document.getElementById('canvasimg').style.display = 'none';
						}
						var background = new Image();
						background.src = 'CampusMapND.png';
						background.onload = function(){
							ctx.drawImage(background,0,0);
						}
						miles = 0;
						document.getElementById('pixelcount').innerHTML = miles;
						document.getElementById('pixelcountInput').value = miles;
					}

					function count() {
						var img = document.getElementById('canvasimg');
						var canvas = document.getElementById('can');
						var standardData = [255,0,0,255];
						var currentData = ctx.getImageData(0,0,canvas.width,canvas.height);
						var button = document.getElementById('submit-route-button');
						setTimeout(async function() {
							pixels=0;
							for (let i=0;i<currentData.data.length;i+=4){
								if (currentData.data[i+0]>standardData[0]-50){
									if (currentData.data[i+1]<standardData[1]+50){
										if (currentData.data[i+2]<standardData[2]+50){
											pixels+=1;
										}
									}
								}
							}
						var feet = Math.floor(pixels*(50/11));
						miles = (feet/5280).toFixed(1);
						document.getElementById('pixelcount').innerHTML = miles;
						document.getElementById('pixelcountInput').value = miles;
						return;
						}, 20);
					}
    
    				function findxy(res, e) {
        				if (res == 'down') {
            				prevX = currX;
            				prevY = currY;
            				currX = e.clientX - canvas.getBoundingClientRect().left;
            				currY = e.clientY - canvas.getBoundingClientRect().top;
    
            				flag = true;
            				dot_flag = true;
            				if (dot_flag) {
                				ctx.beginPath();
                				ctx.fillStyle = x;
                				ctx.fillRect(currX, currY, 2, 2);
                				ctx.closePath();
                				dot_flag = false;
            				}
        				}
        				if (res == 'up' || res == 'out') {
            				flag = false;
        				}
        				if (res == 'move') {
            				if (flag) {
                				prevX = currX;
                				prevY = currY;
                				currX = e.clientX - canvas.getBoundingClientRect().left;
                				currY = e.clientY - canvas.getBoundingClientRect().top;
                				draw();
            				}
        				}
    				}
    			</script>
    			<div>
        			<canvas id='can' width='1500' height='1200' style='position:absolute;top:36%;left:0%;border:2px solid;' onclick='count()'></canvas>
        			<img id='canvasimg' style='position:absolute;top:10%;left:0%;' style='display:none;'>
				</div>
				<div id='button-goes-here'>
					<button class='button' name='submit-route-button'>Submit</button>
					<label class='label-margin-boi' for='route-name'>Route Name: </label>
					<input class='no-margin-boi' name='route-name' type='text' style='width: 200px'>
				</div>
				<p><span id='pixelcount'>0</span> miles</p>
				<div>
					<input id='pixelcountInput' name='pixelcount' type='hidden'/>
				</div>
			</form>
			<button class='button' name='clear-route-button' onclick='erase()'>Clear</button>
		</div>
	</div>
</div>";
unset($_GET['routes']);
}
?>
<script src="scripts/workout.js"></script>
</body>
</html>
	

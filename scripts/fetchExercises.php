<?php
include('scripts/connect.php');
?>

<?php
session_start();
if(isset($_GET['target'])){
	$target = $_GET['target'];
	if (isset($_GET['location'])){
		if ($target != '%All%'){
			$location = $_GET['location'];
			$exercises_query = mysqli_prepare($con, "SELECT distinct exercise.exercise_name, exercise.target_muscle FROM exercise, equipment_available_at WHERE exercise.equipment_name = equipment_available_at.equipment_name AND equipment_available_at.exercise_location_name = ? AND exercise.target_muscle like ?");
			mysqli_stmt_bind_param($exercises_query, "ss", $location, $target);
			mysqli_stmt_execute($exercises_query);
			mysqli_stmt_bind_result($exercises_query, $exercises, $exercise_target);
		}
		else{
			$location = $_GET['location'];
			$exercises_query = mysqli_prepare($con, "SELECT distinct exercise.exercise_name, exercise.target_muscle FROM exercise, equipment_available_at WHERE exercise.equipment_name = equipment_available_at.equipment_name AND equipment_available_at.exercise_location_name = ?");
			mysqli_stmt_bind_param($exercises_query, "s", $location);
			mysqli_stmt_execute($exercises_query);
			mysqli_stmt_bind_result($exercises_query, $exercises, $exercise_target);
		}
	}
	else{
		if ($target != '%All%'){
			$exercises_query = mysqli_prepare($con, "SELECT exercise.exercise_name, exercise.target_muscle FROM exercise WHERE exercise.target_muscle like ?");
			mysqli_stmt_bind_param($exercises_query, "s", $target);
			mysqli_stmt_execute($exercises_query);
			mysqli_stmt_bind_result($exercises_query, $exercises, $exercise_target);
		}
		else{
			$exercises_query = mysqli_prepare($con, "SELECT exercise.exercise_name, exercise.target_muscle FROM exercise");
			mysqli_stmt_execute($exercises_query);
			mysqli_stmt_bind_result($exercises_query, $exercises, $exercise_target);
		}
	}
}

elseif(isset($_GET['location']) && !isset($_GET['target'])){
	$location = $_GET['location'];
	$exercises_query = mysqli_prepare($con, "SELECT exercise.exercise_name, exercise.target_muscle FROM exercise, equipment_available_at WHERE equipment_available_at.equipment_name = exercise.equipment_name and equipment_available_at.exercise_location_name = ?");
	mysqli_stmt_bind_param($exercises_query, "s", $location);
	mysqli_stmt_execute($exercises_query);
	mysqli_stmt_bind_result($exercises_query, $exercises, $exercise_target);
}

else {
	$target = '';
	$exercises_query = mysqli_prepare($con, "SELECT exercise.exercise_name, exercise.target_muscle FROM exercise");
	mysqli_stmt_execute($exercises_query);
	mysqli_stmt_bind_result($exercises_query, $exercises, $exercise_target);
}

$exercises_array = array();
$exercises_target_array = array();
while(mysqli_stmt_fetch($exercises_query)) {
	array_push($exercises_array, $exercises);
	array_push($exercises_target_array, $exercise_target);
}
mysqli_stmt_close($exercises_query);
?>

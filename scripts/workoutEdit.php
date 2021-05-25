<?php
include('connect.php');
?>

<?php
session_start();

if(isset($_POST['reset-workout-button'])) {
	unset($_POST['reset-workout-button']);
	$_SESSION['exercises'] = array();
	$_SESSION['exercise_targets'] = array();
	header("location: ../workout.php");
}

if(isset($_GET['exercise']) && isset($_GET['method']) && isset($_GET['exerciseTarget'])) {
	if(strcmp($_GET['method'], 'A') == 0) {
		$exercise = $_GET['exercise'];
		array_push($_SESSION['exercises'], $exercise);
		$exercise_target = $_GET['exerciseTarget'];;
		array_push($_SESSION['exercise_targets'], $exercise_target);
		if(isset($_GET['target'])) {
			if(isset($_GET['location'])) {
				header("location: ../workout.php?location={$_GET['location']}&target=%25{$_GET['target']}%25");
			}
			else {
				header("location: ../workout.php?target=%25{$_GET['target']}%25");
			}
		}
		else {
			if(isset($_GET['location'])) {
				header("location: ../workout.php?location={$_GET['location']}");
			}
			else {
				header("location: ../workout.php");
			}
		}
		unset($_GET['exercise']);
		unset($_GET['exerciseTarget']);
	}
	elseif(strcmp($_GET['method'], 'R') == 0) {
		$delete_key = array_search($_GET['exercise'], $_SESSION['exercises']);
		unset($_SESSION['exercises'][$delete_key]);
		unset($_SESSION['exercise_targets'][$delete_key]);
		if(isset($_GET['target'])) {
			if(isset($_GET['location'])) {
				header("location: ../workout.php?location={$_GET['location']}&target=%25{$_GET['target']}%25");
			}
			else {
				header("location: ../workout.php?target=%25{$_GET['target']}%25");
			}
		}
		else {
			if(isset($_GET['location'])) {
				header("location: ../workout.php?location={$_GET['location']}");
			}
			else {
				header("location: ../workout.php");
			}
		}
		unset($_GET['exercise']);
		unset($_GET['exerciseTarget']);
	}
}

if(isset($_GET['workout']) && (strcmp($_GET['method'], "R") == 0)) {
	$remove_workout_query = mysqli_prepare($con, "DELETE FROM workout WHERE workout.workout_id = ?");
	mysqli_stmt_bind_param($remove_workout_query, "i", $_GET['workout']);
	mysqli_stmt_execute($remove_workout_query);
	mysqli_stmt_close($remove_workout_query);

	$remove_exercises_query = mysqli_prepare($con, "DELETE FROM workout_comprised_of WHERE workout_id = ?");
	mysqli_stmt_bind_param($remove_exercises_query, "i", $_GET['workout']);
	mysqli_stmt_execute($remove_exercises_query);
	mysqli_stmt_close($remove_exercises_query);

	header("location: ../workout.php");
}

if(isset($_POST['create-workout-button'])) {
	unset($_POST['create-workout-button']);
	$workout_name = mysqli_real_escape_string($con, $_POST['workout-name']);
	if(empty($workout_name)) {
		$_SESSION['msg'] = "<script>alert('Workout name cannot be blank!')</script>";
		header("location: ../workout.php");
	}
	else {
		$exercise_count = count($_SESSION['exercises']);
		if($exercise_count == 0) {
			$_SESSION['msg'] = "<script>alert('There are no selected exercises!')</script>";
			header("location: ../workout.php");
		}
		else {
			header("location: ../workout.php?name={$workout_name}");
		}
	}
}

if(isset($_POST['submit-workout-button'])) {
	unset($_POST['submit-workout-button']);
	$workout_name = $_GET['workout-name'];
	$create_workout_query = mysqli_prepare($con, "INSERT INTO workout (workout_name, created_by_user) VALUES (?, ?)");
	mysqli_stmt_bind_param($create_workout_query, "si", $workout_name, $_SESSION['user_id']);
	mysqli_stmt_execute($create_workout_query);
	$workout_id = mysqli_insert_id($con);
	mysqli_stmt_close($create_workout_query);
			
	$workout_order_counter = 1;
	foreach($_SESSION['exercises'] as $selected_exercise) {
		$add_exercise_query = mysqli_prepare($con, "INSERT INTO workout_comprised_of (workout_id, exercise_name, workout_order, num_sets, num_reps) VALUES (?, ?, ?, ?, ?)");
		mysqli_stmt_bind_param($add_exercise_query, "isiis", $workout_id, $selected_exercise, $workout_order_counter, $_POST['sets-input'][$workout_order_counter-1], $_POST['reps-input'][$workout_order_counter-1]);
		mysqli_stmt_execute($add_exercise_query);
		mysqli_stmt_close($add_exercise_query);
		$workout_order_counter = $workout_order_counter + 1;
	}
	$_SESSION['exercises'] = array();
	$_SESSION['exercise_targets'] = array();
	header("location: ../workout.php");
}

if(isset($_POST['submit-track-button'])) {
	$calories_burned = mysqli_real_escape_string($con, $_POST['calories-burned-input']);
	$workout_type = mysqli_real_escape_string($con, $_POST['workout-type-input']);
	$workout_name = mysqli_real_escape_string($con, $_POST['workout-name-input']);
	if(empty($calories_burned) || empty($workout_type)) {
		$_SESSION['msg'] = "<script>alert('One or more fields left blank')</script>";
		header("location: ../workout.php");
	}
	else {
		if(empty($workout_name)) {
			$track_exercise_query = mysqli_prepare($con, "INSERT INTO tracked_workout (created_by_user, calories_burned, workout_type, workout_date) VALUES (?, ?, ?, CURDATE())");
			mysqli_stmt_bind_param($track_exercise_query, "iis", $_SESSION['user_id'], $calories_burned, $workout_type);
			mysqli_stmt_execute($track_exercise_query);
			mysqli_stmt_close($track_exercise_query);
		}
		else {
			$track_exercise_query = mysqli_prepare($con, "INSERT INTO tracked_workout (created_by_user, calories_burned, workout_type, workout_name, workout_date) VALUES (?, ?, ?, ?, CURDATE())");
			mysqli_stmt_bind_param($track_exercise_query, "iiss", $_SESSION['user_id'], $calories_burned, $workout_type, $workout_name);
			mysqli_stmt_execute($track_exercise_query);
			mysqli_stmt_close($track_exercise_query);
		}
		header("location: ../workout.php");
	}
}

if(isset($_POST['show-running-routes'])) {
	header('location: ../workout.php?routes=True');
}

if(isset($_POST['submit-route-button'])) {
	$distance = $_POST['pixelcount'];
	$user_id = $_SESSION['user_id'];
	$route_name = $_POST['route-name'];
	
	$create_route_query = mysqli_prepare($con, "INSERT INTO routes (created_by, distance, name) VALUES (?, ?, ?)");
	mysqli_stmt_bind_param($create_route_query, "ids", $user_id, $distance, $route_name);
	mysqli_stmt_execute($create_route_query);
	mysqli_stmt_close($create_route_query);
}

if(isset($_GET['view-running-routes'])) {
	if($_SESSION['user_id'])
	$route_url = $_GET['route']; 
}
	

?>

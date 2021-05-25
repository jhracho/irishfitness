<?php
include('scripts/connect.php');
?>

<?php
session_start();
$username = $_SESSION['username'];

if(empty($username)) {
	$_SESSION['msg'] = "You must log in to view this page!";
	header("location: login.php");
}

$first_name = $_SESSION['first_name'];
$last_name = $_SESSION['last_name'];
$user_id = $_SESSION['user_id'];

$user_data_query = mysqli_prepare($con, "SELECT created_at, goal_cals, goal_protein, goal_carbs, goal_fat, goal_burned from user where user.user_id = ?");
mysqli_stmt_bind_param($user_data_query, "i", $user_id);
mysqli_stmt_execute($user_data_query);
mysqli_stmt_bind_result($user_data_query, $created_at, $goal_cals, $goal_protein, $goal_carbs, $goal_fat, $goal_burned);
mysqli_stmt_fetch($user_data_query);
mysqli_stmt_close($user_data_query);

$height_in_inches = $_SESSION['height_feet'] * 12 + $_SESSION['height_inches'];
$weight = $_SESSION['weight'];
$gender = $_SESSION['gender'];
if(strcmp($gender, 'Male') == 0) {
	$BMR = 66 + 6.3 * $weight + 12.9 * $height_in_inches - 6.8 * 19;
	$recommended_cals = round($BMR * 1.375, -1);
}
elseif(strcmp($gender, 'Female') == 0) {
	$BMR = 655 + 4.3 * $weight + 4.7 * $height_in_inches - 4.7 * 19;
	$recommended_cals = round($BMR * 1.375, -1);
}
$recommended_pro = round(($recommended_cals * 0.3) / 4);
$recommended_car = round(($recommended_cals * 0.5) / 4);
$recommended_fat = round(($recommended_cals * 0.2) / 9);

$date_created = date_parse($created_at);

$month = "";
switch($date_created['month']) {
case 1:
	$month = "January";
	break;
case 2:
	$month = "February";
	break;
case 3:
	$month = "March";
	break;
case 4:
	$month = "April";
	break;
case 5:
	$month = "May";
	break;
case 6:
	$month = "June";
	break;
case 7:
	$month = "July";
	break;
case 8:
	$month = "August";
	break;
case 9:
	$month = "September";
	break;
case 10:
	$month = "October";
	break;
case 11:
	$month = "November";
	break;
case 12:
	$month = "December";
	break;
default:
	$month = NULL;
	break;
}

$tracked_query = mysqli_prepare($con, "SELECT sum(calories*servings), sum(protein*servings), sum(carbs*servings), sum(fat*servings) FROM meal, food_item, meal_item WHERE meal.meal_id = meal_item.meal_id and meal_item.food_id = food_item.food_id and meal.user_id = ? and meal.meal_date = CURDATE()");
mysqli_stmt_bind_param($tracked_query, "i", $user_id);
mysqli_stmt_execute($tracked_query);
mysqli_stmt_bind_result($tracked_query, $tracked_cals, $tracked_protein, $tracked_carbs, $tracked_fat);
mysqli_stmt_fetch($tracked_query);
mysqli_stmt_close($tracked_query);

if($tracked_cals == NULL) {
	$tracked_cals = 0;
}
if($tracked_protein == NULL) {
	$tracked_protein = 0;
}
if($tracked_carbs == NULL) {
	$tracked_carbs = 0;
}
if($tracked_fat == NULL) {
	$tracked_fat = 0;
}

$burned_query = mysqli_prepare($con, "SELECT sum(calories_burned) FROM tracked_workout WHERE created_by_user = ? and workout_date = CURDATE()");
mysqli_stmt_bind_param($burned_query, "i", $user_id);
mysqli_stmt_execute($burned_query);
mysqli_stmt_bind_result($burned_query, $tracked_burned);
mysqli_stmt_fetch($burned_query);
mysqli_stmt_close($burned_query);

if($tracked_burned == NULL) {
	$tracked_burned = 0;
}

$total_cals_query = mysqli_prepare($con, "SELECT sum(calories*servings) FROM meal, food_item, meal_item WHERE meal.meal_id = meal_item.meal_id and meal_item.food_id = food_item.food_id and meal.user_id = ?");
mysqli_stmt_bind_param($total_cals_query, "i", $user_id);
mysqli_stmt_execute($total_cals_query);
mysqli_stmt_bind_result($total_cals_query, $total_cals);
mysqli_stmt_fetch($total_cals_query);
mysqli_stmt_close($total_cals_query);

if(empty($total_cals)) {
	$total_cals = 0;
}

$total_workouts_query = mysqli_prepare($con, "SELECT count(workout_id) FROM workout WHERE workout.created_by_user = ?");
mysqli_stmt_bind_param($total_workouts_query, "i", $user_id);
mysqli_stmt_execute($total_workouts_query);
mysqli_stmt_bind_result($total_workouts_query, $total_workouts);
mysqli_stmt_fetch($total_workouts_query);
mysqli_stmt_close($total_workouts_query);

$unique_foods_query = mysqli_prepare($con, "SELECT count(T.food_id) FROM (SELECT distinct food_item.food_id as food_id FROM meal, food_item, meal_item WHERE meal.meal_id = meal_item.meal_id and meal_item.food_id = food_item.food_id and meal.user_id = ?) T");
mysqli_stmt_bind_param($unique_foods_query, "i", $user_id);
mysqli_stmt_execute($unique_foods_query);
mysqli_stmt_bind_result($unique_foods_query, $unique_foods);
mysqli_stmt_fetch($unique_foods_query);
mysqli_stmt_close($unique_foods_query);

$unique_exercises_query = mysqli_prepare($con, "SELECT count(T.exercise_name) FROM (SELECT distinct exercise.exercise_name as exercise_name FROM exercise, workout, workout_comprised_of WHERE workout.workout_id = workout_comprised_of.workout_id and exercise.exercise_name = workout_comprised_of.exercise_name and workout.created_by_user = ?) T");
mysqli_stmt_bind_param($unique_exercises_query, "i", $user_id);
mysqli_stmt_execute($unique_exercises_query);
mysqli_stmt_bind_result($unique_exercises_query, $unique_exercises);
mysqli_stmt_fetch($unique_exercises_query);
mysqli_stmt_close($unique_exercises_query);

$meals_created_query = mysqli_prepare($con, "SELECT count(T.meal_id) FROM (SELECT distinct meal.meal_id as meal_id FROM meal WHERE meal.user_id = ?) T");
mysqli_stmt_bind_param($meals_created_query, "i", $user_id);
mysqli_stmt_execute($meals_created_query);
mysqli_stmt_bind_result($meals_created_query, $meals_created);
mysqli_stmt_fetch($meals_created_query);
mysqli_stmt_close($meals_created_query);
?>

<html>
<head>
<title>Home - <?php echo $first_name; ?> <?php echo $last_name; ?></title>
<link rel="stylesheet" href="assets/css/home.css">
<link rel="shortcut icon" type="image/x-icon" href="assets/icons/favicon.ico"> 
</head>
<body>
<div style="display: none">
<p id='tracked_cals'><?php echo $tracked_cals; ?></p>
<p id='tracked_protein'><?php echo $tracked_protein; ?></p>
<p id='tracked_carbs'><?php echo $tracked_carbs; ?></p>
<p id='tracked_fat'><?php echo $tracked_fat; ?></p>
<p id='recommended_cals'><?php echo $recommended_cals; ?></p>
<p id='recommended_protein'><?php echo $recommended_pro; ?></p>
<p id='recommended_carbs'><?php echo $recommended_car; ?></p>
<p id='recommended_fat'><?php echo $recommended_fat; ?></p>
<p id='tracked_burned'><?php echo $tracked_burned; ?></p>
</div>
<div class="top-banner">
	<h3>Irish Fitness - Notre Dame's Fitness Hub</h3>
	<h4>CSE 30246 - Database Concepts</h4>
</div>
<div class="topnav">
	<h3><a href="home.php" class="active">Home Page</a></h3>
	<h3><a href="meal.php" class="inactive">Meals</a></h3>
	<h3><a href="workout.php" class="inactive">Workouts</a></h3>
	<h4><a href="logout.php" class="inactive">Sign Out</a></h4>
	<h4><a href="profile.php" class="inactive">Profile</a></h4>
</div>
<div class="top-container">
	<h1>Welcome to Irish Fitness, <?php echo $first_name; ?>!</h1>
	<p>Member since <?php echo $month; ?> <?php echo $date_created['year']; ?></p>
	<hr>
	<h2>Daily Goals</h2>
	<button class='button review-button' id='daily-review-button'>Show my Daily Review</button>
	<div class="half-column">
	<?php
	if($goal_cals != NULL) {
		if(($tracked_cals/$goal_cals) * 100 > 99) {
			echo "
				<label for='calories' id='calories-modal-label' class='modal-label'>Calories: ".$goal_cals."</label>
				<div class='progress-background' id='calories'>
					<p class='p-left'>".$tracked_cals."</p>
					<div class='progress-foreground' style='width: 99%;'>
					</div>
				</div>";
		}
		else {
			echo "
				<label for='calories' id='calories-modal-label' class='modal-label'>Calories: ".$goal_cals."</label>
				<div class='progress-background' id='calories'>
					<p class='p-left'>".$tracked_cals."</p>
					<div class='progress-foreground' style='width: ".($tracked_cals/$goal_cals) * 100 ."%;'>
					</div>
				</div>";
		}
	}
	else {
		echo "
			<label for='calories'>Calories</label>
			<br>
			<button class='button' id='calories-modal-button'>Add a daily calorie goal</button><br>";
	}
?>
	<?php
	if($goal_protein != NULL) {
		if(($tracked_protein/$goal_protein) * 100 > 99) {
			echo "
				<label for='protein' id='protein-modal-label' class='modal-label'>Protein: ".$goal_protein."</label>
				<div class='progress-background' id='calories'>
					<p class='p-left'>".$tracked_protein."</p>
					<div class='progress-foreground' style='width: 99%;'>
					</div>
					</div>";
		}
		else {
			echo "
				<label for='protein' id='protein-modal-label' class='modal-label'>Protein: ".$goal_protein."</label>
				<div class='progress-background' id='calories'>
					<p class='p-left'>".$tracked_protein."</p>
					<div class='progress-foreground' style='width: ".($tracked_protein/$goal_protein) * 100 ."%;'>
					</div>
					</div>";
		}
	}
	else {
		echo "
			<label for='protein'>Protein</label>
			<br>
			<button class='button' id='protein-modal-button'>Add a daily protein goal</button><br>";
	}
?>
	</div>
	<div class="half-column">
	<?php
	if($goal_carbs != NULL) {
		if(($tracked_carbs/$goal_carbs) * 100 > 99) {
			echo "
				<label for='carbs' id='carbs-modal-label' class='modal-label'>Carbs: ".$goal_carbs."</label>
				<div class='progress-background' id='carbs'>
					<p class='p-right'>".$tracked_carbs."</p>
					<div class='progress-foreground' style='width: 99%;'>
					</div>
					</div>";
		}
		else {
			echo "
				<label for='carbs' id='carbs-modal-label' class='modal-label'>Carbs: ".$goal_carbs."</label>
				<div class='progress-background' id='carbs'>
					<p class='p-right'>".$tracked_carbs."</p>
					<div class='progress-foreground' style='width: ".($tracked_carbs/$goal_carbs) * 100 ."%;'>
					</div>
					</div>";
		}
	}
	else {
		echo "
			<label for='carbs'>Carbohydrates</label>
			<br>
			<button class='button' id='carbs-modal-button'>Add a daily carbohydrate goal</button><br>";
	}
?>
	<?php
	if($goal_fat != NULL) {
		if(($tracked_fat/$goal_fat) * 100 > 99) {
			echo "
				<label for='fat' id='fat-modal-label' class='modal-label'>Fats: ".$goal_fat."</label>
				<div class='progress-background' id='fat'>
					<p class='p-right'>".$tracked_fat."</p>
					<div class='progress-foreground' style='width: 99%;'>
					</div>
					</div>";
		}
		else {
			echo "
				<label for='fat' id='fat-modal-label' class='modal-label'>Fats: ".$goal_fat."</label>
				<div class='progress-background' id='fat'>
					<p class='p-right'>".$tracked_fat."</p>
					<div class='progress-foreground' style='width: ".($tracked_fat/$goal_fat) * 100 ."%;'>
					</div>
					</div>";
		}
	}
	else {
		echo "
			<label for='fat'>Fats</label>
			<br>
			<button class='button' id='fat-modal-button'>Add a daily fat goal</button><br>";
	}
?>
	</div>
	<div class='full-column'>
	<?php
	if($goal_burned != NULL) {
		if(($tracked_burned/$goal_burned) * 100 > 99) {
			echo "
				<label for='burned' id='burned-modal-label' class='modal-label'>Calories Burned: ".$goal_burned."</label>
				<div class='progress-background' id='burned'>
					<p class='p-center'>".$tracked_burned."</p>
					<div class='progress-foreground' style='width: 99%;'>
					</div>
					</div>";
		}
		else {
			echo "
				<label for='burned' id='burned-modal-label' class='modal-label'>Calories Burned: ".$goal_burned."</label>
				<div class='progress-background' id='burned'>
					<p class='p-center'>".$tracked_burned."</p>
					<div class='progress-foreground' style='width: ".($tracked_burned/$goal_burned) * 100 ."%;'>
					</div>
					</div>";
		}
	}
	else {
		echo "
			<label for='burned'>Calories Burned</label>
			<br>
			<button class='button' id='burned-modal-button'>Add a daily calorie goal</button><br>";
	}
?>
	</div>
	<h2>Account Milestones</h2>
	<div class="sub-column first-column">
		<span class="dot"><?php echo $total_cals; ?></span>
		<h4>Calories Tracked</h4>
	</div>
	<div class="sub-column">
		<span class="dot"><?php echo $meals_created; ?></span>
		<h4>Meals Created</h4>
	</div>
	<div class="sub-column">
		<span class="dot"><?php echo $total_workouts; ?></span>
		<h4>Custom Workouts</h4>
	</div>
	<div class="sub-column">
		<span class="dot"><?php echo $unique_exercises; ?></span>
		<h4>Unique Exercises</h4>
	</div>
</div>
<div class="modal" tabindex="-1" role="dialog" id="calories-modal">
	<div class="modal-content">
		<div class="modal-header">
			<h4>Daily Calorie Goal:</h4>
			<a class="close" aria-label="Close" id="calories-close"><span aria-hidden="true">&times;</span></a>
		</div>
		<div class="modal-body">
			<form action="scripts/macroUpdates.php" method="post">
				<label for="calories-input">Goal:</label><br>
				<input type="number" value="<?php if($goal_cals != NULL) {echo $goal_cals;} else {echo $recommended_cals;} ?>" step="10" min="0" max="10000" id="calories-input" name="calories-input"><br>
				<button class="submitButton" id="cals-update-button" name="cals-update-button">Submit</button>
			</form>
		</div>
	</div>
</div>
<div class="modal" tabindex="-1" role="dialog" id="protein-modal">
	<div class="modal-content">
		<div class="modal-header">
			<h4>Daily Protein Goal:</h4>
			<a class="close" aria-label="Close" id="protein-close"><span aria-hidden="true">&times;</span></a>
		</div>
		<div class="modal-body">
			<form action="scripts/macroUpdates.php" method="post">
				<label for="protein-input">Goal:</label><br>
				<input type="number" value="<?php if($goal_protein != NULL) {echo $goal_protein;} else {echo $recommended_pro;} ?>" step="1" min="0" max="10000" id="protein-input" name="protein-input"><br>
				<button class="submitButton" id="protein-update-buton" name="protein-update-button">Submit</button>
			</form>
		</div>
	</div>
</div>
<div class="modal" tabindex="-1" role="dialog" id="carbs-modal">
	<div class="modal-content">
		<div class="modal-header">
			<h4>Daily Carb Goal:</h4>
			<a class="close" aria-label="Close" id="carbs-close"><span aria-hidden="true">&times;</span></a>
		</div>
		<div class="modal-body">
			<form action="scripts/macroUpdates.php" method="post">
				<label for="carbs-input">Goal:</label><br>
				<input type="number" value="<?php if($goal_carbs != NULL) {echo $goal_carbs;} else {echo $recommended_car;} ?>" step="1" min="0" max="10000" id="carbs-input" name="carbs-input"><br>
				<button class="submitButton" id="carbs-update-button" name="carbs-update-button">Submit</button>
			</form>
		</div>
	</div>
</div>
<div class="modal" tabindex="-1" role="dialog" id="fat-modal">
	<div class="modal-content">
		<div class="modal-header">
			<h4>Daily Fat Goal:</h4>
			<a class="close" aria-label="Close" id="fat-close"><span aria-hidden="true">&times;</span></a>
		</div>
		<div class="modal-body">
			<form action="scripts/macroUpdates.php" method="post">
				<label for="fat-input">Goal:</label><br>
				<input type="number" value="<?php if($goal_fat != NULL) {echo $goal_fat;} else {echo $recommended_fat;}?>" step="1" min="0" max="10000" id="fat-input" name="fat-input"><br>
				<button class="submitButton" id="fat-update-button" name="fat-update-button">Submit</button>
			</form>
		</div>
	</div>
</div>
<div class="modal" tabindex="-1" role="dialog" id="burned-modal">
	<div class="modal-content">
		<div class="modal-header">
			<h4>Daily Calories Burned Goal:</h4>
			<a class="close" aria-label="Close" id="burned-close"><span aria-hidden="true">&times;</span></a>
		</div>
		<div class="modal-body">
			<form action="scripts/macroUpdates.php" method="post">
				<label for="burned-input">Goal:</label><br>
				<input type="number" value="<?php if($goal_burned != NULL) {echo $goal_burned;} else {echo 0;}?>" step="1" min="0" max="10000" id="burned-input" name="burned-input"><br>
				<button class="submitButton" id="burned-update-button" name="burned-update-button">Submit</button>
			</form>
		</div>
	</div>
</div>
<div class="modal" tabindex="-1" role="dialog" id="review-modal">
	<div class="modal-content-large">
		<div class="modal-header">
			<h4>Daily Review:</h4>
			<a class="close" aria-label="Close" id="review-close"><span aria-hidden="true">&times;</span></a>
		</div>
		<div class="modal-body">
			<div class='modal-half-column' id='macros-column'>
				<h2>Your Macros</h2>
				<div id='macros-canvas'>
				</div>
			</div>
			<div class='modal-half-column' id='activity-column'>
				<h2>Your Activity</h2>
				<div id='activity-canvas'>
				</div>
			</div>
			<!--
			<div id='meal-summary'>
				<h2>Your Meals</h2>
				<?php //include('scripts/mealSummary.php') ?>
			</div>
			-->
		</div>
	</div>
</div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<script src="scripts/dailyreview.js"></script>
<script src="scripts/homeModals.js"></script>
</body>
</html>


<?php include('scripts/connect.php') ?>

<?php

// Remove food from meal
if (isset ($_GET['ID']) && isset($_GET['MEAL'])){
	$food_id = $_GET['ID'];
	$meal_id = $_GET['MEAL'];
	
	// Query to remove food
	$remove_food = mysqli_prepare($con, "DELETE FROM meal_item WHERE food_id = ? AND meal_id = ?");
	mysqli_stmt_bind_param($remove_food, "ii", $food_id, $meal_id);
	mysqli_stmt_execute($remove_food);
	mysqli_stmt_close($remove_food);

	// If there is no food left, delete the meal
	$check_left = mysqli_prepare($con, "SELECT count(food_id) from meal_item where meal_id = ?");
	mysqli_stmt_bind_param($check_left, "i", $meal_id);
	mysqli_stmt_execute($check_left);
	mysqli_stmt_bind_result($check_left, $count);
	mysqli_stmt_fetch($check_left);
	mysqli_stmt_close($check_left);
	
	if ($count == 0){
		$delete_meal = mysqli_prepare($con, "DELETE FROM meal WHERE meal_id = ?");
		mysqli_stmt_bind_param($delete_meal, "i", $meal_id);
		mysqli_stmt_execute($delete_meal);
		mysqli_stmt_close($delete_meal);
	}	

	// Redirect
	if (isset ($_GET['OFFSET'])){
		$offset = $_GET['OFFSET'];
		header("location: meal.php?offset=".$offset);		
	}
	else{
		header("location: meal.php");
	}
}

else{
	header("location: meal.php");
}
?>

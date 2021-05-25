<?php include('foodConnect.php') ?>
<?php

// TODO: Some food items have null cells and cause syntax errors. Need to address those (or we don't really need to address them?)

// Set all is_offered columns in food_item to '0'
$query = <<<eof
	UPDATE food_item
	SET is_offered=0
	WHERE sourced_from = 'NDH'
	OR sourced_from = 'SDH';
eof;

mysqli_query($con, $query);


// Handle North
$file = fopen('todayNorth.csv', 'r');
$meal = 1;
$location = 'North';

while (($line = fgetcsv($file)) !== FALSE){
	// Grab values from CSV
	$food_name  = $line[0];
	$food_serv  = $line[1];
	$food_cals  = $line[2];
	$food_fat   = $line[3];
	$food_carbs = $line[4];
	$food_sugar = $line[5];
	$food_prot  = $line[6];

	// Check if we've reached a delimiter to change meal
	if($food_name === '-'){
		$meal = $meal + 1;
	}

	// Nutritional Yeast is dumb. Why is it on the website? Let's skip it.
	elseif($food_name === 'Nutritional Yeast'){
		continue;
	}

	// Catches non-int fields
	if($food_cals == "< 1"){
		$food_cals = 0;
	}
	if($food_fat == "< 1"){
		$food_fat = 0;
	}
	if($food_carbs == "< 1"){
		$food_carbs = 0;
	}
	if($food_sugar == "< 1"){
		$food_sugar = 0;
	}
	if($food_prot == "< 1"){
		$food_prot = 0;
	}


	// If meal = 1, insert breakfast foods
	elseif($meal == 1){
		// Check if the food has already been added
		$check_query = mysqli_prepare($con, "SELECT count(food_name) FROM food_item WHERE MEAL_TIME = 'B' AND food_name = ?");
		mysqli_stmt_bind_param($check_query, "s", $food_name);
		mysqli_stmt_execute($check_query);
		mysqli_stmt_bind_result($check_query, $result);
		mysqli_stmt_fetch($check_query);
		mysqli_stmt_close($check_query);

		// If result = 0, food is not in the database. Add it with is_offered = 1!
		if ($result == 0){
			$query = "INSERT INTO food_item (food_name, serving_size, calories, fat, carbs, sugar, protein, meal_time, sourced_from, is_offered) VALUES ('$food_name', '$food_serv', $food_cals, $food_fat, $food_carbs, $food_sugar, $food_prot, 'B', 'NDH', 1);";
			if (mysqli_query($con, $query)){
				echo "Record update successfully";
			} else {
				echo "Error updating record: " . mysqli_error($con) . "\n";
			}
		}

		// If result != 0, the food is in the database. Update is_offered to 1!
		else{
			$update_query = mysqli_prepare($con, "UPDATE food_item SET is_offered = 1 WHERE food_name = ? AND meal_time = 'B' AND sourced_from = 'NDH'");
			mysqli_stmt_bind_param($update_query, "s", $food_name);		
			mysqli_stmt_execute($update_query);
			mysqli_stmt_close($update_query);
		}
	}

	// If meal = 2, insert lunch foods
	elseif($meal == 2){
		// Check if the food has already been added
		$check_query = mysqli_prepare($con, "SELECT count(food_name) FROM food_item WHERE MEAL_TIME = 'L' AND food_name = ? AND sourced_from = 'NDH'");
		mysqli_stmt_bind_param($check_query, "s", $food_name);
		mysqli_stmt_execute($check_query);
		mysqli_stmt_bind_result($check_query, $result);
		mysqli_stmt_fetch($check_query);
		mysqli_stmt_close($check_query);

		// If result = 0, food is not in the database. Add it with is_offered = 1!
		if ($result == 0){
			$query = "INSERT INTO food_item (food_name, serving_size, calories, fat, carbs, sugar, protein, meal_time, sourced_from, is_offered) VALUES ('$food_name', '$food_serv', $food_cals, $food_fat, $food_carbs, $food_sugar, $food_prot, 'L', 'NDH', 1);";
			mysqli_query($con, $query);
		}

		// If result != 0, the food is in the database. Update is_offered to 1!
		else{
			$update_query = mysqli_prepare($con, "UPDATE food_item SET is_offered = 1 WHERE food_name = ? AND meal_time = 'L' AND sourced_from = 'NDH'");
			mysqli_stmt_bind_param($update_query, "s", $food_name);		
			mysqli_stmt_execute($update_query);
			mysqli_stmt_close($update_query);
		}
	}
	
	// If meal = 3, insert dinner foods
	elseif($meal == 3){
		// Check if the food has already been added
		$check_query = mysqli_prepare($con, "SELECT count(food_name) FROM food_item WHERE MEAL_TIME = 'D' AND food_name = ? AND sourced_from = 'NDH'");
		mysqli_stmt_bind_param($check_query, "s", $food_name);
		mysqli_stmt_execute($check_query);
		mysqli_stmt_bind_result($check_query, $result);
		mysqli_stmt_fetch($check_query);
		mysqli_stmt_close($check_query);

		// If result = 0, food is not in the database. Add it with is_offered = 1!
		if ($result == 0){
			$query = "INSERT INTO food_item (food_name, serving_size, calories, fat, carbs, sugar, protein, meal_time, sourced_from, is_offered) VALUES ('$food_name', '$food_serv', $food_cals, $food_fat, $food_carbs, $food_sugar, $food_prot, 'D', 'NDH', 1);";
			mysqli_query($con, $query);
		}

		// If result != 0, the food is in the database. Update is_offered to 1!
		else{
			$update_query = mysqli_prepare($con, "UPDATE food_item SET is_offered = 1 WHERE food_name = ? AND meal_time = 'D' AND sourced_from = 'NDH'");
			mysqli_stmt_bind_param($update_query, "s", $food_name);		
			mysqli_stmt_execute($update_query);
			mysqli_stmt_close($update_query);
		}
	} 
}
fclose($file);

// Handle South 
$file = fopen('todaySouth.csv', 'r');
$meal = 1;
$location = 'South';

while (($line = fgetcsv($file)) !== FALSE){
	// Grab values from CSV
	$food_name  = $line[0];
	$food_serv  = $line[1];
	$food_cals  = $line[2];
	$food_fat   = $line[3];
	$food_carbs = $line[4];
	$food_sugar = $line[5];
	$food_prot  = $line[6];

	// Check if we've reached a delimiter to change meal
	if($food_name === '-'){
		$meal = $meal + 1;
	}

	elseif($food_name === 'Nutritional Yeast'){
		continue;
	}

	// Catches non-int fields
	if($food_cals == "< 1"){
		$food_cals = 0;
	}
	if($food_fat == "< 1"){
		$food_fat = 0;
	}
	if($food_carbs == "< 1"){
		$food_carbs = 0;
	}
	if($food_sugar == "< 1"){
		$food_sugar = 0;
	}
	if($food_prot == "< 1"){
		$food_prot = 0;
	}

	// If meal = 1, insert breakfast foods
	elseif($meal == 1){
		// Check if the food has already been added
		$check_query = mysqli_prepare($con, "SELECT count(food_name) FROM food_item WHERE MEAL_TIME = 'B' AND food_name = ? AND sourced_from = 'SDH'");
		mysqli_stmt_bind_param($check_query, "s", $food_name);
		mysqli_stmt_execute($check_query);
		mysqli_stmt_bind_result($check_query, $result);
		mysqli_stmt_fetch($check_query);
		mysqli_stmt_close($check_query);

		// If result = 0, the food is not in the database. Add it!
		if ($result == 0){
			$query = "INSERT INTO food_item (food_name, serving_size, calories, fat, carbs, sugar, protein, meal_time, sourced_from, is_offered) VALUES ('$food_name', '$food_serv', $food_cals, $food_fat, $food_carbs, $food_sugar, $food_prot, 'B', 'SDH', 1);";
			mysqli_query($con, $query);
		}

		// If result != 0, the food is in the database. Update is_offered to 1!
		else{
			$update_query = mysqli_prepare($con, "UPDATE food_item SET is_offered = 1 WHERE food_name = ? AND meal_time = 'B' AND sourced_from = 'SDH'");
			mysqli_stmt_bind_param($update_query, "s", $food_name);		
			mysqli_stmt_execute($update_query);
			mysqli_stmt_close($update_query);
		}
	}

	// If meal = 2, insert lunch foods
	elseif($meal == 2){
		// Check if the food has already been added
		$check_query = mysqli_prepare($con, "SELECT count(food_name) FROM food_item WHERE MEAL_TIME = 'L' AND food_name = ? AND sourced_from = 'SDH'");
		mysqli_stmt_bind_param($check_query, "s", $food_name);
		mysqli_stmt_execute($check_query);
		mysqli_stmt_bind_result($check_query, $result);
		mysqli_stmt_fetch($check_query);
		mysqli_stmt_close($check_query);

		// If result = 0, food is not in the database. Add it with is_offered = 1!
		if ($result == 0){
			$query = "INSERT INTO food_item (food_name, serving_size, calories, fat, carbs, sugar, protein, meal_time, sourced_from, is_offered) VALUES ('$food_name', '$food_serv', $food_cals, $food_fat, $food_carbs, $food_sugar, $food_prot, 'L', 'SDH', 1);";
			mysqli_query($con, $query);
		}

		// If result != 0, the food is in the database. Update is_offered to 1!
		else{
			$update_query = mysqli_prepare($con, "UPDATE food_item SET is_offered = 1 WHERE food_name = ? AND meal_time = 'L' AND sourced_from = 'SDH'");
			mysqli_stmt_bind_param($update_query, "s", $food_name);		
			mysqli_stmt_execute($update_query);
			mysqli_stmt_close($update_query);
		}

	}
	
	// If meal = 3, insert dinner foods
	elseif($meal == 3){
		// Check if the food has already been added
		$check_query = mysqli_prepare($con, "SELECT count(food_name) FROM food_item WHERE MEAL_TIME = 'D' AND food_name = ? AND sourced_from = 'SDH'");
		mysqli_stmt_bind_param($check_query, "s", $food_name);
		mysqli_stmt_execute($check_query);
		mysqli_stmt_bind_result($check_query, $result);
		mysqli_stmt_fetch($check_query);
		mysqli_stmt_close($check_query);

		// If result = 0, food is not in the database. Add it with is_offered = 1!
		if ($result == 0){
			$query = "INSERT INTO food_item (food_name, serving_size, calories, fat, carbs, sugar, protein, meal_time, sourced_from, is_offered) VALUES ('$food_name', '$food_serv', $food_cals, $food_fat, $food_carbs, $food_sugar, $food_prot, 'D', 'SDH', 1);";
			mysqli_query($con, $query);
		}

		// If result != 0, the food is in the database. Update is_offered to 1!
		else{
			$update_query = mysqli_prepare($con, "UPDATE food_item SET is_offered = 1 WHERE food_name = ? AND meal_time = 'D' AND sourced_from = 'SDH'");
			mysqli_stmt_bind_param($update_query, "s", $food_name);		
			mysqli_stmt_execute($update_query);
			mysqli_stmt_close($update_query);
		}

	}
}
fclose($file);
?>

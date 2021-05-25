<?php include('connect.php') ?>
<?php

session_start();
$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
//date_default_timezone_set("America/New_York");
//$date = date('m/d/Y');

// Handle offset parameter
if (isset($_GET['offset'])){
	$offset = $_GET['offset'];
}
else{
	$offset = 0;
}

// Create new breakfast
if(isset($_POST['breakfast-submit'])){
	// If individual foods are selected
	if (isset($_POST['food'])){
		$foods = $_POST['food'];
		// Check if a meal has been created
		$check_breakfast = mysqli_prepare($con, "SELECT meal_id FROM meal WHERE meal_type = 'B' AND user_id = ? AND meal_date = CURDATE() - INTERVAL ? DAY");
		mysqli_stmt_bind_param($check_breakfast, "ii", $user_id, $offset);
		mysqli_stmt_execute($check_breakfast);
		mysqli_stmt_bind_result($check_breakfast, $meal_id);
		mysqli_stmt_fetch($check_breakfast);
		mysqli_stmt_close($check_breakfast);
		
		// Create new meal if one is not created
		if($meal_id == 0){
			$create_meal = mysqli_prepare($con, "INSERT INTO meal VALUES (NULL, ?, CURDATE() - INTERVAL ? DAY, 'B', NULL)");
			mysqli_stmt_bind_param($create_meal, "ii", $user_id, $offset);
			mysqli_stmt_execute($create_meal);
			$meal_id = mysqli_insert_id($con);
			mysqli_stmt_close($create_meal);	
		}

		// Add food items to meal_item
		foreach($foods as $food_id){
			// Get serving info
			$servings_string = 'servings-' . $food_id;
			$servings = mysqli_real_escape_string($con, $_POST[$servings_string]);
			$insert_food = mysqli_prepare($con, "INSERT INTO meal_item (food_id, meal_id, servings) VALUES (?, ?, ?)");
			mysqli_stmt_bind_param($insert_food, "iii", $food_id, $meal_id, intval($servings));
			mysqli_stmt_execute($insert_food);
			mysqli_stmt_close($insert_food);
		}
	}

	// If a presaved meal is selected
	elseif(isset($_POST['presave-select'])){
		$meal_name = mysqli_real_escape_string($con, $_POST['presave-select']);
		//echo"<script>alert(".$meal_name.")</script>";
		$check_breakfast = mysqli_prepare($con, "SELECT meal_id FROM meal WHERE meal_type = 'B' AND user_id = ? AND meal_date = CURDATE() - INTERVAL ? DAY");
		mysqli_stmt_bind_param($check_breakfast, "ii", $user_id, $offset);
		mysqli_stmt_execute($check_breakfast);
		mysqli_stmt_bind_result($check_breakfast, $meal_id);
		mysqli_stmt_fetch($check_breakfast);
		mysqli_stmt_close($check_breakfast);
		
		if($meal_id == 0){
			$create_meal = mysqli_prepare($con, "INSERT INTO meal VALUES (NULL, ?, CURDATE() - INTERVAL ? DAY, 'B', NULL)");
			mysqli_stmt_bind_param($create_meal, "ii", $user_id, $offset);
			mysqli_stmt_execute($create_meal);
			$meal_id = mysqli_insert_id($con);
			mysqli_stmt_close($create_meal);	
		}
	 
		$load_presave = mysqli_prepare($con, "INSERT INTO meal_item SELECT food_id, ?, servings FROM meal_item, (SELECT meal_id as id FROM meal WHERE meal_name = ?)A WHERE meal_item.meal_id = A.id");
		mysqli_stmt_bind_param($load_presave, "is", $meal_id, $meal_name);
		mysqli_stmt_execute($load_presave);
		mysqli_stmt_close($load_presave);
	}

	// If nothing is selected
	else{
		echo"<script>alert('You must select one or more foods.')</script>";
	}
}

if (isset($_POST['breakfast-save'])){
	// Grab today's breakfast meal_id
	$get_id = mysqli_prepare($con, "SELECT meal_id FROM meal WHERE meal_type = 'B' AND user_id = ? AND meal_date = CURDATE() - INTERVAL ? DAY");
	mysqli_stmt_bind_param($get_id, "ii", $user_id, $offset);
	mysqli_stmt_execute($get_id);
	mysqli_stmt_bind_result($get_id, $meal_id);	
	mysqli_stmt_fetch($get_id);
	mysqli_stmt_close($get_id);

	// If no meal, prompt the user they cannot save an empty meal
	if($meal_id == 0){
		echo"<script>alert('You cannot save an empty meal!')</script>";	
	}

	// Otherwise, update the meal name for a presaved meal
	else{
		$name = mysqli_real_escape_string($con, $_POST['breakfast-name']);
		if (empty($name)){
			echo"<script>alert('Meal names cannot be empty!')</script>";	
		}
		else{
			$save_meal = mysqli_prepare($con, "UPDATE meal SET meal_name = ? WHERE meal_id = ?");
			mysqli_stmt_bind_param($save_meal, "si", $name, $meal_id);
			mysqli_stmt_execute($save_meal);
			mysqli_stmt_close($save_meal);
		}			
	}
}

// Add Lunch Meal
if(isset($_POST['lunch-submit'])){
	// If individual foods are selected
	if (isset($_POST['food'])){
		$foods = $_POST['food'];
		// Check if a meal has been created
		$check_lunch = mysqli_prepare($con, "SELECT meal_id FROM meal WHERE meal_type = 'L' AND user_id = ? AND meal_date = CURDATE() - INTERVAL ? DAY");
		mysqli_stmt_bind_param($check_lunch, "ii", $user_id, $offset);
		mysqli_stmt_execute($check_lunch);
		mysqli_stmt_bind_result($check_lunch, $meal_id);
		mysqli_stmt_fetch($check_lunch);
		mysqli_stmt_close($check_lunch);
		
		// Create new meal if one is not created
		if($meal_id == 0){
			$create_meal = mysqli_prepare($con, "INSERT INTO meal VALUES (NULL, ?, CURDATE() - INTERVAL ? DAY, 'L', NULL)");
			mysqli_stmt_bind_param($create_meal, "ii", $user_id, $offset);
			mysqli_stmt_execute($create_meal);
			$meal_id = mysqli_insert_id($con);
			mysqli_stmt_close($create_meal);	
		}

		// Add food items to meal_item
		foreach($foods as $food_id){
			// Get serving info
			$servings_string = 'servings-' . $food_id;
			$servings = mysqli_real_escape_string($con, $_POST[$servings_string]);
			$insert_food = mysqli_prepare($con, "INSERT INTO meal_item (food_id, meal_id, servings) VALUES (?, ?, ?)");
			mysqli_stmt_bind_param($insert_food, "iii", $food_id, $meal_id, intval($servings));
			mysqli_stmt_execute($insert_food);
			mysqli_stmt_close($insert_food);
		}
	}

	// If a presaved meal is selected
	elseif(isset($_POST['presave-select'])){
		$meal_name = mysqli_real_escape_string($con, $_POST['presave-select']);
		//echo"<script>alert(".$meal_name.")</script>";
		$check_lunch = mysqli_prepare($con, "SELECT meal_id FROM meal WHERE meal_type = 'L' AND user_id = ? AND meal_date = CURDATE() - INTERVAL ? DAY");
		mysqli_stmt_bind_param($check_lunch, "ii", $user_id, $offset);
		mysqli_stmt_execute($check_lunch);
		mysqli_stmt_bind_result($check_lunch, $meal_id);
		mysqli_stmt_fetch($check_lunch);
		mysqli_stmt_close($check_lunch);
		
		if($meal_id == 0){
			$create_meal = mysqli_prepare($con, "INSERT INTO meal VALUES (NULL, ?, CURDATE() - INTERVAL ? DAY, 'L', NULL)");
			mysqli_stmt_bind_param($create_meal, "ii", $user_id, $offset);
			mysqli_stmt_execute($create_meal);
			$meal_id = mysqli_insert_id($con);
			mysqli_stmt_close($create_meal);	
		}
	 
		$load_presave = mysqli_prepare($con, "INSERT INTO meal_item SELECT food_id, ?, servings FROM meal_item, (SELECT meal_id as id FROM meal WHERE meal_name = ?)A WHERE meal_item.meal_id = A.id");
		mysqli_stmt_bind_param($load_presave, "is", $meal_id, $meal_name);
		mysqli_stmt_execute($load_presave);
		mysqli_stmt_close($load_presave);
	}

	// If nothing is selected
	else{
		echo"<script>alert('You must select one or more foods.')</script>";
	}
}

// Save Lunch Meal
if (isset($_POST['lunch-save'])){
	// Grab today's lunch meal_id
	$get_id = mysqli_prepare($con, "SELECT meal_id FROM meal WHERE meal_type = 'L' AND user_id = ? AND meal_date = CURDATE() - INTERVAL ? DAY");
	mysqli_stmt_bind_param($get_id, "ii", $user_id, $offset);
	mysqli_stmt_execute($get_id);
	mysqli_stmt_bind_result($get_id, $meal_id);	
	mysqli_stmt_fetch($get_id);
	mysqli_stmt_close($get_id);

	// If no meal, prompt the user they cannot save an empty meal
	if($meal_id == 0){
		echo"<script>alert('You cannot save an empty meal!')</script>";	
	}

	// Otherwise, update the meal name for a presaved meal
	else{
		$name = mysqli_real_escape_string($con, $_POST['lunch-name']);
		if (empty($name)){
			echo"<script>alert('Meal names cannot be empty!')</script>";	
		}
		else{
			$save_meal = mysqli_prepare($con, "UPDATE meal SET meal_name = ? WHERE meal_id = ?");
			mysqli_stmt_bind_param($save_meal, "si", $name, $meal_id);
			mysqli_stmt_execute($save_meal);
			mysqli_stmt_close($save_meal);
		}			
	}
}

// Add Dinner Meal
if(isset($_POST['dinner-submit'])){
	// If individual foods are selected
	if (isset($_POST['food'])){
		$foods = $_POST['food'];
		// Check if a meal has been created
		$check_dinner = mysqli_prepare($con, "SELECT meal_id FROM meal WHERE meal_type = 'D' AND user_id = ? AND meal_date = CURDATE() - INTERVAL ? DAY");
		mysqli_stmt_bind_param($check_dinner, "ii", $user_id, $offset);
		mysqli_stmt_execute($check_dinner);
		mysqli_stmt_bind_result($check_dinner, $meal_id);
		mysqli_stmt_fetch($check_dinner);
		mysqli_stmt_close($check_dinner);
		
		// Create new meal if one is not created
		if($meal_id == 0){
			$create_meal = mysqli_prepare($con, "INSERT INTO meal VALUES (NULL, ?, CURDATE() - INTERVAL ? DAY, 'D', NULL)");
			mysqli_stmt_bind_param($create_meal, "ii", $user_id, $offset);
			mysqli_stmt_execute($create_meal);
			$meal_id = mysqli_insert_id($con);
			mysqli_stmt_close($create_meal);	
		}

		// Add food items to meal_item
		foreach($foods as $food_id){
			// Get serving info
			$servings_string = 'servings-' . $food_id;
			$servings = mysqli_real_escape_string($con, $_POST[$servings_string]);
			$insert_food = mysqli_prepare($con, "INSERT INTO meal_item (food_id, meal_id, servings) VALUES (?, ?, ?)");
			mysqli_stmt_bind_param($insert_food, "iii", $food_id, $meal_id, intval($servings));
			mysqli_stmt_execute($insert_food);
			mysqli_stmt_close($insert_food);
		}
	}

	// If a presaved meal is selected
	elseif(isset($_POST['presave-select'])){
		$meal_name = mysqli_real_escape_string($con, $_POST['presave-select']);
		//echo"<script>alert(".$meal_name.")</script>";
		$check_dinner = mysqli_prepare($con, "SELECT meal_id FROM meal WHERE meal_type = 'D' AND user_id = ? AND meal_date = CURDATE() - INTERVAL ? DAY");
		mysqli_stmt_bind_param($check_dinner, "ii", $user_id, $offset);
		mysqli_stmt_execute($check_dinner);
		mysqli_stmt_bind_result($check_dinner, $meal_id);
		mysqli_stmt_fetch($check_dinner);
		mysqli_stmt_close($check_dinner);
		
		if($meal_id == 0){
			$create_meal = mysqli_prepare($con, "INSERT INTO meal VALUES (NULL, ?, CURDATE() - INTERVAL ? DAY, 'D', NULL)");
			mysqli_stmt_bind_param($create_meal, "ii", $user_id, $offset);
			mysqli_stmt_execute($create_meal);
			$meal_id = mysqli_insert_id($con);
			mysqli_stmt_close($create_meal);	
		}
	 
		$load_presave = mysqli_prepare($con, "INSERT INTO meal_item SELECT food_id, ?, servings FROM meal_item, (SELECT meal_id as id FROM meal WHERE meal_name = ?)A WHERE meal_item.meal_id = A.id");
		mysqli_stmt_bind_param($load_presave, "is", $meal_id, $meal_name);
		mysqli_stmt_execute($load_presave);
		mysqli_stmt_close($load_presave);
	}

	// If nothing is selected
	else{
		echo"<script>alert('You must select one or more foods.')</script>";
	}
}

// Save Dinner 
if (isset($_POST['dinner-save'])){
	// Grab today's breakfast meal_id
	$get_id = mysqli_prepare($con, "SELECT meal_id FROM meal WHERE meal_type = 'D' AND user_id = ? AND meal_date = CURDATE() - INTERVAL ? DAY");
	mysqli_stmt_bind_param($get_id, "ii", $user_id, $offset);
	mysqli_stmt_execute($get_id);
	mysqli_stmt_bind_result($get_id, $meal_id);	
	mysqli_stmt_fetch($get_id);
	mysqli_stmt_close($get_id);

	// If no meal, prompt the user they cannot save an empty meal
	if($meal_id == 0){
		echo"<script>alert('You cannot save an empty meal!')</script>";	
	}

	// Otherwise, update the meal name for a presaved meal
	else{
		$name = mysqli_real_escape_string($con, $_POST['dinner-name']);
		if (empty($name)){
			echo"<script>alert('Meal names cannot be empty!')</script>";	
		}
		else{
			$save_meal = mysqli_prepare($con, "UPDATE meal SET meal_name = ? WHERE meal_id = ?");
			mysqli_stmt_bind_param($save_meal, "si", $name, $meal_id);
			mysqli_stmt_execute($save_meal);
			mysqli_stmt_close($save_meal);
		}			
	}
}

// Add a Custom Food to meal and save to food_item with user_id as location
if (isset($_POST['custom-breakfast-add'])){
	// Data Grab
	$name = mysqli_real_escape_string($con, $_POST['custom-name']);	
	$cals = mysqli_real_escape_string($con, $_POST['custom-cals']);	
	$prot = mysqli_real_escape_string($con, $_POST['custom-protein']);	
	$carb = mysqli_real_escape_string($con, $_POST['custom-carbs']);	
	$fats = mysqli_real_escape_string($con, $_POST['custom-fat']);	
	$sgrs = mysqli_real_escape_string($con, $_POST['custom-sugar']);

	// Input Error Checking
	if (empty($name)){
		echo"<script>alert('You must enter a name!')</script>";
	}
	if (empty($cals)){
		$cals = 0;
	}
	if (empty($prot)){
		$prot = 0;
	}
	if (empty($carb)){
		$carb = 0;
	}
	if (empty($fats)){
		$fats = 0;
	}
	if (empty($sgrs)){
		$sgrs = 0;
	}
	
	// Add food to food_item
	$add_food_query = mysqli_prepare($con, "INSERT INTO food_item (food_name, calories, protein, carbs, fat, sourced_from, meal_time, is_offered, sugar, serving_size) VALUES (?, ?, ?, ?, ?, ?, 'C', 1, ?, 'One')");
	mysqli_stmt_bind_param($add_food_query, "siiiisi", $name, $cals, $prot, $carb, $fats, $username, $sgrs);
	mysqli_stmt_execute($add_food_query);
	$food_id = mysqli_insert_id($con);
	$error = mysqli_stmt_error($add_food_query);
	mysqli_stmt_close($add_food_query);

	// Add food to meal_item / create new meal
	$check_dinner = mysqli_prepare($con, "SELECT meal_id FROM meal WHERE meal_type = 'B' AND user_id = ? AND meal_date = CURDATE() - INTERVAL ? DAY");
	mysqli_stmt_bind_param($check_dinner, "ii", $user_id, $offset);
	mysqli_stmt_execute($check_dinner);
	mysqli_stmt_bind_result($check_dinner, $meal_id);
	mysqli_stmt_fetch($check_dinner);
	mysqli_stmt_close($check_dinner);
		
	// Create new meal if one is not created
	if($meal_id == 0){
		$create_meal = mysqli_prepare($con, "INSERT INTO meal VALUES (NULL, ?, CURDATE() - INTERVAL ? DAY, 'B', NULL)");
		mysqli_stmt_bind_param($create_meal, "ii", $user_id, $offset);
		mysqli_stmt_execute($create_meal);
		$meal_id = mysqli_insert_id($con);
		mysqli_stmt_close($create_meal);	
	}
	
	$insert_food = mysqli_prepare($con, "INSERT INTO meal_item VALUES (?, ?, 1)");
	mysqli_stmt_bind_param($insert_food, "ii", $food_id, $meal_id);
	mysqli_stmt_execute($insert_food);
	mysqli_stmt_close($insert_food);	
}

if (isset($_POST['custom-lunch-add'])){
	// Data Grab
	$name = mysqli_real_escape_string($con, $_POST['custom-name']);	
	$cals = mysqli_real_escape_string($con, $_POST['custom-cals']);	
	$prot = mysqli_real_escape_string($con, $_POST['custom-protein']);	
	$carb = mysqli_real_escape_string($con, $_POST['custom-carbs']);	
	$fats = mysqli_real_escape_string($con, $_POST['custom-fat']);	
	$sgrs = mysqli_real_escape_string($con, $_POST['custom-sugar']);

	// Input Error Checking
	if (empty($name)){
		echo"<script>alert('You must enter a name!')</script>";
	}
	if (empty($cals)){
		$cals = 0;
	}
	if (empty($prot)){
		$prot = 0;
	}
	if (empty($carb)){
		$carb = 0;
	}
	if (empty($fats)){
		$fats = 0;
	}
	if (empty($sgrs)){
		$sgrs = 0;
	}
	
	// Add food to food_item
	$add_food_query = mysqli_prepare($con, "INSERT INTO food_item (food_name, calories, protein, carbs, fat, sourced_from, meal_time, is_offered, sugar, serving_size) VALUES (?, ?, ?, ?, ?, ?, 'C', 1, ?, 'One')");
	mysqli_stmt_bind_param($add_food_query, "siiiisi", $name, $cals, $prot, $carb, $fats, $username, $sgrs);
	mysqli_stmt_execute($add_food_query);
	$food_id = mysqli_insert_id($con);
	$error = mysqli_stmt_error($add_food_query);
	mysqli_stmt_close($add_food_query);

	// Add food to meal_item / create new meal
	$check_dinner = mysqli_prepare($con, "SELECT meal_id FROM meal WHERE meal_type = 'L' AND user_id = ? AND meal_date = CURDATE() - INTERVAL ? DAY");
	mysqli_stmt_bind_param($check_dinner, "ii", $user_id, $offset);
	mysqli_stmt_execute($check_dinner);
	mysqli_stmt_bind_result($check_dinner, $meal_id);
	mysqli_stmt_fetch($check_dinner);
	mysqli_stmt_close($check_dinner);
		
	// Create new meal if one is not created
	if($meal_id == 0){
		$create_meal = mysqli_prepare($con, "INSERT INTO meal VALUES (NULL, ?, CURDATE() - INTERVAL ? DAY, 'L', NULL)");
		mysqli_stmt_bind_param($create_meal, "ii", $user_id, $offset);
		mysqli_stmt_execute($create_meal);
		$meal_id = mysqli_insert_id($con);
		mysqli_stmt_close($create_meal);	
	}
	
	$insert_food = mysqli_prepare($con, "INSERT INTO meal_item VALUES (?, ?, 1)");
	mysqli_stmt_bind_param($insert_food, "ii", $food_id, $meal_id);
	mysqli_stmt_execute($insert_food);
	mysqli_stmt_close($insert_food);	
}

if (isset($_POST['custom-dinner-add'])){
	// Data Grab
	$name = mysqli_real_escape_string($con, $_POST['custom-name']);	
	$cals = mysqli_real_escape_string($con, $_POST['custom-cals']);	
	$prot = mysqli_real_escape_string($con, $_POST['custom-protein']);	
	$carb = mysqli_real_escape_string($con, $_POST['custom-carbs']);	
	$fats = mysqli_real_escape_string($con, $_POST['custom-fat']);	
	$sgrs = mysqli_real_escape_string($con, $_POST['custom-sugar']);

	// Input Error Checking
	if (empty($name)){
		echo"<script>alert('You must enter a name!')</script>";
	}
	if (empty($cals)){
		$cals = 0;
	}
	if (empty($prot)){
		$prot = 0;
	}
	if (empty($carb)){
		$carb = 0;
	}
	if (empty($fats)){
		$fats = 0;
	}
	if (empty($sgrs)){
		$sgrs = 0;
	}
	
	// Add food to food_item
	$add_food_query = mysqli_prepare($con, "INSERT INTO food_item (food_name, calories, protein, carbs, fat, sourced_from, meal_time, is_offered, sugar, serving_size) VALUES (?, ?, ?, ?, ?, ?, 'C', 1, ?, 'One')");
	mysqli_stmt_bind_param($add_food_query, "siiiisi", $name, $cals, $prot, $carb, $fats, $username, $sgrs);
	mysqli_stmt_execute($add_food_query);
	$food_id = mysqli_insert_id($con);
	$error = mysqli_stmt_error($add_food_query);
	mysqli_stmt_close($add_food_query);

	// Add food to meal_item / create new meal
	$check_dinner = mysqli_prepare($con, "SELECT meal_id FROM meal WHERE meal_type = 'D' AND user_id = ? AND meal_date = CURDATE() - INTERVAL ? DAY");
	mysqli_stmt_bind_param($check_dinner, "ii", $user_id, $offset);
	mysqli_stmt_execute($check_dinner);
	mysqli_stmt_bind_result($check_dinner, $meal_id);
	mysqli_stmt_fetch($check_dinner);
	mysqli_stmt_close($check_dinner);
		
	// Create new meal if one is not created
	if($meal_id == 0){
		$create_meal = mysqli_prepare($con, "INSERT INTO meal VALUES (NULL, ?, CURDATE() - INTERVAL ? DAY, 'D', NULL)");
		mysqli_stmt_bind_param($create_meal, "ii", $user_id, $offset);
		mysqli_stmt_execute($create_meal);
		$meal_id = mysqli_insert_id($con);
		mysqli_stmt_close($create_meal);	
	}
	
	$insert_food = mysqli_prepare($con, "INSERT INTO meal_item VALUES (?, ?, 1)");
	mysqli_stmt_bind_param($insert_food, "ii", $food_id, $meal_id);
	mysqli_stmt_execute($insert_food);
	mysqli_stmt_close($insert_food);	
}

if (isset($_POST['custom-snack-add'])){
	// Data Grab
	$name = mysqli_real_escape_string($con, $_POST['custom-name']);	
	$cals = mysqli_real_escape_string($con, $_POST['custom-cals']);	
	$prot = mysqli_real_escape_string($con, $_POST['custom-protein']);	
	$carb = mysqli_real_escape_string($con, $_POST['custom-carbs']);	
	$fats = mysqli_real_escape_string($con, $_POST['custom-fat']);	
	$sgrs = mysqli_real_escape_string($con, $_POST['custom-sugar']);

	// Input Error Checking
	if (empty($name)){
		echo"<script>alert('You must enter a name!')</script>";
	}
	if (empty($cals)){
		$cals = 0;
	}
	if (empty($prot)){
		$prot = 0;
	}
	if (empty($carb)){
		$carb = 0;
	}
	if (empty($fats)){
		$fats = 0;
	}
	if (empty($sgrs)){
		$sgrs = 0;
	}
	
	// Add food to food_item
	$add_food_query = mysqli_prepare($con, "INSERT INTO food_item (food_name, calories, protein, carbs, fat, sourced_from, meal_time, is_offered, sugar, serving_size) VALUES (?, ?, ?, ?, ?, ?, 'C', 1, ?, 'One')");
	mysqli_stmt_bind_param($add_food_query, "siiiisi", $name, $cals, $prot, $carb, $fats, $username, $sgrs);
	mysqli_stmt_execute($add_food_query);
	$food_id = mysqli_insert_id($con);
	$error = mysqli_stmt_error($add_food_query);
	mysqli_stmt_close($add_food_query);

	// Add food to meal_item / create new meal
	$check_dinner = mysqli_prepare($con, "SELECT meal_id FROM meal WHERE meal_type = 'S' AND user_id = ? AND meal_date = CURDATE() - INTERVAL ? DAY");
	mysqli_stmt_bind_param($check_dinner, "ii", $user_id, $offset);
	mysqli_stmt_execute($check_dinner);
	mysqli_stmt_bind_result($check_dinner, $meal_id);
	mysqli_stmt_fetch($check_dinner);
	mysqli_stmt_close($check_dinner);
		
	// Create new meal if one is not created
	if($meal_id == 0){
		$create_meal = mysqli_prepare($con, "INSERT INTO meal VALUES (NULL, ?, CURDATE() - INTERVAL ? DAY, 'S', NULL)");
		mysqli_stmt_bind_param($create_meal, "ii", $user_id, $offset);
		mysqli_stmt_execute($create_meal);
		$meal_id = mysqli_insert_id($con);
		mysqli_stmt_close($create_meal);	
	}
	
	$insert_food = mysqli_prepare($con, "INSERT INTO meal_item VALUES (?, ?, 1)");
	mysqli_stmt_bind_param($insert_food, "ii", $food_id, $meal_id);
	mysqli_stmt_execute($insert_food);
	mysqli_stmt_close($insert_food);	
}

if (isset($_POST['custom-dinner-add'])){
	// Data Grab
	$name = mysqli_real_escape_string($con, $_POST['custom-name']);	
	$cals = mysqli_real_escape_string($con, $_POST['custom-cals']);	
	$prot = mysqli_real_escape_string($con, $_POST['custom-protein']);	
	$carb = mysqli_real_escape_string($con, $_POST['custom-carbs']);	
	$fats = mysqli_real_escape_string($con, $_POST['custom-fat']);	
	$sgrs = mysqli_real_escape_string($con, $_POST['custom-sugar']);

	// Input Error Checking
	if (empty($name)){
		echo"<script>alert('You must enter a name!')</script>";
	}
	if (empty($cals)){
		$cals = 0;
	}
	if (empty($prot)){
		$prot = 0;
	}
	if (empty($carb)){
		$carb = 0;
	}
	if (empty($fats)){
		$fats = 0;
	}
	if (empty($sgrs)){
		$sgrs = 0;
	}
	
	// Add food to food_item
	$add_food_query = mysqli_prepare($con, "INSERT INTO food_item (food_name, calories, protein, carbs, fat, sourced_from, meal_time, is_offered, sugar, serving_size) VALUES (?, ?, ?, ?, ?, ?, 'C', 1, ?, 'One')");
	mysqli_stmt_bind_param($add_food_query, "siiiisi", $name, $cals, $prot, $carb, $fats, $username, $sgrs);
	mysqli_stmt_execute($add_food_query);
	$food_id = mysqli_insert_id($con);
	$error = mysqli_stmt_error($add_food_query);
	mysqli_stmt_close($add_food_query);

	// Add food to meal_item / create new meal
	$check_dinner = mysqli_prepare($con, "SELECT meal_id FROM meal WHERE meal_type = 'D' AND user_id = ? AND meal_date = CURDATE() - INTERVAL ? DAY");
	mysqli_stmt_bind_param($check_dinner, "ii", $user_id, $offset);
	mysqli_stmt_execute($check_dinner);
	mysqli_stmt_bind_result($check_dinner, $meal_id);
	mysqli_stmt_fetch($check_dinner);
	mysqli_stmt_close($check_dinner);
		
	// Create new meal if one is not created
	if($meal_id == 0){
		$create_meal = mysqli_prepare($con, "INSERT INTO meal VALUES (NULL, ?, CURDATE() - INTERVAL ? DAY, 'D', NULL)");
		mysqli_stmt_bind_param($create_meal, "ii", $user_id, $offset);
		mysqli_stmt_execute($create_meal);
		$meal_id = mysqli_insert_id($con);
		mysqli_stmt_close($create_meal);	
	}
	
	$insert_food = mysqli_prepare($con, "INSERT INTO meal_item VALUES (?, ?, 1)");
	mysqli_stmt_bind_param($insert_food, "ii", $food_id, $meal_id);
	mysqli_stmt_execute($insert_food);
	mysqli_stmt_close($insert_food);	
}
?>

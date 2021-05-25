<?php include('connect.php') ?>
<?php

session_start();
// Display Dining Hall Options
if(isset($_GET['location']) && isset($_GET['meal']) && ($_GET['location'] == 'NDH' || $_GET['location'] == 'SDH')){
	// Get URL parameters
	$meal = $_GET['meal'];
	$location = $_GET['location'];

	// Grab and display data
	
	echo "<label for='checkboxes'>Select Foods:</label>";

	//TODO: echo the table headers
	$get_foods_query = mysqli_prepare($con, "SELECT food_id, food_name, calories, protein, carbs, fat, sugar, serving_size from food_item where sourced_from = ? and meal_time = ? and is_offered = 1 ORDER BY food_name");
	mysqli_stmt_bind_param($get_foods_query, "ss", $location, $meal);
	mysqli_stmt_execute($get_foods_query);
	mysqli_stmt_bind_result($get_foods_query, $food_id, $food_name, $calories, $protein, $carbs, $fat, $sugar, $serving_size);

	$count = 0;	
	//TODO: for each food, echo a table row also add a dropdown for serving sizes with options 1-5 also <3
	while (mysqli_stmt_fetch($get_foods_query)){
		if ($count == 0){
			echo "<table id='breakfast-table' width='100%'>
			<thead>
				<tr>
					<th> Select </th>
					<th> Servings </th>
					<th> Name </th>
					<th> Calories per Serving </th>
					<th> Protein </th>
					<th> Carbs </th>
					<th> Fat </th>
					<th> Sugar </th>
					<th> Serving Size </th>
				</tr>
				</thead>
				<tbody>";
			echo"
				<tr>
					<td class='checkbox'> <input type='checkbox' name='food[]' value='{$food_id}'> </td>
					<td class ='select'>
						<select name='servings-{$food_id}'>
							<option value ='1'>1</option>
							<option value ='2'>2</option>
							<option value ='3'>3</option>
							<option value ='4'>4</option>
							<option value ='5'>5</option>
							<option value ='6'>6</option>
							<option value ='7'>7</option>
							<option value ='8'>8</option>
							<option value ='9'>9</option>
							<option value ='10'>10</option>
						</select>
					</td>
					<td> {$food_name}</td>
					<td> {$calories} </td>
					<td> {$protein}</td>
                    <td> {$carbs}</td>
                    <td> {$fat}</td>
					<td> {$sugar}</td>
					<td> {$serving_size} </td>
				</tr>";
		}
			
		else {
			echo "<tr>
					<td class='checkbox'> <input type='checkbox' name='food[]' value='{$food_id}'> </td>
					<td class ='select'>
						<select name='servings-{$food_id}'>
							<option value ='1'>1</option>
							<option value ='2'>2</option>
							<option value ='3'>3</option>
							<option value ='4'>4</option>
							<option value ='5'>5</option>
							<option value ='6'>6</option>
							<option value ='7'>7</option>
							<option value ='8'>8</option>
							<option value ='9'>9</option>
							<option value ='10'>10</option>
						</select>
					</td>
					<td> {$food_name}</td>
					<td> {$calories} </td>
					<td> {$protein}</td>
                    <td> {$carbs}</td>
                    <td> {$fat}</td>
					<td> {$sugar}</td>
					<td> {$serving_size} </td>
				</tr>";
		}
			 
		$count += 1;
		//echo "</br><input type='checkbox' name='food[]' value='{$food_id}'> {$food_name} - {$calories} Calories/Serving - One Serving: {$serving_size}";
	}
	echo "</tbody> </table>";
	if ($meal == "B"){
		echo"</br><button type='submit' class='btn btn-primary' name='breakfast-submit'>Add to Breakfast</button>";	
	}
	elseif ($meal == "L"){
		echo"</br><button type='submit' class='btn btn-primary' name='lunch-submit'>Add to Lunch</button>";	
	}
	elseif ($meal == "D"){
		echo"</br><button type='submit' class='btn btn-primary' name='dinner-submit'>Add to Dinner</button>";	
	}
	mysqli_stmt_close($get_foods_query); 
}

// Display Pre-Saved Meals
elseif(isset($_GET['location']) && $_GET['location'] == 'Saved'){	
	$get_presaves = mysqli_prepare($con, "SELECT meal_name FROM meal WHERE meal_name IS NOT NULL AND user_id = ?");
	mysqli_stmt_bind_param($get_presaves, "i", $_SESSION['user_id']);
	mysqli_stmt_execute($get_presaves);
	mysqli_stmt_bind_result($get_presaves, $meal_name);
	mysqli_stmt_store_result($get_presaves);
	$count = mysqli_stmt_num_rows($get_presaves);
	if ($count == 0){
		echo"</br><label>You do not have any meals saved...</label>";
		//echo"<label>a{$meal_name}a</label>";
	}
	else{
		echo "<label for='selection'>Choose a meal:</label>
		      <select class='form-control' name='presave-select'>
			  <option value='' disabled selected hidden>--</option>";	
		while (mysqli_stmt_fetch($get_presaves)){
			echo"<option value='{$meal_name}'>{$meal_name}</option>";
		}	
		echo"</select>";		
		echo"</br><button type='submit' class='btn btn-primary' name='breakfast-submit'>Add to Breakfast</button>";
	}
	mysqli_stmt_close($get_presaves);
}

// Display Custom Food Input
elseif(isset($_GET['location']) && $_GET['location'] == 'Custom'){
	$meal = $_GET['meal'];

	echo"<h4>Enter nutrition data in GRAMS:</h4>
			<div>
				<label for ='text-input'>Food Name:</label>
				<input type='text' class='form-control' name='custom-name'>
			</div>
			<div>
				<label for ='text-input'>Calories:</label>
				<input type='number' class='form-control' name='custom-cals'>
			</div>
			<div>
				<label for ='text-input'>Protein:</label>
				<input type='number' class='form-control' name='custom-protein'>
				</div>
			<div>
				<label for ='text-input'>Carbs:</label>
				<input type='number' class='form-control' name='custom-carbs'>
			</div>
			<div>
				<label for ='text-input'>Fat:</label>
				<input type='number' class='form-control' name='custom-fat'>
			</div>
			<div>
				<label for ='text-input'>Sugar:</label>
				<input type='number' class='form-control' name='custom-sugar'>
				</div>";
	
	if ($meal == "B"){
		echo"</br><button type='submit' class='btn btn-primary' name='custom-breakfast-add'>Add to Breakfast</button>";	
	}
	elseif ($meal == "L"){
		echo"</br><button type='submit' class='btn btn-primary' name='custom-lunch-add'>Add to Lunch</button>";	
	}
	elseif ($meal == "D"){
		echo"</br><button type='submit' class='btn btn-primary' name='custom-dinner-add'>Add to Dinner</button>";	
	}
	elseif ($meal == "S"){
		echo"</br><button type='submit' class='btn btn-primary' name='custom-snack-add'>Add to Snacks</button>";	
	}
	 
	//echo"</br><button type='submit' class='btn btn-primary' name='custom-add'>Add Custom Food</button>";	
}

// Display Smashburger
elseif(isset($_GET['flex'])){
	$meal = $_GET['meal'];
	$location = $_GET['location'];
	//echo"<h3>a{$location}a</h3>";
	if ($location == "ModMark"){
		echo "<h3>NOTE: Foods marked with (Half) can be scaled up to a whole portion by selecting 2 servings on the table.</h3>";
	}
	if ($location == "StarGinger"){
		echo "<h2>Star Ginger</h2>";
	}
	$get_foods_query = mysqli_prepare($con, "SELECT food_id, food_name, calories, protein, carbs, fat, sugar, serving_size from food_item where sourced_from = ? and is_offered = 1 ORDER BY food_name");
	mysqli_stmt_bind_param($get_foods_query, "s", $location);
	mysqli_stmt_execute($get_foods_query);
	mysqli_stmt_bind_result($get_foods_query, $food_id, $food_name, $calories, $protein, $carbs, $fat, $sugar, $serving_size);

	$count = 0;
	//TODO: for each food, echo a table row also add a dropdown for serving sizes with options 1-5 also <3
	while (mysqli_stmt_fetch($get_foods_query)){
		if ($count == 0){
			echo "<table id='breakfast-table' width='100%'>
			<thead>
				<tr>
					<th> Select </th>
					<th> Servings </th>
					<th> Name </th>
					<th> Calories per Serving </th>
					<th> Protein </th>
					<th> Carbs </th>
					<th> Fat </th>
					<th> Sugar </th>
					<th> Serving Size </th>
				</tr>
				</thead>
				<tbody>";
			echo"
				<tr>
					<td class='checkbox'> <input type='checkbox' name='food[]' value='{$food_id}'> </td>
					<td class ='select'>
						<select name='servings-{$food_id}'>
							<option value ='1'>1</option>
							<option value ='2'>2</option>
							<option value ='3'>3</option>
							<option value ='4'>4</option>
						</select>
					</td>
					<td> {$food_name}</td>
					<td> {$calories} </td>
					<td> {$protein}</td>
                    <td> {$carbs}</td>
                    <td> {$fat}</td>
					<td> {$sugar}</td>
					<td> {$serving_size} </td>
				</tr>";
		}
			
		else {
			echo "<tr>
					<td class='checkbox'> <input type='checkbox' name='food[]' value='{$food_id}'> </td>
					<td class ='select'>
						<select name='servings-{$food_id}'>
							<option value ='1'>1</option>
							<option value ='2'>2</option>
							<option value ='3'>3</option>
							<option value ='4'>4</option>
							<option value ='5'>5</option>
							<option value ='6'>6</option>
							<option value ='7'>7</option>
							<option value ='8'>8</option>
							<option value ='9'>9</option>
							<option value ='10'>10</option>
						</select>
					</td>
					<td> {$food_name}</td>
					<td> {$calories} </td>
					<td> {$protein}</td>
                    <td> {$carbs}</td>
                    <td> {$fat}</td>
					<td> {$sugar}</td>
					<td> {$serving_size} </td>
				</tr>";
		}
			 
		$count += 1;

		//echo "</br><input type='checkbox' name='food[]' value='{$food_id}'> {$food_name} - {$calories} Calories/Serving - One Serving: {$serving_size}";
	}
	echo "</tbody> </table>";

	if ($meal == "L"){
		echo"</br><button type='submit' class='btn btn-primary' name='lunch-submit'>Add to Lunch</button>";	
	}
	elseif ($meal == "D"){
		echo"</br><button type='submit' class='btn btn-primary' name='dinner-submit'>Add to Dinner</button>";	
	}
	elseif ($meal == "S"){
		echo"</br><button type='submit' class='btn btn-primary' name='custom-snack-add'>Add to Snacks</button>";	
	}
}
?>

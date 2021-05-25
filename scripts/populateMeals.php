<?php include('connect.php') ?>

<?php
// Initialize
//date_default_timezone_set("America/New_York");
//$date = CURDATE();
$user_id = $_SESSION['user_id'];

// Handle Day Navigation
if(isset($_GET['offset'])){
	$offset = $_GET['offset'];
}
else{
	$offset = 0;
}

// Handle Breakfast
echo "<hr><h3>Breakfast</h3>";
echo "<button type='button' class='button' data-toggle='modal' data-target='#breakfast-modal'>Add Items +</button>";

$breakfast_query = mysqli_prepare($con, "SELECT meal.meal_id, food_item.food_id, food_name, servings, calories, protein, carbs, fat, sugar FROM meal, food_item, meal_item WHERE meal.meal_id=meal_item.meal_id AND food_item.food_id=meal_item.food_id AND meal.meal_type='B' AND meal.user_id = ? AND meal.meal_date = CURDATE() - INTERVAL ? DAY");
mysqli_stmt_bind_param($breakfast_query, "ii", $user_id, $offset);
mysqli_stmt_execute($breakfast_query);
mysqli_stmt_bind_result($breakfast_query, $meal_id, $food_id, $food_name, $servings, $calories, $protein, $carbs, $fat, $sugar);
mysqli_stmt_store_result($breakfast_query);
$bCount = mysqli_stmt_num_rows($breakfast_query);


if($bCount == 0){
	echo "<h4>You have not tracked your breakfast today.</h4>";
}
else{
	echo "<button type='button' class='button' data-toggle='modal' data-target='#breakfast-save-modal'>Save Meal</button>";
    echo "<table>
                <thead>
                    <tr>
                        <th style='width: 15%'>Food</th>
                        <th style='width: 15%'>Servings</th>
                        <th style='width: 15%'>Calories</th>
                        <th style='width: 10%'>Protein</th>
                        <th style='width: 10%'>Carbs</th>
                        <th style='width: 10%'>Fat</th>
						<th style='width: 10%'>Sugar</th>
						<th style='width: 15%'>Remove</th>
                    </tr>
                </thead>
				<tbody>";
	while (mysqli_stmt_fetch($breakfast_query)){
		$calories_total = $servings * $calories;
		$protein_total  = $servings * $protein;
		$carbs_total    = $servings * $carbs;
		$fat_total      = $servings * $fat;
		$sugar_total    = $servings * $sugar;

		echo"
                    <tr>
                        <td>{$food_name}</td>
                        <td>{$servings}</td>
                        <td>{$calories_total}</td>
                        <td>{$protein_total}</td>
                        <td>{$carbs_total}</td>
                        <td>{$fat_total}</td>
						<td>{$sugar_total}</td>
						<td><a class='btn btn-danger' href='removeFood.php?ID={$food_id}&MEAL={$meal_id}&OFFSET={$offset}'>&#10006;</a></td>
					</tr>";	
	}				
		echo"
                </tbody>
			</table>";
}
mysqli_stmt_close($breakfast_query); 

// Handle Lunch
echo "<hr><h3>Lunch</h3>";
echo "<button type='button' class='button' data-toggle='modal' data-target='#lunch-modal'>Add Items +</button>";

$lunch_query = mysqli_prepare($con, "SELECT meal.meal_id, food_item.food_id, food_name, servings, calories, protein, carbs, fat, sugar FROM meal, food_item, meal_item WHERE meal.meal_id=meal_item.meal_id AND food_item.food_id=meal_item.food_id AND meal.meal_type='L' AND meal.user_id = ? AND meal.meal_date = CURDATE() - INTERVAL ? Day");
mysqli_stmt_bind_param($lunch_query, "ii", $user_id, $offset);
mysqli_stmt_execute($lunch_query);
mysqli_stmt_bind_result($lunch_query, $meal_id, $food_id, $food_name, $servings, $calories, $protein, $carbs, $fat, $sugar);
mysqli_stmt_store_result($lunch_query);
$lCount = mysqli_stmt_num_rows($lunch_query);


if($lCount == 0){
	echo "<h4>You have not tracked your lunch today.</h4>";
}
else{
	echo "<button type='button' class='button' data-toggle='modal' data-target='#lunch-save-modal'>Save Meal</button>";
    echo "<table>
                <thead>
                    <tr>
                        <th style='width: 15%'>Food</th>
                        <th style='width: 15%'>Servings</th>
                        <th style='width: 15%'>Calories</th>
                        <th style='width: 10%'>Protein</th>
                        <th style='width: 10%'>Carbs</th>
                        <th style='width: 10%'>Fat</th>
						<th style='width: 10%'>Sugar</th>
						<th style='width: 15%'>Remove</th>
                    </tr>
                </thead>
				<tbody>";
	while (mysqli_stmt_fetch($lunch_query)){
		$calories_total = $servings * $calories;
		$protein_total  = $servings * $protein;
		$carbs_total    = $servings * $carbs;
		$fat_total      = $servings * $fat;
		$sugar_total    = $servings * $sugar;

		echo"
                    <tr>
                        <td>{$food_name}</td>
                        <td>{$servings}</td>
                        <td>{$calories_total}</td>
                        <td>{$protein_total}</td>
                        <td>{$carbs_total}</td>
                        <td>{$fat_total}</td>
						<td>{$sugar_total}</td>
						<td><a class='btn btn-danger' href='removeFood.php?ID={$food_id}&MEAL={$meal_id}&OFFSET={$offset}'>&#10006;</a></td>
					</tr>";	
	}				
		echo"
                </tbody>
			</table>";
}
mysqli_stmt_close($lunch_query); 

// Handle Dinner
echo "<hr><h3>Dinner</h3>";
echo "<button type='button' class='button' data-toggle='modal' data-target='#dinner-modal'>Add Items +</button>";

$dinner_query = mysqli_prepare($con, "SELECT meal.meal_id, food_item.food_id, food_name, servings, calories, protein, carbs, fat, sugar FROM meal, food_item, meal_item WHERE meal.meal_id=meal_item.meal_id AND food_item.food_id=meal_item.food_id AND meal.meal_type='D' AND meal.user_id = ? AND meal.meal_date = CURDATE() - INTERVAL ? DAY");
mysqli_stmt_bind_param($dinner_query, "ii", $user_id, $offset);
mysqli_stmt_execute($dinner_query);
mysqli_stmt_bind_result($dinner_query, $meal_id, $food_id, $food_name, $servings, $calories, $protein, $carbs, $fat, $sugar);
mysqli_stmt_store_result($dinner_query);
$dCount = mysqli_stmt_num_rows($dinner_query);


if($dCount == 0){
	echo "<h4>You have not tracked your dinner today.</h4>";
}
else{
	echo "<button type='button' class='button' data-toggle='modal' data-target='#dinner-save-modal'>Save Meal</button>";
    echo "<table>
                <thead>
                    <tr>
                        <th style='width: 15%'>Food</th>
                        <th style='width: 15%'>Servings</th>
                        <th style='width: 15%'>Calories</th>
                        <th style='width: 10%'>Protein</th>
                        <th style='width: 10%'>Carbs</th>
                        <th style='width: 10%'>Fat</th>
						<th style='width: 10%'>Sugar</th>
						<th style='width: 15%'>Remove</th>
                    </tr>
                </thead>
				<tbody>";
	while (mysqli_stmt_fetch($dinner_query)){
		$calories_total = $servings * $calories;
		$protein_total  = $servings * $protein;
		$carbs_total    = $servings * $carbs;
		$fat_total      = $servings * $fat;
		$sugar_total    = $servings * $sugar;

		echo"
                    <tr>
                        <td>{$food_name}</td>
                        <td>{$servings}</td>
                        <td>{$calories_total}</td>
                        <td>{$protein_total}</td>
                        <td>{$carbs_total}</td>
                        <td>{$fat_total}</td>
						<td>{$sugar_total}</td>
						<td><a class='btn btn-danger' href='removeFood.php?ID={$food_id}&MEAL={$meal_id}&OFFSET={$offset}'>&#10006;</a></td>
					</tr>";	
	}				
		echo"
                </tbody>
			</table>";
}
mysqli_stmt_close($dinner_query); 

// Handle Snack
echo "<hr><h3>Snacks</h3>";
echo "<button type='button' class='button' data-toggle='modal' data-target='#snack-modal'>Add Items +</button>";

$snack_query = mysqli_prepare($con, "SELECT meal.meal_id, food_item.food_id, food_name, servings, calories, protein, carbs, fat, sugar FROM meal, food_item, meal_item WHERE meal.meal_id=meal_item.meal_id AND food_item.food_id=meal_item.food_id AND meal.meal_type='S' AND meal.user_id = ? AND meal.meal_date = CURDATE() - INTERVAL ? DAY");
mysqli_stmt_bind_param($snack_query, "ii", $user_id, $offset);
mysqli_stmt_execute($snack_query);
mysqli_stmt_bind_result($snack_query, $meal_id, $food_id, $food_name, $servings, $calories, $protein, $carbs, $fat, $sugar);
mysqli_stmt_store_result($snack_query);
$sCount = mysqli_stmt_num_rows($snack_query);


if($sCount == 0){
	echo "<h4>You have not tracked any snacks today.</h4>";
}
else{
	echo "<button type='button' class='button' data-toggle='modal' data-target='#breakfast-save-modal'>Save Meal</button>";
    echo "<table>
                <thead>
                    <tr>
                        <th style='width: 15%'>Food</th>
                        <th style='width: 15%'>Servings</th>
                        <th style='width: 15%'>Calories</th>
                        <th style='width: 10%'>Protein</th>
                        <th style='width: 10%'>Carbs</th>
                        <th style='width: 10%'>Fat</th>
						<th style='width: 10%'>Sugar</th>
						<th style='width: 15%'>Remove</th>
                    </tr>
                </thead>
				<tbody>";
	while (mysqli_stmt_fetch($snack_query)){
		$calories_total = $servings * $calories;
		$protein_total  = $servings * $protein;
		$carbs_total    = $servings * $carbs;
		$fat_total      = $servings * $fat;
		$sugar_total    = $servings * $sugar;
		echo"
                    <tr>
                        <td>{$food_name}</td>
                        <td>{$servings}</td>
                        <td>{$calories_total}</td>
                        <td>{$protein_total}</td>
                        <td>{$carbs_total}</td>
                        <td>{$fat_total}</td>
						<td>{$sugar_total}</td>
						<td><a class='btn btn-danger' href='removeFood.php?ID={$food_id}&MEAL={$meal_id}&OFFSET={$offset}'>&#10006;</a></td>
					</tr>";	
	}				
		echo"
                </tbody>
			</table>";
}
mysqli_stmt_close($snack_query); 


?>

<?php include('foodConnect.php') ?>
<?php

if ($argc != 3){
	echo "php addFlex.php <location> <CSV File>\n";
	exit;
}

$location = $argv[1];
$file     = fopen($argv[2], 'r');

while (($line = fgetcsv($file)) !== FALSE){
	$food_name = $line[0];
	$food_serv = $line[1];
	$food_cals = $line[2];
	$food_fats = $line[3];
	$food_carb = $line[4];
	$food_sgrs = $line[5];
	$food_prot = $line[6];
	
	$add_food = mysqli_prepare($con, "INSERT INTO food_item VALUES (NULL, ?, ?, ?, ?, ?, ?, 'F', 1, ?, ?)");
	mysqli_stmt_bind_param($add_food, "siiiisis", $food_name, $food_cals, $food_prot, $food_carb, $food_fats, $location, $food_sgrs, $food_serv);
	mysqli_stmt_execute($add_food);
	mysqli_stmt_close($add_food);
}

?>

<?php
// Hanlde query
if (isset($_GET['offset'])){
	$offset = $_GET['offset'];
}
else{
	$offset = 0;
}

if ($offset > 6 || $offset < 0){
	$offset = 0;
}

$bkwd = $offset+1;
$frwd = $offset-1;

// Move backwards
if ($offset != 6){
echo"
<div class='left'>
	<button class='left-button' name='day-sub-button' onclick=location.href='meal.php?offset={$bkwd}'>&#8592;</button>
	</div>";
}
else {
	echo"
		<div class='left'>
			<p style='color: #0c2340'>p</p>
		</div>";
}

// Header
if ($offset == 0){
echo"
<div class='middle'>
	<h2>Today's Meals</h2>
</div>";
}

elseif ($offset == 1){
echo"
<div class='middle'>
	<h2>Meals From 1 Day Ago</h2>
</div>";
}

else{
echo"
<div class='middle'>
	<h2>Meals From {$offset} Days Ago</h2>
</div>";
}

// Move forwards
if ($offset != 0){
echo"
<div class='right'>
	<button class='right-button' name='day-add-button' onclick=location.href='meal.php?offset={$frwd}'>&#8594;</button>
</div>
";
}
?>

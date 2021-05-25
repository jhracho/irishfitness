<?php include('connect.php'); ?>

<?php
// This prevents running route drawing modal from popping up
	echo "
		<table class='routes-table'>
			<thead>
				<tr>
					<th style='width: 50%'>Route Name</th>
					<th style='width: 50%'>Distance</th>
				</tr>
				</thead>
				<tbody>
			";
 
	$user_id = $_SESSION["user_id"];
	
	$running_route_query = mysqli_prepare($con, "SELECT name, distance FROM routes WHERE name IS NOT NULL and created_by = ?");
	mysqli_stmt_bind_param($running_route_query, "i", $user_id);
	mysqli_stmt_execute($running_route_query);
	mysqli_stmt_bind_result($running_route_query, $name, $distance);
	while(mysqli_stmt_fetch($running_route_query)){
	echo "
		<tr>
			<td>{$name}</td>
			<td>{$distance} miles</td>
		</tr>
		";
	}
	echo
		"
		</tbody>
		</table>
	";
	mysqli_stmt_close($running_route_query);
?>


<?php include('connect.php'); ?>

<?php
session_start();

if(isset($_POST['cals-update-button'])) {
	$cals = $_POST['calories-input'];
	$user_id = $_SESSION['user_id'];
	$update_cals_query = mysqli_prepare($con, "UPDATE user SET goal_cals = ? where user.user_id = ?");
	mysqli_stmt_bind_param($update_cals_query, "is", $cals, $user_id);
	mysqli_stmt_execute($update_cals_query);
	mysqli_stmt_close($update_cals_query);
	header("Refresh: 0; url=../home.php");
}

if(isset($_POST['protein-update-button'])) {
	$protein = $_POST['protein-input'];
	$user_id = $_SESSION['user_id'];
	$update_protein_query = mysqli_prepare($con, "UPDATE user SET goal_protein = ? where user.user_id = ?");
	mysqli_stmt_bind_param($update_protein_query, "is", $protein, $user_id);
	mysqli_stmt_execute($update_protein_query);
	mysqli_stmt_close($update_protein_query);
	header("Refresh: 0; url=../home.php");
}

if(isset($_POST['carbs-update-button'])) {
	$carbs = $_POST['carbs-input'];
	$user_id = $_SESSION['user_id'];
	$update_carbs_query = mysqli_prepare($con, "UPDATE user SET goal_carbs = ? where user.user_id = ?");
	mysqli_stmt_bind_param($update_carbs_query, "is", $carbs, $user_id);
	mysqli_stmt_execute($update_carbs_query);
	mysqli_stmt_close($update_carbs_query);
	header("Refresh: 0; url=../home.php");
}

if(isset($_POST['fat-update-button'])) {
	$fat = $_POST['fat-input'];
	$user_id = $_SESSION['user_id'];
	$update_fat_query = mysqli_prepare($con, "UPDATE user SET goal_fat = ? where user.user_id = ?");
	mysqli_stmt_bind_param($update_fat_query, "is", $fat, $user_id);
	mysqli_stmt_execute($update_fat_query);
	mysqli_stmt_close($update_fat_query);
	header("Refresh: 0; url=../home.php");
}

if(isset($_POST['burned-update-button'])) {
	$burned = $_POST['burned-input'];
	$user_id = $_SESSION['user_id'];
	$update_burned_query = mysqli_prepare($con, "UPDATE user SET goal_burned = ? where user.user_id = ?");
	mysqli_stmt_bind_param($update_burned_query, "is", $burned, $user_id);
	mysqli_stmt_execute($update_burned_query);
	mysqli_stmt_close($update_burned_query);
	header("Refresh: 0; url=../home.php");
}
?>

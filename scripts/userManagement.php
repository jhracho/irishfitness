<?php include('connect.php') ?>
<?php

session_start();
$username = "";

// Handle login
if (isset($_POST['login-button'])){
    // Get values from HTML form
    $username  = strtolower(mysqli_real_escape_string($con, $_POST['username-input']));
    $password  = mysqli_real_escape_string($con, $_POST['password-input']);

    // Check input
    if (empty($username) || empty($password)){
        echo"<script>alert(\"You must enter a username and password!\")</script>";
        header("Refresh: 0; url='../login.php");
    }

    else{
		// Generate Query
		$password_hash = md5($password);
		$validate_query = mysqli_prepare($con, "SELECT count(username) FROM user where username = ? AND password_hash = ?");
		mysqli_stmt_bind_param($validate_query, "ss", $username, $password_hash);
		mysqli_stmt_execute($validate_query);
		mysqli_stmt_bind_result($validate_query, $valid);
		mysqli_stmt_fetch($validate_query);
		mysqli_stmt_close($validate_query);

        // Check for validation
		if($valid > 0){
			$user_data_query = mysqli_prepare($con, "SELECT user_id, first_name, last_name, created_at, height_feet, height_inches, weight, goal, residence, gender FROM user WHERE username = ?");
			mysqli_stmt_bind_param($user_data_query, "s", $username);
			mysqli_stmt_execute($user_data_query);
			mysqli_stmt_bind_result($user_data_query, $user_id, $first_name, $last_name, $created_at, $height_feet, $height_inches, $weight, $goal, $residence, $gender);
			mysqli_stmt_fetch($user_data_query);
			mysqli_stmt_close($user_data_query);
			$_SESSION['username'] = $username;
			$_SESSION['first_name'] = $first_name;
			$_SESSION['last_name'] = $last_name;
			$_SESSION['user_id']  = $user_id;
			$_SESSION['created_at'] = $created_at;
			$_SESSION['height_feet'] = $height_feet;
			$_SESSION['height_inches'] = $height_inches;
			$_SESSION['weight']  = $weight;
			$_SESSION['goal']  = $goal;
			$_SESSION['residence']  = $residence;
			$_SESSION['gender'] = $gender;
			$_SESSION['exercises'] = array();
			$_SESSION['exercise_targets'] = array();
            header('location: ../home.php');
        }
        else{
            echo"<script>alert(\"Invalid username and/or password\")</script>";
            header("Refresh: 0; url=../login.php");
        }
    }
}

// Handle signup
if (isset($_POST['signup-button'])){
    // Get form values
    $username   = strtolower(mysqli_real_escape_string($con, $_POST['username-input']));
    $password1  = mysqli_real_escape_string($con, $_POST['password-input']);
    $password2  = mysqli_real_escape_string($con, $_POST['password-confirm']);
    $first_name  = mysqli_real_escape_string($con, $_POST['firstname-input']);
	$last_name   = mysqli_real_escape_string($con, $_POST['lastname-input']);
	$gender     = mysqli_real_escape_string($con, $_POST['gender-input']);
    $height_feet = mysqli_real_escape_string($con, $_POST['heightFeet-input']);
    $height_inches = mysqli_real_escape_string($con, $_POST['heightInch-input']);
	$weight     = mysqli_real_escape_string($con, $_POST['weight-input']);
	$residence  = mysqli_real_escape_string($con, $_POST['residence-input']);
	$goal       = mysqli_real_escape_string($con, $_POST['goal-input']);

    # Error checking
    if (empty($username) || empty($password1) || empty($first_name) || empty($last_name) || empty($height_feet) || empty($height_inches) || empty($weight) || strcmp($residence, "null") == 0 || strcmp($goal, "null") == 0 || strcmp($gender, "null") == 0){
        echo"<script>alert(\"One or more fields was left empty. Please try again.\")</script>";
        header("Refresh: 0; url='../signup.php");    
    }
    elseif($password1 !== $password2){
        echo"<script>alert(\"Passwords do not match!\")</script>";
        header("Refresh: 0; url='../signup.php");
	}

	else{
		$check_user_query = mysqli_prepare($con, "SELECT count(username) FROM user WHERE username = ?");
		mysqli_stmt_bind_param($check_user_query, "s", $username);
		mysqli_stmt_execute($check_user_query);
		mysqli_stmt_bind_result($check_user_query, $valid);
		mysqli_stmt_fetch($check_user_query);
		mysqli_stmt_close($check_user_query);

		if ($valid > 0){
            echo"<script>alert(\"Username already exists\")</script>";
            header("Refresh: 0; url='../signup.php"); 
        }
		else{
			$password = md5($password1);
			$add_query = mysqli_prepare($con, "INSERT INTO user (username, password_hash, first_name, last_name, height_feet, height_inches, weight, initial_weight, goal, residence, gender) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
			mysqli_stmt_bind_param($add_query, "ssssiiddsss", $username, $password, $first_name, $last_name, $height_feet, $height_inches, $weight, $weight, $goal, $residence, $gender);
           	mysqli_stmt_execute($add_query);
			mysqli_stmt_close($add_query);

			$user_data_query = mysqli_prepare($con, "SELECT user_id, first_name, last_name, created_at, height_feet, height_inches, weight, goal, residence, gender FROM user WHERE username = ?");
			mysqli_stmt_bind_param($user_data_query, "s", $username);
			mysqli_stmt_execute($user_data_query);
			mysqli_stmt_bind_result($user_data_query, $user_id, $first_name, $last_name, $created_at, $height_feet, $height_inches, $weight, $goal, $residence, $gender);
			mysqli_stmt_fetch($user_data_query);
			mysqli_stmt_close($user_data_query);
			$_SESSION['username'] = $username;
			$_SESSION['first_name'] = $first_name;
			$_SESSION['last_name'] = $last_name;
			$_SESSION['user_id']  = $user_id;
			$_SESSION['created_at'] = $created_at;
			$_SESSION['height_feet'] = $height_feet;
			$_SESSION['height_inches'] = $height_inches;
			$_SESSION['weight']  = $weight;
			$_SESSION['goal']  = $goal;
			$_SESSION['residence']  = $residence;
			$_SESSION['exercises'] = array();
			$_SESSION['exercise_targets'] = array();
			$_SESSION['gender'] = $gender;

			$add_has_eaten = mysqli_prepare($con, "INSERT INTO has_eaten (user_id) VALUES (?)");
			mysqli_stmt_bind_param($add_has_eaten, "i", $user_id);
			mysqli_stmt_execute($add_has_eaten);
			mysqli_stmt_close($add_has_eaten);
			header('location: ../home.php');
        }
    }
}

?>

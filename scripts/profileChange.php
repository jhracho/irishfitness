<?php include('scripts/connect.php')?>

<?php

session_start();

$username = $_SESSION['username'];
if(empty($username)) {
	$_SESSION['msg'] = "You must log in to view this page!";
	header("location: login.php");
}

$user_data_query = mysqli_prepare($con, "SELECT first_name, last_name FROM user WHERE username = ?");
mysqli_stmt_bind_param($user_data_query, "s", $username);
mysqli_stmt_execute($user_data_query);
mysqli_stmt_bind_result($user_data_query, $first_name, $last_name);
mysqli_stmt_fetch($user_data_query);
mysqli_stmt_close($user_data_query);

$residence=$_SESSION['residence'];
$created_at=$_SESSION['created_at'];
$created_date = date_parse($created_at);
$height_feet = $_SESSION['height_feet'];
$height_inches = $_SESSION['height_inches'];
$weight = $_SESSION['weight']; 
$goal = $_SESSION['goal'];  

// Handle the user change
if (isset($_POST["change-button"])){
    // Get the type of change it was
    $edit_type = mysqli_real_escape_string($con, $_POST['edit-select']);
    switch($edit_type){
        case 'edit-residence':
            $new_residence = mysqli_real_escape_string($con, $_POST['residence-change']); 
            $update_query = mysqli_prepare($con, "UPDATE user SET residence = ? WHERE username = ?");
            mysqli_stmt_bind_param($update_query, "ss", $new_residence, $username);
            mysqli_stmt_execute($update_query);
            mysqli_stmt_close($update_query);
            $_SESSION['residence'] = $new_residence; 
            break;
        case 'edit-goal':
            $new_goal = mysqli_real_escape_string($con, $_POST['goal-change']); 
            $update_query = mysqli_prepare($con, "UPDATE user SET goal = ? WHERE username = ?");
            mysqli_stmt_bind_param($update_query, "ss", $new_goal, $username);
            mysqli_stmt_execute($update_query);
            mysqli_stmt_close($update_query);
            $_SESSION['goal'] = $new_goal; 
            break;
        case 'edit-height':
            $new_height_ft = mysqli_real_escape_string($con, $_POST['hfeet-change']);
            $new_height_in = mysqli_real_escape_string($con, $_POST['hinches-change']); 
            $update_query = mysqli_prepare($con, "UPDATE user SET height_feet = ?, height_inches = ? WHERE username = ?");
            mysqli_stmt_bind_param($update_query, "iis", $new_height_ft, $new_height_in, $username);
            mysqli_stmt_execute($update_query);
            mysqli_stmt_close($update_query);
            $_SESSION['height_feet'] = $new_height_ft; 
            $_SESSION['height_inches'] = $new_height_in;
            break;
        case 'edit-weight':
            $new_weight = mysqli_real_escape_string($con, $_POST['weight-change']);
            $update_query = mysqli_prepare($con, "UPDATE user SET weight = ? WHERE username = ?");
            mysqli_stmt_bind_param($update_query, "ds", $new_weight, $username); 
            mysqli_stmt_execute($update_query);
            mysqli_stmt_close($update_query);
            $_SESSION['weight'] = $new_weight;
            break;
    }
    
    header("Refresh: 0; url='../irishfitness/profile.php"); 
}

if (isset($_POST['submit-new-pword-button'])) {
    // Get values from the change password form
    $curPass  = mysqli_real_escape_string($con, $_POST['curpass-input']);
    $newPass  = mysqli_real_escape_string($con, $_POST['newpass-input']);
    $confirmNew = mysqli_real_escape_string($con, $_POST['confirmpass-input']);


    // Check if any fields are empty
    if (empty($curPass) || empty($newPass) || empty($confirmNew)){
        echo"<script>alert('Please fill out all fields.')</script>";
    }
    else{
        $curPass_hash = md5($curPass);
        $newPass_hash = md5($newPass);
        $confirmNew_hash = md5($confirmNew);

        $password_check = mysqli_prepare($con, "SELECT count(username) FROM user where username = ? AND password_hash = ?");
        mysqli_stmt_bind_param($password_check, "ss", $_SESSION['username'], $curPass_hash);
		mysqli_stmt_execute($password_check);
		mysqli_stmt_bind_result($password_check, $match);
		mysqli_stmt_fetch($password_check);
        mysqli_stmt_close($password_check);
        
        if ($match <= 0){
            echo"<script>alert('Incorrect current password!')</script>";
        }
        else if ($newPass_hash != $confirmNew_hash){
            echo"<script>alert('New password entries do not match! Try confirming again.')</script>";
        }
        else {
            $change_pass_query = mysqli_prepare($con, "UPDATE user SET password_hash=? WHERE username=?");
			mysqli_stmt_bind_param($change_pass_query, "ss", $newPass_hash, $username);
           	mysqli_stmt_execute($change_pass_query);
			mysqli_stmt_close($change_pass_query);
        }
    }
}

?>
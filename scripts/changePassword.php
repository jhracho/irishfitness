<?php include('connect.php') ?>
<?php

session_start();

if (isset($_POST['submit-new-pword-button'])) {
    // Get values from the change password form
    $curPass  = mysqli_real_escape_string($con, $_POST['curpass-input']);
    $newPass  = mysqli_real_escape_string($con, $_POST['newpass-input']);
    $confirmNew = mysqli_real_escape_string($con, $_POST['confirmpass-input']);

    // Check if any fields are empty
    if (empty($curPass) || empty($newPass) || empty($confirmNew)){
        $_SESSION['msg'] = "<script>alert(\"You must enter your current and new passwords!\")</script>";
    }
    else{
        $currPass_hash = md5($curPass);
        $newPass_hash = md5($newPass);
        $confirmNew_hash = md5($confirmNew);

        $password_check = mysqli_prepare($con, "SELECT count(username) FROM user where username = ? AND password_hash = ?");
        mysqli_stmt_bind_param($password_check, "ss", $_SESSION['username'], $password_hash);
		mysqli_stmt_execute($password_check);
		mysqli_stmt_bind_result($password_check, $match);
		mysqli_stmt_fetch($password_check);
        mysqli_stmt_close($password_check);
        
        if ($match <= 0){
            echo"<script>alert(\"Incorrect current password!\")</script>";
        }
        if ($newPass_hash != $confirmNew_hash){
            echo"<script>alert(\"New passwords do not match. Try confirming again!\")</script>";
        }


    }
}


?>
<?php include('scripts/userManagement.php') ?>

<?php
if(isset($_SESSION['msg'])) {
	echo "<script>alert('".$_SESSION['msg']."')</script>";
	unset($_SESSION['msg']);
}
?>

<html>
	<head>
		<title>Irish Fitness | Login</title>
		<link rel="stylesheet" href="assets/css/login.css">
		<link rel="shortcut icon" type="image/x-icon" href="assets/icons/favicon.ico">
	</head>
	<body>
		<div class="container">
		<img src="assets/icons/Circle_Logo_Wordless.png">
		<hr>
		<h3>Sign In</h3>
		<form class="input-form" method="post" action="scripts/userManagement.php">
			<input name='username-input' type="text" placeholder="Username">
			<input name='password-input' type="password" placeholder="Password">
			<button name='login-button' class="login-button">Sign In</button>
		<hr>
		<p>Don't have an account? <a href="signup.php">Create Account</a></p>
		</form>
		</div>
</html>

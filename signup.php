<?php include('scripts/userManagement.php') ?>

<html>
	<head>
		<title>Irish Fitness | Signup</title>
		<link rel="stylesheet" href="assets/css/signup.css">
		<link rel="shortcut icon" type="image/x-icon" href="assets/icons/favicon.ico" > 
	</head>
	<body>
		<div class="container">
				<img src="assets/icons/Circle_Logo_Wordless.png">
				<hr>
				<h3>Create Account</h3>
				<form action="scripts/userManagement.php" method="post">
				<input type="text" placeholder="Username" name="username-input">
				<div class="column">
					<input type="password" placeholder="Password" name="password-input">
					<input type="password" placeholder="Confirm Password" name="password-confirm">
					<input type="text" placeholder="First Name" name="firstname-input">
					<input type="text" placeholder="Last Name" name="lastname-input">
					<select name="gender-input">
						<option value="null" hidden>Gender</option>
						<option value="Male">Male</option>
						<option value="Female">Female</option>
					</select>
				</div>
				<div class="column">
					<input type="number" placeholder="Height (feet)" min="0" max="7" name="heightFeet-input">
					<input type="number" placeholder="Height (inches)" min="0" max="11" name="heightInch-input">
					<input type="number" placeholder="Weight (lbs)" min="0" max="500" step="0.1"  name="weight-input">
					<select name="residence-input">
						<option value="null" hidden>Residence</option>
						<option value="Alumni Hall">Alumni Hall</option>
						<option value="Badin Hall">Badin Hall</option>
						<option value="Baumer Hall">Baumer Hall</option>
						<option value="Breen-Phillips Hall">Breen-Phillips Hall</option>
						<option value="Carroll Hall">Carroll Hall</option>
						<option value="Cavanaugh Hall">Cavanaugh Hall</option>
						<option value="Dillon Hall">Dillon Hall</option>
						<option value="Duncan Hall">Duncan Hall</option>
						<option value="Dunne Hall">Dunne Hall</option>
						<option value="Farley Hall">Farley Hall</option>
						<option value="Fisher Hall">Fisher Hall</option>
						<option value="Flaherty Hall">Flaherty Hall</option>
						<option value="Howard Hall">Howard Hall</option>
						<option value="Keenan Hall">Keenan Hall</option>
						<option value="Keough Hall">Keough Hall</option>
						<option value="Knott Hall">Knott Hall</option>
						<option value="Johnson Family Hall">Johnson Family Hall</option>
						<option value="Lewis Hall">Lewis Hall</option>
						<option value="Lyons Hall">Lyons Hall</option>
						<option value="McGlinn Hall">McGlinn Hall</option>
						<option value="Morrissey Hall">Morrissey Hall</option>
						<option value="O'Neill Family Hall">O'Neill Family Hall</option>
						<option value="Pasquerilla East Hall">Pasquerilla East Hall</option>
						<option value="Pasquerilla West Hall">Pasquerilla West Hall</option>
						<option value="Ryan Hall">Ryan Hall</option>
						<option value="St. Edwards Hall">St. Edward's Hall</option>
						<option value="Siegfried Hall">Siegfried Hall</option>
						<option value="Sorin Hall">Sorin Hall</option>
						<option value="Stanford Hall">Stanford Hall</option>
						<option value="Walsh Hall">Walsh Hall</option>
						<option value="Welsh Family Hall">Welsh Family Hall</option>
						<option value="Zahm Hall">Zahm Hall</option>
						<option value="Off Campus">Off Campus</option>
					</select>
					<select name="goal-input">
						<option value="null" hidden>Fitness Goal</option>
						<option value="Muscle Gain">Muscle Gain</option>
						<option value="Strength Gain">Strength Gain</option>
						<option value="Weight Loss">Weight Loss</option>
					</select>
				</div>
				<button class="signup-button" name="signup-button">Sign Up</button>
			</form>
		<hr>
		<p>Already have an account? <a href="login.php">Sign In</a></p>
		</div>
	</body>
</html>

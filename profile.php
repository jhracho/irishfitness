<?php include('scripts/profileChange.php')?>

<!-- get the variables from the database under _SESSION[username]
call them in a select query, store in a variable -->

<html>
	<head>
		<title>Profile - <?php echo $first_name; ?> <?php echo $last_name; ?></title>
		<link rel="stylesheet" href="assets/css/profile.css">
		
		<link rel="shortcut icon" type="image/x-icon" href="assets/icons/favicon.ico"> 
	</head>
	<body>
		<div class="top-banner">
			<h3>Irish Fitness - Notre Dame's Fitness Hub</h3>
			<h4>CSE 30246 - Database Concepts</h4>
		</div>
		<div class="topnav">
			<!--<h3><a href="about.html">About Us</a></h3>-->
			<h3><a href="home.php" class="inactive">Home Page</a></h3>
			<h3><a href="meal.php" class="inactive">Meals</a></h3>
			<h3><a href="workout.php" class="inactive">Workouts</a></h3>
			<h4><a href="logout.php" class="inactive">Sign Out</a></h4>
			<h4><a href="profile.php" class="active">Profile</a></h4>
		</div>
		<div class="top-container">
			<h1><?php echo $first_name; ?> <?php echo $last_name; ?></h1>
			<h3>Account Information</h3>
			<p><b>Username</b>&emsp;&emsp;<?php echo $username; ?></p>
			<p><b>Account Created</b>&emsp;&emsp;<?php echo $created_date['month']; ?>/<?php echo $created_date['day']; ?>/<?php echo $created_date['year']; ?></p>
			<p><b>Residence</b>&emsp;&emsp;<?php echo $residence; ?></p>
			<button id="password-button" class="edit-button" data-toggle='modal' data-target='#password-modal'>Change Password</button>
			<br>
			<h3>Health and Fitness</h3>
			<p><b>Goal</b>&emsp;&emsp;<?php echo $goal; ?></p>
			<p><b>Height</b>&emsp;&emsp;<?php echo $height_feet; ?>'<?php echo $height_inches; ?>"</p>
			<p><b>Weight</b>&emsp;&emsp;<?php echo $weight; ?> lbs.</p>
			<br>
			<button id="edit-button" class="edit-button" data-toggle='modal' data-target='#edit-modal'>Edit Profile</button>
		</div>

		<div id="edit-modal" class="modal">
  			<div class="modal-content">
			  	<div class="modal-header">
				  <span class="close">&times;</span>
				  <h2>Edit Profile</h2>
				</div>
				<div class="modal-body">
					<form method="post">
						<label for="select">Select the information to change:</label>
						<select id="edit-select" name="edit-select" onChange="handleSelection(value)">
							<option value="blank-choice" hidden>       </option>
							<option name="edit-residence" value="edit-residence">Residence</option>
							<option name="edit-goal" value="edit-goal">Goal</option>
							<option name="edit-height" value="edit-height">Height</option>
							<option name="edit-weight" value="edit-weight">Weight</option>
						</select>
    					<div id="residence-div" style="display:none">
							<label for="residence-change">Select your new residence:</label>
							<select name="residence-change">
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
						</div>
						<div id="goal-div" style="display:none">
							<label for="goal-change">Select your new goal:</label>
							<select name="goal-change">
								<option value="goal-blank">    </option>
								<option value="Muscle">Muscle Gain</option>
								<option value="Strength">Strength Gain</option>
								<option value="Weight">Weight Loss</option>
							</select>
						</div>
						<div id="height-div" style="display:none">
							<label for="hfeet-change">Feet:</label><br>
							<input value="<?php echo $height_feet; ?>" type="number" min='0' max='7'id="hfeet-change" name="hfeet-change"><br>
							<label for="hinches-change">Inches:</label><br>	
							<input value="<?php echo $height_inches; ?>" type="number" min='0' max='11' id="hinches-change" name="hinches-change"><br>
						</div>
						<div id="weight-div" style="display:none">
							<label for="weight-change">Weight:</label><br>
							<input value="<?php echo $weight; ?>" type="number" min='0' max='500' step='0.1' id="weight-change" name="weight-change"><br>
						</div>
						<button class="change-button" name="change-button">Submit Change</button>
						<script src="profileSelectForm.js"></script>
					</form>
				</div>
    		</div>
		</div>
		
		<div id="password-modal" class="modal">
  			<!-- modal content -->
  			<div class="modal-content">
			  	<div class="modal-header">
				  <span class="close">&times;</span>
				  <h2>Change Password</h2>
				</div>
				<div class="modal-body">
					<form method="post">
						<input name="curpass-input" type="password" placeholder = "Current Password">
						<input name="newpass-input" type="password" placeholder = "New Password">
						<input name="confirmpass-input" type="password" placeholder = "Confirm New Password">
						<button class="submit-new-pword-button" name="submit-new-pword-button">Change Password</button>
					</form>
				</div>
    		</div>
		</div>

		<!-- modal script (JS) -->
		<script src="editProfileModal.js"></script>

	</body>
</html>

<!-- php to change any value
if statement where any of the buttons are -->

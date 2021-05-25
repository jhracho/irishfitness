<?php include('scripts/submitMeal.php') ?>

<?php
$username   = $_SESSION['username'];
$first_name = $_SESSION['first_name'];
$last_name  = $_SESSION['last_name'];
$user_id    = $_SESSION['user_id'];


if(empty($username)) {
	$_SESSION['msg'] = "You must log in to view this page!";
	header("location: login.php");
}

?>

<html>
    <head>
        <title>Meals - <?php echo $first_name; ?> <?php echo $last_name; ?></title>
		<link rel="stylesheet" href="assets/css/meal.css">
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
	        <h3><a href="meal.php" class="active">Meals</a></h3>
	        <h3><a href="workout.php" class="inactive">Workouts</a></h3>
	        <h4><a href="logout.php" class="inactive">Sign Out</a></h4>
	        <h4><a href="profile.php" class="inactive">Profile</a></h4>
		</div>
		<div class="top-container">
			<div class="message-container">
				<h5>If you or someone you know is showing signs of an eating disorder, please know there are <a href='https://www.ucc.nd.edu/counseling-services' target='_blank'>resources</a> available to help.</h5>
				<h5>Contact: Jocie Antonelli, RD (<a href='https://mail.google.com/mail/u/0/?fs=1&to=jantonel@nd.edu&tf=cm' target='_blank'>jantonel@nd.edu</a>)</h5>
			</div>
			<div class="header-container">
			<?php include('scripts/mealNav.php') ?>
			<!--
				<div class="left">
					<button class='left-button' name='day-sub-button'>&#8592;</button>
				</div>
				<div class="middle">
					<h2>Today's Meals</h2>
				</div>
				<div class="right">
					<button class='right-button' name='day-add-button'>&#8594;</button>
				</div>
			-->
			</div>	
			<?php include('scripts/populateMeals.php') ?>
        </div>
			
        <!-- Add breakfast modal -->
        <div class="modal" tabindex="-1" role="dialog" id="breakfast-modal">
            <div class="modal-content">
				<div class="modal-header">
					<h4>Add Breakfast Items:</h4>
                   	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
               	</div>
               	<div class="modal-body" id="breakfast-modal-body">
               	    <form method="post">
               	        <div>
               	            <label for="selection">Location</label>
							<select class="form-control" onchange="updateBreakfast(this.value)" id="breakfast-location-select">
								<option value="" disabled selected hidden>--</option>
								<option>Pre-Saved Breakfast</option>
								<option>North Dining Hall</option>
								<option>South Dining Hall</option>
               	            	<option>Custom Food</option>
               	            </select>
						</div>
						<div id="breakfast-food-selection">			
						</div>
               	    </form>
               	</div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal -->


        <!-- Save breakfast modal -->
        <div class="modal" tabindex="-1" role="dialog" id="breakfast-save-modal">
            <div class="modal-content">
				<div class="modal-header">
					<h4>Save your breakfast to be easily loaded on other days!</h4>
                   	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
               	</div>
               	<div class="modal-body" id="breakfast-save-modal-body">
               	    <form method="post">
						<div>
							<label for ="text-input">Meal Name:</label>
							<input type="text" class="form-control" name="breakfast-name">
						</div>
               	        <button type="submit" class="btn btn-primary" name="breakfast-save">Save Meal</button>
               	    </form>
               	</div>
            </div><!-- /.modal-content -->
		</div><!-- /.modal -->

		<!-- Add lunch modal -->
        <div class="modal" tabindex="-1" role="dialog" id="lunch-modal">
            <div class="modal-content">
				<div class="modal-header">
					<h4>Add Lunch Items:</h4>
                   	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
               	</div>
               	<div class="modal-body" id="lunch-modal-body">
               	    <form method="post">
               	        <div>
               	            <label for="selection">Location</label>
							<select class="form-control" onchange="updateLunch(this.value)" id="lunch-location-select">
								<option value="" disabled selected hidden>--</option>
								<option>Pre-Saved Lunch</option>
								<option>North Dining Hall</option>
								<option>South Dining Hall</option>
								<option>Modern Market</option>
								<option>Star Ginger</option>
								<option>Smashburger</option>
								<option>Subway</option>
								<option>Taco Bell</option>
               	            	<option>Custom Food</option>
               	            </select>
						</div>
						<div id="lunch-food-selection">			
						</div>
               	    </form>
               	</div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal -->


        <!-- Save lunch modal -->
        <div class="modal" tabindex="-1" role="dialog" id="lunch-save-modal">
            <div class="modal-content">
				<div class="modal-header">
					<h4>Save your lunch to be easily loaded on other days!</h4>
                   	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
               	</div>
               	<div class="modal-body" id="lunch-save-modal-body">
               	    <form method="post">
						<div>
							<label for ="text-input">Meal Name:</label>
							<input type="text" class="form-control" name="lunch-name">
						</div>
               	        <button type="submit" class="btn btn-primary" name="lunch-save">Save Meal</button>
               	    </form>
               	</div>
            </div><!-- /.modal-content -->
		</div><!-- /.modal -->

		<!-- Add dinner modal -->
        <div class="modal" tabindex="-1" role="dialog" id="dinner-modal">
            <div class="modal-content">
				<div class="modal-header">
					<h4>Add Dinner Items:</h4>
                   	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
               	</div>
               	<div class="modal-body" id="dinner-modal-body">
               	    <form method="post">
               	        <div>
               	            <label for="selection">Location</label>
							<select class="form-control" onchange="updateDinner(this.value)" id="dinner-location-select">
								<option value="" disabled selected hidden>--</option>
								<option>Pre-Saved Dinner</option>
								<option>North Dining Hall</option>
								<option>South Dining Hall</option>
								<option>Modern Market</option>
								<option>Star Ginger</option>
								<option>Smashburger</option>
								<option>Subway</option>
								<option>Taco Bell</option>
               	            	<option>Custom Food</option>
               	            </select>
						</div>
						<div id="dinner-food-selection">			
						</div>
               	    </form>
               	</div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal -->


        <!-- Save dinner modal -->
        <div class="modal" tabindex="-1" role="dialog" id="dinner-save-modal">
            <div class="modal-content">
				<div class="modal-header">
					<h4>Save your dinner to be easily loaded on other days!</h4>
                   	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
               	</div>
               	<div class="modal-body" id="dinner-save-modal-body">
               	    <form method="post">
						<div>
							<label for ="text-input">Meal Name:</label>
							<input type="text" class="form-control" name="dinner-name">
						</div>
               	        <button type="submit" class="btn btn-primary" name="dinner-save">Save Meal</button>
               	    </form>
               	</div>
            </div><!-- /.modal-content -->
		</div><!-- /.modal -->

		<!-- Add snack modal -->
        <div class="modal" tabindex="-1" role="dialog" id="snack-modal">
            <div class="modal-content">
				<div class="modal-header">
					<h4>Add Snack Items:</h4>
                   	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
               	</div>
               	<div class="modal-body" id="snack-modal-body">
               	    <form method="post">
               	        <div>
               	            <label for="selection">Location</label>
							<select class="form-control" onchange="updateSnack(this.value)" id="snack-location-select">
								<option value="" disabled selected hidden>--</option>
								<option>Pre-Saved Snack</option>
               	            	<option>Custom Food</option>
               	            </select>
						</div>
						<div id="snack-food-selection">			
						</div>
               	    </form>
               	</div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal -->


        <!-- Save snack modal -->
        <div class="modal" tabindex="-1" role="dialog" id="snack-save-modal">
            <div class="modal-content">
				<div class="modal-header">
					<h4>Save your snacks to be easily loaded on other days!</h4>
                   	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
               	</div>
               	<div class="modal-body" id="snack-save-modal-body">
               	    <form method="post">
						<div>
							<label for ="text-input">Snack Name:</label>
							<input type="text" class="form-control" name="snack-name">
						</div>
               	        <button type="submit" class="btn btn-primary" name="snack-save">Save Snack</button>
               	    </form>
               	</div>
            </div><!-- /.modal-content -->
		</div><!-- /.modal -->

		<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
		<script src="scripts/updateModal.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

	</body>
</html>

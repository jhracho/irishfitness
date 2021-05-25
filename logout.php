<?php
	session_start();
	session_destroy();
	unset($_SESSION['username']);
	unset($_SESSION['firstname']);
	unset($_SESSION['lastname']);
	unset($_SESSION['userid']);
	$_SESSION = [];
	header('location: index.html');
?>

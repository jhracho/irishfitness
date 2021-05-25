<?php
include('scripts/connect.php');
?>

<?php
$exercise = $_GET['exercise'];
$_SESSION['exercises'][] = $exercise;
?>

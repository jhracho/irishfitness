<?php

$hostname = 'localhost';
$username = 'jhracho';
$password = 'IrishFitness';
$database = 'jhracho';

$con = mysqli_connect($hostname, $username, $password, $database);
if (!$con){
    die("Connection failed: ".mysqli_connect_error());
}

?>

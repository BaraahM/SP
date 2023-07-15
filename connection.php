<?php

//the following variables should be changed based on the database information
$db_host = 'localhost'; // database host
$db_name = 'secureprogramming'; // database name
$db_user = 'root'; // database username
$db_pass = ''; // database password

// Connect to the database
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if (!$conn) {
	die("Connection failed: " . mysqli_connect_error());
}

?>

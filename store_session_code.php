<?php
require_once 'connection.php'; //to connect to database
session_destroy();

session_start();
$_SESSION['token'] = $token;


// Retrieve the session details from the AJAX request
$token = $_POST['token'];
$username = $_POST['username'];
$created_at = $_POST['created_at'];
$ip_address = $_SERVER['REMOTE_ADDR']; // Get the user's IP address

// Insert the session details into the database
$sql = "INSERT INTO sessions (token, username, created_at, ip_address) VALUES (?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ssss", $token, $username, $created_at, $ip_address);

if (mysqli_stmt_execute($stmt)) {
  // Success! Session details stored in the database
  echo "Session details stored successfully.";
} else {
  // Error occurred while storing session details
  echo "Error storing session details: " . mysqli_error($conn);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
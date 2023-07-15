<?php
session_start();

require_once 'connection.php'; //to connect to database
require "mail.php"; //to send emails

if($_SERVER["REQUEST_METHOD"] == "POST") { //if data is recieved (ie form submitted)
    $emailOrUsername = trim($_POST["emailOrUsername"]); 
    $password = trim($_POST["password"]);

    // Get the user's IP address
    $userIP = $_SERVER['REMOTE_ADDR'];


    $sql = "SELECT * FROM users WHERE (email = ? OR user_name = ?)"; //find the username or email from the database
    if($stmt = mysqli_prepare($conn, $sql)){
        mysqli_stmt_bind_param($stmt, "ss", $param_emailOrUsername, $param_emailOrUsername);
        $param_emailOrUsername = $emailOrUsername;
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
            if(mysqli_num_rows($result) == 1){ //check if there is a match in the database or not.
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                $_SESSION['Email'] = $row['email'];
                $_SESSION['Username'] = $row['user_name'];
                $hashed_password = $row['password'];
                $salt = $row['salt'];
                $hashed_input_password = hash('sha256', $password . $salt); //the password inputed by the user after salting and hashing

                if($hashed_input_password == $hashed_password) { //check passwords
                    header("location: codeValidate.php");
                } else { //if the password is wrong 
                    header("location: login.php?error=Incorrect email/username or password");
                }
            } else { //if the email/user isn't found
                header("location: login.php?error=Incorrect email/username or password");
            }
        }
    }
}
?>
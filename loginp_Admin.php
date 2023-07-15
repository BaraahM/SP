<?php
session_start();
require_once 'connection.php'; //to connect to database

if($_SERVER["REQUEST_METHOD"] == "POST") { //if data is recieved (ie form submitted)
    $emailOrUsername = trim($_POST["emailOrUsername"]); 
    $password = trim($_POST["password"]);

    // Get the user's IP address
    $userIP = $_SERVER['REMOTE_ADDR'];


    $sql = "SELECT * FROM admin WHERE (email = ? OR user_name = ?)"; //find the username or email from the database
    if($stmt = mysqli_prepare($conn, $sql)){
        mysqli_stmt_bind_param($stmt, "ss", $param_emailOrUsername, $param_emailOrUsername);
        $param_emailOrUsername = $emailOrUsername;
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
            if(mysqli_num_rows($result) == 1){ //check if there is a match in the database or not.
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                
                $hashed_password = $row['password'];
                $salt = $row['salt'];
                $hashed_input_password = hash('sha256', $password . $salt); //the password inputed by the user after salting and hashing

                if($hashed_input_password == $hashed_password) { //check passwords
                    // generate token
                    $token = bin2hex(random_bytes(32));
                    $username = $row['user_name'];
                    $created_at = date('Y-m-d H:i:s');

                    // save token in session
                    $_SESSION['token'] = $token;

                    // save token in database
                    $sql = "INSERT INTO sessions (token, username, created_at, ip_address) VALUES (?, ?, ?, ?)";
                    if ($stmt = mysqli_prepare($conn, $sql)) {
                        mysqli_stmt_bind_param($stmt, "ssss", $token, $username, $created_at, $userIP);
                        if (mysqli_stmt_execute($stmt)) {
                            // redirect to dashboard
                            header("location: usermanagement.php");
                        } else {
                            // handle database error
                            echo "Oops! Something went wrong. Please try again later.";
                        }
                        mysqli_stmt_close($stmt);
                    } else {
                        // handle database error
                        echo "Oops! Something went wrong. Please try again later.";
                    }
                } else { //if the password is wrong 
                    header("location: login_Admin.php?error=Incorrect email/username or password");
                }
            } else { //if the email/user isn't found
                header("location: login_Admin.php?error=Incorrect email/username or password");
            }
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($conn);
}
?>
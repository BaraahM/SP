<?php
require_once "connection.php";
require "mail.php"; //to send emails


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);

    // Check if email exists in database
    $query = "SELECT * FROM users WHERE email = ?";
    if ($stmt = mysqli_prepare($conn, $query)) {
        mysqli_stmt_bind_param($stmt, "s", $param_email);
        $param_email = $email;

        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_store_result($stmt);

            // Check if email exists
            if (mysqli_stmt_num_rows($stmt) == 1) {
                // Generate random code
                $code = rand(10000, 99999);

                // Update the password_resets table with the generated code and email
                $updateQuery = "INSERT INTO password_resets (email, code, expires_at) VALUES (?, ?, NOW() + INTERVAL 1 HOUR)";
                if ($updateStmt = mysqli_prepare($conn, $updateQuery)) {
                    mysqli_stmt_bind_param($updateStmt, "ss", $param_email, $param_code);
                    $param_email = $email;
                    $param_code = $code;

                    if (mysqli_stmt_execute($updateStmt)) {
                        // Send code to user's email
                        $message = "Your code to recover your password is " . $code . ". If you didn't request this, please ignore this email.";
                        $subject = "Password Recovery Verification";

                        
                        Sendmail($email, $subject, $message);
                        header("location: resetpassword.php");
                        //header("location: resetpassword.php?email=" . urlencode($email));

                    
                    } else {
                        echo "Oops! Something went wrong. Please try again later.";
                    }
                }
                mysqli_stmt_close($updateStmt);
            } else {
                // Email doesn't exist in the password_resets table
                header("location: forgotpassword.php?error=Email not found");
            }
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
    mysqli_stmt_close($stmt);
}
mysqli_close($conn);
?>

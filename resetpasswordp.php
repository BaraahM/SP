<?php
require_once "connection.php";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $code = trim($_POST["code"]);
    $password = trim($_POST["password"]);
    $confirm_password = trim($_POST["confirm_password"]);

    // Validate password
    if(empty($password)) {
        $password_err = "Please enter a password.";
    } elseif(strlen($password) < 6) {
        $password_err = "Password must have at least 6 characters.";
    } else {
        $password_pattern = "/^[a-zA-Z0-9!@#$%^&*()_+=-]{6,}$/";
        if(!preg_match($password_pattern, $password)) {
            $password_err = "Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.";
        }
    }

    // Validate confirm password
    if(empty($confirm_password)) {
        $confirm_password_err = "Please confirm the password.";
    } elseif($password != $confirm_password) {
        $confirm_password_err = "Passwords do not match.";
    }

    if(empty($password_err) && empty($confirm_password_err)) {
        // Check if email and code are valid
        $query = "SELECT * FROM password_resets WHERE email = ? AND code = ? AND expires_at > NOW()";
        if($stmt = mysqli_prepare($conn, $query)) {
            mysqli_stmt_bind_param($stmt, "ss", $param_email, $param_code);
            $param_email = $email;
            $param_code = $code;

            if(mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);

                if(mysqli_stmt_num_rows($stmt) == 1) {
                    $salt = bin2hex(random_bytes(16));
                    $hashedPassword = hash('sha256', ($password . $salt));


                    // Update password in users table
                    $query = "UPDATE users SET password = ?, salt = ? WHERE email = ?";
                    if($stmt = mysqli_prepare($conn, $query)) {
                        mysqli_stmt_bind_param($stmt, "sss", $param_password, $param_salt, $param_email);
                        $param_password = $hashedPassword;
                        $param_email = $email;
                        $param_salt = $salt;

                        if(mysqli_stmt_execute($stmt)) {
                            // Delete password reset record from password_resets table
                            $query = "DELETE FROM password_resets WHERE email = ?";
                            if($stmt = mysqli_prepare($conn, $query)) {
                                mysqli_stmt_bind_param($stmt, "s", $param_email);
                                $param_email = $email;

                                mysqli_stmt_execute($stmt);
                                header("location: login.php");
                            } else {
                                echo "Oops! Something went wrong. Please try again later.";
                            }
                        } else {
                            echo "Oops! Something went wrong. Please try again later.";
                        }
                    }
                } else {
                    header("location: resetpassword.php?email=$email&code=$code&error=Invalid email or code");
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($conn);
}
?>
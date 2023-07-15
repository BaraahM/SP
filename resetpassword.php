<!---Design for the reset password page --->
<!DOCTYPE html>
<html>
<head>
    <title>Reset Password Page</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="resetpassword.js"></script>
</head>

<body>
    <div class="container">
        <h2>Reset Password</h2>
        <form action="resetpasswordp.php" method="POST" onsubmit="return validateForm()">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>
            <label for="code">Code:</label>
            <input type="text" name="code" id="code" required>
            <label for="password">New Password:</label>
            <input type="password" name="password" id="password" required>
            <span id="password_err" class="error"></span>
            <label for="confirm_password">Confirm Password:</label>
            <input type="password" name="confirm_password" id="confirm_password" required>
            <span id="confirm_password_err" class="error"></span>
            <input type="submit" value="Reset Password">
            <?php if (isset($_GET['error'])) : ?>
                <p class="error"><?php echo $_GET['error']; ?></p>
            <?php endif; ?>

            <p>Go Back to Login Page? <a href="login.php">Press here</a></p>

        </form>
    </div>
</body>

</html>

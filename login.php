<!--- Login page design --->
<!DOCTYPE html>
<html>
<head>
	<title>Login Page</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<div class="container">
	<a href="login_Admin.php" class="user-management-link">User Management</a>
		<h2>Login Form</h2>
		<form action="loginp.php" method="post" name="loginForm" onsubmit="return validateLoginForm()">
			<label for="emailOrUsername">Email/Username</label>
			<input type="text" name="emailOrUsername" id="emailOrUsername">

			<label for="password">Password</label>
			<input type="password" name="password" id="password">

			<input type="submit" value="Login">
		</form>
		<?php
            if(isset($_GET['error'])) {
                echo '<p class="error">' . $_GET['error'] . '</p>';
            }
        ?>
		<p>Don't have an account? <a href="register.html">Signup here</a></p>
		<p>Forgot your password? <a href="forgotpassword.php">Recover password</a></p>

	</div>

	<script type="text/javascript" src="script.js"></script>
</body>
</html>

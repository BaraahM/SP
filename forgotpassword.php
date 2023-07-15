<!DOCTYPE html>
<html>
<head>
	<title>Forgot Password Page</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
  <div class="container">
    <h2>Forgot Password</h2>
    <?php if(isset($_GET["error"])) { ?>
      <p class="error"><?php echo $_GET["error"]; ?></p>
    <?php } ?>
    <form action="forgotpasswordp.php" method="post">
      <label for="email">Email</label>
      <input type="email" id="email" name="email" required>
      <input type="submit" value="Submit">
      <p>Go Back to Login Page? <a href="login.php">Press here</a></p>

    </form>
  </div>
</body>

</html>
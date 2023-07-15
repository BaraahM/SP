<?php
session_start();
require "mail.php"; //to send emails


$code = rand(10000, 99999);
$email = $_SESSION['Email'];
$username = $_SESSION['Username'];
$message = "Your code to login is " . $code;
$subject = "Login verification";

Sendmail($email, $subject, $message);

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Code Validation</title>
  <link rel="stylesheet" type="text/css" href="style.css">
  <script>
    var code = "<?php echo $code; ?>"; // Assign PHP variable to JavaScript variable
  </script>
</head>
<body>
  <div class="container">
    <h2>Code Validation</h2>
    <form id="codeForm">
      <label for="codeInput">Enter the 5-digit code:</label>
      <input type="text" id="codeInput" maxlength="5">
      <div id="errorText" class="error"></div>
      <input type="submit" value="Submit">
    </form>
    <div id="timer" class="timer"></div>
    <div id="newCodeLink" class="user-management-link">Send New Code</div>
    <div id="emailMessage" class="email-message"><?php echo $email; ?></div>
  </div>

  <script src="scriptCode.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    // Code to send the new session code to the database
    function sendNewSessionCode() {
      var token = "<?php echo bin2hex(random_bytes(32)); ?>"; // Generate a new session token
      var username = "<?php echo $username; ?>"; // Replace with the actual username variable you have
      var created_at = "<?php echo time(); ?>"; // Replace with the actual created_at timestamp

      // Send an AJAX request to store the new session code in the database
      $.ajax({
        url: "store_session_code.php",
        type: "POST",
        data: { token: token, username: username, created_at: created_at },
        success: function(response) {
          console.log(response);
        },
        error: function(xhr, status, error) {
          console.log(error);
        }
      });
    }
  </script>
</body>
</html>

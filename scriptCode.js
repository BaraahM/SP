document.getElementById("codeForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent form submission
  
    var codeInput = document.getElementById("codeInput").value;
    var errorText = document.getElementById("errorText");
    var validCode = code; // Use the generated code from PHP
  
    // Validate if the input is numeric and has 5 digits
    if (!/^\d{5}$/.test(codeInput)) {
      errorText.textContent = "Invalid code. Please enter a 5-digit numeric code.";
    } else if (codeInput !== validCode) {
      errorText.textContent = "Invalid code. The code entered does not match.";
    } else {
      // Code is valid
      errorText.textContent = ""; // Clear any previous error messages
      alert("Code is valid!"); // Perform desired action for valid code
      
      // Call the function to send the new session code to the database
      //sendNewSessionCode();
  
      // Redirect to the dashboard page
      window.location.href = "Validated.php";
    }
  });
  
  document.getElementById("codeInput").addEventListener("input", function() {
    var codeInput = this.value;
    var errorText = document.getElementById("errorText");
  
    if (/\D/.test(codeInput)) {
      errorText.textContent = "Invalid code. Only numeric digits are allowed.";
    } else {
      errorText.textContent = "";
    }
  });  
  
  function resetForm() {
    document.getElementById("codeInput").value = "";
    startTimer(5 * 60);
    document.getElementById("newCodeLink").style.display = "none"; // Hide new code link on form reset
    document.getElementById("emailMessage").style.display = "none"; // Hide email message on form reset
  }
  
  function startTimer(duration) {
    var timerDisplay = document.getElementById("timer");
    var newCodeLink = document.getElementById("newCodeLink");
    var emailMessage = document.getElementById("emailMessage");
    var start = Date.now();
    var end = start + duration * 1000;
  
    function updateTimer() {
      var remaining = Math.max(0, end - Date.now());
      var minutes = Math.floor(remaining / 60000);
      var seconds = Math.floor((remaining % 60000) / 1000);
  
      timerDisplay.textContent = minutes.toString().padStart(2, "0") + ":" + seconds.toString().padStart(2, "0");
  
      if (remaining <= 0) {
        clearInterval(timer);
        timerDisplay.textContent = "Expired";
        document.getElementById("codeInput").disabled = true; // Disable input field after expiration
        newCodeLink.style.display = "block"; // Show new code link after expiration
        emailMessage.style.display = "block"; // Show email message after expiration
      }
    }
  
    updateTimer();
    var timer = setInterval(updateTimer, 1000);
  }
  
  // Hide new code link and email message initially
  document.getElementById("newCodeLink").style.display = "none";
  document.getElementById("emailMessage").style.display = "none";
  
  // Start the timer initially
  startTimer(5 * 60);
  
  // Redirect to a different page when the "Send New Code" link is clicked
  document.getElementById("newCodeLink").addEventListener("click", function() {
    window.location.href = "new-code-page.html"; // Replace "new-code-page.html" with the desired URL
  });
  
  // Set the email message text based on the provided variable
  var email = "<?php echo $email; ?>"; // Retrieve the email variable from PHP
  document.getElementById("emailMessage").textContent = "The code has been sent to your email: " + email;
  
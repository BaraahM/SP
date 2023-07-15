function validateRegisterationForm() {
	var username = document.forms["registrationForm"]["username"].value;
	var email = document.forms["registrationForm"]["email"].value;
	var password = document.forms["registrationForm"]["password"].value;
	var confirmPassword = document.forms["registrationForm"]["confirmPassword"].value;

	// Username validation
	if (username.length < 3 || username.length > 20) {
		alert("Username must be between 3 and 20 characters");
		return false;
	}

	// Email validation
	var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
	if (!emailRegex.test(email)) {
		alert("Invalid email format");
		return false;
	}

	// Password validation
	var passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,25}$/;
	if (!passwordRegex.test(password)) {
		alert("Password must have at least 1 lowercase character, 1 uppercase character, 1 special character, and be between 6 and 25 characters");
		return false;
	}

	// Confirm password validation
	if (password !== confirmPassword) {
		alert("Passwords do not match");
		return false;
	}

	return true;
}


function validateLoginForm() {
    var emailOrUsername = document.forms["loginForm"]["emailOrUsername"].value;
    var password = document.forms["loginForm"]["password"].value;
  
    if (emailOrUsername == "") {
      alert("Please enter your email or username.");
      return false;
    }
  
    if (password == "") {
      alert("Please enter your password.");
      return false;
    }
  
    return true;
  }
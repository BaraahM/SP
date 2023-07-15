function validateForm() {
    var password = document.getElementById("password").value;
    var confirm_password = document.getElementById("confirm_password").value;
    var password_err = document.getElementById("password_err");
    var confirm_password_err = document.getElementById("confirm_password_err");
    var error_count = 0;

    // Validate password
    if (password === "") {
        password_err.innerHTML = "Please enter a password.";
        error_count++;
    } else if (password.length < 6) {
        password_err.innerHTML = "Password must have at least 6 characters.";
        error_count++;
    } else {
        var password_pattern = /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{6,}$/;
        if (!password_pattern.test(password)) {
            password_err.innerHTML = "Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.";
            error_count++;
        } else {
            password_err.innerHTML = "";
        }
    }

    // Validate confirm password
    if (confirm_password === "") {
        confirm_password_err.innerHTML = "Please confirm the password.";
        error_count++;
    } else {
        if (password !== confirm_password) {
            confirm_password_err.innerHTML = "Passwords do not match.";
            error_count++;
        } else {
            confirm_password_err.innerHTML = "";
        }
    }

    if (error_count === 0) {
        return true;
    } else {
        return false;
    }
}

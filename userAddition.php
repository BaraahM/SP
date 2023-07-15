<?php

require_once 'connection.php';

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	
	// Retrieve the registration data from the form
	$username = $_POST['username'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$confirmPassword = $_POST['confirmPassword'];

	// Variable to validate the registration data
	$errors = array();

	// Check if the username is between 3 and 20 characters
	if (strlen($username) < 3 || strlen($username) > 20) {
		$errors[] = "Username must be between 3 and 20 characters";
	}

	// Check if the email is valid
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$errors[] = "Invalid email format";
	}

	// Check if the password is between 6 and 25 characters and contains at least one lowercase, one uppercase, one digit, and one special character
	if (strlen($password) < 6 || strlen($password) > 25 || !preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,25}$/', $password)) {
		$errors[] = "Password must have at least 1 lowercase character, 1 uppercase character, 1 digit, 1 special character, and be between 6 and 25 characters";
	}

	// Check if the password and confirm password match
	if ($password !== $confirmPassword) {
		$errors[] = "Passwords do not match";
	}
    
    // Check if the email is already taken (by checking if there is a matchin in the database)
    $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $errors[] = "This email is already taken.";
    }

    // Check if the username is already taken (by checking if there is a matchin in the database)
    $stmt = $conn->prepare("SELECT * FROM users WHERE user_name=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $errors[] = "This username is already taken.";
    }

    // If there are no errors, insert the data into the database
    if (empty($errors)) {
        $sql="SELECT * FROM users";
        $result=mysqli_query($conn,$sql);
        $rowcount=mysqli_num_rows($result);
        
        $user_id = $rowcount + 1;

        // Hash and salt the password
        $salt = bin2hex(random_bytes(16));
        $hashedPassword = hash('sha256', ($password . $salt));

        // Insert the registration data into the database
        $stmt = $conn->prepare("INSERT INTO users (user_id,user_name, email, password, salt) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param('sssss',$user_id, $username, $email, $hashedPassword, $salt);
        if ($stmt->execute()) {
            echo "Registration successful";
            header('location:usermanagement.php');
        } else {
            echo "Error: " . $stmt->error;
        }

    } else {
        // Display the errors
        foreach ($errors as $error) {
            echo "<p class='error'>" . $error . "</p>";
        }
    }

    // Close the database connection
    mysqli_close($conn);
    }
    ?>

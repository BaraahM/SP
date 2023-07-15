<?php
session_start();
require_once 'connection.php'; // to connect to the database

// Function to validate the credit card number
function validateCardNumber($cardNumber)
{
    // Return true if the card number is valid, false otherwise
    // Example validation: check if the card number is numeric and has a specific length
    return is_numeric($cardNumber) && strlen($cardNumber) === 16;
}

// Function to validate the expiration date
function validateExpirationDate($expirationDate)
{
    // Return true if the expiration date is valid, false otherwise
    // Example validation: check if the expiration year and month are in the future
    $currentYear = date('Y');
    $currentMonth = date('m');

    $inputYear = substr($expirationDate, 0, 4);
    $inputMonth = substr($expirationDate, 4, 2);

    if ($inputYear > $currentYear) {
        return true; // Expiration year is in the future
    } elseif ($inputYear == $currentYear && $inputMonth >= $currentMonth && $inputMonth <= 12 && $inputMonth >= 1) {
        return true; // Expiration year is the current year and the month is in the future or current
    } else {
        return false; // Expiration year is in the past or the month is invalid
    }
}

// Function to validate the CVV
function validateCVV($cvv)
{
    // Return true if the CVV is valid, false otherwise
    // Example validation: check if the CVV is numeric and has a specific length
    return is_numeric($cvv) && (strlen($cvv) === 3 || strlen($cvv) === 4);
}

// Function to encrypt the credit card information using SHA-256
function encrypt($data)
{
    $hash = hash('sha256', $data); // Apply SHA-256 hashing to the data
    return $hash;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") { // if data is received (i.e., form submitted)
    // Retrieve and sanitize payment details from the form
    $cardNumber = trim($_POST["card_number"]);
    $expirationDate = trim($_POST["expiration_date"]);
    $cvv = trim($_POST["cvv"]);
    $orderId = $_POST['order_id'];
    

    // Perform credit card validation
    if (validateCardNumber($cardNumber) && validateExpirationDate($expirationDate) && validateCVV($cvv)) {
        // Encrypt the credit card information using SHA-256 before storing it in the database
        $encryptedCardNumber = encrypt($cardNumber);
        $encryptedExpirationDate = encrypt($expirationDate);
        $encryptedCvv = encrypt($cvv);

        // Save the payment details in the database
        $sql = "INSERT INTO payments (order_id, card_number, expiration_date, cvv) VALUES (?, ?, ?, ?)";
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "ssss", $param_orderId, $param_cardNumber, $param_expirationDate, $param_cvv);
            $param_orderId = $orderId;
            $param_cardNumber = $encryptedCardNumber;
            $param_expirationDate = $encryptedExpirationDate;
            $param_cvv = $encryptedCvv;

            if (mysqli_stmt_execute($stmt)) {
                // Update the corresponding row in the orders table to mark it as paid
                $updateSql = "UPDATE orders SET isPaid = 1 WHERE session_id = ?";
                if ($updateStmt = mysqli_prepare($conn, $updateSql)) {
                    mysqli_stmt_bind_param($updateStmt, "i", $param_orderId);
                    $param_orderId = $orderId;
                    mysqli_stmt_execute($updateStmt);
                    mysqli_stmt_close($updateStmt);
                }

                // Redirect to a success page or display a success message
                header("location: payment_success.php?order_id=$orderId");
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Invalid credit card details. Please try again.";
    }
} else {
    echo "Invalid request.";
}
mysqli_close($conn);

<?php

session_start();
require_once 'connection.php'; // to connect to the database

if (isset($_SESSION['username']) && isset($_SESSION['token'])) { // check if the user is logged in
    if ($_SERVER["REQUEST_METHOD"] == "POST") { // if data is received (i.e., form submitted)
        $size = trim($_POST["size"]);
        $crust = trim($_POST["crust"]);
        $type = trim($_POST["type"]);
        $username = $_SESSION['username'];
        $token = $_POST['order_id'];
        $orderId = $_POST['order_id'];



        // Get the user's IP address
        $userIP = $_SERVER['REMOTE_ADDR'];

        // Verify token and IP address
        $sql = "SELECT * FROM sessions WHERE username = ? AND session_id = ? ORDER BY created_at ASC LIMIT 1";
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_token);
            $param_username = $username;
            $param_token = $token;
            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);
                if (mysqli_num_rows($result) == 1) { // if the token and IP address are valid
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    //$session_id = $row['session_id'];
                    $session_id = $_POST['order_id'];

                    // Save the pizza order to the database
                    $sql = "INSERT INTO orders (session_id, size, crust, type, price, isPaid) VALUES (?, ?, ?, ?, ?, ?)";
                    if ($stmt = mysqli_prepare($conn, $sql)) {
                        mysqli_stmt_bind_param($stmt, "ssssdi", $param_session_id, $param_size, $param_crust, $param_type, $param_price, $param_isPaid);
                        $param_session_id = $_POST['order_id'];
                        $param_size = $size;
                        $param_crust = $crust;
                        $param_type = $type;
                        $param_price = $_POST['price']; // Retrieve the price from the form
                        $param_isPaid = 0;
                        if (mysqli_stmt_execute($stmt)) {
                            //$order_id = mysqli_insert_id($conn); // Retrieve the newly inserted order_id
                            mysqli_stmt_close($stmt);
                            mysqli_close($conn);
                            header("location: payment_form.php?order_id=$session_id"); // Redirect to payment form with the order_id
                        } else {
                            echo "Oops! Something went wrong. Please try again later.";
                        }
                    } else {
                        echo "Oops! Something went wrong. Please try again later.";
                    }
                } else {
                    header("location: login.php"); // redirect to login page
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
} else {
    header("location: login.php"); // redirect to login page
}

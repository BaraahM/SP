<?php
    require_once 'connection.php'; // to connect to the database
    session_start();

    // generate token
    $sql = "SELECT * FROM users WHERE (email = ?)"; //find the username or email from the database
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    $email = $_SESSION['Email'];
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $token = bin2hex(random_bytes(32));
    $username = $row['user_name'];
    $created_at = time();
    // Get the user's IP address
    $userIP = $_SERVER['REMOTE_ADDR'];
    // save token in session
    $_SESSION['token'] = $token;
    $_SESSION['username'] = $username;

    // save token in database
    $sql = "INSERT INTO sessions (session_id, username, created_at, ip_address) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssss", $token, $username, $created_at, $userIP);
    mysqli_stmt_execute($stmt);
    // redirect to dashboard
    header("location: order_pizza.php?order_id=$token");
?>
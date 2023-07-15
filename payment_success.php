<!DOCTYPE html>
<html>
<head>
    <title>Payment Success</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script type="text/javascript">
        // Function to redirect the user to the pizza order page after a delay
        function redirect() {
            const order_id = "<?php echo $_GET['order_id']; ?>";
            window.location = `order_pizza.php?order_id=${order_id}`;
        }

        // Wait for 10 seconds and then redirect
        setTimeout(redirect, 10000);
    </script>
</head>
<body>
    <div class="container">
        <h2>Payment Successful</h2>
        <p>Your payment has been processed successfully. Thank you for your order!</p>
        <p>You will be redirected back to the pizza order page in 10 seconds. If not, <a href="order_pizza.php?order_id=<?php echo $_GET['order_id']; ?>">click here</a>.</p>
    </div>
</body>
</html>
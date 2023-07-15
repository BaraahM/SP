<!DOCTYPE html>
<html>
<head>
    <title>Payment</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Payment</h2>
        <form action="process_payment.php" method="POST">
            <input type="hidden" name="order_id" id ="order_id" value="<?php echo $_GET['order_id']; ?>">
            <label for="card_number">Card Number:</label>
            <input type="text" name="card_number" id="card_number" required><br><br>

            <label for="expiration_date">Expiration Date (YYYYMM):</label>
            <input type="text" name="expiration_date" id="expiration_date" required><br><br>

            <label for="cvv">CVV:</label>
            <input type="text" name="cvv" id="cvv" required><br><br>

            <input type="submit" value="Pay">
        </form>
    </div>
</body>
</html>

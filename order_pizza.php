
<!DOCTYPE html>
<html>
<head>
    <title>Order Pizza</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Order Pizza</h1>
        <form action="order_pizzap.php" method="POST">
        <input type="hidden" name="order_id" id="order_id" value="<?php echo $_GET['order_id']; ?>">
            <input type="hidden" name="price" id="price" value="">

            <label for="size">Size:</label>
            <select name="size" id="size" onchange="updatePrice()">
                <option value="small">Small ($12)</option>
                <option value="medium">Medium ($16)</option>
                <option value="large">Large ($22)</option>
            </select><br><br>

            <label for="crust">Crust:</label>
            <select name="crust" id="crust">
                <option value="thin">Thin</option>
                <option value="thick">Thick</option>
                <option value="deep dish">Deep Dish</option>
            </select><br><br>

            <label for="type">Type:</label>
            <select name="type" id="type">
                <option value="vegan">Vegan Pizza</option>
            </select><br><br>

            <input type="submit" value="Order">
        </form>
        <script type="text/javascript" src="script.js"></script>
        <script type="text/javascript">
            function updatePrice() {
                var sizeSelect = document.getElementById("size");
                var priceField = document.getElementById("price");
                if (sizeSelect.value === "small") {
                    priceField.value = "12";
                } else if (sizeSelect.value === "medium") {
                    priceField.value = "16";
                } else if (sizeSelect.value === "large") {
                    priceField.value = "22";
                }
            }
        </script>
    </div>
</body>
</html>

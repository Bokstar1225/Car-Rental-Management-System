<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Renting Out a Car</title>
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <form id="loginForm" action="login.php" method="POST">
            <div class="form-group">
                <label for="car-name">Car Name</label>
                <input type="text" id="car-name" name="car-name" placeholder="Enter The Car">
            </div><br>
            
            <div class="form-group">
                <label for="customer">Customer</label>
                <input type="text" id="customer" name="customer" placeholder="Enter The Customers Name">
            </div>

            <div class="form-group">
                <label for="rent-date">Rent Date</label>
                <input type="date" id="password" name="password">
            </div>

            <div class="form-group">
                <label for="return-date">Return Date</label>
                <input type="date" id="return-date" name="return-date">
            </div>
            
            <button type="submit" name="rent">Rent Car</button>
        </form>
         <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    </div>

    <?php
        if($_SERVER['REQUEST_METHOD'] === "POST")
    ?>
</body>
</html>
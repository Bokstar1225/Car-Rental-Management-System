<?php
    session_start();
    include "../includes/db.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Open Sans', sans-serif;
        }
        
        body {
            background-color: whitesmoke;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        
        .container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            padding: 30px;
        }
        
        h2 {
            color: #2c3e50;
            text-align: center;
            margin-bottom: 30px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #34495e;
        }
        
        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 16px;
            transition: border 0.3s;
        }
        
        input:focus {
            outline: none;
            border-color: #3498db;
            box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.2);
        }
        
        .error {
            color: #e74c3c;
            font-size: 13px;
            margin-top: 5px;
            display: none;
        }
        
        button {
            background-color: #c0392b;
            color: white;
            border: none;
            border-radius: 6px;
            padding: 14px;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s;
        }
        
        .success-message {
            background-color: #2ecc71;
            color: white;
            padding: 15px;
            border-radius: 6px;
            text-align: center;
            margin-top: 20px;
            display: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Add New Car</h2>
        <form action="add_car.php" method="POST">
            <div class="form-group">
                <label for="brand">Brand</label>
                <input type="text" id="brand" name="brand" placeholder="Enter the car brand">
                <div class="error" id="nameError">Please enter a valid first name</div>
            </div>
            
            <div class="form-group">
                <label for="model">Model</label>
                <input type="text" id="model" name="model" placeholder="Enter the car model">
                <div class="error" id="surnameError">Please enter a valid last name</div>
            </div>
            
            <div class="form-group">
                <label for="plate-number">Plate Number</label>
                <input type="text" id="plate-number" name="plate-number" placeholder="Enter the plate number">
                <div class="error" id="emailError">Please enter a valid email address</div>
            </div>

            <div class="form-group">
                <label for="car">Upload Car Image</label>
                <input type="file" id="car" name="car">
                <div class="error" id="emailError">Please enter a valid email address</div>
            </div>
            
            <div class="form-group">
                <label for="status">Status</label>
                <input type="text" id="status" name="status">
                <div class="error" id="phoneError">Please enter a valid phone number</div>
            </div>
            
            <button type="submit" name="Add">Add Car</button>
        </form>
    </div>

    <?php
        if($_SERVER["REQUEST_METHOD"] === "POST"){
            $brand = $_POST['brand'];
            $model = $_POST['model'];

            $plateNumber = $_POST['plate-number'];
            $status = $_POST['status'];
        }
    ?>
</body>
</html>
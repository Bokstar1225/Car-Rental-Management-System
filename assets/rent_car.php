<?php
    session_start();
    include "../includes/db.php";

    if(!isset($_SESSION['admin'])){
        header("location: login.php");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Renting Out a Car</title>
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
            height: 600px;
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
            margin-top: 75px;
            transition: background-color 0.3s;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Rent out a car</h2>
        <form id="loginForm" action="rent_car.php" method="POST">
            <div class="form-group">
                <label for="customer_id">Customer</label>
                <select name="customer_id" required>
                <?php
                    $customers = $conn->query("SELECT CustomerID, Name FROM customers");
                    while($c = $customers->fetch(PDO::FETCH_ASSOC)){
                        echo "<option value='{$c['CustomerID']}'>{$c['Name']}</option>";
                    }
                ?>
                </select>
            </div><br>
            
            <div class="form-group">
                <label for="car_id">Car</label>
                <select name="car_id" required>
                <?php
                    $cars = $conn->query("SELECT CarID, Brand FROM cars WHERE Status = 'Available'");
                    while($car = $cars->fetch(PDO::FETCH_ASSOC)){
                        echo "<option value='{$car['CarID']}'>{$car['Brand']}</option>";
                    }
                ?>
                </select>
            </div>

            <div class="form-group">
                <label for="rental_date">Rent Date</label>
                <input type="date" id="rental_date" name="rental_date" required>
            </div>

            <div class="form-group">
                <label for="return_date">Return Date</label>
                <input type="date" id="return_date" name="return_date" required>
            </div>
            
            <button type="submit" name="rent">Rent Car</button>
        </form>
         <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    </div>

    <?php
        if($_SERVER['REQUEST_METHOD'] === "POST"){
            $customer_id = $_POST['customer_id'];
            $car_id = $_POST['car_id'];
            $rental_date = $_POST['rental_date'];
            $return_date = $_POST['return_date'];

            try{
                //Checking if car is already rented
                $checkCar = $conn->prepare("SELECT Status FROM cars WHERE CarID = ?");
                $checkCar->execute([$car_id]);
                $car = $checkCar->fetch(PDO::FETCH_ASSOC);

                if($car && $car['Status'] === 'Rented'){
                    echo "<p style='color:red;'>This car is already rented out.</p>";
                
                }else{
                    // Start transaction (so both insert + update succeed together)
                    $conn->beginTransaction();

                    //Inserting rental record
                    $stmt = $conn->prepare("INSERT INTO rentals (CustomerID, CarID, Rent_Date, Return_Date) VALUES (?, ?, ?, ?)");
                    $stmt->execute([$customer_id, $car_id, $rental_date, $return_date]);

                    //Update car status
                    $updateCar = $conn->prepare("UPDATE cars SET Status = 'Rented' WHERE CarID = ?");
                    $conn->commit();
                    
                    if($updateCar->execute([$car_id])){
                        header("location: rentals.php");
                        exit;
                    }
                }
            }catch(PDOException $e){
                $conn->rollBack();
                echo "<p style='color:red;'>Error: " . $e->getMessage() . "</p>";
            }
        }
    ?>
</body>
</html>
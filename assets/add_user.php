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
    <title>Customer Registration</title>
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
        <h2>Add New Customer</h2>
        <form action="add_user.php" method="POST">
            <div class="form-group">
                <label for="name">First Name</label>
                <input type="text" id="name" name="name" placeholder="Enter first name">
                <div class="error" id="nameError">Please enter a valid first name</div>
            </div>
            
            <div class="form-group">
                <label for="surname">Last Name</label>
                <input type="text" id="surname" name="surname" placeholder="Enter last name">
                <div class="error" id="surnameError">Please enter a valid last name</div>
            </div>
            
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" placeholder="Enter email address">
                <div class="error" id="emailError">Please enter a valid email address</div>
            </div>
            
            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="tel" id="phone" name="phone" placeholder="Enter phone number">
                <div class="error" id="phoneError">Please enter a valid phone number</div>
            </div>
            
            <button type="submit" name="Add">Add Customer</button>
        </form>
    </div>

    <?php
        if($_SERVER["REQUEST_METHOD"] === "POST"){
            $name = $_POST['name'];
            $surname = $_POST['surname'];

            $email = $_POST['email'];
            $phoneNumber = $_POST['phone'];

            try {
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                //Inserting into customers table
                $sql = "INSERT INTO customers (Name, Surname, Email, PhoneNumber)
                VALUES (:name, :surname, :email, :phone)";

                //Prepare statements to prevent SQL Injection
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':surname', $surname);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':phone', $phoneNumber);
                
                if ($stmt->execute()) {
                    header("Location: users.php");
                    exit;
                } else {
                    echo "<br>An error has occurred";
                }
            } catch (PDOException $e) {
                echo "An error has occured " . $e->getMessage();
            }

        }
    ?>

    <script>
        document.getElementById('customerForm').addEventListener('submit', function(e) {
            e.preventDefault();
            let isValid = true;
            
            // Reset errors
            document.querySelectorAll('.error').forEach(error => error.style.display = 'none');
            
            // Validate name
            const name = document.getElementById('name').value.trim();
            if (name === '' || name.length < 2) {
                document.getElementById('nameError').style.display = 'block';
                isValid = false;
            }
            
            // Validate surname
            const surname = document.getElementById('surname').value.trim();
            if (surname === '' || surname.length < 2) {
                document.getElementById('surnameError').style.display = 'block';
                isValid = false;
            }
            
            // Validate email
            const email = document.getElementById('email').value.trim();
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                document.getElementById('emailError').style.display = 'block';
                isValid = false;
            }
            
            // Validate phone (basic validation)
            const phone = document.getElementById('phone').value.trim();
            const phoneRegex = /^[\d\s\-\+\(\)]{10,}$/;
            if (!phoneRegex.test(phone)) {
                document.getElementById('phoneError').style.display = 'block';
                isValid = false;
            }
        });
    </script>
</body>
</html>
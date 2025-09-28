<?php
    session_start();
    include "../includes/db.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Registration</title>
    <link rel="stylesheet" type="text/css" href="./css/style 2.css">
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
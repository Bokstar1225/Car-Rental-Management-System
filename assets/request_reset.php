<?php
    include "../includes/db.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
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
            height: 500px;
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
        <h2>Reset Password</h2>
        <form method="POST">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter Your Email">
                <div class="error" id="emailError">Please enter a valid email</div>
            </div><br>
            
            <button type="submit" name="submit">Reset Link</button>
        </form>
    </div>
    
    <?php
        if($_SERVER['REQUEST_METHOD'] === "POST"){
            $email = trim($_POST['email']);

            // Check if email exists in database
            $stmt = $conn->prepare("SELECT AdminID FROM admins WHERE Email = :email");
            $stmt->execute([':email' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if($user){
                // Generate token
                $token = bin2hex(random_bytes(50));
                $expires = date("Y-m-d H:i:s", strtotime("+5 hour"));

                // Store token in DB
                $stmt = $conn->prepare("INSERT INTO password_resets (adminID, token, expires_at) VALUES (:uid, :token, :expires)");
                $stmt->execute([
                    ':uid' => $user['AdminID'],
                    ':token' => $token,
                    ':expires' => $expires
                ]);

                // Reset link
                $resetLink = "http://localhost/car_rental_system/assets/reset_password.php?token=" . $token;

                // Link to reset password since when are sending the link to the email
                $message = "Password reset link (for testing): <a href='$resetLink'>$resetLink</a>";
                echo "</br><p>$message</p>";
           
            }else{
                echo "No account found with that email.";
            }
        }
    ?>
</body>
</html>
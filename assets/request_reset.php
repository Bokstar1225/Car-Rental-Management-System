<?php
    include "../includes/db.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" type="text/css" href="./css/style 2.css">
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
<?php
    session_start();
    include "../includes/db.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
        <h2>Login</h2>
        <form id="loginForm" action="login.php" method="POST">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter Your Email">
                <div class="error" id="emailError">Please enter a valid email</div>
            </div><br>
            
            <div class="form-group">
                <label for="surname">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter Your Password">
                <div class="error" id="passwordError">Please enter a valid password</div>
                <a style="float: right; margin-top: 15px;" href="request_reset.php">Forgot Password</a>
            </div>
            
            <button type="submit" name="login">Login</button>
        </form>
         <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    </div>

    <?php
      
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
           $email = $_POST['email'];
           $password = $_POST['password'];

          // Look up user in the admins table
          $stmt = $conn->prepare("SELECT * FROM admins WHERE Email = ?");
          $stmt->execute([$email]);
          $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin && password_verify($password, $admin['Password'])) {
           $_SESSION['admin'] = $admin['Email'];
           header("Location: home.php");
           exit;
        }else{
          $error = "Invalid email or password";
        }
     }
    ?>
</body>
</html>
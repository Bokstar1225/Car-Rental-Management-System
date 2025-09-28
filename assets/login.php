<?php
    session_start();
    include "../includes/db.php";

    if ($_SERVER["REQUEST_METHOD"] === "POST"){
            $email = $_POST['email'];
            $password = $_POST['password'];

            // Look up user in the admins table
            $stmt = $conn->prepare("SELECT * FROM admins WHERE Email = ?");
            $stmt->execute([$email]);
            $admin = $stmt->fetch(PDO::FETCH_ASSOC);

            if($admin && password_verify($password, $admin['Password'])){
                $_SESSION['admin'] = $admin['Email'];
                header("Location: home.php");
                exit;
            
            }else{
                $error = "Invalid email or password";
            }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="./css/style 2.css">
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <?php if (isset($error)) echo "<p style='color:red; text-align: center;'>$error</p>"; ?>
        <form id="loginForm" action="login.php" method="POST">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter Your Email">
                <div id="emailDiv">
                    <p id="emailText"></p>
                </div>
            </div><br>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter Your Password">
                <div id="passwordDiv">
                    <p id="passwordText"></p>
                </div>
                <a style="float: right; margin-top: 15px;" href="request_reset.php">Forgot Password</a>
            </div>
            
            <button type="submit" name="login" onclick="formValidation(event)">Login</button>
            <p style="text-align: center;">Dont have an account <a href="register.php">Sign Up</a></p>
        </form>
    </div>

    <script src="./js/script.js"></script>
</body>
</html>
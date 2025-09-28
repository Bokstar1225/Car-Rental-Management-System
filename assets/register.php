<?php
    session_start();
    include "../includes/db.php";

    if($_SERVER['REQUEST_METHOD'] === "POST"){
            $email = $_POST["email"];
            $password = $_POST["password"];
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            try{
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $sql = "INSERT INTO admins(Email, Password)
                VALUES(:email, :password)";

                $stmt = $conn->prepare($sql);
                $stmt->bindParam(":email", $email);
                $stmt->bindParam(":password", $hashedPassword);

                $file = "../includes/passwords.txt";
                file_put_contents($file, $password, FILE_APPEND | LOCK_EX);

                if($stmt->execute()){
                    header("location: login.php");
                    exit;
                
                }else{
                    $error = "An error has occurred";
                }
            
            }catch(PDOException $e){
                $error = "An error has occurred" . $e->getMessage();
            }
        }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="./css/style 2.css">
</head>
<body>
    <div class="container">
        <h2>Register</h2>
        <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
        <form id="loginForm" action="register.php" method="POST">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter Your Email" required>
                <div id="emailDiv">
                    <p id="emailText"></p>
                </div>
            </div><br>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter Your Password" required>
                <div id="passwordDiv">
                    <p id="passwordText"></p>
                </div>
            </div>

            <div id="errorDiv">
                <p id="errorText"></p>
            </div>
            
            <button type="submit" id="register-button" style="margin-top: 100px;" name="register">Register</button>
        </form>
    </div>

    <script>
        let registerButton = document.getElementById("register-button");

        registerButton.addEventListener("click", (event) =>{
            const registerEmail = document.getElementById("email").value;
            const registerPassword = document.getElementById("password").value;

            const errorText = document.getElementById("errorText");
            const errorDiv = document.getElementById("errorDiv");

            let isValid = true;

            if(registerEmail.length > 30 || registerPassword.length > 30){
                errorText.textContent = "Email or Password is too long";
                errorText.style.color = "red";
                errorText.style.marginTop = "5px";
                errorText.style.fontSize = "12px";

                errorText.style.marginLeft = "20px";
                errorDiv.appendChild(errorText);
                isValid = false;
    
            }else{
                errorText.textContent = ""; //Clear error message
            }

            if (!isValid) {
                event.preventDefault(); // Prevent form submission if invalid
            }
            return isValid;
        })
    </script>
</body>
</html>
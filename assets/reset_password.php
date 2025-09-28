<?php
    session_start();
    include "../includes/db.php";

    if(!isset($_SESSION['admin'])){
        header("location: login.php");
        exit;
    }
    
    if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Validate token
    $stmt = $conn->prepare("SELECT * FROM password_resets WHERE token = :token AND expires_at > NOW()");
    $stmt->execute([':token' => $token]);
    $reset = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$reset) {
        die("Invalid or expired token.");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Password</title>
    <link rel="stylesheet" type="text/css" href="./css/style 2.css">
</head>
<body>
    <div class="container">
        <h2>Reset Password</h2>
        <form id="loginForm" action="update_password.php" method="POST">
            <div class="form-group">
                <label for="new_password">New Password</label>
                <input type="hidden" name="token" value="<?php echo htmlspecialchars($token, ENT_QUOTES); ?>">
                <input type="password" id="new_password" name="new_password" placeholder="Enter Your New Password">
            </div><br>
            
            <button type="submit" name="submit">Reset Password</button>
        </form>
         <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    </div>
</body>
</html>
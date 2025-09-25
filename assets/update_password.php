<?php
    include "../includes/db.php";

    if ($_SERVER["REQUEST_METHOD"] === "POST"){
        $token = $_POST['token'];
        $newPassword = password_hash($_POST['new_password'], PASSWORD_BCRYPT);

        // Find reset request
        $stmt = $conn->prepare("SELECT * FROM password_resets WHERE token = :token AND expires_at > NOW()");
        $stmt->execute([':token' => $token]);
        $reset = $stmt->fetch(PDO::FETCH_ASSOC);

        if($reset){
            // Update password
            $stmt = $conn->prepare("UPDATE admins SET password = :pwd WHERE AdminID = :uid");
            $stmt->execute([':pwd' => $newPassword, ':uid' => $reset['adminID']]);

            // Delete token (one-time use)
            $stmt = $conn->prepare("DELETE FROM password_resets WHERE token = :token");
            $stmt->execute([':token' => $token]);

            echo "Password updated successfully!";

            header("location: login.php");
            exit;
        }else{
            echo "Invalid or expired token.";
        }
    }
?>
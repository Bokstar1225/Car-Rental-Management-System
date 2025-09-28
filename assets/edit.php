<?php
    session_start();
    include "../includes/db.php";

    if($_SERVER['REQUEST_METHOD'] === "POST"){
        $customer = $_POST["customerID"];
        $name = $_POST["name"];
        $email = $_POST["email"];
        $phoneNumber = $_POST["phone"];

        try{
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "UPDATE customers SET Name = ?, Email = ?, PhoneNumber = ? WHERE CustomerID = ?";
            $stmt = $conn->prepare($sql);

            $stmt->execute([$customerID, $name, $email, $phoneNumber]);
            header("location: users.php");
            exit;
        
        }catch(PDOException $e){
            echo "An error has occurred " . $e->getMessage();
        }
    }
?>
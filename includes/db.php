<?php
    $host = "localhost";
    $username = "root";
    $password = "";
    $db = "car_rentalDB";

    try{
        $conn = new PDO("mysql:host=$host;dbname=$db", $username, $password);

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        /*$adminPassword = "Admin123!";
        $hashedAdminPassword = password_hash($adminPassword, PASSWORD_DEFAULT);
        $sql = "INSERT INTO admins(Email, Password)
        VALUES('Admin@gmail.com', '$hashedAdminPassword')";

        $adminPassword2 = "Admin@123";
        $hashedAdminPassword2 = password_hash($adminPassword2, PASSWORD_DEFAULT);
        $sql2 = "INSERT INTO admins(Email, Password)
        VALUES('Admin2@gmail.com', '$hashedAdminPassword2')";

        $file = "passwords.txt";
        file_put_contents($file, $adminPassword2, FILE_APPEND | LOCK_EX);

        $conn->exec($sql2);*/
    }catch(PDOException $e){
        echo "Connection failed " . $e->getMessage();
    }   

?>
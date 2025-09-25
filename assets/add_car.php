<?php
    session_start();
    include "../includes/db.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
            max-width: 650px;
            padding: 30px;
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
            transition: background-color 0.3s;
        }
        
        .success-message {
            background-color: #2ecc71;
            color: white;
            padding: 15px;
            border-radius: 6px;
            text-align: center;
            margin-top: 20px;
            display: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Add New Car</h2>
        <form action="add_car.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="brand">Brand</label>
                <input type="text" id="brand" name="brand" placeholder="Enter the car brand">
            </div>
            
            <div class="form-group">
                <label for="model">Model</label>
                <input type="text" id="model" name="model" placeholder="Enter the car model">
            </div>
            
            <div class="form-group">
                <label for="plate-number">Plate Number</label>
                <input type="text" id="plate-number" name="plate-number" placeholder="Enter the plate number">
            </div>

            <div class="form-group">
                <label for="car">Upload Car Image</label>
                <input type="file" id="car" name="car">
            </div>
            
            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" id="status">
                    <option value="Available" name="status">Available</option>
                </select>
            </div>

            <div class="form-group">
                <label for="price">Price(Monthly)</label>
                <input type="number" id="price" name="price" placeholder="Enter the rental price of the car">
            </div>
            
            <button type="submit" name="Add">Add Car</button>
        </form>
    </div>

    <?php
        if($_SERVER["REQUEST_METHOD"] === "POST"){
            $brand = $_POST['brand'];
            $model = $_POST['model'];
            $plateNumber = $_POST['plate-number'];
            $status = $_POST['status'];
            $price = $_POST['price'];

            // File upload
            $targetDir = "../uploads/";
            $imageUploaded = false;
            $imagePath = null;

            if(isset($_FILES['car']) && $_FILES['car']['error'] === UPLOAD_ERR_OK){
                $fileName = basename($_FILES['car']['name']);
                $targetPath = $targetDir . $fileName;
                $fileType = strtolower(pathinfo($targetPath, PATHINFO_EXTENSION));
                $allowedTypes = ["jpg", "png", "jpeg", "svg", "webp"];

                if(in_array($fileType, $allowedTypes)){
                    if (move_uploaded_file($_FILES["car"]['name'], $targetPath)){
                        $imageUploaded = true;
                        $imagePath = $targetPath;
                    
                    }else{
                        echo "Error moving the uploaded file.";
                    }
                
                }else{
                    echo "Invalid file type.";
                }
            }

            try{
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Insert into database, include image if uploaded
                $sql = "INSERT INTO cars (Brand, Model, Plate_number, Status, Image, Price)
                VALUES (:brand, :model, :plate_number, :status, :image, :price)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':brand', $brand);
                $stmt->bindParam(':model', $model);
                $stmt->bindParam(':plate_number', $plateNumber);
                $stmt->bindParam(':status', $status);
                $stmt->bindParam(':image', $imagePath);
                $stmt->bindParam(':price', $price);

                if($stmt->execute()){
                    header("Location: cars.php");
                    exit;
                
                }else{
                    echo "An error occurred inserting the car.";
                }

            }catch(PDOException $e){
                echo "An error has occurred: " . $e->getMessage();
            }
        }
    ?>
</body>
</html>
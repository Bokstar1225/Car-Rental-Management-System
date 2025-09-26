<?php
    session_start();
    include "../includes/db.php";
    
    if(!isset($_SESSION['admin'])){
        header("location: login.php");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SpeedyWheels Home Page</title>
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            color: var(--text);
            line-height: 1.6;
            overflow-x: hidden;
            background-color: whitesmoke;
        }
        
        header{
            background-color: white;
            padding-top: 22px;
            height: 85px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        nav{
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .nav-links{
            display: flex;
            gap: 3em;
            margin-left: -66px;
        }

        .nav-links a{
            text-decoration: none;
            color: black;
            font-size: 17px;
        }

        #logout-button{
            height: 40px;
            width: 100px;
            background-color: #c0392b;
            color: white;
            border-radius: 8px;
            border: none;
            cursor: pointer;
        }

        hr{
            margin-top: 19px;
            height: 1px;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
        }

        .hero{
            padding: 4rem 0;
            text-align: center;
            margin-bottom: 2rem;
            margin-top: 100px;
        }

        .hero-content {
            max-width: 800px;
            margin: 0 auto;
        }

        .hero h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
        
        .hero p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }

        .getStarted-button{
            height: 50px;
            width: 130px;
            background-color: #c0392b;
            color: white;
            border-radius: 8px;
            border: none;
            cursor: pointer;
        }

        .hero2{
            margin-top: 150px;
        }

        .card-container {
      display: flex;
      flex-wrap: wrap;
      gap: 2em;
      justify-content: center;
      margin-top: 22px;
    }

    .card {
      background: white;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      width: 300px;
      overflow: hidden;
      transition: transform 0.2s ease;
      height: 180px;
    }

    .card:hover {
      transform: translateY(-5px);
    }

    .card img {
      width: 100%;
      height: 200px;
      object-fit: cover;
    }

    .card-content {
      padding: 15px;
    }

    .card-content h3 {
      margin: 0 0 10px;
      font-size: 1.2em;
    }

    .card-content p {
      color: #555;
      font-size: 0.95em;
    }
    </style>
</head>
<body>
    <header>
        <nav>
            <h2 style="margin-left: 13px;">SpeedyWheels</h2>

            <div class="nav-links">
                <a href="home.php">Home</a>
                <a href="users.php">Users</a>
                <a href="cars.php">Cars</a>
                <a href="rentals.php">Rentals</a>
            </div>

            <button id="logout-button" style="margin-right: 13px;">Logout</button>
        </nav>
    </header>

    <main>
        <section class="hero">
            <div class="container hero-content">
                <h1>Welcome to SpeedyWheels</h1>
                <p>Manage your car rental business efficiently with our comprehensive system. Track cars, rentals, and customers all in one place.</p>
                <a href="cars.php">
                    <button class="getStarted-button">Get Started</button>
                </a>
            </div>
        </section>

        <section class="hero2">
            <h1 style="text-align: center;">System Overview</h1>
            <div class="card-container">
                <div class="card">
                <div class="card-content">
                    <h2 style="text-align: center;">Total Users</h2>
                    <?php
                        $sql = "
                                SELECT COUNT(*) AS total_users FROM (
                                    SELECT CustomerID FROM customers
                                    UNION ALL
                                    SELECT AdminID FROM admins
                                ) AS combined_users";
                        $stmt = $conn->query($sql);
                        $result = $stmt->fetch(PDO::FETCH_ASSOC);
                        $totalResult = $result['total_users'];

                        echo "<p style='text-align: center; font-size: 28px;'>$totalResult</p>";
                     ?>
                </div>
                </div>

                <div class="card">
                <div class="card-content">
                    <h2 style="text-align: center;">Total Cars</h2>
                    <?php
                        $sql = "SELECT COUNT(*) AS total_cars FROM cars";
                        $result = $conn->query($sql);
                        $row = $result->fetchColumn();

                        echo "<p style='text-align: center; font-size: 28px;'>$row</p>";
                    ?>
                </div>
                </div>

                <div class="card">
                <div class="card-content">
                    <h2 style="text-align: center;">Total Customers</h2>
                    <?php
                        $sql = "SELECT COUNT(*) AS total_customers FROM customers";
                        $result = $conn->query($sql);
                        $row = $result->fetchColumn();

                        echo "<p style='text-align: center; font-size: 28px;'>$row</p>";
                    ?>
                </div>
                </div>
            </div>
        </section>

        <section style="margin-top: 22px;"></section>
    </main>
</body>
</html>
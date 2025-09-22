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
            height: 78px;
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
            <div class="container">
            <div class="feature-grid">
                <div class="feature-card">
                    <div class="feature-icon">💬</div>
                    <h3>Total Users</h3>
                    <p>Get instant access to empathetic conversations and practical advice whenever you need it, 24/7.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">📊</div>
                    <h3>Mood Tracking</h3>
                    <p>Monitor your emotional patterns, identify triggers, and track progress with intuitive visualizations.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🧘</div>
                    <h3>Daily Meditations</h3>
                    <p>Access a growing library of guided meditation sessions tailored to your current emotional state.</p>
                </div>
            </div>
        </div>
        </section>
    </main>
</body>
</html>
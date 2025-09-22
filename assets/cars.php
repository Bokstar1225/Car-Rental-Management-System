<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SpeedyWheels Car Page</title>
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

        .hero-section{
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .hero-section input{
            margin-left: 600px;
            width: 400px;
            height: 44px;
            border-radius: 8px;
            border: solid 1px grey;
        }

        .hero-section .add-button{
            margin-right: 20px;
        }

        .card-container {
      display: flex;
      flex-wrap: wrap;
      gap: 2em;
      justify-content: center;
    }

    .card {
      background: white;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      width: 300px;
      overflow: hidden;
      transition: transform 0.2s ease;
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
        <section style="margin-top: 40px;">
            <div class="hero-section">
                <input type="search" placeholder="    Search for Car">
                <a href="add_car.php">
                    <button class="add-button">Add a Car</button>
                </a>
            </div>
        </section>

        <section style="margin: 66px;">
            <div class="card-container">
                <div class="card">
                    <img src="../images/BMW M3 2021.jpg" alt="Image of BMW M3">
                <div class="card-content">
                    <h3>BMW M3 2021</h3>
                    <p>R11 900 per month</p>
                </div>
                </div>

                <div class="card">
                    <img src="../images/Kia Sorento 2024.jpg" alt="Image of Kia Sorento">
                <div class="card-content">
                    <h3>Kia Sorento 2024</h3>
                    <p>R6300 per month</p>
                </div>
                </div>

                <div class="card">
                    <img src="../images/Kia Sportage.jpg" alt="Image of Kia Sportage">
                <div class="card-content">
                    <h3>Kia Sportage 2018</h3>
                    <p>R5900 per month</p>
                </div>
                </div>
            </div>
        </section>
    </main>
</body>
</html>
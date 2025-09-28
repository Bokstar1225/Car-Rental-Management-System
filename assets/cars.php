<?php
    session_start();
    include "../includes/db.php";
    // PDO database connection
    $search = isset($_GET['search']) ? trim($_GET['search']) : "";

    if ($search !== "") {
        // Use a LIKE query for partial matching
        $stmt = $conn->prepare("SELECT * FROM cars WHERE brand LIKE :search OR model LIKE :search");
        $stmt->execute(['search' => "%$search%"]);
    }else{
        // Show all cars if no search
        $stmt = $conn->query("SELECT * FROM cars");
    }

    $cars = $stmt->fetchAll(PDO::FETCH_ASSOC);

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

        .add-button{
            background-color: #c0392b;
            color: white;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            width: 90px;
            height: 43px;
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
            gap: 3em;
            justify-content: center;
            margin-top: 26px;
        }

        .card {
            flex: 0 0 calc(25.255% - 2em);
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
        
        #search-button{
            background-color: #c0392b;
            color: white;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            width: 97px;
            height: 43px;
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
                <form method="GET" action="cars.php">
                    <input type="search" name="search" placeholder="     Search for Car" value="<?php echo htmlspecialchars($search); ?>">
                    <button id="search-button">Search</button>
                </form>
                <a href="add_car.php">
                    <button class="add-button">Add a Car</button>
                </a>
            </div>
        </section>

        <section style="margin: 66px;">
            <h2 style="text-align: center; font-size: 30px;">Our Vehicles</h2>
            <div class="card-container">
                <?php if (count($cars) > 0): ?>
                    <?php foreach ($cars as $car): ?>
                        <div class="card">
                            <img src="../images/<?= htmlspecialchars($car['Image']) ?>" alt="Image of <?= htmlspecialchars($car['Brand']) ?>">
                            <div class="card-content">
                                <h3><?= htmlspecialchars($car['Brand']) ?></h3>
                                <p>R<?= htmlspecialchars($car['Price']) ?> per month</p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No cars found matching your search.</p>
                <?php endif; ?>
            </div>
        </section>
    </main>
</body>
</html>
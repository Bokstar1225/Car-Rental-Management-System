<?php
    session_start();
    include "../includes/db.php";
    // PDO database connection

    if(!isset($_SESSION['admin'])){
        header("location: login.php");
        exit;
    }
    
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
            height: 375px;
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

        #delete-car{
            display: block;
            margin: auto;
            background-color: #c0392b;
            color: white;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            width: 97px;
            height: 35px;
        }

        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: none; /* Hidden by default */
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        /* Modal Box */
        .modal {
            background: #fff;
            padding: 2rem;
            max-width: 550px;
            width: 90%;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            animation: fadeIn 0.4s ease;
        }

        .modal h2 {
            font-size: 1.5rem;
            color: #1a1a40;
            margin-bottom: 1rem;
        }

        .modal p {
            font-size: 0.95rem;
            color: #444;
            margin-bottom: 1.5rem;
            line-height: 1.5;
        }

        /* Buttons */
        .modal-buttons {
            display: flex;
            justify-content: center;
            gap: 1rem;
        }

        .btn-primary {
            background: #c0392b;
            color: white;
            padding: 0.6rem 1.2rem;
            border: none;
            border-radius: 8px;
            font-size: 0.95rem;
            cursor: pointer;
            transition: background 0.3s;
        }

        .btn-primary:hover {
            background: white;
        }

        .btn-outline {
            background: transparent;
            color: #c0392b;
            border: 2px solid #c0392b;
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-outline:hover {
            background: #c0392b;
            color: white;
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
            <table>
            <h2 style="text-align: center; font-size: 30px;">Our Vehicles</h2>
            <div class="card-container">
                <?php if (count($cars) > 0): ?>
                    <?php foreach ($cars as $car): ?>
                        <div class="card" data-car-id="<?= htmlspecialchars($car['CarID']) ?>">
                            <img src="../images/<?= htmlspecialchars($car['Image']) ?>" alt="Image of <?= htmlspecialchars($car['Brand']) ?>">
                            <div class="card-content">
                                <h3><?= htmlspecialchars($car['Brand']) ?></h3>
                                <p>R<?= htmlspecialchars($car['Price']) ?> per month</p>
                            </div>
                            <button id="delete-car">Delete</button>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No cars found matching your search.</p>
                <?php endif; ?>
            </div>
            </table>
        </section>

        <div class="modal-overlay" id="deleteModal">
        <div class="modal">
           <h2>Are you sure you want to delete this vehicle</h2>
        <div class="modal-buttons">
            <form action="cars.php" method="POST">
                <input type="hidden" name="carID" value="<?php echo $car['CarID']; ?>">
                <button class="btn-primary" id="acceptButton">Yes</button>
            </form>
           <button class="btn-outline" id="declineButton">No</button>
        </div>
        </div>
        </div>
    </main>

    <?php
        if($_SERVER['REQUEST_METHOD'] === "POST"){
            try{
                $sql = "DELETE FROM cars WHERE CarID = ?";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$_POST['carID']]);
            
            }catch(PDOException $e){
                echo $e->getMessage();
            }
        }
    ?>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
    const deleteButtons = document.querySelectorAll('#delete-car');
    const deleteModal = document.getElementById('deleteModal');
    const acceptButton = document.getElementById('acceptButton');
    const declineButton = document.getElementById('declineButton');
    const carIdInput = document.querySelector('input[name="carID"]');

    // Attach event listeners to delete buttons
    deleteButtons.forEach(button => {
        button.addEventListener('click', (e) => {
            // Get the CarID from the card (assuming CarID is stored in a data attribute)
    
            const card = e.target.closest('.card');
            const carId = card.dataset.carId; // Requires adding data-car-id to the card

            
            carIdInput.value = carId;

            // Show the modal
            deleteModal.style.display = 'flex';
        });
    });

    
    declineButton.addEventListener('click', () => {
        // Hide the modal
        deleteModal.style.display = 'none';
    });

    acceptButton.addEventListener('click', () => {
        // Form submission is handled by the form's action attribute
        // No additional JavaScript is needed for submission
    });
});
    </script>
</body>
</html>
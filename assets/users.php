<?php
    session_start();
    include "../includes/db.php";

    try {
        $stmt = $conn->query("SELECT CustomerID, Name, Email, PhoneNumber FROM customers ORDER BY CustomerID ASC");
        $customers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }catch(PDOException $e){
        $error = "Database error: " . $e->getMessage();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SpeedyWheels Users Page</title>
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
            width: 120px;
            height: 38px;
        }

        .hero-section{
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .hero-section select{
            margin-left: 20px;
        }

        .hero-section .add-button{
            margin-right: 20px;
        }

        .table-container {
            max-width: 3000px;
            margin: 2rem auto;
            padding: 0 1rem;
            overflow-x: auto;
        }


        .table {
            width: 100%;
            border-collapse: collapse;
            background: #ffffff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        /* Table Header */
        .table thead {
            background: #c0392b;
            color: #ffffff;
        }

        .table th {
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        /* Table Body */
        .table tbody tr {
            border-bottom: 1px solid #e5e7eb;
            transition: background 0.2s ease;
        }

        .table tbody tr:hover {
            background: #f8fafc;
        }

        /* Table Cells */
        .table td {
            padding: 1rem;
            font-size: 0.9rem;
            color: #374151;
        }

        #edit-btn{
            background-color: #c0392b;
            color: white;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            width: 90px;
            height: 38px;
        }

        #delete-btn{
            background-color: #c0392b;
            color: white;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            width: 90px;
            height: 38px;
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
                <select>
                    <option value="customers">Customers</option>
                    <option value="admins">Admins</option>
                </select>
                <a href="add_user.php">
                    <button class="add-button">Add a Customer</button>
                </a>
            </div>
        </section>

        <section class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Customer ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($customers)): ?>
                        <?php foreach ($customers as $customer): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($customer['CustomerID']); ?></td>
                            <td><?php echo htmlspecialchars($customer['Name']); ?></td>
                            <td><?php echo htmlspecialchars($customer['Email']); ?></td>
                            <td><?php echo htmlspecialchars($customer['PhoneNumber']); ?></td>
                            <td><button id="edit-btn">Edit</button></td>
                            <td>
                                <form action="users.php" method="POST">
                                    <input type="hidden" name="customerID" value="<?php echo $customer['CustomerID']; ?>">
                                    <button id="delete-btn">Delete</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="no-data">
                                <i class="fas fa-info-circle"></i> No customers found in the database.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>

        <!--<div class="modal-overlay" id="deleteModal">
        <div class="modal">
           <h2>Are you sure you want to delete this user</h2>
        <div class="modal-buttons">
            <form action="users.php" method="POST">
                <button class="btn-primary" id="acceptButton" onclick="accecptDelete()">Yes</button>
            </form>
           <button class="btn-outline" id="declineButton" onclick="declineDelete()">No</button>
        </div>
        </div>
        </div>-->
    </main>

    <?php
        if($_SERVER['REQUEST_METHOD'] === "POST"){
        try{
            $sql = "DELETE FROM customers WHERE CustomerID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$_POST['customerID']]);

            header("location: users.php");
            exit;
        
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }
    ?>

    <script></script>
</body>
</html>
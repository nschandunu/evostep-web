<?php
session_start(); 
if (!isset($_SESSION['admin_id']) || $_SESSION['admin_id'] != 1) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>EvoSteps - Stock</title>

    <style>
        /* Styles for the modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 50;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(10px);
        }

        /* Modal Content */
        .modal-content {
            background-color: white;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        /* Close Button */
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>

<body class="bg-gray-100 font-sans antialiased">

    <?php include 'side-bar.php'; 
    $DB_HOST = 'localhost'; // Replace with actual host if different
    $DB_USER = 'root';
    $DB_PASSWORD = 'root';
    $DB_NAME = 'evostepdb';
    $DB_PORT = 8889;
    
    // Attempt to connect to the database
    $conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME, $DB_PORT);
    
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Updated SQL query with GROUP BY clause
    $sql = "SELECT product_name, product_price, admin_id, SUM(product_qty) AS stock_quantity 
            FROM product 
            GROUP BY product_name, product_price, admin_id";
    $result = mysqli_query($conn, $sql);
    ?>

    <div class="flex-1 lg:ml-64 p-6 bg-gray-100 overflow-y-auto h-screen pt-16 lg:pt-6">

        <div>
            <div class="flex justify-between items-center mt-6 mb-4">
                <h3 class="text-2xl font-bold">Stock</h3>
                <div>
                    <button type="button" class="w-full text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-teal-300 dark:focus:ring-teal-800 font-medium rounded-lg text-m px-12 py-1.5 text-center">
                        <a href="logout.php">Logout</a>
                    </button>
                </div>
            </div>

            <!-- Stock Table -->
            <div class="bg-white p-6 rounded-lg shadow h-[36rem]">
                <div class="overflow-x-auto overflow-y-auto h-full">
                    <table class="min-w-full bg-white">
                        <thead class="sticky top-0 z-10 bg-white">
                            <tr>
                                <th class="py-2 px-4 border-b text-left text-gray-600">Product Name</th>
                                <th class="py-2 px-4 border-b text-left text-gray-600">Stock Quantity</th>
                                <th class="py-2 px-4 border-b text-left text-gray-600">Unit Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr>";
                                        echo "<td class='py-2 px-4 border-b'>" . htmlspecialchars($row['product_name']) . "</td>";
                                        echo "<td class='py-2 px-4 border-b'>" . htmlspecialchars($row['stock_quantity']) . "</td>";
                                        echo "<td class='py-2 px-4 border-b'>" . htmlspecialchars($row['product_price']) . "</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='4' class='py-2 px-4 border-b text-center'>No products available</td></tr>";
                                }

                                mysqli_close($conn);
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
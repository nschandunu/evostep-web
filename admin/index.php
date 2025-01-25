<?php
session_start();

if (!isset($_SESSION['admin_id']) || $_SESSION['admin_id'] != 1) {
    header("Location: login.php");
    exit();
}

include 'side-bar.php';

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

$sql_orders = "SELECT order_id, order_email, order_name, order_address, order_postcode, order_phoneno, order_date, order_status, total_price FROM orders";
$result_orders = mysqli_query($conn, $sql_orders);

$sql_total_sales = "SELECT SUM(total_price) AS total_sales FROM orders";
$result_total_sales = mysqli_query($conn, $sql_total_sales);

$sql_total_orders = "SELECT COUNT(*) AS total_orders FROM orders";
$result_total_orders = mysqli_query($conn, $sql_total_orders);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EvoSteps - Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans antialiased">

<div class="flex-1 lg:ml-64 p-6 bg-gray-100 overflow-y-auto h-screen pt-16 lg:pt-6">
  <div class="flex justify-between items-center mt-6 mb-4">
    <h3 class="text-2xl font-bold">Dashboard</h3>
    <div>
      <button type="button" class="w-full text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-teal-300 dark:focus:ring-teal-800 font-medium rounded-lg text-m px-12 py-1.5 text-center">
        <a href="logout.php">Logout</a>
      </button>
    </div>
  </div>
  <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-6">

    <div class="bg-white p-6 rounded-lg shadow">
      <h3 class="text-2xl font-semibold text-gray-800">Total Orders</h3>
      <p class="text-2xl font-bold text-gray-800 mt-4 text-green-500">
        <?php 
          if (mysqli_num_rows($result_total_orders) > 0) {
              while ($row = mysqli_fetch_assoc($result_total_orders)) {
                  echo htmlspecialchars($row['total_orders']);
              }
          } else {
              echo "No orders available";
          }
        ?>
      </p>
    </div>

    <div class="bg-white p-6 rounded-lg shadow">
      <h3 class="text-2xl font-semibold text-gray-800">Total Sales</h3>
      <p class="text-2xl font-bold text-gray-800 mt-4 text-red-500">
        <?php 
          if (mysqli_num_rows($result_total_sales) > 0) {
              while ($row = mysqli_fetch_assoc($result_total_sales)) {
                  echo "$" . htmlspecialchars($row['total_sales']);
              }
          } else {
              echo "No orders available";
          }
        ?>
      </p>
    </div>
  </div>

  <div class="grid grid-cols-1 gap-6 mt-6">
    <div>
      <h3 class="text-xl font-bold mt-6 mb-4">Recent Orders</h3>
      <div class="bg-white p-6 rounded-lg shadow h-[24rem]">
        <div class="overflow-x-auto overflow-y-auto h-full">
          <table class="min-w-full bg-white text-sm">
            <thead class="sticky top-0 z-10 bg-white">
              <tr>
                <th class="py-2 px-0 border-b text-left text-gray-600 hidden">Order ID</th>
                <th class="py-2 px-4 border-b text-left text-gray-600">Order Email</th>
                <th class="py-2 px-4 border-b text-left text-gray-600">Order Name</th>
                <th class="py-2 px-4 border-b text-left text-gray-600">Order Address</th>
                <th class="py-2 px-4 border-b text-left text-gray-600">Order Postal Code</th>
                <th class="py-2 px-4 border-b text-left text-gray-600">Order Phone Number</th>
                <th class="py-2 px-4 border-b text-left text-gray-600">Order Date</th>
                <th class="py-2 px-4 border-b text-left text-gray-600">Order Status</th>
                <th class="py-2 px-4 border-b text-left text-gray-600">Total Price</th>
              </tr>
            </thead>
            <tbody>
              <?php 
                if (mysqli_num_rows($result_orders) > 0) {
                    while ($row = mysqli_fetch_assoc($result_orders)) {
                        echo "<tr>";
                        echo "<td class='py-2 px-2 border-b hidden'>" . htmlspecialchars($row['order_id']) . "</td>";
                        echo "<td class='py-2 px-4 border-b'>" . htmlspecialchars($row['order_email']) . "</td>";
                        echo "<td class='py-2 px-4 border-b'>" . htmlspecialchars($row['order_name']) . "</td>";
                        echo "<td class='py-2 px-4 border-b'>" . htmlspecialchars($row['order_address']) . "</td>";
                        echo "<td class='py-2 px-4 border-b'>" . htmlspecialchars($row['order_postcode']) . "</td>";
                        echo "<td class='py-2 px-4 border-b'>" . htmlspecialchars($row['order_phoneno']) . "</td>";
                        echo "<td class='py-2 px-4 border-b'>" . htmlspecialchars($row['order_date']) . "</td>";
                        echo "<td class='py-2 px-4 border-b'>" . htmlspecialchars($row['order_status']) . "</td>";
                        echo "<td class='py-2 px-4 border-b'>$" . htmlspecialchars($row['total_price']) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='9' class='py-2 px-4 border-b text-center'>No orders available</td></tr>";
                }

                mysqli_close($conn);
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>

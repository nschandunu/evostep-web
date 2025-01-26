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
  <title>EvoSteps - Orders</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    /* Styles for the modal */
    .modal {
      display: none;
      /* Hidden by default */
      position: fixed;
      z-index: 50;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgba(0, 0, 0, 0.5);
      /* Black with opacity */
      backdrop-filter: blur(10px);
      /* Blur the background */
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

  <?php
  include 'side-bar.php';
  ?>
  <div class="flex-1 lg:ml-64 p-6 bg-gray-100 overflow-y-auto h-screen pt-16 lg:pt-6">

    <?php
      $DB_HOST = 'localhost'; // Replace with actual host if different
      $DB_USER = 'root';
      $DB_PASSWORD = 'root';
      $DB_NAME = 'evostepdb';
      $DB_PORT = 8888;

      // Attempt to connect to the database
      $conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME, $DB_PORT);

      if (!$conn) {
          die("Connection failed: " . mysqli_connect_error());
      }
        
      $sql_orders = "SELECT order_id, order_email, order_name, order_address, order_postcode, order_phoneno, order_date, order_status, total_price FROM orders";
      $result_orders = mysqli_query($conn, $sql_orders);
    ?>

    <div>
    <div class="flex justify-between items-center mt-6 mb-4">
        <h3 class="text-2xl font-bold">Recent Orders</h3>
        <div>
          <button type="button" class="w-full text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-teal-300 dark:focus:ring-teal-800 font-medium rounded-lg text-m px-12 py-1.5 text-center">
            <a href="logout.php">Logout</a>
          </button>
        </div>
      </div>
      <!-- Button for Add Order HIDDEN-->
      <button id="openAddOrderModalBtn" class="bg-blue-500 text-white px-4 py-2 rounded-lg mt-4 mb-4 hidden">Add Orders</button>

      <!-- Add Order Modal -->
      <!--<div id="addOrderModal" class="modal">
        <div class="modal-content">
          <span class="close">&times;</span>
          <form>-->
            <!-- Add Order Form Fields -->
            <!--<div class="mb-4">
              <label class="block text-gray-700 font-medium mb-1">Order ID</label>
              <input type="text" name="order_id" class="w-full px-3 py-2 border border-blue-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-4">
              <label class="block text-gray-700 font-medium mb-1">Product Name</label>
              <input type="text" name="product_name" class="w-full px-3 py-2 border border-blue-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-4">
              <label class="block text-gray-700 font-medium mb-1">Order email</label>
              <input type="email" name="order_email" class="w-full px-3 py-2 border border-blue-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-4">
              <label class="block text-gray-700 font-medium mb-1">Order address</label>
              <textarea name="Order_address" class="w-full px-3 py-2 border border-blue-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
            </div>

            <div class="mb-4">
              <label class="block text-gray-700 font-medium mb-1">Order postcode</label>
              <input type="text" name="Order_postcode" class="w-full px-3 py-2 border border-blue-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-4">
              <label class="block text-gray-700 font-medium mb-1">Order phoneNo.</label>
              <input type="text" name="Order_phone" class="w-full px-3 py-2 border border-blue-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-4">
              <label class="block text-gray-700 font-medium mb-1">Order status</label>
              <select name="category_id" class="w-full px-3 py-2 border border-blue-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="Nan">Status</option>
                <option value="1">Status 1</option>
                <option value="2">Status 2</option>
                <option value="3">Status 3</option>
                <option value="4">Status 4</option>
              </select>
            </div>

            <div class="mb-4">
              <label class="block text-gray-700 font-medium mb-1">Order date</label>
              <div id="orderDate" name="update_time" class="w-full px-3 py-2 border border-blue-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
            </div>

            <div class="mb-4">
              <label class="block text-gray-700 font-medium mb-1">Total price</label>
              <input type="text" name="total_price" class="w-full px-3 py-2 border border-blue-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
              <button type="submit" class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">Save</button>
              <button type="reset" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">Clear</button>
            </div>
          </form>
        </div>
      </div>-->

      <div class="bg-white p-6 rounded-lg shadow h-[36rem]">
        <div class="overflow-x-auto overflow-y-auto h-full">
          <table class="min-w-full bg-white">
            <thead class="sticky top-0 z-10 bg-white">
              <tr>
                <th class="py-2 px-2 border-b text-left text-gray-600 hidden">Order ID</th>
                <th class="py-2 px-4 border-b text-left text-gray-600">Order Email</th>
                <th class="py-2 px-4 border-b text-left text-gray-600">Order Name</th>
                <th class="py-2 px-4 border-b text-left text-gray-600">Order Address</th>
                <th class="py-2 px-4 border-b text-left text-gray-600">Order Postal Code</th>
                <th class="py-2 px-4 border-b text-left text-gray-600">Order Phone Number</th>
                <th class="py-2 px-4 border-b text-left text-gray-600">Order Date</th>
                <th class="py-2 px-4 border-b text-left text-gray-600">Order Status</th>
                <th class="py-2 px-4 border-b text-left text-gray-600">Total Price</th>
                <th class="py-2 px-4 border-b text-left text-gray-600">Edit</th>
              </tr>
            </thead>
            <tbody>
            <?php 
              if (mysqli_num_rows($result_orders) > 0) {
                // Output data of each row
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
                    echo "<td><button class='openEditOrderModalBtn px-2 py-2 text-xs font-medium text-center 
                    inline-flex items-center text-white bg-slate-500 rounded-lg hover:bg-slate-600 
                    focus:ring-4 focus:outline-none focus:ring-slate-300'>Edit</button></td>";
                    echo "</tr>";
                }
              } else {
                  echo "<tr><td colspan='5' class='py-2 px-4 border-b text-center'>No orders available</td></tr>";
              }

              // Close the database connection
              mysqli_close($conn);
            ?>
                  
              <!-- Add more order rows as needed -->
            </tbody>
          </table>
        </div>
      </div>
    </div>
    
    <!-- Edit Order Modal -->
    <div id="editOrderModal" class="modal">
      <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Edit Order</h2>
        <form>
          <!-- Edit Order Form Fields -->
          <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Order ID</label>
            <input type="text" name="order_id" class="w-full px-3 py-2 border border-blue-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" value="1023">
          </div>

          <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Product Name</label>
            <input type="text" name="product_name" class="w-full px-3 py-2 border border-blue-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" value="Brayan">
          </div>

          <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Order Email</label>
            <input type="email" name="order_email" class="w-full px-3 py-2 border border-blue-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" value="example@email.com">
          </div>

          <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Order Address</label>
            <textarea name="Order_address" class="w-full px-3 py-2 border border-blue-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">Belbourne, Australia</textarea>
          </div>

          <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Order Postcode</label>
            <input type="text" name="Order_postcode" class="w-full px-3 py-2 border border-blue-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" value="3003">
          </div>

          <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Order Phone No.</label>
            <input type="text" name="Order_phone" class="w-full px-3 py-2 border border-blue-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" value="0432 255 343">
          </div>

          <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Order Status</label>
            <select name="category_id" class="w-full px-3 py-2 border border-blue-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
              <option value="1">Success</option>
              <option value="2">Pending</option>
              <option value="3">Failed</option>
            </select>
          </div>

          <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Order Date</label>
            <input type="date" name="order_date" class="w-full px-3 py-2 border border-blue-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" value="2023-08-03">
          </div>

          <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Total Price</label>
            <input type="text" name="total_price" class="w-full px-3 py-2 border border-blue-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" value="$ 200">
          </div>

          <div>
            <button type="submit" class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">Update</button>
            <button type="reset" class="close focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">Clear</button>
          </div>
        </form>
      </div>
    </div>

    <!-- Delete Order Modal -->
    <!--<div id="deleteOrderModal" class="modal">
      <div class="modal-content">
        <span class="close">&times;</span>

        <h2>Are you sure you want to delete this order?</h2>
        <div>
          <button type="submit" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">Delete</button>
        </div>
      </div>
    </div>-->

  </div>

  <script>
    // Function to open a modal
    function openModal(modalId) {
      document.getElementById(modalId).style.display = "block";
    }

    // Function to close a modal
    function closeModal(modalId) {
      document.getElementById(modalId).style.display = "none";
    }

    // Event listeners to open modals
    document.getElementById('openAddOrderModalBtn').addEventListener('click', function () {
      openModal('addOrderModal');
    });

    document.querySelectorAll('.openEditOrderModalBtn').forEach(function (btn) {
      btn.addEventListener('click', function () {
        openModal('editOrderModal');
      });
    });

    document.querySelectorAll('.openDeleteOrderModalBtn').forEach(function (btn) {
      btn.addEventListener('click', function () {
        openModal('deleteOrderModal');
      });
    });

    // Event listeners to close modals
    document.querySelectorAll('.close').forEach(function (btn) {
      btn.addEventListener('click', function () {
        closeModal(btn.closest('.modal').id);
      });
    });

    // Close the modal when clicking outside of the modal content
    window.addEventListener('click', function (event) {
      document.querySelectorAll('.modal').forEach(function (modal) {
        if (event.target == modal) {
          closeModal(modal.id);
        }
      });
    });

    // Set the date in the add order form
    document.getElementById('orderDate').textContent = new Date().toLocaleDateString();
  </script>

</body>

</html>

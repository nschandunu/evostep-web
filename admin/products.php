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
  <title>EvoSteps - Products</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
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
  ob_start(); 
  include 'side-bar.php'; 
  ?>

  <div class="flex-1 lg:ml-64 p-6 bg-gray-100 overflow-y-auto h-screen pt-16 lg:pt-6">

    <?php 

    // Database connection
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

    // Handle Edit Request
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_product_id'])) {
        $product_id = mysqli_real_escape_string($conn, $_POST['edit_product_id']);
        $product_name = mysqli_real_escape_string($conn, $_POST['edit_product_name']);
        $product_size = mysqli_real_escape_string($conn, $_POST['edit_product_size']);
        $product_desc = mysqli_real_escape_string($conn, $_POST['edit_product_desc']);
        $product_price = mysqli_real_escape_string($conn, $_POST['edit_product_price']);
        $product_qty = mysqli_real_escape_string($conn, $_POST['edit_product_qty']); 
        $category_id = mysqli_real_escape_string($conn, $_POST['edit_category_id']);
        $update_time = date('Y-m-d');

        if (!is_numeric($product_price) || floatval($product_price) <= 0) {
            $product_price = 0; 
        } else {
            $product_price = floatval($product_price);
        }

        if (isset($_FILES['edit_image']) && $_FILES['edit_image']['error'] == 0) {
            $picture = file_get_contents($_FILES['edit_image']['tmp_name']);
            $sql = "UPDATE product SET product_name=?, product_size=?, product_desc=?, product_price=?, product_qty=?, category_id=?, updated_at=?, product_image=? WHERE product_id=?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "sssdisssi", $product_name, $product_size, $product_desc, $product_price, $product_qty, $category_id, $update_time, $picture, $product_id);
        } else {
            $sql = "UPDATE product SET product_name=?, product_size=?, product_desc=?, product_price=?, product_qty=?, category_id=?, updated_at=? WHERE product_id=?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "sssdissi", $product_name, $product_size, $product_desc, $product_price, $product_qty, $category_id, $update_time, $product_id);
        }

        if (mysqli_stmt_execute($stmt)) {
            echo "<div class='text-green-500'>Product updated successfully!</div>";
        } else {
            echo "<div class='text-red-500'>Error updating product: " . mysqli_error($conn) . "</div>";
        }
        mysqli_stmt_close($stmt);

        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }

    // Handle Delete Request
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_product_id'])) {
        $product_id = mysqli_real_escape_string($conn, $_POST['delete_product_id']);
        $sql = "DELETE FROM product WHERE product_id=?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $product_id);

        if (mysqli_stmt_execute($stmt)) {
            echo "<div class='text-green-500'>Product deleted successfully!</div>";
        } else {
            echo "<div class='text-red-500'>Error deleting product: " . mysqli_error($conn) . "</div>";
        }
        mysqli_stmt_close($stmt);

        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }

    // Handle Add Product Request
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_name']) && !isset($_POST['edit_product_id']) && !isset($_POST['delete_product_id'])) {
        $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
        $product_size = mysqli_real_escape_string($conn, $_POST['product_size']);
        $product_desc = mysqli_real_escape_string($conn, $_POST['product_desc']);
        $product_price = mysqli_real_escape_string($conn, $_POST['product_price']);
        $product_qty = mysqli_real_escape_string($conn, $_POST['product_qty']);
        $productisactive = 'A'; 
        $category_id = mysqli_real_escape_string($conn, $_POST['category_id']);
        $update_time = date('Y-m-d');
        $admin_id = 1;

        if (!is_numeric($product_price) || floatval($product_price) <= 0) {
            $product_price = 0; 
        } else {
            $product_price = floatval($product_price);
        }

        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $picture = file_get_contents($_FILES['image']['tmp_name']);

            $sql = "INSERT INTO product (product_name, product_size, product_desc, product_price, product_qty, category_id, updated_at, admin_id, product_image, product_isactive) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = mysqli_prepare($conn, $sql);
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "sssdississ", $product_name, $product_size, $product_desc, $product_price, $product_qty, $category_id, $update_time, $admin_id, $picture, $productisactive);

                if (mysqli_stmt_execute($stmt)) {
                    echo "<div class='text-green-500'>Product added successfully!</div>";
                } else {
                    echo "<div class='text-red-500'>Error: " . mysqli_error($conn) . "</div>";
                }
                mysqli_stmt_close($stmt);
            } else {
                echo "<div class='text-red-500'>Error preparing statement: " . mysqli_error($conn) . "</div>";
            }
        } else {
            echo "<div class='text-red-500'>Error with the image upload.</div>";
        }

        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }

    // Fetch Products
    $sql = "SELECT p.product_id, p.product_name, p.product_size, p.product_desc, p.product_price, p.product_qty, p.category_id, c.category_name 
            FROM product p 
            JOIN category c ON p.category_id = c.category_id";

    $result = mysqli_query($conn, $sql);

    // Fetch Categories for Add/Edit Forms
    $sql_category = "SELECT category_id, category_name FROM category";
    $result_category = mysqli_query($conn, $sql_category);
    $result_categoryEdit = mysqli_query($conn, $sql_category);
    ?>

    <!-- Products Table -->
    <div class="mt-6">
      <div class="flex justify-between items-center mt-6 mb-4">
        <h3 class="text-2xl font-bold">Products</h3>
        <div>
          <button type="button" class="w-full text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-teal-300 dark:focus:ring-teal-800 font-medium rounded-lg text-m px-12 py-1.5 text-center">
            <a href="logout.php">Logout</a>
          </button>
        </div>
      </div>
      <!-- Add Product Button -->
      <button id="openAddModalBtn" class="bg-blue-500 text-white px-4 py-2 rounded-lg mt-4 mb-4">Add Product</button>

      <!-- Add Product Modal -->
      <div id="addProductModal" class="modal">
        <div class="modal-content">
          <span class="close">&times;</span>
          <form method="POST" enctype="multipart/form-data">
            <div class="mb-4">
              <label class="block text-gray-700 font-medium mb-1">Product Name</label>
              <input type="text" name="product_name" class="w-full px-3 py-2 border border-blue-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div class="mb-4">
              <label class="block text-gray-700 font-medium mb-1">Size</label>
              <select name="product_size" class="w-full px-3 py-2 border border-blue-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                <option value="s-6">6</option>
                <option value="s-7">7</option>
                <option value="s-8">8</option>
                <option value="s-9">9</option>
                <option value="s-10">10</option>
              </select>
            </div>

            <div class="mb-4">
              <label class="block text-gray-700 font-medium mb-1">Product Description</label>
              <textarea name="product_desc" class="w-full px-3 py-2 border border-blue-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required></textarea>
            </div>

            <div class="mb-4">
              <label class="block text-gray-700 font-medium mb-1">Product Price</label>
              <input type="text" name="product_price" class="w-full px-3 py-2 border border-blue-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div class="mb-4">
              <label class="block text-gray-700 font-medium mb-1">Product Quantity</label>
              <input type="number" name="product_qty" class="w-full px-3 py-2 border border-blue-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div class="mb-4">
              <label class="block text-gray-700 font-medium mb-1">Product Image</label>
              <input type="file" id="productImage" name="image" accept="image/*" required class="w-full px-3 py-2 border border-blue-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
              <img id="imagePreview" class="mt-4 max-h-48 w-full object-cover rounded-lg hidden" />
            </div>

            <div class="mb-4">
              <label class="block text-gray-700 font-medium mb-1">Category ID</label>
              <select name="category_id" class="w-full px-3 py-2 border border-blue-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                <?php
                      if ($result_category->num_rows > 0) {
                        echo "<option value=''>Select Category</option>";
                        while ($row = $result_category->fetch_assoc()) {
                          echo "<option value='" . htmlspecialchars($row['category_id']) . "'>" . htmlspecialchars($row['category_name']) . "</option>";
                        }
                      } else {
                        echo "<option value=''>No categories available</option>";
                      }
                  ?>
              </select>
            </div>

            <div class="mb-4">
              <label class="block text-gray-700 font-medium mb-1">Updated At</label>
              <div id="productDate" class="w-full px-3 py-2 border border-blue-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"><?php echo date('Y-m-d'); ?></div>
            </div>

            <div>
              <button type="submit" class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">Save</button>
              <button type="reset" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">Clear</button>
            </div>
          </form>
        </div>
      </div>

      <div class="bg-white p-6 rounded-lg shadow h-[36rem]">
        <div class="overflow-x-auto overflow-y-auto h-full">
          <table class="min-w-full bg-white">
            <thead class="sticky top-0 z-10 bg-white">
              <tr>
                <th class="py-2 px-4 border-b text-left text-gray-600 hidden">Product ID</th>
                <th class="py-2 px-4 border-b text-left text-gray-600">Product Name</th>
                <th class="py-2 px-4 border-b text-left text-gray-600">Size</th>
                <th class="py-2 px-4 border-b text-left text-gray-600">Description</th>
                <th class="py-2 px-4 border-b text-left text-gray-600">Price</th>
                <th class="py-2 px-4 border-b text-left text-gray-600">Quantity</th> 
                <th class="py-2 px-4 border-b text-left text-gray-600">Category Name</th>
                <th class="py-2 px-4 border-b text-left text-gray-600">Edit/Delete</th>
              </tr>
            </thead>
            <tbody>
              <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td class='py-2 px-4 border-b hidden'>" . htmlspecialchars($row['product_id']) . "</td>";
                        echo "<td class='py-2 px-4 border-b'>" . htmlspecialchars($row['product_name']) . "</td>";
                        echo "<td class='py-2 px-4 border-b'>" . htmlspecialchars($row['product_size']) . "</td>";
                        echo "<td class='py-2 px-4 border-b'>" . htmlspecialchars($row['product_desc']) . "</td>";
                        echo "<td class='py-2 px-4 border-b'>$" . htmlspecialchars($row['product_price']) . "</td>";
                        echo "<td class='py-2 px-4 border-b'>" . htmlspecialchars($row['product_qty']) . "</td>"; // Displaying product quantity
                        echo "<td class='py-2 px-4 border-b' data-category-id='" . htmlspecialchars($row['category_id']) . "'>" . htmlspecialchars($row['category_name']) . "</td>";
                        echo "<td><button class='openEditModalBtn px-2 py-2 text-xs font-medium text-center inline-flex items-center text-white bg-slate-500 rounded-lg hover:bg-slate-600 focus:ring-4 focus:outline-none focus:ring-slate-300'>Edit</button>";
                        echo "<button class='openDeleteModalBtn px-2 py-2 text-xs font-medium text-center inline-flex items-center text-white bg-red-500 rounded-lg hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300'>Delete</button></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7' class='py-2 px-4 border-b text-center'>No products available</td></tr>";
                }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Edit Product Modal -->
    <div id="editProductModal" class="modal">
      <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Edit Product</h2>
        <form method="POST" enctype="multipart/form-data">
          <input type="hidden" name="edit_product_id" id="editProductId">
          <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Product Name</label>
            <input type="text" name="edit_product_name" id="editProductName" class="w-full px-3 py-2 border border-blue-300 rounded" required>
          </div>

          <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Size</label>
            <select name="edit_product_size" id="editProductSize" class="w-full px-3 py-2 border border-blue-300 rounded" required>
              <option value="s-6">6</option>
              <option value="s-7">7</option>
              <option value="s-8">8</option>
              <option value="s-9">9</option>
              <option value="s-10">10</option>
            </select>
          </div>

          <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Product Description</label>
            <textarea name="edit_product_desc" id="editProductDesc" class="w-full px-3 py-2 border border-blue-300 rounded" required></textarea>
          </div>

          <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Product Price</label>
            <input type="text" name="edit_product_price" id="editProductPrice" class="w-full px-3 py-2 border border-blue-300 rounded" required>
          </div>

          <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Product Quantity</label> 
            <input type="number" name="edit_product_qty" id="editProductQty" class="w-full px-3 py-2 border border-blue-300 rounded" required>
          </div>

          <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Product Image</label>
            <input type="file" name="edit_image" accept="image/*" class="w-full px-3 py-2 border border-blue-300 rounded">
          </div>

          <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Category ID</label>
            <select name="edit_category_id" id="editCategoryId" class="w-full px-3 py-2 border border-blue-300 rounded">
              <?php
                  if ($result_categoryEdit->num_rows > 0) {
                    echo "<option value=''>Select Category</option>";
                    while ($row = $result_categoryEdit->fetch_assoc()) {
                      echo "<option value='" . htmlspecialchars($row['category_id']) . "'>" . htmlspecialchars($row['category_name']) . "</option>";
                    }
                  }
              ?>
            </select>
          </div>

          <div>
            <button type="submit" class="focus:outline-none text-white bg-green-700 hover:bg-green-800 font-medium rounded-lg px-5 py-2.5">Save</button>
            <button type="reset" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 font-medium rounded-lg px-5 py-2.5">Clear</button>
          </div>
        </form>
      </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteProductModal" class="modal">
      <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Delete Product</h2>
        <p>Are you sure you want to delete this product?</p>
        <form method="POST">
          <input type="hidden" name="delete_product_id" id="deleteProductId">
          <div class="mt-4">
            <button type="submit" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 font-medium rounded-lg px-5 py-2.5">Delete</button>
          </div>
        </form>
      </div>
    </div>

    <script>
      // Get modal elements
      const addProductModal = document.getElementById("addProductModal");
      const editProductModal = document.getElementById("editProductModal");
      const deleteProductModal = document.getElementById("deleteProductModal");

      // Get open modal buttons
      const openAddModalBtn = document.getElementById("openAddModalBtn");
      const openEditModalBtns = document.querySelectorAll(".openEditModalBtn");
      const openDeleteModalBtns = document.querySelectorAll(".openDeleteModalBtn");

      // Get close buttons
      const closeButtons = document.getElementsByClassName("close");

      // Open Add Product Modal
      openAddModalBtn.onclick = function () {
        addProductModal.style.display = "block";
      };

      // Open Edit Product Modal and populate fields
      openEditModalBtns.forEach(button => {
        button.onclick = function () {
          const row = button.closest('tr');
          const productId = row.querySelector('td:nth-child(1)').textContent;
          const productName = row.querySelector('td:nth-child(2)').textContent;
          const productSize = row.querySelector('td:nth-child(3)').textContent;
          const productDesc = row.querySelector('td:nth-child(4)').textContent;
          const productPrice = row.querySelector('td:nth-child(5)').textContent.replace('$', ''); 
          const productQty = row.querySelector('td:nth-child(6)').textContent; 
          const categoryId = row.querySelector('td:nth-child(7)').getAttribute('data-category-id');

          document.getElementById('editProductId').value = productId;
          document.getElementById('editProductName').value = productName;
          document.getElementById('editProductSize').value = productSize; 
          document.getElementById('editProductDesc').value = productDesc;
          document.getElementById('editProductPrice').value = productPrice; 
          document.getElementById('editProductQty').value = productQty; 
          document.getElementById('editCategoryId').value = categoryId;

          editProductModal.style.display = "block";
        };
      });

      // Open Delete Confirmation Modal
      openDeleteModalBtns.forEach(button => {
        button.onclick = function () {
          const productId = button.closest('tr').querySelector('td:nth-child(1)').textContent;
          document.getElementById('deleteProductId').value = productId;
          deleteProductModal.style.display = "block";
        };
      });

      // Close modals when clicking on the close button
      Array.from(closeButtons).forEach(button => {
        button.onclick = function () {
          addProductModal.style.display = "none";
          editProductModal.style.display = "none";
          deleteProductModal.style.display = "none";
        };
      });

      // Close modals when clicking outside the modal content
      window.onclick = function (event) {
        if (event.target == addProductModal) {
          addProductModal.style.display = "none";
        } else if (event.target == editProductModal) {
          editProductModal.style.display = "none";
        } else if (event.target == deleteProductModal) {
          deleteProductModal.style.display = "none";
        }
      };

      // Previewing Image
      document.getElementById('productImage').addEventListener('change', function(event) {
          const file = event.target.files[0];
          if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
              const imagePreview = document.getElementById('imagePreview');
              imagePreview.src = e.target.result;
              imagePreview.classList.remove('hidden');
            }
            reader.readAsDataURL(file);
          }
      });
    </script>

  </div>
  <?php ob_end_flush();  ?>
</body>

</html>

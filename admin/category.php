<?php
ob_start();

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
  <title>EvoSteps - Categories</title>
  <script src="https://cdn.tailwindcss.com"></script>
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

  <?php include 'side-bar.php'; ?>

  <div class="flex-1 lg:ml-64 p-6 bg-gray-100 overflow-y-auto h-screen pt-16 lg:pt-6">
    <?php
      if (isset($_SESSION['success_message'])) {
          echo "<p class='text-green-600'>" . $_SESSION['success_message'] . "</p>";
          unset($_SESSION['success_message']); 
      }

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

      if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_category_id'])) {
          $delete_category_id = mysqli_real_escape_string($conn, $_POST['delete_category_id']);
          $delete_sql = "DELETE FROM category WHERE category_id = ?";
          $stmt = mysqli_prepare($conn, $delete_sql);
          mysqli_stmt_bind_param($stmt, "i", $delete_category_id);
          mysqli_stmt_execute($stmt);
          mysqli_stmt_close($stmt);

          $_SESSION['success_message'] = "Category deleted successfully.";

          header("Location: " . $_SERVER['PHP_SELF']);
          exit();
      }

      if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_category_id'])) {
          $edit_category_id = mysqli_real_escape_string($conn, $_POST['edit_category_id']);
          $category_name = mysqli_real_escape_string($conn, $_POST['category_name']);
          $category_desc = mysqli_real_escape_string($conn, $_POST['category_desc']);
          $updated_at = date('Y-m-d H:i:s');

          $edit_sql = "UPDATE category SET category_name = ?, category_desc = ?, updated_at = ? WHERE category_id = ?";
          $stmt = mysqli_prepare($conn, $edit_sql);
          mysqli_stmt_bind_param($stmt, "sssi", $category_name, $category_desc, $updated_at, $edit_category_id);
          mysqli_stmt_execute($stmt);
          mysqli_stmt_close($stmt);

          $_SESSION['success_message'] = "Category updated successfully.";

          header("Location: " . $_SERVER['PHP_SELF']);
          exit();
      }

      if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['delete_category_id']) && !isset($_POST['edit_category_id'])) {
          $category_name = mysqli_real_escape_string($conn, $_POST['category_name']);
          $category_desc = mysqli_real_escape_string($conn, $_POST['category_desc']);
          $updated_at = date('Y-m-d H:i:s');
          $admin_id = 1;  

          $sql = "INSERT INTO category (category_name, category_desc, updated_at, admin_id) 
                  VALUES (?, ?, ?, ?)";

          $stmt = mysqli_prepare($conn, $sql);
          if ($stmt) {
              mysqli_stmt_bind_param($stmt, "sssi", 
                  $category_name, 
                  $category_desc, 
                  $updated_at, 
                  $admin_id
              );

              if (mysqli_stmt_execute($stmt)) {
                  $_SESSION['success_message'] = "Category added successfully!";
              } else {
                  echo "Error: " . mysqli_error($conn);
              }

              mysqli_stmt_close($stmt);
          } else {
              echo "Error preparing statement: " . mysqli_error($conn);
          }

          header("Location: " . $_SERVER['PHP_SELF']);
          exit();
      }

      $sql = "SELECT category_id, category_name, category_desc, updated_at, admin_id FROM category";
      $result = mysqli_query($conn, $sql);
    ?>

    <!-- Categories Table -->
    <div class="mt-6">
      <div class="flex justify-between items-center mt-6 mb-4">
        <h3 class="text-2xl font-bold">Categories</h3>
        <div>
          <button type="button" class="w-full text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-teal-300 dark:focus:ring-teal-800 font-medium rounded-lg text-m px-12 py-1.5 text-center">
            <a href="logout.php">Logout</a>
          </button>
        </div>
      </div>
      <!-- Add Category Button -->
      <button id="openAddModalBtn" class="bg-blue-500 text-white px-4 py-2 rounded-lg mt-4 mb-4">Add Category</button>

      <!-- Add Category Modal -->
      <div id="addModal" class="modal">
        <div class="modal-content">
          <span class="close">&times;</span>
          <form method="POST">
            <div class="mb-4">
              <label class="block text-gray-700 font-medium mb-1">Category Name</label>
              <input type="text" name="category_name" class="w-full px-3 py-2 border border-blue-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="mb-4">
              <label class="block text-gray-700 font-medium mb-1">Category Description</label>
              <textarea name="category_desc" class="w-full px-3 py-2 border border-blue-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
            </div>
            <div class="mb-4">
              <label class="block text-gray-700 font-medium mb-1">Updated At</label>
              <input type="date" id="addUpdatedAt" name="update_time" class="w-full px-3 py-2 border border-blue-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
              <button type="submit" class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2">Save</button>
              <button type="reset" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2">Clear</button>
            </div>
          </form>
        </div>
      </div>

      <!-- Edit Category Modal -->
      <div id="editModal" class="modal">
        <div class="modal-content">
          <span class="close">&times;</span>
          <form method="POST">
            <input type="hidden" name="edit_category_id" id="editCategoryId">
            <div class="mb-4">
              <label class="block text-gray-700 font-medium mb-1">Category Name</label>
              <input type="text" name="category_name" id="editCategoryName" class="w-full px-3 py-2 border border-blue-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="mb-4">
              <label class="block text-gray-700 font-medium mb-1">Category Description</label>
              <textarea name="category_desc" id="editCategoryDesc" class="w-full px-3 py-2 border border-blue-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
            </div>
            <div class="mb-4">
              <label class="block text-gray-700 font-medium mb-1">Updated At</label>
              <input type="date" id="editUpdatedAt" name="update_time" class="w-full px-3 py-2 border border-blue-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
              <button type="submit" class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2">Save</button>
              <button type="reset" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2">Clear</button>
            </div>
          </form>
        </div>
      </div>

      <!-- Delete Category Modal -->
      <div id="deleteModal" class="modal">
        <div class="modal-content">
          <span class="close">&times;</span>
          <p class="text-gray-700 font-medium mb-4">Are you sure you want to delete this category?</p>
          <form method="POST">
          <input type="hidden" id="deleteCategoryId" name="delete_category_id">
          <div class="mt-4">
            <button type="submit" id="confirmDeleteBtn" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">Delete</button>
          </div>
        </form>
        </div>
      </div>

      <!-- Categories Table -->
      <div class="bg-white p-6 rounded-lg shadow h-[36rem]">
        <div class="overflow-x-auto overflow-y-auto h-full">
          <table class="min-w-full bg-white">
            <thead class="sticky top-0 z-10 bg-white">
              <tr>
                <th class="py-2 px-4 border-b text-left text-gray-600 hidden">Category ID</th>
                <th class="py-2 px-4 border-b text-left text-gray-600">Category Name</th>
                <th class="py-2 px-4 border-b text-left text-gray-600">Description</th>
                <th class="py-2 px-4 border-b text-left text-gray-600">Updated At</th>
                <th class="py-2 px-4 border-b text-left text-gray-600">Edit/Delete</th>
              </tr>
            </thead>
            <tbody>
            <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td class='py-2 px-4 border-b hidden'>" . htmlspecialchars($row['category_id']) . "</td>";
                echo "<td class='py-2 px-4 border-b'>" . htmlspecialchars($row['category_name']) . "</td>";
                echo "<td class='py-2 px-4 border-b'>" . htmlspecialchars($row['category_desc']) . "</td>";
                echo "<td class='py-2 px-4 border-b'>" . htmlspecialchars($row['updated_at']) . "</td>";
                echo "<td>
                        <button type='button' class='editBtn px-4 py-2 text-xs font-medium text-center text-white bg-slate-500 rounded-lg hover:bg-slate-600 focus:ring-4 
                        focus:outline-none focus:ring-slate-300 dark:bg-slate-600 dark:hover:bg-slate-700 dark:focus:ring-slate-800' data-id='" . htmlspecialchars($row['category_id']) . "' data-name='" . htmlspecialchars($row['category_name']) . "' data-desc='" . htmlspecialchars($row['category_desc']) . "' data-updated-at='" . htmlspecialchars($row['updated_at']) . "'>Edit</button>
                        <button type='button' class='deleteBtn px-3 py-2 text-xs font-medium text-center text-white bg-red-500 rounded-lg 
                        hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 
                        dark:focus:ring-red-800' data-id='" . htmlspecialchars($row['category_id']) . "'>Delete</button>
                      </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4' class='py-2 px-4 border-b text-center'>No category available</td></tr>";
        }

        mysqli_close($conn);
    ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <script>
    function updateDate() {
      const now = new Date();
      const year = now.getFullYear();
      const month = String(now.getMonth() + 1).padStart(2, '0');
      const day = String(now.getDate()).padStart(2, '0');
      const currentDate = `${year}-${month}-${day}`;

      document.getElementById('addUpdatedAt').value = currentDate;
    }

    updateDate();

    var addModal = document.getElementById("addModal");
    var editModal = document.getElementById("editModal");
    var deleteModal = document.getElementById("deleteModal");

    var openAddModalBtn = document.getElementById("openAddModalBtn");

    var closeBtns = document.getElementsByClassName("close");

    openAddModalBtn.onclick = function () {
      addModal.style.display = "block";
    }

    document.querySelectorAll('.editBtn').forEach(button => {
      button.addEventListener('click', function () {
        const id = this.getAttribute('data-id');
        const name = this.getAttribute('data-name');
        const desc = this.getAttribute('data-desc');
        const updatedAt = this.getAttribute('data-updated-at');

        document.getElementById('editCategoryId').value = id;
        document.getElementById('editCategoryName').value = name;
        document.getElementById('editCategoryDesc').value = desc;
        document.getElementById('editUpdatedAt').value = updatedAt;

        editModal.style.display = "block";
      });
    });

    document.querySelectorAll('.deleteBtn').forEach(button => {
      button.addEventListener('click', function () {
        const id = this.getAttribute('data-id');
        document.getElementById('deleteCategoryId').value = id;
        deleteModal.style.display = "block";
      });
    });

    for (var i = 0; i < closeBtns.length; i++) {
      closeBtns[i].onclick = function () {
        this.parentElement.parentElement.style.display = "none";
        resetFormFields(this.parentElement.parentElement.querySelector('form'));
      }
    }

    window.onclick = function (event) {
      if (event.target == addModal || event.target == editModal || event.target == deleteModal) {
        event.target.style.display = "none";
        resetFormFields(event.target.querySelector('form'));
      }
    }

    function resetFormFields(form) {
      if (form) form.reset();
    }
  </script>
  <?php
  ob_end_flush(); 
  ?>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../assets/css/style.css" />
  <link rel="stylesheet" href="../assets/css/nav_cart.css" />
  <title>EvoSteps | Ready to Wear</title>
</head>
<body>
  <?php include './includes/navbar.php'; 
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

    $product_id = $_GET['product_id'];
    $query_product = "
      SELECT product_id, product_image, product_name, product_price, product_desc
      FROM product
      WHERE product_id = $product_id";

    $result_product = mysqli_query($conn, $query_product);

    $query = "
      SELECT product_id, product_image, product_name, product_price
      FROM product
      WHERE product_id != $product_id LIMIT 4";

    $result = mysqli_query($conn, $query);

    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
      $sql_order = "INSERT INTO orders (order_name, order_email, order_address, order_postcode, order_phoneno, order_status, order_date, total_price)
                    SELECT 'temporary name', 'tmp', 'tmp', 'tmp', 'tmp', 'In Progress', '2000-01-01', 0
                    WHERE NOT EXISTS (
                      SELECT 1 FROM orders
                      WHERE order_name = 'temporary name'
                      ORDER BY order_id DESC
                      LIMIT 1
                    )";
      $stmt = mysqli_prepare($conn, $sql_order);
      mysqli_stmt_execute($stmt);
    
      $sql_max_id = "SELECT MAX(order_id) AS max_id FROM orders";
      $result = mysqli_query($conn, $sql_max_id);
    
      $row = mysqli_fetch_assoc($result);
      $max_id = $row['max_id'];

      $sql_product = "INSERT INTO orderproduct (order_id, product_id, quantity) 
                      VALUES ($max_id, $product_id, 1) 
                      ON DUPLICATE KEY UPDATE quantity = quantity + 1";
      $stmt = mysqli_prepare($conn, $sql_product);
      mysqli_stmt_execute($stmt);
    }
  ?>
  <div class="p-10">
  </div>

  <section class="py-8 bg-white md:py-16 dark:bg-gray-900 antialiased w-full">
    <div class="max-w-screen-xl px-4 mx-auto 2xl:px-0">
      <div class="lg:grid lg:grid-cols-2 lg:gap-8 xl:gap-16">
        <div class="image-container max-w-md lg:max-w-lg mx-auto">
          <?php 
            while ($row = mysqli_fetch_assoc($result_product)) {
              echo '<img class="image dark:hidden rounded-lg" src="data:image/png;charset=utf8;base64,' . base64_encode($row['product_image']) . '" />';
              echo '</div>';
              echo '<div class="mt-6 sm:mt-8 lg:mt-0">';
              echo '<h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">';
              echo ''. htmlspecialchars($row['product_name']) .'';
              echo '</h1>';
              echo '<div class="mt-4 sm:items-center sm:gap-4 sm:flex">';
              echo '<p class="text-2xl font-extrabold text-gray-900 sm:text-3xl dark:text-white">$'. htmlspecialchars($row['product_price']) .'</p>';
            }
          ?>
            <div class="flex items-center gap-2 mt-2 sm:mt-0">
              <div class="flex items-center gap-1">
                <svg class="w-4 h-4 text-yellow-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M13.849 4.22c-.684-1.626-3.014-1.626-3.698 0L8.397 8.387l-4.552.361c-1.775.14-2.495 2.331-1.142 3.477l3.468 2.937-1.06 4.392c-.413 1.713 1.472 3.067 2.992 2.149L12 19.35l3.897 2.354c1.52.918 3.405-.436 2.992-2.15l-1.06-4.39 3.468-2.938c1.353-1.146.633-3.336-1.142-3.477l-4.552-.36-1.754-4.17Z" />
                </svg>
                <svg class="w-4 h-4 text-yellow-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M13.849 4.22c-.684-1.626-3.014-1.626-3.698 0L8.397 8.387l-4.552.361c-1.775.14-2.495 2.331-1.142 3.477l3.468 2.937-1.06 4.392c-.413 1.713 1.472 3.067 2.992 2.149L12 19.35l3.897 2.354c1.52.918 3.405-.436 2.992-2.15l-1.06-4.39 3.468-2.938c1.353-1.146.633-3.336-1.142-3.477l-4.552-.36-1.754-4.17Z" />
                </svg>
                <svg class="w-4 h-4 text-yellow-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M13.849 4.22c-.684-1.626-3.014-1.626-3.698 0L8.397 8.387l-4.552.361c-1.775.14-2.495 2.331-1.142 3.477l3.468 2.937-1.06 4.392c-.413 1.713 1.472 3.067 2.992 2.149L12 19.35l3.897 2.354c1.52.918 3.405-.436 2.992-2.15l-1.06-4.39 3.468-2.938c1.353-1.146.633-3.336-1.142-3.477l-4.552-.36-1.754-4.17Z" />
                </svg>
                <svg class="w-4 h-4 text-yellow-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M13.849 4.22c-.684-1.626-3.014-1.626-3.698 0L8.397 8.387l-4.552.361c-1.775.14-2.495 2.331-1.142 3.477l3.468 2.937-1.06 4.392c-.413 1.713 1.472 3.067 2.992 2.149L12 19.35l3.897 2.354c1.52.918 3.405-.436 2.992-2.15l-1.06-4.39 3.468-2.938c1.353-1.146.633-3.336-1.142-3.477l-4.552-.36-1.754-4.17Z" />
                </svg>
                <svg class="w-4 h-4 text-yellow-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M13.849 4.22c-.684-1.626-3.014-1.626-3.698 0L8.397 8.387l-4.552.361c-1.775.14-2.495 2.331-1.142 3.477l3.468 2.937-1.06 4.392c-.413 1.713 1.472 3.067 2.992 2.149L12 19.35l3.897 2.354c1.52.918 3.405-.436 2.992-2.15l-1.06-4.39 3.468-2.938c1.353-1.146.633-3.336-1.142-3.477l-4.552-.36-1.754-4.17Z" />
                </svg>
              </div>
              <p class="text-sm font-medium leading-none text-gray-500 dark:text-gray-400">
                (5.0)
              </p>
              <a href="#" class="text-sm font-medium leading-none text-gray-900 underline hover:no-underline dark:text-white">
                345 Reviews
              </a>
            </div>
          </div>
          
          <form method="POST">
          <div class="mt-6 sm:gap-4 sm:items-center sm:flex sm:mt-8">
            <a href="#" title="" class="text-white mt-4 sm:mt-0 bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800 flex items-center justify-center" role="button">
              <svg class="w-5 h-5 -ms-2 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4h1.5L8 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm.75-3H7.5M11 7H6.312M17 4v6m-3-3h6" />
              </svg>
              <button type="submit">Add to cart</button>
            </a>
          </div>
          </form>

          <hr class="my-6 md:my-8 border-gray-200 dark:border-gray-800" />
          <?php 
            mysqli_data_seek($result_product, 0);
            while ($row = mysqli_fetch_assoc($result_product)) {
              echo '<p class="mb-6 text-gray-500 dark:text-gray-400">'. htmlspecialchars($row['product_desc']) .'</p>';
            }
          ?>
          <p class="text-gray-500 dark:text-gray-400">
            Crafted for comfort and style, this product offers durability and a perfect fit for everyday use.
          </p>
        </div>
      </div>
      <span class="relative flex justify-center">
        <div class="absolute inset-x-0 top-1/2 h-px -translate-y-1/2 bg-transparent bg-gradient-to-r from-transparent via-gray-500 to-transparent opacity-75"></div>
        <span class="p-10 relative z-10 bg-white">You may also like </span>
      </span>
      <section>
        <div class="mx-auto max-w-screen-xl px-4 py-4 sm:px-6 sm:py-6 lg:px-8">
          <header>
            <h2 class="text-xl font-bold text-gray-900 sm:text-3xl">Product Collection</h2>
            <p class="mt-4 max-w-md text-gray-500">
              Lorem ipsum, dolor sit amet consectetur adipisicing elit. Itaque praesentium cumque iure dicta incidunt est ipsam, officia dolor fugit natus?
            </p>
          </header>
          <ul class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <?php 
              while ($row = mysqli_fetch_assoc($result)) {
                echo '<li>';
                echo '<a href="product_description.php?product_id=' . urlencode($row['product_id']) . '" class="group block overflow-hidden">';
                echo '<img src="data:image/png;charset=utf8;base64,' . base64_encode($row['product_image']) . '" alt="" class="h-[350px] w-full object-cover transition duration-500 group-hover:scale-105 sm:h-[450px]" />';              
                echo '<div class="relative bg-white pt-3">';
                echo '<h3 class="text-xs text-gray-700 group-hover:underline group-hover:underline-offset-4">'. htmlspecialchars($row['product_name']) .'</h3>';
                echo '<p class="mt-2">';
                echo '<span class="sr-only"> Regular Price </span>';
                echo '<span class="tracking-wider text-gray-900"> £'.htmlspecialchars($row['product_price']).' </span>';
                echo '</p>';
                echo '</div>';
                echo '</a>';
                echo '</li>';
              }            
            ?>
          </ul>
        </div>
      </section>
    </div>
  </section>
  <?php include './includes/footer.php'; ?>
  <?php include './includes/cart.php'; ?>
  <script src="../assets/js/main.js"></script>
</body>
</html>

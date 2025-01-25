<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/nav_cart.css" />
    <link rel="stylesheet" href="../assets/css/style.css" />
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

  $sortBy = isset($_GET['sortBy']) ? $_GET['sortBy'] : 'ASC';
  $availability = isset($_GET['availability']) ? $_GET['availability'] : [];
  $priceFrom = isset($_GET['From']) ? (int)$_GET['From'] : 0;
  $priceTo = isset($_GET['To']) ? (int)$_GET['To'] : 600;

  // Build availability condition
  $availabilityCondition = '';
  if (!empty($availability)) {
    $availabilityConditions = [];
    if (in_array('InStock', $availability)) {
        $availabilityConditions[] = "product_isactive = 'A'";
    }
    if (in_array('PreOrder', $availability)) {
        $availabilityConditions[] = "product_isactive = 'P'";
    }
    if (in_array('OutOfStock', $availability)) {
        $availabilityConditions[] = "product_isactive = 'I'";
    }
    $availabilityCondition = "AND (" . implode(" OR ", $availabilityConditions) . ")";
  }
  // SQL Query
  $query = "
      SELECT product_id, product_image, product_name, product_price, product_qty
      FROM product
      WHERE product_price BETWEEN $priceFrom AND $priceTo
      $availabilityCondition
      ORDER BY product_price $sortBy
  ";

  $result = mysqli_query($conn, $query);

?>


<br><br>
<section>
  <div class="mx-auto max-w-screen-xl px-4 py-8 sm:px-6 sm:py-12 lg:px-8">
    <header>
      <h2 class="text-xl font-bold text-gray-900 sm:text-3xl">Step into style</h2>
    </header>

    <div class="mt-8 block lg:hidden">
      <button
        class="flex cursor-pointer items-center gap-2 border-b border-gray-400 pb-1 text-gray-900 transition hover:border-gray-600"
      >
        <span class="text-sm font-medium"> Filters & Sorting </span>

        <svg
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          stroke-width="1.5"
          stroke="currentColor"
          class="size-4 rtl:rotate-180"
        >
          <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
        </svg>
      </button>
    </div>

    <div class="mt-4 lg:mt-8 lg:grid lg:grid-cols-4 lg:items-start lg:gap-8">
      <div class="hidden space-y-4 lg:block">
      <!--DID CHANGES-->
      <form method="GET" action="">
        <div>
          <label for="SortBy" class="block text-xs font-medium text-gray-700"> Sort By </label>
          <select id="SortBy" name="sortBy" class="mt-1 rounded border-gray-300 text-sm">
            <option value="ASC" <?= $sortBy == 'ASC' ? 'selected' : '' ?>>Price, Low to High</option>
            <option value="DESC" <?= $sortBy == 'DESC' ? 'selected' : '' ?>>Price, High to Low</option>
          </select>
        </div>

        <div>
          <p class="block text-xs font-medium text-gray-700">Filters</p>
          <div class="mt-1 space-y-2">
            <details class="overflow-hidden rounded border border-gray-300">
                <summary class="flex cursor-pointer items-center justify-between gap-2 p-4 text-gray-900 transition">
                    <span class="text-sm font-medium"> Availability </span>
                    <span class="transition group-open:-rotate-180">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                        </svg>
                    </span>
                </summary>
                <div class="border-t border-gray-200 bg-white">
                    <ul class="space-y-1 border-t border-gray-200 p-4">
                        <li>
                            <label for="FilterInStock" class="inline-flex items-center gap-2">
                                <input type="checkbox" id="FilterInStock" class="size-5 rounded border-gray-300" name="availability[]" value="InStock" <?= in_array('InStock', $availability) ? 'checked' : '' ?> />
                                <span class="text-sm font-medium text-gray-700"> In Stock (5+) </span>
                            </label>
                        </li>
                        <li>
                            <label for="FilterPreOrder" class="inline-flex items-center gap-2">
                                <input type="checkbox" id="FilterPreOrder" class="size-5 rounded border-gray-300" name="availability[]" value="PreOrder" <?= in_array('PreOrder', $availability) ? 'checked' : '' ?> />
                                <span class="text-sm font-medium text-gray-700"> Pre Order (3+) </span>
                            </label>
                        </li>
                        <li>
                            <label for="FilterOutOfStock" class="inline-flex items-center gap-2">
                                <input type="checkbox" id="FilterOutOfStock" class="size-5 rounded border-gray-300" name="availability[]" value="OutOfStock" <?= in_array('OutOfStock', $availability) ? 'checked' : '' ?> />
                                <span class="text-sm font-medium text-gray-700"> Out of Stock (10+) </span>
                            </label>
                        </li>
                    </ul>
                </div>
            </details>

            <details class="overflow-hidden rounded border border-gray-300">
                <summary class="flex cursor-pointer items-center justify-between gap-2 p-4 text-gray-900 transition">
                    <span class="text-sm font-medium"> Price </span>
                    <span class="transition group-open:-rotate-180">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                        </svg>
                    </span>
                </summary>
                <div class="border-t border-gray-200 bg-white">
                    <div class="border-t border-gray-200 p-4">
                        <div class="flex justify-between gap-4">
                            <label for="FilterPriceFrom" class="flex items-center gap-2">
                                <span class="text-sm text-gray-600">$</span>
                                <input type="number" id="FilterPriceFrom" placeholder="From" class="w-full rounded-md border-gray-200 shadow-sm sm:text-sm" name="From" value="<?= $priceFrom ?>" />
                            </label>
                            <label for="FilterPriceTo" class="flex items-center gap-2">
                                <span class="text-sm text-gray-600">$</span>
                                <input type="number" id="FilterPriceTo" placeholder="To" class="w-full rounded-md border-gray-200 shadow-sm sm:text-sm" name="To" value="<?= $priceTo ?>" />
                            </label>
                        </div>
                    </div>
                </div>
            </details>
        </div>
    </div>
    <button type="submit" class="mt-4 inline-flex items-center justify-center rounded-md border border-transparent bg-black px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-gray-800">
      Apply Filters
    </button>
    </form>
    <!--CHANGES END-->
      </div>

      <div class="lg:col-span-3">
        <ul class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
          <?php 
            while ($row = mysqli_fetch_assoc($result)) {
              echo '<li>';
              echo '<a href="products.php?product_id=' . urlencode($row['product_id']) . '" class="group block overflow-hidden">';
              echo '<a href="product_description.php?product_id=' . urlencode($row['product_id']) . '" class="group block overflow-hidden rounded">';              
              echo '<div class="relative h-[350px] sm:h-[400px] rounded overflow-hidden">';
              echo '<img src="data:image/png;charset=utf8;base64,' . base64_encode($row['product_image']) . '" class="absolute inset-0 h-full w-full object-cover opacity-100 group-hover:opacity-0"/>';
              echo '</div>';
              echo '<div class="relative bg-white pt-3">';
              echo '<h3 class="text-sm text-gray-700 group-hover:underline group-hover:underline-offset-4">' . htmlspecialchars($row['product_name']) . '</h3>';
              echo '<div class="mt-1.5 flex items-center justify-between text-gray-900">';
              echo '<p class="tracking-wide">$' . htmlspecialchars($row['product_price']) . '</p>';
              echo '<p class="text-xs uppercase tracking-wide text-gray-500 shadow-sm">' . htmlspecialchars($row['product_qty']). ' left in stock</p>';
              echo '</div>';
              echo '</div>';
              echo '</a>';
              echo '</li>';
          }
          ?>
          
        </ul>
        <ol class="mt-8 flex justify-center gap-1 text-xs font-medium">
     

      <li>
        <a href="#" class="block size-8 rounded border border-gray-100 text-center leading-8">
          1
        </a>
      </li>

      <li class="block size-8 rounded border-black bg-black text-center leading-8 text-white">2</li>

      <li>
        <a href="#" class="block size-8 rounded border border-gray-100 text-center leading-8">
          3
        </a>
      </li>

      <li>
        <a href="#" class="block size-8 rounded border border-gray-100 text-center leading-8">
          4
        </a>
      </li>

      <li>
        <a
          href="#"
          class="inline-flex size-8 items-center justify-center rounded border border-gray-100"
        >
          <span class="sr-only">Next Page</span>
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="size-3"
            viewBox="0 0 20 20"
            fill="currentColor"
          >
            <path
              fill-rule="evenodd"
              d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
              clip-rule="evenodd"
            />
          </svg>
        </a>
      </li>
    </ol>
      </div>
    </div>
  </div>
</section>
<?php include './includes/footer.php'; ?>
<?php include './includes/cart.php'; ?>
<script src="../assets/js/main.js"></script>

</body>
</html>
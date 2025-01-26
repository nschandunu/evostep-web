<!-- cart.php -->
 <style>
    
 </style>
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

  $order_id_query = "SELECT order_id FROM orders WHERE order_name = 'temporary name'";
  $result_orderId = mysqli_query($conn, $order_id_query);
    
  $row = mysqli_fetch_assoc($result_orderId);
  $order_id = $row['order_id'];

  $products_query = "SELECT p.product_id, p.product_name, p.product_image, p.product_price, p.product_size, op.quantity 
                    FROM product p JOIN orderproduct op ON p.product_id = op.product_id 
                    WHERE op.order_id = $order_id";
  
  $result = mysqli_query($conn, $products_query);

  $subtotal_query = "SELECT SUM(p.product_price * op.quantity) AS total_cost
              FROM product p
              JOIN orderproduct op ON p.product_id = op.product_id
              WHERE op.order_id = $order_id";

  $subtotal_result = mysqli_query($conn, $subtotal_query);
  $subtotal_row = mysqli_fetch_assoc($subtotal_result);

  if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $delete_product_id = mysqli_real_escape_string($conn, $_POST['delete_product_id']);
    $delete_sql = "DELETE FROM orderproduct WHERE product_id = $delete_product_id";
    $stmt = mysqli_prepare($conn, $delete_sql);
    mysqli_stmt_execute($stmt);
  }
 ?>
<div class="relative z-10 hidden" id="cartPanel" aria-labelledby="slide-over-title" role="dialog" aria-modal="true">
  <div id="overlay" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity opacity-0 pointer-events-none"></div>

  <div class="fixed inset-0 overflow-hidden">
    <div class="absolute inset-0 overflow-hidden">
      <div id="panel" class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10 transform translate-x-full transition-transform ease-in-out duration-500">
        <div class="pointer-events-auto w-screen max-w-md">
          <div class="flex h-full flex-col overflow-y-scroll bg-white shadow-xl">
            <div class="flex-1 overflow-y-auto px-4 py-6 sm:px-6">
              <div class="flex items-start justify-between">
                <h2 class="text-lg font-medium text-gray-900" id="slide-over-title">Shopping cart</h2>
                <div class="ml-3 flex h-7 items-center">
                  <button type="button" id="closeCartBtn" class="relative -m-2 p-2 text-gray-400 hover:text-gray-500">
                    <span class="sr-only">Close panel</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                  </button>
                </div>
              </div>
              <div class="mt-8">
                <div class="flow-root">
                  <ul role="list" class="-my-6 divide-y divide-gray-200">
                        <?php 
                          if (!$result){
                            echo '<h3>No Items in Cart</h3>';
                          }
                          else {
                            while ($row = mysqli_fetch_assoc($result)) {
                            echo '<li class="flex py-6">';
                            echo '<div class="h-24 w-24 flex-shrink-0 overflow-hidden rounded-md border border-gray-200">';
                            echo '<img src="data:image/png;charset=utf8;base64,' . base64_encode($row['product_image']) . '" alt="Product Image" class="h-full w-full object-cover object-center">';
                            echo '</div>';
                            echo '<div class="ml-4 flex flex-1 flex-col">
                                  <div class="flex justify-between text-base font-medium text-gray-900">';
                            echo '<h3>'. htmlspecialchars($row['product_name']) .'</h3>';
                            echo '<p class="ml-4">$'. htmlspecialchars($row['product_price']) .'</p>';
                            echo '</div>';
                            echo '<p class="mt-1 text-sm text-gray-500">'. htmlspecialchars($row['product_size']) .'</p>';
                            echo '<div class="flex flex-1 items-end justify-between text-sm">';
                            echo '<p class="text-gray-500">Quantity: '. htmlspecialchars($row['quantity']) .'</p>';
                            echo '<div class="flex">';
                            echo '<form method="POST">';
                            echo '<input type="hidden" id="deleteProductId" name="delete_product_id" value="'. htmlspecialchars($row['product_id']) .'">';
                            echo '<button type="submit" id="confirmDeleteBtn" class="font-medium text-blue-600 hover:text-blue-500" data-id="'. htmlspecialchars($row['product_id']) .'">Remove</button>';
                            echo '</form>';
                            echo '</div>
                                  </div>
                                  </div>
                                  </li>';
                            }
                          }
                        ?>       
                  </ul>
                </div>
              </div>
            </div>
            <div class="border-t border-gray-200 px-4 py-6 sm:px-6">
              <div class="flex justify-between text-base font-medium text-gray-900">
                <p>Subtotal</p>
                <p>
                  <?php 
                    $subtotal = $subtotal_row['total_cost'];
                    echo '$'. $subtotal_row['total_cost'] .'';
                  ?>
                </p>
              </div>
              <p class="mt-0.5 text-sm text-gray-500">Shipping and taxes calculated at checkout.</p>
              <div class="mt-6">
                <a href="./checkout.php?order_id=<?php echo urlencode($order_id); ?>&subtotal=<?php echo urlencode($subtotal); ?>" class="flex items-center justify-center rounded-md border border-transparent bg-blue-600 px-6 py-3 text-base font-medium text-white shadow-sm hover:bg-blue">Checkout</a>
              </div>
              <div class="mt-6 flex justify-center text-center text-sm text-gray-500">
                <p>or <a href="./shop.php"><button type="button" class="font-medium text-blue-600 hover:text-blue-500">Continue Shopping <span aria-hidden="true"> &rarr;</span></button></a></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
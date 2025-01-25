<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../assets/css/style.css" />
    <link rel="stylesheet" href="../assets/css/nav_cart.css" />
    <title>EvoSteps | Checkout</title>
  </head>
  <body>
  <?php include './includes/navbar.php'; ?>
    <?php
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

    $order_id = intval($_GET['order_id']);
    $subtotal = floatval($_GET['subtotal']);

    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
      $order_name = mysqli_real_escape_string($conn, $_POST['first_name'] . ' ' . $_POST['last_name']);
      $order_email = mysqli_real_escape_string($conn, $_POST['email']);
      $order_address = mysqli_real_escape_string($conn, $_POST['address']);
      $order_postcode = mysqli_real_escape_string($conn, $_POST['postal']);
      $order_phoneno = mysqli_real_escape_string($conn, $_POST['phone']);
      $order_status = 'Placed';
      $order_totalprice = $subtotal;
      $order_date = date('Y-m-d H:i:s');

      $sql = "UPDATE orders SET order_email='$order_email', order_name='$order_name', order_address='$order_address',
      order_postcode='$order_postcode', order_phoneno='$order_phoneno', order_date='$order_date', 
      order_status='$order_status',
      total_price=$subtotal WHERE order_id=$order_id";

      $stmt = mysqli_prepare($conn, $sql);
      mysqli_stmt_execute($stmt);

      $sql_delete = "DELETE from orderproduct";
      $stmt_delete = mysqli_prepare($conn, $sql_delete);
      mysqli_stmt_execute($stmt_delete);
    }
    ?>
<section class="bg-white py-8 antialiased dark:bg-gray-900 md:py-16 mt-20">
      <form method="POST" class="mx-auto max-w-screen-xl px-4 2xl:px-0">
        <ol
          class="items-center flex w-full max-w-2xl text-center text-sm font-medium text-gray-500 dark:text-gray-400 sm:text-base"
        >
          <li
            class="after:border-1 flex items-center text-primary-700 after:mx-6 after:hidden after:h-1 after:w-full after:border-b after:border-gray-200 dark:text-primary-500 dark:after:border-gray-700 sm:after:inline-block sm:after:content-[''] md:w-full xl:after:mx-10"
          >
            <span
              class="flex items-center after:mx-2 after:text-gray-200 after:content-['/'] dark:after:text-gray-500 sm:after:hidden"
            >
              <svg
                class="me-2 h-4 w-4 sm:h-5 sm:w-5"
                aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg"
                width="24"
                height="24"
                fill="none"
                viewBox="0 0 24 24"
              >
                <path
                  stroke="currentColor"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M8.5 11.5 11 14l4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
                />
              </svg>
              Cart
            </span>
          </li>

          <li
            class="after:border-1 flex items-center text-primary-700 after:mx-6 after:hidden after:h-1 after:w-full after:border-b after:border-gray-200 dark:text-primary-500 dark:after:border-gray-700 sm:after:inline-block sm:after:content-[''] md:w-full xl:after:mx-10"
          >
            <span
              class="flex items-center after:mx-2 after:text-gray-200 after:content-['/'] dark:after:text-gray-500 sm:after:hidden"
            >
              <svg
                class="me-2 h-4 w-4 sm:h-5 sm:w-5"
                aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg"
                width="24"
                height="24"
                fill="none"
                viewBox="0 0 24 24"
              >
                <path
                  stroke="currentColor"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M8.5 11.5 11 14l4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
                />
              </svg>
              Checkout
            </span>
          </li>
        </ol>

        <div class="mt-6 sm:mt-8 lg:flex lg:items-start lg:gap-12 xl:gap-16">
          <div class="min-w-0 flex-1 space-y-8">
            <div class="space-y-4">
              <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                Delivery Details
              </h2>
              <div>
                <div class="mb-2 flex items-center gap-2">
                  <label
                    for="select-country-input-3"
                    class="block text-sm font-medium text-gray-900 dark:text-white"
                  >
                    Country*
                  </label>
                </div>
                <select
                  id="select-country-input-3"
                  class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                >
                  <option value="LK" selected>Sri Lanka</option>
                  <option value="AS">Australia</option>
                  <option value="FR">France</option>
                  <option value="ES">Spain</option>
                  <option value="UK">United Kingdom</option>
                  <option value="US">United States</option>
                  <option value="CA">Canada</option>
                  <option value="DE">Germany</option>
                  <option value="IT">Italy</option>
                  <option value="JP">Japan</option>
                  <option value="CN">China</option>
                  <option value="IN">India</option>
                  <option value="BR">Brazil</option>
                  <option value="ZA">South Africa</option>
                  <option value="MX">Mexico</option>
                  <option value="RU">Russia</option>
                  <option value="KR">South Korea</option>
                  <option value="ID">Indonesia</option>
                  <option value="SG">Singapore</option>
                  <option value="NL">Netherlands</option>
                  <option value="SE">Sweden</option>
                  <option value="CH">Switzerland</option>
                  <option value="AE">United Arab Emirates</option>
                  <option value="NZ">New Zealand</option>
                  <option value="TR">Turkey</option>
                  <option value="SA">Saudi Arabia</option>
                  <option value="PL">Poland</option>
                  <option value="BE">Belgium</option>
                  <option value="AT">Austria</option>
                  <option value="DK">Denmark</option>
                  <option value="NO">Norway</option>
                  <option value="FI">Finland</option>
                  <option value="IE">Ireland</option>
                  <option value="PT">Portugal</option>
                  <option value="GR">Greece</option>
                  <option value="HK">Hong Kong</option>
                  <option value="MY">Malaysia</option>
                  <option value="PH">Philippines</option>
                  <option value="VN">Vietnam</option>
                  <option value="TH">Thailand</option>
                </select>
              </div>
              <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                  <label
                    for="first_name"
                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
                  >
                    First Name
                  </label>
                  <input
                    type="text"
                    id="first_name"
                    name="first_name"
                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                    required
                  />
                </div>

                <div>
                  <label
                    for="last_name"
                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
                  >
                    Last Name
                  </label>
                  <input
                    type="text"
                    id="last_name"
                    name="last_name"
                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                    required
                  />
                </div>
                <div>
                  <label
                    for="phone"
                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
                    >Phone</label
                  >
                  <input
                    type="tel"
                    id="phone"
                    name="phone"
                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                    required
                  />
                </div>

                <div>
                  <label
                    for="email"
                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
                  >
                    Email
                  </label>
                  <input
                    type="email"
                    id="email"
                    name="email"
                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                    required
                  />
                </div>
              </div>
              <div>
                <label
                  for="address"
                  class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
                >
                  Address</label
                >
                <input
                  type="text"
                  id="address"
                  name="address"
                  class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                  required
                />
              </div>
              <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                  <label
                    for="postal"
                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
                  >
                    Postal code
                  </label>
                  <input
                    type="text"
                    id="postal"
                    name="postal"
                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                    required
                  />
                </div>
                <div>
                  <label
                    for="city"
                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
                  >
                    City
                  </label>
                  <input
                    type="text"
                    id="city"
                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                    required
                  />
                </div>
              </div>
            </div>

            <div class="space-y-4">
              <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                Payment
              </h3>

              <div class="grid grid-cols-1 gap-4 md:grid-cols-1">
                <div
                  class="rounded-lg border border-gray-200 bg-gray-50 p-4 ps-4 dark:border-gray-700 dark:bg-gray-800"
                >
                  <div class="flex items-start">
                    <div class="flex h-5 items-center">
                      <input
                        id="credit-card"
                        aria-describedby="credit-card-text"
                        type="radio"
                        name="payment-method"
                        value=""
                        class="h-4 w-4 border-gray-300 bg-white text-primary-600 focus:ring-2 focus:ring-primary-600 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-primary-600"
                        checked
                      />
                    </div>

                    <div class="ms-4 text-sm">
                      <label
                        for="credit-card"
                        class="font-medium leading-none text-gray-900 dark:text-white"
                      >
                        Credit Card
                      </label>
                      <p
                        id="credit-card-text"
                        class="mt-1 text-xs font-normal text-gray-500 dark:text-gray-400"
                      >
                        Pay with your credit card
                      </p>
                    </div>
                  </div>

                  <div class="p-6 bg-gray-50">
                    <div class="space-y-4">
                      <div>
                        <label
                          for="card-number"
                          class="block text-sm font-medium text-gray-700"
                          >Card number</label
                        >
                        <input
                          type="text"
                          id="card-number"
                          name="card-number"
                          placeholder="Card number"
                          class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm"
                        />
                      </div>
                      <div class="flex space-x-4">
                        <div class="flex-1">
                          <label
                            for="expiration-date"
                            class="block text-sm font-medium text-gray-700"
                            >Expiration date (MM / YY)</label
                          >
                          <input
                            type="text"
                            id="expiration-date"
                            name="expiration-date"
                            placeholder="MM / YY"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm"
                          />
                        </div>
                        <div class="flex-1">
                          <label
                            for="security-code"
                            class="block text-sm font-medium text-gray-700"
                            >Security code</label
                          >
                          <input
                            type="text"
                            id="security-code"
                            name="security-code"
                            placeholder="CVC"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm"
                          />
                        </div>
                      </div>
                      <div>
                        <label
                          for="name-on-card"
                          class="block text-sm font-medium text-gray-700"
                          >Name on card</label
                        >
                        <input
                          type="text"
                          id="name-on-card"
                          name="name-on-card"
                          placeholder="Name on card"
                          class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm"
                        />
                      </div>
                    </div>

                    <div class="mt-6">
                      <div class="flex items-center">
                        <input
                          type="checkbox"
                          id="same-as-shipping"
                          name="same-as-shipping"
                          checked
                          class="h-4 w-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500"
                        />
                        <label
                          for="same-as-shipping"
                          class="ml-2 block text-sm text-gray-700"
                          >Use shipping address as billing address</label
                        >
                      </div>
                    </div>
                  </div>
                </div>

                <div
                  class="rounded-lg border border-gray-200 bg-gray-50 p-4 ps-4 dark:border-gray-700 dark:bg-gray-800"
                >
                  <div class="flex items-start">
                    <div class="flex h-5 items-center">
                      <input
                        id="pay-on-delivery"
                        aria-describedby="pay-on-delivery-text"
                        type="radio"
                        name="payment-method"
                        value=""
                        class="h-4 w-4 border-gray-300 bg-white text-primary-600 focus:ring-2 focus:ring-primary-600 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-primary-600"
                      />
                    </div>

                    <div class="ms-4 text-sm">
                      <label
                        for="pay-on-delivery"
                        class="font-medium leading-none text-gray-900 dark:text-white"
                      >
                        Cash on delivery
                      </label>
                      <p
                        id="pay-on-delivery-text"
                        class="mt-1 text-xs font-normal text-gray-500 dark:text-gray-400"
                      >
                        +$10 payment processing fee
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="space-y-4">
              <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                Delivery Methods
              </h3>

              <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                <div
                  class="rounded-lg border border-gray-200 bg-gray-50 p-4 ps-4 dark:border-gray-700 dark:bg-gray-800"
                >
                  <div class="flex items-start">
                    <div class="flex h-5 items-center">
                      <input
                        id="dhl"
                        aria-describedby="dhl-text"
                        type="radio"
                        name="delivery-method"
                        value=""
                        class="h-4 w-4 border-gray-300 bg-white text-primary-600 focus:ring-2 focus:ring-primary-600 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-primary-600"
                        checked
                      />
                    </div>

                    <div class="ms-4 text-sm">
                      <label
                        for="dhl"
                        class="font-medium leading-none text-gray-900 dark:text-white"
                      >
                        $15 - DHL Fast Delivery
                      </label>
                      <p
                        id="dhl-text"
                        class="mt-1 text-xs font-normal text-gray-500 dark:text-gray-400"
                      >
                        Get it by Tommorow
                      </p>
                    </div>
                  </div>
                </div>

                <div
                  class="rounded-lg border border-gray-200 bg-gray-50 p-4 ps-4 dark:border-gray-700 dark:bg-gray-800"
                >
                  <div class="flex items-start">
                    <div class="flex h-5 items-center">
                      <input
                        id="fedex"
                        aria-describedby="fedex-text"
                        type="radio"
                        name="delivery-method"
                        value=""
                        class="h-4 w-4 border-gray-300 bg-white text-primary-600 focus:ring-2 focus:ring-primary-600 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-primary-600"
                      />
                    </div>

                    <div class="ms-4 text-sm">
                      <label
                        for="fedex"
                        class="font-medium leading-none text-gray-900 dark:text-white"
                      >
                        Free Delivery - FedEx
                      </label>
                      <p
                        id="fedex-text"
                        class="mt-1 text-xs font-normal text-gray-500 dark:text-gray-400"
                      >
                        Get it withing 1-2 weeks
                      </p>
                    </div>
                  </div>
                </div>

                <div
                  class="rounded-lg border border-gray-200 bg-gray-50 p-4 ps-4 dark:border-gray-700 dark:bg-gray-800"
                >
                  <div class="flex items-start">
                    <div class="flex h-5 items-center">
                      <input
                        id="express"
                        aria-describedby="express-text"
                        type="radio"
                        name="delivery-method"
                        value=""
                        class="h-4 w-4 border-gray-300 bg-white text-primary-600 focus:ring-2 focus:ring-primary-600 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-primary-600"
                      />
                    </div>

                    <div class="ms-4 text-sm">
                      <label
                        for="express"
                        class="font-medium leading-none text-gray-900 dark:text-white"
                      >
                        $49 - Prime Delivery
                      </label>
                      <p
                        id="express-text"
                        class="mt-1 text-xs font-normal text-gray-500 dark:text-gray-400"
                      >
                        Get it today
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

                        <div
                          class="mt-6 w-full space-y-6 sm:mt-8 lg:mt-0 lg:max-w-xs xl:max-w-md"
                        >
                        <div class="max-w-lg mx-auto mt-8">
                  <div class="text-center text-gray-500 text-sm font-medium mb-4"></div>
                  <div class="flex flex-col space-y-4">
                    
                  </div>
                  <div class="flex items-center justify-center mt-6">
                  </div>
              </div>
              <div>
              <label
                for="voucher"
                class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
              >
                Enter a gift card, voucher or promotional code
              </label>
              <div class="flex max-w-md items-center gap-4">
                <input
                  type="text"
                  id="voucher"
                  class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                  placeholder=""
                />
                <button
                  type="button"
                  class="flex items-center justify-center rounded-lg bg-primary-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-primary-800 focus:outline-none focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800"
                >
                  Apply
                </button>
              </div>
            </div>
            <div class="flow-root">
              <div class="-my-3 divide-y divide-gray-200 dark:divide-gray-800">
                <dl class="flex items-center justify-between gap-4 py-3">
                  <dt
                    class="text-base font-normal text-gray-500 dark:text-gray-400"
                  >
                    Subtotal
                  </dt>
                  <dd
                    class="text-base font-medium text-gray-900 dark:text-white"
                  >
                    $<?php echo''.$subtotal.''?>
                  </dd>
                </dl>
                <dl class="flex items-center justify-between gap-4 py-3">
                  <dt
                    class="text-base font-normal text-gray-500 dark:text-gray-400"
                  >
                    Coupon
                  </dt>
                  <dd
                    class="text-base font-medium text-gray-900 dark:text-white"
                  >
                    - 0$
                  </dd>
                </dl>

                <dl class="flex items-center justify-between gap-4 py-3">
                  <dt class="text-base font-bold text-gray-900 dark:text-white">
                    Total
                  </dt>
                  <dd class="text-base font-bold text-gray-900 dark:text-white">
                    $<?php echo''.$subtotal.''?>
                  </dd>
                </dl>
              </div>
            </div>

            <div class="space-y-3">
              <button
                type="submit"
                class="flex w-full items-center justify-center rounded-lg bg-primary-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-primary-800 focus:outline-none focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800"
              >
                Proceed to Payment
              </button>
            </div>
          </div>
        </div>
      </form>
    </section>
    <?php include './includes/footer.php'; ?>
    <?php include './includes/cart.php'; ?>
    <script src="../assets/js/main.js"></script>
  </body>
</html>

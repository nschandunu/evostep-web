<?php 
session_start();

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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $sql = "SELECT admin_id, username, admin_password FROM admin WHERE username = ?";
    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "s", $email); 
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        mysqli_stmt_bind_result($stmt, $admin_id, $username, $stored_password);
        mysqli_stmt_fetch($stmt);

        if ($password === $stored_password) {
            $_SESSION['admin_id'] = $admin_id;
            $_SESSION['username'] = $username;
            
            header("Location: index.php");
            exit();
        } else {
            $error = 'Invalid credentials';
        }
    } else {
        $error = 'Invalid credentials';
    }

    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <link href="../../assets/css/style.css" rel="stylesheet" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>EvoSteps | Login</title>
</head>
<body>
  <section class="bg-background">
    <div class="lg:grid lg:min-h-screen lg:grid-cols-12">
      <section class="relative flex h-32 items-end bg-gray-900 lg:col-span-5 lg:h-full xl:col-span-6">
      <div class="absolute inset-0 h-full w-full opacity-1">
        <img src="/../assets/images/login_d.png" alt="Background Image" class="h-full w-full object-cover" />
      </div>
        <a class="absolute top-0 left-0 p-12 hidden lg:block" href="#">
          <span class="sr-only">EvoSteps Login Page</span>
          <img src="../../assets/images/logo-white.png" alt="Logo" class="h-7" />
        </a>
        <div class="hidden lg:relative lg:block lg:p-12">
          <h4 class="font-poppins mt-6 text-2xl font-bold text-black sm:text-3xl md:text-4xl text-ce">
            <div class="flex items-center justify-center">
              <div class="flex-grow border-t border-gray-300"></div>
              <span class="px-4">
                <!-- <img src="/../assets/images/shadow.png" alt="Shadow Divider" class="w-12 h-auto">  -->
              </span>
              <div class="flex-grow border-t border-gray-300"></div>
            </div>
          </h4>
            <p class="font-nunito mt-4 leading-relaxed text-black">
          <!-- Welcome to the EvoStep Admin Dashboard. Please log in to efficiently manage store, track orders, and update inventory. -->
          </p>
        </div>
      </section>
      
      <main class="flex items-center justify-center px-8 py-8 sm:px-12 lg:col-span-7 lg:px-16 lg:py-12 xl:col-span-6">
        <div class="bg-background max-w-xl lg:max-w-3xl">
          <div class="bg-background pt-4 flex items-center justify-center h-full">
            <div class="bg-background relative flex flex-col sm:w-[30rem] rounded-lg border-gray-400 shadow-lg">
              <div class="bg-background flex-auto p-6">
                <h4 class="bg-background mb-2 font-bold text-whitetext xl:text-xl font-poppins">Sign in to EvoSteps</h4>
                <p class="bg-background mb-6 text-whitetext font-nunito">Welcome back! Please sign in to continue</p>

                <?php if (!empty($error)) { ?>
                  <div style="color: red; font-weight: bold;"><?php echo $error; ?></div>
                <?php } ?>

                <form id="login-form" class="mb-4" action="login.php" method="POST">
                  <div class="mb-4">
                    <label for="email" class="mb-2 inline-block text-xs font-medium uppercase text-whitetext font-nunito">Email or Username</label>
                    <input type="text" name="email" class="bg-background block w-full cursor-text appearance-none rounded-md border border-gray-400 bg--100 py-2 px-3 text-sm outline-none focus:border-indigo-500 focus:bg-white focus:text-gray-600 focus:shadow" id="email" placeholder="Enter your email or username" autofocus="" />
                  </div>
                  <div class="mb-4">
                    <div class="flex justify-between">
                      <label class="mb-2 inline-block text-xs font-medium uppercase text-whitetext font-nunito" for="password">Password</label>
                      <a href="auth-forgot-password-basic.html" class="cursor-pointer text-indigo-500 no-underline hover:text-indigo-500">
                        <small class="font-nunito text-graytext">Forgot Password?</small>
                      </a>
                    </div>
                    <div class="relative flex w-full flex-wrap items-stretch">
                      <input type="password" name="password" id="password" class="bg-background relative block flex-auto cursor-text appearance-none rounded-md border border-gray-400 bg--100 py-2 px-3 text-sm outline-none focus:border-blue-600 focus:bg-background  focus:text-gray-600 focus:shadow" placeholder="············" />
                    </div>
                  </div>
                  <div class="mb-4">
                    <div class="block">
                      <input class="mt-1 mr-2 h-5 w-5 appearance-none rounded border border-gray-300 bg-contain bg-no-repeat align-top text-black shadow checked:bg-blue-500 focus:border-blue-500 focus:shadow" type="checkbox" id="remember-me" checked />
                      <label class="inline-block text-whitetext" for="remember-me"> Remember Me </label>
                    </div>
                  </div>
                  <div class="mb-4">
                    <button class="grid w-full cursor-pointer select-none rounded-md bg-black py-2 px-5 text-center align-middle text-sm text-white shadow hover:border border-black hover:bg-white hover:text-black focus:border-black focus:bg-white focus:text-black transition-colors duration-300 ease-in-out group-hover:text-white focus:shadow-none" type="submit">Sign in</button>
                  </div>
                </form>
                  <!-- Sign with Apple button -->
                  <div class="mt-4">
                    <button id="apple-signin-btn" class="w-full py-2 px-5 rounded-md border border-gray-300 flex items-center justify-center bg-black text-white font-nunito text-sm shadow-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                      <span class="flex items-center justify-center transform transition-transform duration-300 hover:scale-105">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/3/31/Apple_logo_white.svg" alt="Apple Logo" class="w-4 h-5 mr-2 ">
                        Sign in with Apple
                      </span>
                    </button>
                  </div>

                    <!-- Popup -->
                    <div id="apple-signin-popup" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden">
                    <div class="bg-white p-6 rounded-md w-96">
                      <h2 class="text-lg font-semibold mb-4">Sign in with Apple ID</h2>
                      <p>Please sign in with your Apple Account to proceed.</p>
                      <div class="mt-4">
                      <!-- Add your sign-in options here, e.g., Apple login button -->
                      <a href="https://www.icloud.com" class="block">
                      <button class="w-full py-2 px-5 rounded-md bg-black text-white flex items-center justify-center">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/3/31/Apple_logo_white.svg" alt="Apple Logo" class="w-4 h-5 mr-2">
                        Sign in with Apple
                      </button>
                      </a>
                      </div>
                      <button id="close-popup" class="mt-4 text-blue-500">Close</button>
                    </div>
                    </div>

                  <script>
                    const signinButton = document.getElementById("apple-signin-btn");
                    const popup = document.getElementById("apple-signin-popup");
                    const closePopupButton = document.getElementById("close-popup");

                    signinButton.addEventListener("click", () => {
                      popup.classList.remove("hidden");
                    });

                    closePopupButton.addEventListener("click", () => {
                      popup.classList.add("hidden");
                    });
                  </script>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
  </section>
  <script src="../../assets/js/login.js"></script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - EvoSteps</title>
    <link rel="stylesheet" href="../assets/css/nav_cart.css" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
<?php include './includes/navbar.php'; ?>

    <!-- Header Section -->
    <div class="relative w-full h-[28rem] bg-cover bg-center mb-8"
        style="background-image: url('../assets/images/contus.jpg');">
        <div class="absolute inset-0 bg-black opacity-50"></div>
        <div class="relative flex items-center justify-center h-full text-white">
            <div class="text-center px-4">
                <h1 class="text-4xl font-semibold mb-2">Contact Us</h1>
                <p class="text-lg">We’d love to hear from you! Whether you have questions about our products, 
                    need assistance with an order, or want to <br> share your EvoSteps experience, 
                    we’re here to assist.</p>
            </div>
        </div>
    </div>

    <div class="container mx-auto p-8">
        <!-- Contact Section -->
        <div>
            <div class="mb-12">
                <h2 class="text-3xl font-semibold mb-2">Got a Question?</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Column 1 -->
                <div>
                    <div class="mb-8">
                        <h3 class="font-bold text-xl">Customer Support</h3>
                        <p>contact@evostep.com</p>
                    </div>
                    <div class="mb-8">
                        <h3 class="font-bold text-xl">Phone</h3>
                        <p>011 222 2222</p>
                        <p>011 888 8888</p>
                    </div>
                    <div class="mb-8">
                        <h3 class="font-bold text-xl">Order Inquiries</h3>
                        <p>orders@evostep.com</p>
                    </div>
                    <div>
                        <h3 class="font-bold text text-xl">Press Inquiries</h3>
                        <p>press@evostep.com</p>
                    </div>
                </div>
                <!-- Column 2 -->
                <div>
                    <div class="mb-8">
                        <h3 class="font-bold text-xl">Socials</h3>
                        <div class="flex items-center mb-2">
                            <img src="../assets/images/icons8-x-logo-50.png" alt="" class="w-6 h-6 mr-2">
                            <p>@EvoSteps</p>
                        </div>
                        <div class="flex items-center">
                            <img src="../assets/images/con03.png" alt="" class="w-6 h-6 mr-2">
                            <p>@EvoSteps</p>
                        </div>
                    </div>
                    <div class="mb-8">
                        <h3 class="font-bold text-xl">Wholesale Inquiries</h3>
                        <p>support@evostep.com</p>
                    </div>
                    <div>
                        <h3 class="font-bold text-xl">Marketing Inquiries</h3>
                        <p>marketing@evostep.com</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br><br>
    <div class="bg-[#b4e0f5] py-10 px-8 md:px-16 flex flex-col md:flex-row items-center">
        <div class="text-black font-bold text-xl md:text-2xl mb-8 md:mb-0 md:ml-12 text-left">
            We're always happy to hear from you!
            <div class="text-black text-sm md:text-lg font-normal mt-4">
                Please note:<br>
                <ul class="list-disc ml-8 text-[0.8rem] md:text-[1rem]">
                    <li>Our customer service team is available Monday-Friday, 9am-5pm<br>(UTC+05:30,
                        Colombo).
                    </li>
                    <li>Live Chat inquiries will be responded to within 24 hours.</li>
                    <li>For urgent inquiries, please contact us via phone.</li>
                </ul>
            </div>
            <p class="text-black font-bold text-xl md:text-2xl mt-4">Thank you for choosing Evo Steps!</p>
        </div>
        <div class="md:ml-64 mb-4 md:mb-0 order-first md:order-last">
            <img src="../assets/images/cus_sup.gif" alt="Illustration" class="w-full md:w-96 h-auto">
        </div>
    </div>
    <?php include './includes/footer.php'; ?>
    <?php include './includes/cart.php'; ?>
    <script src="../assets/js/main.js"></script>
    </body>

</html>

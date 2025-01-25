<!DOCTYPE html>
<html>

<head>
    <meta charSet="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Evo Sale</title>
    <link rel="stylesheet" href="../assets/css/nav_cart.css" />
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
</head>

<body>

    <?php include './includes/navbar.php'; ?>

    <div class="flex flex-col items-center bg-white-100 p-6 sm:pb-8 min-h-screen">
        <div class="relative isolate px-6 lg:px-8 mb-24">
            <div class="flex items-center justify-center h-screen pb-20 bg-white-100">
                <section class="text-center px-6 pt-14 lg:px-4">
                    <h1 class="text-6xl font-bold text-gray-800">
                        Get Ready for the <span class="text-red-500">Big Step!</span>
                    </h1>
                    <p class="mt-4 text-gray-700 text-xl">
                        Exciting ‘Winter’ Sale at Evo Step – stay tuned for <br> exclusive offers and fresh footwear styles!
                    </p>
                    <a href="#" class="mt-4 inline-block bg-black text-white py-2 px-4 rounded">
                        Coming Soon
                    </a>
                </section>
            </div>            
        </div>
    </div>


    <?php include './includes/footer.php'; ?>
    <?php include './includes/cart.php'; ?>
    <script src="../assets/js/main.js"></script>
    
</body>

</html>

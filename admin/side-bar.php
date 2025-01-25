<script src="https://cdn.tailwindcss.com"></script>
<div class="flex h-screen bg-gray-200">
    <div class="w-64 bg-gray-900 text-white flex flex-col fixed h-full lg:block hidden">
        <div class="h-16 flex items-center justify-center">
            <img src="../../assets/images/icon.png" class="h-[2.5rem] mt-4">
        </div>
        <div class="flex-1 flex flex-col">
            <nav class="overflow-y-auto">
                <ul class="space-y-4">
                    <li class="p-4 hover:bg-gray-600 cursor-pointer menu-item" data-url="dashboard.php">
                        <div class="flex items-center space-x-2">
                            <img src="../../assets/images/img002.png" class="h-[1.5rem]" alt="Dashboard Icon">
                            <span>Dashboard</span>
                        </div>
                    </li>
                    <li class="p-4 hover:bg-gray-600 cursor-pointer menu-item" data-url="orders.php">
                        <div class="flex items-center space-x-2">
                            <img src="../../assets/images/img004.png" class="h-[1.5rem]" alt="order Icon">
                            <span>Orders</span>
                        </div>
                    </li>
                    <li class="p-4 hover:bg-gray-600 cursor-pointer menu-item" data-url="stock.php">
                        <div class="flex items-center space-x-2">
                            <img src="../../assets/images/img007.png" class="h-[1.5rem]" alt="stock Icon">
                            <span>Stocks</span>
                        </div>
                    </li>
                    <li class="p-4 hover:bg-gray-600 cursor-pointer menu-item" data-url="products.php">
                        <div class="flex items-center space-x-2">
                            <img src="../../assets/images/img006.png" class="h-[1.5rem]" alt="products Icon">
                            <span>Products</span>
                        </div>
                    </li>
                    <li class="p-4 hover:bg-gray-600 cursor-pointer menu-item" data-url="category.php">
                        <div class="flex items-center space-x-2">
                            <img src="../../assets/images/img008.png" class="h-[1.5rem]" alt="category Icon">
                            <span>Category</span>
                        </div>
                    </li>
                </ul>
            </nav>
        </div>
    </div>

    <!-- Mobile menu button -->
    <div class="lg:hidden w-full bg-gray-900 text-white fixed top-0 z-20">
        <div class="flex items-center justify-between p-4">
            <img src="../../assets/images/icon.png" class="h-[2.5rem]">
            <button id="menu-btn" class="text-white">
                <img src="../../assets/images/img009.png" alt="Icon" class="h-6 w-6" />
            </button>
        </div>
        <nav id="mobile-menu" class="hidden flex-col bg-gray-800">
            <ul class="space-y-2 p-4">
                <li><a href="dashboard.php" class="block p-2 bg-gray-700 rounded">Dashboard</a></li>
                <li><a href="orders.php" class="block p-2 bg-gray-700 rounded">Orders</a></li>
                <li><a href="stock.php" class="block p-2 bg-gray-700 rounded">Stock</a></li>
                <li><a href="products.php" class="block p-2 bg-gray-700 rounded">Products</a></li>
                <li><a href="category.php" class="block p-2 bg-gray-700 rounded">Category</a></li>
            </ul>
        </nav>
    </div>

    <script>
        document.getElementById('menu-btn').addEventListener('click', function () {
            var menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });

        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.menu-item').forEach(function (item) {
                item.addEventListener('click', function () {
                    const url = this.getAttribute('data-url');
                    if (url) {
                        window.location.href = url;
                    }
                });
            });
        });
    </script>

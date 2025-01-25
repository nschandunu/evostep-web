<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ Page</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .accordion-content {
            display: none;
        }
        .accordion-header.active .accordion-content {
            display: block;
        }
        .accordion-header .arrow {
            transition: transform 0.3s ease;
        }
        .accordion-header.active .arrow {
            transform: rotate(90deg);
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-6 bg-white shadow-md">
        <div class="flex">
            <div class="w-1/4 p-4 border-r border-gray-200">
                <h2 class="text-lg font-semibold mb-4">Categories</h2>
                <ul class="space-y-2">
                    <li><a href="delivery.html" class="text-gray-700 hover:text-blue-500">Delivery and order tracking</a></li>
                    <li><a href="returns.html" class="text-gray-700 hover:text-blue-500">Returns, exchanges and refunds</a></li>
                    <li><a href="payment.html" class="text-gray-700 hover:text-blue-500">Payments and promotions</a></li>
                    <li><a href="informations.html" class="text-gray-700 hover:text-blue-500">Information on sizes and products</a></li>
                    <li><a href="personals.html" class="text-gray-700 hover:text-blue-500">Personal data and notifications</a></li>
                </ul>
            </div>
            <div class="w-3/4 p-4">
                <!--<h1 class="text-2xl font-bold mb-4">Where is my order?</h1>
                <p class="text-gray-700 mb-6">Check the details of your in-store and online purchases, and know their status at any moment in My purchases. If you already have an account, log in with your e-mail address and password. If you purchased as a guest, enter your e-mail address and the order number you wish to consult. In this case, be sure to log in from My purchases &gt; I am not registered.</p>-->
                <h3 class="text-xl font-semibold mb-4">Information on sizes and products</h3>
                <div class="accordion-item border-b border-gray-200">
                    <div class="accordion-header flex justify-between items-center cursor-pointer p-4" onclick="toggleAccordion(this)">
                        <span>Do you have a size chart?</span>
                        <svg class="arrow w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                    <div class="accordion-content p-4">
                        <p>Yes, we provide a size chart for each product category to help you find the best fit. You can find it on the product page or in the Size Guide section.</p>
                    </div>
                </div>
                <div class="accordion-item border-b border-gray-200">
                    <div class="accordion-header flex justify-between items-center cursor-pointer p-4" onclick="toggleAccordion(this)">
                        <span>How do I measure myself for the best fit?</span>
                        <svg class="arrow w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                    <div class="accordion-content p-4">
                        <p>Yes, we provide a size chart for each product category to help you find the best fit. You can find it on the product page or in the Size Guide section.</p>
                    </div>
                </div>
                <div class="accordion-item border-b border-gray-200">
                    <div class="accordion-header flex justify-between items-center cursor-pointer p-4" onclick="toggleAccordion(this)">
                        <span>What should I do if I'm in between sizes?</span>
                        <svg class="arrow w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                    <div class="accordion-content p-4">
                        <p>If you’re between sizes, we recommend sizing up or down based on the fit description provided on the product page. You can also refer to customer reviews for additional guidance.</p>
                    </div>
                </div>
                <div class="accordion-item border-b border-gray-200">
                    <div class="accordion-header flex justify-between items-center cursor-pointer p-4" onclick="toggleAccordion(this)">
                        <span>What matiriels are you products made from?</span>
                        <svg class="arrow w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                    <div class="accordion-content p-4">
                        <p>Our products are made from high-quality materials such as cotton, polyester, nylon, and blends, as specified on each product page.</p>
                    </div>
                </div>
                <div class="accordion-item border-b border-gray-200">
                    <div class="accordion-header flex justify-between items-center cursor-pointer p-4" onclick="toggleAccordion(this)">
                        <span>Where are your products manufactured?</span>
                        <svg class="arrow w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                    <div class="accordion-content p-4">
                        <p>Our products are proudly manufactured in several locations to ensure the highest quality and ethical standards.
                            United States Some of our premium collections are produced in state-of-the-art facilities across the country.We partner with skilled artisans in Italy and Portugal for our luxury lines.Our everyday wear is made in factories in China and Bangladesh, where we maintain strict oversight to ensure fair labor practices and high-quality production standards
                            </p>
                    </div>
                </div>
                <div class="accordion-item border-b border-gray-200">
                    <div class="accordion-header flex justify-between items-center cursor-pointer p-4" onclick="toggleAccordion(this)">
                        <span>How do I know if a product is in sock?</span>
                        <svg class="arrow w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                    <div class="accordion-content p-4">
                        <p>Each product page clearly indicates the availability status near the size selection, showing whether the item is in stock or out of stock. If a product is currently out of stock, you have the option to sign up for notifications and be alerted as soon as it’s back in stock.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function toggleAccordion(element) {
            element.classList.toggle('active');
            const content = element.nextElementSibling;
            if (element.classList.contains('active')) {
                content.style.display = 'block';
            } else {
                content.style.display = 'none';
            }
        }
    </script>
</body>
</html>
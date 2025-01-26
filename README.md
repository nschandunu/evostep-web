# EvoStep - E-Commerce
A PHP-based e-commerce website for a shoe brand, developed as part of a university assignment, featuring CRUD operations, user and admin authentication, and a responsive UI built with Tailwind CSS.

## Table of Contents

- [Features](#features)
- [Folder Structure](#folder-structure)
- [Installation](#installation)
- [Usage](#usage)
- [License](#license)

## Features

- **User Authentication**: Secure user registration and login system.
- **Product Listings**: Display available shoes with descriptions, images, and categories.
- **Shopping Cart**: Add items to the cart and proceed to checkout.
- **Admin Panel**: Manage products, categories, and orders (CRUD operations).
- **Responsive Design**: Optimized for mobile and desktop screens using Tailwind CSS.
- **Checkout Process**: Smooth and secure payment integration (future).
- **Blog Section**: Informative blog posts (optional).

## Folder Structure

```bash
.
├── admin/
│   ├── category.php              # Category management page
│   ├── header.php                # Admin header
│   ├── index.php                 # Admin dashboard
│   ├── login.php                 # Admin login
│   ├── logout.php                # Admin logout
│   ├── orders.php                # Order management
│   ├── products.php              # Product management
│   ├── side-bar.php              # Admin sidebar
│   ├── stock.php                 # Stock management
├── assets/
│   ├── css/                      # Styling files
│   │   ├── nav_cart.css          # CSS for navigation and cart
│   │   └── style.css             # General styles
│   ├── images/                   # Image assets
│   │   ├── example.png           # Example image
│   ├── product-images/           # Product image assets
│   │   └── product_img.jpg       # Product images
│   └── js/                       # JavaScript files
│       ├── login.js              # Login script
│       └── main.js               # General scripts
├── config/
│   └── config.php                # Database configuration
├── database/
│   ├── evostepdb.sql             # Database dump
├── public/
│   ├── blog/                     # Blog section
│   ├── faq/                      # Frequently asked questions
│   ├── includes/                 # Reusable components
│   │   ├── cart.php              # Cart component
│   │   ├── cartpopup.php         # Cart popup component
│   │   ├── cookies.php           # Cookies management
│   │   ├── footer.php            # Footer component
│   │   ├── navbar.php            # Navbar component
│   │   └── themecontroller.php   # Theme control script
│   ├── checkout.php              # Checkout process page
│   ├── contactus.php             # Contact page
│   ├── product_description.php   # Product details page
│   ├── shop.php                  # Shop page
│   └── sale.php                  # Sale page
├── src/
│   ├── controllers/              # Controllers for handling requests
│   ├── db/                       # Database interaction files
│   └── models/                   # Data models for the application
│   │   └── input.css             # Tailwind CSS input
├── .DS_Store                     # macOS system file
├── .env                          # Environment variables
├── .gitignore                    # Git ignore rules
├── .htaccess                     # Apache server configuration
├── 404.php                       # Error page
├── README.md                     # Project documentation
├── index.php                     # Main entry point
├── LICENSE                       # License information
├── package.json                  # Node.js dependencies (if any)
└── tailwind.config.js            # Tailwind CSS configuration
```

## Installation

### Clone the repository:
```bash
git clone https://github.com/nschandunu/evostep-web.git
cd evostep-web
```
### Install Dependencies (Optional):
If you’re using Node.js for development:
```bash
npm install
```
### Database Setup:
Create a MySQL database and import the evostepdb.sql file located in the `/database/` directory.

### Tailwind CSS:
If you’re making changes to the front-end styles, run Tailwind’s build process:
```bash
npx tailwindcss -i ./src/input.css -o ./assets/css/style.css --watch
```
## Usage 
- User can explore product catalogue and add to cart and then checkout
- **Live Website**: [Visit the website here](https://www.evostep.store).  
- Admins can log in to manage products, including creating, updating, and deleting products. (CRUD)
- **Admin Panel**: [Visit the admin panel](https://www.evostep.store/admin/).
- Admin Panel Credetials : admin@email | Admin@123


## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
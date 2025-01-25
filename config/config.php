<?php
// Database credentials
$DB_HOST = $_ENV['DB_HOST'] ?? 'localhost';
$DB_USER = $_ENV['DB_USER'] ?? 'root';
$DB_PASSWORD = $_ENV['DB_PASSWORD'] ?? 'root';
$DB_NAME = $_ENV['DB_NAME'] ?? 'evostepdb';
$DB_PORT = $_ENV['DB_PORT'] ?? 8889;

// Attempt to connect to the database
$conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME, $DB_PORT);

// Check if the connection was successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


?>
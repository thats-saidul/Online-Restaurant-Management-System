<?php
// config/db.php

// Database configuration
$host = "localhost";       // Usually 'localhost'
$db_name = "restaurant";   // Your database name
$username = "root";        // MySQL username
$password = "";            // MySQL password

// Create connection
$conn = new mysqli($host, $username, $password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Set charset to handle special characters
$conn->set_charset("utf8mb4");

// Now $conn can be used in your controllers for queries
// Example: $result = $conn->query("SELECT * FROM admins");
?>

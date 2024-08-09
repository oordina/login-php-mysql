<?php
// Database connection parameters
$db_host = 'yourwebsite.ca'; // Change to your database host
$db_name = 'loginname';      // Your database name
$db_user = 'root';           // Your database username
$db_pass = 'password';       // Your database password

// Establish a database connection
try {
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    // Check the connection
    if ($conn->connect_errno) {
        throw new Exception("Failed to connect to MySQL: " . $conn->connect_error);
    }

    // Set the character set to UTF-8
    if (!$conn->set_charset("utf8mb4")) {
        throw new Exception("Error setting character set: " . $conn->error);
    }
} catch (Exception $e) {
    // Log the error and display a user-friendly message
    error_log("Database connection error: " . $e->getMessage());
    die("Sorry, there was a problem connecting to the database. Please try again later.");
}
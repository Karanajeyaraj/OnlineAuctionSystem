<?php
$servername = "localhost";
$username = "root";  // Default username for XAMPP
$password = "";      // Default password is empty in XAMPP
$database = "bidding"; // Your database name

// Create connection
$connection = new mysqli($servername, $username, $password, $database);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}
?>

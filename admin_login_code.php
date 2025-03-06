<?php
session_start(); // Start session for admin login
include 'database.php'; // Ensure this contains the correct connection settings

// Establish a database connection
$conn = mysqli_connect("localhost", "root", "", "bidding");

// Check if the connection is successful
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Get form inputs safely
$admin = isset($_POST['name']) ? mysqli_real_escape_string($conn, $_POST['name']) : '';
$password = isset($_POST['pwd']) ? mysqli_real_escape_string($conn, $_POST['pwd']) : '';

// Query to check admin credentials
$query = "SELECT * FROM `admin` WHERE admin='$admin' AND pwd='$password'";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $_SESSION['admin'] = $admin; // Store admin session
    header("Location: admin_profile.php"); // Redirect to admin dashboard
    exit();
} else {
    echo "Invalid username or password.";
}

// Close the database connection
mysqli_close($conn);
?>

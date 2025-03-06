<?php 
ob_start();
include 'database.php'; // Ensure database.php uses mysqli

// Retrieve form data
$productd_name = $_POST['p_name'];
$category = $_POST['catry'];
$price = $_POST['price'];
$photo = $_FILES["file"]["name"];
$despt = $_POST['desp'];

// Check for file upload errors
if ($_FILES["file"]["error"] > 0) {
    echo "Error: " . $_FILES["file"]["error"] . "<br />";
} else {
    if (file_exists("upload/" . $_FILES["file"]["name"])) {
        echo $_FILES["file"]["name"] . " already exists.";
    } else {
        move_uploaded_file($_FILES["file"]["tmp_name"], "upload/" . $_FILES["file"]["name"]);
    }
}

// Establish database connection
$connection = mysqli_connect("localhost", "root", "", "bidding");

// Check connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Insert product details into the database
$query = "INSERT INTO add_products (id, name, category, price, photo, description) 
          VALUES (NULL, ?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($connection, $query);
mysqli_stmt_bind_param($stmt, "ssdss", $productd_name, $category, $price, $photo, $despt);

if (mysqli_stmt_execute($stmt)) {
    header("Location: add_product.php");
} else {
    echo "Error: " . mysqli_error($connection);
}

// Close the statement and connection
mysqli_stmt_close($stmt);
mysqli_close($connection);
?>

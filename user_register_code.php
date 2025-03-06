<?php
ob_start();
session_start();
include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = mysqli_connect("localhost", "root", "", "bidding");

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Collect form data
    $f_name = isset($_POST['f_name']) ? $_POST['f_name'] : '';
    $l_name = isset($_POST['l_name']) ? $_POST['l_name'] : '';
    $mail = isset($_POST['mail']) ? $_POST['mail'] : '';
    $pwd = isset($_POST['pwd']) ? $_POST['pwd'] : '';
    $dob = isset($_POST['dob']) ? $_POST['dob'] : '';
    $gen = isset($_POST['gen']) ? $_POST['gen'] : '';
    $add = isset($_POST['add']) ? $_POST['add'] : '';
    $ph = isset($_POST['ph']) ? $_POST['ph'] : '';

    if (!empty($f_name) && !empty($l_name) && !empty($mail) && !empty($pwd) && !empty($dob) && !empty($gen) && !empty($add) && !empty($ph)) {
        // Check actual column names in database
        $stmt = $conn->prepare("INSERT INTO `user_registration` (f_name, l_name, email, pass, dob, gender, address, phone) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssss", $f_name, $l_name, $mail, $pwd, $dob, $gen, $add, $ph);

        if ($stmt->execute()) {
            echo "Registration successful!";
            header("Location: user_login.php"); // Redirect to login page
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "All fields are required!";
    }

    $conn->close();
} else {
    echo "Invalid request!";
}
?>

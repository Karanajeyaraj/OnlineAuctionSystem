<?php
ob_start();
session_start();
include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $admin = isset($_POST['name']) ? $_POST['name'] : '';
    $password = isset($_POST['pass']) ? $_POST['pass'] : '';

    if (!empty($admin) && !empty($password)) {
        $conn = mysqli_connect("localhost", "root", "", "bidding");

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Use prepared statements to prevent SQL injection
        $stmt = $conn->prepare("SELECT * FROM `user_registration` WHERE email = ? AND pass = ?");
        $stmt->bind_param("ss", $admin, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $_SESSION['name'] = $admin;
            header("Location: user_profile.php");
            exit();
        } else {
            echo "Invalid user ID or password";
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "Please enter both email and password";
    }
} else {
    echo "Invalid request";
}
?>

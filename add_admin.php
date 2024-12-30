<?php
include 'config/db_connect.php';

// Define the admin credentials
$username = 'admin'; // Change this to your desired username
$password = 'admin123'; // Change this to your desired password

// Hash the password
$password_hash = password_hash($password, PASSWORD_DEFAULT);

// Insert the admin user into the database
$sql = "INSERT INTO admin_users (username, password_hash) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $username, $password_hash);

if ($stmt->execute()) {
    echo "Admin user added successfully!<br>";
    echo "Username: $username<br>";
    echo "Password: $password<br>";
} else {
    echo "Error adding admin: " . $conn->error;
}
?>

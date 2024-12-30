<?php
// Include database connection
include 'config/db_connect.php';

// Set timezone to Indian/Kolkata
date_default_timezone_set('Asia/Kolkata');

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form inputs
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $category = $_POST['category'];
    $address = $_POST['address'];
    $description = $_POST['description'];

    // Get the current date and time in the specified timezone
    $submitted_at = date('Y-m-d H:i:s');

    // Insert the data into the database
    $sql = "INSERT INTO callback_requests (name, phone, category, address, description, submitted_at) 
            VALUES ('$name', '$phone', '$category', '$address', '$description', '$submitted_at')";

    if ($conn->query($sql) === TRUE) {
        // Redirect to index.html with a success flag
        header("Location: index.html?success=1");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

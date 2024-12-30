<?php
include 'config/db_connect.php';

// Retrieve the record ID from the POST request
$id = $_POST['id'] ?? null;

if ($id) {
    // Step 1: Fetch the record from the 'callback_requests' table, excluding unwanted columns
    $sql = "SELECT name, phone, category, address, description, submitted_at FROM callback_requests WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Step 2: Insert the fetched record into the 'completed_requests' table
        $current_date = date('Y-m-d');
        $current_time = date('H:i:s');

        // Combine the current date and time for completed_at
        $completed_at = $current_date . ' ' . $current_time;

        $insert_sql = "INSERT INTO completed_requests (name, phone, category, description, address, submitted_at, completed_at)
                       VALUES (?, ?, ?, ?, ?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bind_param(
            "sssssss",
            $row['name'],
            $row['phone'],
            $row['category'],
            $row['description'],
            $row['address'],
            $row['submitted_at'], // Using submitted_at from the fetched record
            $completed_at // Pass the concatenated completed_at
        );

        if ($insert_stmt->execute()) {
            // Step 3: Delete the record from the 'callback_requests' table
            $delete_sql = "DELETE FROM callback_requests WHERE id = ?";
            $delete_stmt = $conn->prepare($delete_sql);
            $delete_stmt->bind_param("i", $id);

            if ($delete_stmt->execute()) {
                echo "Record successfully marked as completed.";
            } else {
                echo "Error deleting the record: " . $conn->error;
            }
        } else {
            echo "Error inserting into completed table: " . $conn->error;
        }
    } else {
        echo "Record not found.";
    }
} else {
    echo "Invalid request.";
}
?>

<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}
include 'config/db_connect.php';

$result = $conn->query("SELECT * FROM completed_requests ORDER BY completed_at DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Completed Records</title>
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        /* Body */
        body {
            background-color: #fff; /* White background */
            color: #333; /* Dark text */
            padding: 20px;
        }

        /* Header */
        h2 {
            text-align: center;
            color: #ff5722; /* Red */
            font-size: 2rem;
            margin-bottom: 20px;
        }

        /* Table */
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            background-color: #fff; /* White */
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd; /* Light gray border */
        }

        th {
            background-color: #ff5722; /* Red */
            color: white;
            font-size: 1rem;
        }

        td {
            font-size: 1rem;
        }

        /* Table Row Hover */
        tr:hover {
            background-color: #f5f5f5; /* Light gray */
        }

        /* Action Button */
        a button {
            padding: 10px 20px;
            background-color: #ff9800; /* Orange */
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
            text-align: center;
            display: block;
            margin: 30px auto 0;
        }

        a button:hover {
            background-color: #fb8c00; /* Darker orange */
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            table {
                width: 100%;
            }

            th, td {
                padding: 10px;
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <h2>Completed Records</h2>
    <table>
        <tr>
            <th>Name</th>
            <th>Phone</th>
            <th>Category</th>
            <th>Address</th>
            <th>Description</th>
            <th>Submitted At</th>
            <th>Completed At</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['name'] ?></td>
                <td><?= $row['phone'] ?></td>
                <td><?= $row['category'] ?></td>
                <td><?= $row['address'] ?></td>
                <td><?= $row['description'] ?></td>
                <td><?= $row['submitted_at'] ?></td>
                <td><?= $row['completed_at'] ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>

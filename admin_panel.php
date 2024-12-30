<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}
include 'config/db_connect.php';

$filter_date = $_GET['date'] ?? '';
$filter_category = $_GET['category'] ?? '';

// Fetch records with optional filters
$sql = "SELECT * FROM callback_requests WHERE status = 'Pending'";
if ($filter_date) {
    $sql .= " AND DATE(submitted_at) = '$filter_date'";
}
if ($filter_category) {
    $sql .= " AND category = '$filter_category'";
}
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
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

        h2 {
            text-align: center;
            color: #ff5722; /* Red */
            margin-bottom: 20px;
            font-size: 1.8rem;
        }

        /* Form Styles */
        form {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: center;
            margin-bottom: 20px;
        }

        input[type="date"], select {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
            width: calc(50% - 10px); /* Ensure responsiveness */
        }

        button[type="submit"] {
            background-color: #ff5722; /* Red */
            color: white;
            border: none;
            border-radius: 4px;
            padding: 10px;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #e64a19; /* Darker red */
        }

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
            font-size: 0.9rem;
        }

        th {
            background-color: #f5f5f5;
        }

        /* Actions Column */
        td form {
            display: flex;
            gap: 5px;
        }

        td button {
            padding: 5px 10px;
            font-size: 0.8rem;
        }

        /* Completed Button */
        a button {
            background-color: #4caf50; /* Green */
            color: white;
            border: none;
            padding: 10px;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
            text-align: center;
        }

        a button:hover {
            background-color: #388e3c; /* Darker green */
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            input[type="date"], select {
                width: 100%; /* Full-width on smaller screens */
            }

            th, td {
                font-size: 0.8rem;
                padding: 8px;
            }

            h2 {
                font-size: 1.5rem;
            }
        }

        @media (max-width: 480px) {
            h2 {
                font-size: 1.2rem;
            }

            button, td button {
                font-size: 0.8rem;
                padding: 8px;
            }

            th, td {
                padding: 6px;
                font-size: 0.7rem;
            }
        }
    </style>
</head>
<body>
    <h2>Admin Panel</h2>
    <form method="GET">
        <input type="date" name="date" value="<?= $filter_date ?>">
        <select name="category">
            <option value="">Select Category</option>
            <option value="Puberty Makeup" <?= $filter_category == 'Puberty Makeup' ? 'selected' : '' ?>>Puberty MakeUp</option>
            <option value="Maternity Makeup" <?= $filter_category == 'Maternity Makeup' ? 'selected' : '' ?>>Maternity MakeUp</option>
            <option value="Baby Shower Makeup" <?= $filter_category == 'Baby Shower Makeup' ? 'selected' : '' ?>>Baby Shower MakeUp</option>
            <option value="Bridal Makeup" <?= $filter_category == 'Bridal Makeup' ? 'selected' : '' ?>>Bridal MakeUp</option>
            <option value="Pro HD Makeup" <?= $filter_category == 'Pro HD Makeup' ? 'selected' : '' ?>>Pro HD MakeUp</option>
            <option value="Engagement Makeup" <?= $filter_category == 'Engagement Makeup' ? 'selected' : '' ?>>Engagement MakeUp</option>
            <option value="Nature Makeup" <?= $filter_category == 'Nature Makeup' ? 'selected' : '' ?>>Nature MakeUp</option>
            <option value="HD Makeup" <?= $filter_category == 'HD Makeup' ? 'selected' : '' ?>>HD MakeUp</option>
            <option value="Smookey Makeup" <?= $filter_category == 'Smookey Makeup' ? 'selected' : '' ?>>Eye Makeup</option>
            <option value="Eye Makeup" <?= $filter_category == 'Eye Makeup' ? 'selected' : '' ?>>Smookey Makeup</option>
            <option value="Hair Styling" <?= $filter_category == 'Hair Styling' ? 'selected' : '' ?>>Hair Styling</option>
            <option value="Smookey Makeup" <?= $filter_category == 'Fashion Makeup' ? 'selected' : '' ?>>Fashion Makeup</option>
            <option value=" Makeup" <?= $filter_category == 'Fashion Makeup' ? 'selected' : '' ?>>Fashion Makeup</option>
        </select>
        <button type="submit">Filter</button>
    </form>
    <table>
        <tr>
            <th>Name</th>
            <th>Phone</th>
            <th>Category</th>
            <th>Address</th>
            <th>Description</th>
            <th>Submitted At</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['name'] ?></td>
                <td><?= $row['phone'] ?></td>
                <td><?= $row['category'] ?></td>
                <td><?= $row['address'] ?></td>
                <td><?= $row['description'] ?></td>
                <td><?= $row['submitted_at'] ?></td>
                <td>
                    <form method="POST" action="update_status.php">
                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                        <button type="submit" name="action" value="delete">Delete</button>
                        <button type="submit" name="action" value="complete">Mark as Completed</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
    <a href="completed.php"><button>Check Completed</button></a>
</body>
</html>

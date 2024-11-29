<?php
// Connect to database and fetch blocks
include_once '../dbConnect.php';  

// Query to fetch blocks
$sql = "SELECT * FROM blocks";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Blocks</title>
    <link rel="stylesheet" href="css/styles.css"> <!-- Link to your CSS file -->
    <style>
        /* Additional CSS for table styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        img.block-image {
            max-height: 100px;
            max-width: 150px;
        }
        .actions {
            white-space: nowrap;
        }
        .actions a {
            margin-right: 10px;
            padding: 5px 10px;
            text-decoration: none;
            background-color: #007bff;
            color: #fff;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .actions a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h2>View Blocks</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Image</th>
            <th>Price</th>
            <th>Facilities</th>
            <th>Created At</th>
            <th>Actions</th>
        </tr>
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['block_id'] . "</td>";
            echo "<td>" . $row['block_name'] . "</td>";
            echo "<td><img src='../" . $row['image_url'] . "' class='block-image'></td>"; // Adjust image source path
            echo "<td>" . $row['price'] . "</td>";
            echo "<td>" . $row['facilities'] . "</td>";
            echo "<td>" . $row['created_at'] . "</td>";
            echo "<td class='actions'><a href='editblock.php?id=" . $row['block_id'] . "'>Edit</a> | <a href='deleteblock.php?id=" . $row['block_id'] . "' onclick='return confirm(\"Are you sure you want to delete this block?\")'>Delete</a></td>";
            echo "</tr>";
        }
        ?>
    </table>
    <a href="addblock.php">Add New Block</a>
</body>
</html>

<?php
// Close connection
mysqli_close($conn);
?>

<?php
// Connect to database and fetch block details for editing
include_once '../dbConnect.php';  

if (isset($_GET['id'])) {
    $block_id = $_GET['id'];
    
    // Query to fetch block details
    $sql = "SELECT * FROM blocks WHERE block_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $block_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $block = mysqli_fetch_assoc($result);
    
    // Handle form submission for updating block
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $new_price = $_POST['price'];
        $new_facilities = $_POST['facilities'];
        
        // Check if a new image file was uploaded
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = '../images/';
            $upload_file = $upload_dir . basename($_FILES['image']['name']);
            
            // Move uploaded file to specified directory
            if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_file)) {
                $new_image_url = 'images/' . basename($_FILES['image']['name']);
            } else {
                echo "Error uploading file.";
                exit;
            }
        } else {
            // Keep existing image URL if no new file was uploaded
            $new_image_url = $block['image_url'];
        }
        
        // Update query
        $update_sql = "UPDATE blocks SET image_url = ?, price = ?, facilities = ? WHERE block_id = ?";
        $update_stmt = mysqli_prepare($conn, $update_sql);
        mysqli_stmt_bind_param($update_stmt, "sssi", $new_image_url, $new_price, $new_facilities, $block_id);
        
        if (mysqli_stmt_execute($update_stmt)) {
            echo "Block updated successfully.";
            // Redirect or display success message
        } else {
            echo "Error updating block: " . mysqli_error($conn);
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Block</title>
    <link rel="stylesheet" href="css/styles.css"> <!-- Link to your CSS file -->
    <style>
        /* Additional CSS for form styling */
        form {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        label {
            font-weight: bold;
        }
        input[type="text"], textarea {
            width: 100%;
            padding: 8px;
            margin: 5px 0 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="file"] {
            margin-top: 10px;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        a.button {
            display: inline-block;
            margin-top: 10px;
            padding: 8px 20px;
            background-color: #28a745;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }
        a.button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <h2>Edit Block</h2>
    <form method="post" enctype="multipart/form-data">
        <label>Current Image:</label><br>
        <img src="../<?php echo $block['image_url']; ?>" height="100"><br>
        
        <label>Change Image:</label><br>
        <input type="file" name="image"><br>
        
        <label>Price:</label><br>
        <input type="text" name="price" value="<?php echo $block['price']; ?>"><br>
        
        <label>Facilities:</label><br>
        <textarea name="facilities"><?php echo $block['facilities']; ?></textarea><br>
        
        <input type="submit" value="Update">
    </form>
    <a href="view_blocks.php" class="button">Back to View Blocks</a>
</body>
</html>

<?php
    // Close prepared statement and database connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else {
    echo "Block ID not specified.";
}
?>

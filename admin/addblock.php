<?php
// Connect to database
include_once '../dbConnect.php';  

// Handle form submission for adding new block
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $block_name = $_POST['block_name'];
    $price = $_POST['price'];
    $facilities = $_POST['facilities'];
    
    // Process image upload
    $target_dir = "../images/"; // Directory where images will be stored
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check !== false) {
        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif") {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        } else {
            // Attempt to upload file
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                // File uploaded successfully, insert block details into database
                $image_url = "images/" . basename($_FILES["image"]["name"]);
                
                // Insert query
                $insert_sql = "INSERT INTO blocks (block_name, image_url, price, facilities) VALUES (?, ?, ?, ?)";
                $insert_stmt = mysqli_prepare($conn, $insert_sql);
                mysqli_stmt_bind_param($insert_stmt, "ssis", $block_name, $image_url, $price, $facilities);
                
                if (mysqli_stmt_execute($insert_stmt)) {
                    echo "New block added successfully.";
                    // Redirect or display success message
                } else {
                    echo "Error adding block: " . mysqli_error($conn);
                }
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        echo "File is not an image.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Block</title>
    <link rel="stylesheet" href="css/styles.css"> <!-- Link to your CSS file -->
</head>
<body>
    <h2>Add New Block</h2>
    <form method="post" enctype="multipart/form-data">
        <label>Block Name:</label><br>
        <input type="text" name="block_name"><br>
        
        <label>Image File:</label><br>
        <input type="file" name="image"><br> <!-- Use type="file" for file upload -->
        
        <label>Price:</label><br>
        <input type="text" name="price"><br>
        
        <label>Facilities:</label><br>
        <textarea name="facilities"></textarea><br>
        
        <input type="submit" value="Add">
    </form>
    <a href="view_blocks.php">Back to View Blocks</a>
</body>
</html>

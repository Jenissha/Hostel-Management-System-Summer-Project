<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Record</title>
    <link rel="stylesheet" href="../css/styles.css"> <!-- Link to your CSS file -->
    <style>
        /* Additional CSS for button styling */
        .back-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            border: none;
            cursor: pointer;
        }
        .back-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $regno = $_POST['regno'];
        require_once('../dbConnect.php');
        $sql = "DELETE FROM users WHERE regno='$regno';";
        
        if (mysqli_query($conn, $sql)) {
            mysqli_close($conn);
            echo "Record deleted successfully";
        } else {
            echo "Error deleting record: " . mysqli_error($conn);
        }
    }
    ?>
    
    <!-- Back button to return to search page -->
    <a href="studentsearch.php" class="back-btn">Back to Search</a>
</body>
</html>
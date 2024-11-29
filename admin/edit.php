<?php
require_once('../dbConnect.php');

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['regno'])) {
    $regno = $_GET['regno'];
    
    // Prepare statement to fetch record for editing
    $sql = "SELECT name, regno, email, phoneno, block, roomno FROM users WHERE regno=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $regno);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    // Fetch record
    if ($row = mysqli_fetch_assoc($result)) {
        // Record found, proceed with displaying form
    } else {
        $message = "No record found for this registration number.";
    }
    mysqli_stmt_close($stmt);
}

// Handle form submission for updating record
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $regno = $_POST['regno'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phoneno = $_POST['phoneno'];
    $block = $_POST['block'];
    $roomno = $_POST['roomno'];
    
    // Prepare statement for updating record
    $sql = "UPDATE users SET name=?, email=?, phoneno=?, block=?, roomno=? WHERE regno=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssssss", $name, $email, $phoneno, $block, $roomno, $regno);
    
    if (mysqli_stmt_execute($stmt)) {
        $message = "Record updated successfully";
        // Fetch updated record
        $sql = "SELECT name, regno, email, phoneno, block, roomno FROM users WHERE regno=?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $regno);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);
    } else {
        $message = "Error updating record: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Record</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        form {
            margin-top: 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
        }
        input[type="text"], input[type="email"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 16px;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 12px 20px;
            cursor: pointer;
            border-radius: 4px;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .back-btn {
            background-color: #6c757d;
            color: #fff;
            border: none;
            padding: 12px 20px;
            cursor: pointer;
            border-radius: 4px;
            font-size: 16px;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
        }
        .back-btn:hover {
            background-color: #5a6268;
        }
        .message {
            text-align: center;
            margin-top: 10px;
            color: #007bff;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Record</h1>
        <?php if (!empty($message)) { ?>
            <p class="message"><?php echo $message; ?></p>
        <?php } ?>
        <?php if (!empty($row)) { ?>
            <form action="" method="post">
                <input type="hidden" name="regno" value="<?php echo $row['regno']; ?>">
                <label>Name:</label>
                <input type="text" name="name" value="<?php echo $row['name']; ?>"><br>
                <label>Email:</label>
                <input type="email" name="email" value="<?php echo $row['email']; ?>"><br>
                <label>Phone Number:</label>
                <input type="text" name="phoneno" value="<?php echo $row['phoneno']; ?>"><br>
                <label>Block:</label>
                <input type="text" name="block" value="<?php echo $row['block']; ?>"><br>
                <label>Room No:</label>
                <input type="text" name="roomno" value="<?php echo $row['roomno']; ?>"><br>
                <input type="submit" value="Update">
            </form>
            <a href="studentsearch.php" class="back-btn">Back to Search</a>
        <?php } else { ?>
            <p class="message"><?php echo $message; ?></p>
            <a href="studentsearch.php" class="back-btn">Back to Search</a>
        <?php } ?>
    </div>
</body>
</html>

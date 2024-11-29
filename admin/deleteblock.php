<?php
// Connect to database
include_once '../dbConnect.php';

// Check if block ID is set and numeric
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $block_id = $_GET['id'];

    // Prepare delete query
    $delete_sql = "DELETE FROM blocks WHERE block_id = ?";
    $delete_stmt = mysqli_prepare($conn, $delete_sql);
    mysqli_stmt_bind_param($delete_stmt, "i", $block_id);

    // Execute delete query
    if (mysqli_stmt_execute($delete_stmt)) {
        // Redirect to view blocks page after successful deletion
        header("Location: view_blocks.php");
        exit();
    } else {
        echo "Error deleting block: " . mysqli_error($conn);
    }

    // Close statement
    mysqli_stmt_close($delete_stmt);
} else {
    echo "Invalid block ID.";
}

// Close connection
mysqli_close($conn);
?>

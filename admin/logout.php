<?php
session_start();
session_unset();
session_destroy();
header("Location: ../index.php"); // Redirects to index.php in the main folder
exit();
?>

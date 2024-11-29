<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
   
   
    <?php include 'header.php'; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"> <!-- Font Awesome -->
    <style>

        /* Global Styles */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa; /* Light Gray */
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .container {
            display: flex;
            flex: 1;
            overflow: hidden; /* Hide overflow for sidebar */
        }

        /* Sidebar Styles */
        .sidebar {
            width: 250px;
            background-color: #000000; /* Black */
            color: #ffffff; /* White */
            transition: width 0.3s ease;
            overflow-y: auto; /* Enable scrolling if needed */
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            z-index: 100;
            position: fixed;
            height: 100%;
            padding-top: 80px; /* Adjusted for header height */
        }

        .sidebar-header {
            padding: 10px 20px;
            text-align: center;
            border-bottom: 1px solid #333333; /* Dark Gray */
        }

        .sidebar-header h3 {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
            color: #ffffff; /* White */
        }

        .sidebar-menu {
            padding-top: 20px;
        }

        .sidebar-menu a {
            display: block;
            padding: 12px 20px;
            text-decoration: none;
            color: #ffffff; /* White */
            font-size: 18px;
            transition: background-color 0.3s;
            position: relative;
        }

        .sidebar-menu a:hover {
            background-color: #333333; /* Dark Gray */
        }

        .sidebar-menu a i {
            margin-right: 10px;
        }

        .sidebar-menu a .btn-icon {
            position: absolute;
            top: 50%;
            right: 20px;
            transform: translateY(-50%);
            font-size: 18px;
            color: #ffffff; /* White */
            opacity: 0.7;
        }

        /* Main Content Styles */
        .main-content {
            flex: 1;
            padding: 20px;
            transition: margin-left 0.3s ease;
            background-color: #f2f2f2; /* Light Gray */
            margin-left: 250px;
            margin-top: 80px; /* Adjusted for header height */
        }

        .card {
            background-color: #ffffff; /* White */
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            cursor: pointer;
            margin-bottom: 20px;
            padding: 20px;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .card-title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #333333; /* Dark Gray */
        }

        .card-description {
            font-size: 14px;
            color: #666666; /* Gray */
            line-height: 1.5;
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }

            .main-content {
                margin-left: 0;
            }

            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
                margin-bottom: 20px;
                box-shadow: none;
                padding-top: 0;
            }

            .sidebar-header {
                border-bottom: none;
                text-align: left;
                padding: 10px 20px;
            }

            .sidebar-menu {
                padding-top: 10px;
            }

            .sidebar-menu a {
                padding: 10px 20px;
                position: relative;
            }

            .sidebar-menu a .btn-icon {
                position: absolute;
                top: 50%;
                right: 20px;
                transform: translateY(-50%);
                font-size: 18px;
                color: #ffffff; /* White */
                opacity: 0.7;
            }

            .main-content {
                margin-top: 20px; /* Adjust margin top for smaller screens */
            }
        }
    </style>
</head>
<body>



<div class="container">
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h3>Admin Panel</h3>
        </div>
        <div class="sidebar-menu">
            <a href="roomdetails.php">
                Room Details
                <span class="btn-icon"><i class="fas fa-bed"></i></span>
            </a>
            <a href="studentsearch.php">
                Student Search
                <span class="btn-icon"><i class="fas fa-search"></i></span>
            </a>
            <a href="leaverequests.php">
                Leave Requests
                <span class="btn-icon"><i class="fas fa-calendar"></i></span>
            </a>
            <a href="view_blocks.php">
                Manage Blocks
                <span class="btn-icon"><i class="fas fa-building"></i></span>
            </a>
            <!-- Add more sidebar links as needed -->
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="card">
            <p class="card-title">Room Details</p>
            <p class="card-description">Check all student room details.</p>
        </div>

        <div class="card">
            <p class="card-title">Student Search</p>
            <p class="card-description">Search for a student.</p>
        </div>

        <div class="card">
            <p class="card-title">Leave Requests</p>
            <p class="card-description">Approve or reject leave requests.</p>
        </div>

        <div class="card">
            <p class="card-title">Manage Blocks</p>
            <p class="card-description">Add, edit, or delete hostel blocks.</p>
        </div>
        <!-- Add more cards for additional features -->
    </div>
</div>

</body>
</html>

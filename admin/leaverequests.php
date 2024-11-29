<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Leave Requests</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Encode+Sans+Expanded:wght@400;700&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: helvetica;
        }
        table {
            width: 750px;
            border-collapse: collapse;
            margin: 50px auto;
        }
        tr:nth-of-type(odd) {
            background: #eee;
        }
        th {
            background: #3498db;
            color: white;
            font-weight: bold;
        }
        td, th {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: left;
            font-size: 18px;
        }
        .approvebtn {
            border-radius: 50px;
            background: #01bf71;
            padding: 10px 22px;
            color: #010606;
            font-size: 16px;
            outline: none;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease-in-out;
            text-decoration: none;
        }
        .rejectbtn {
            border-radius: 50px;
            background: red;
            padding: 10px 32px;
            color: #010606;
            font-size: 16px;
            outline: none;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease-in-out;
            text-decoration: none;
            margin-top: 5px;
        }
        @media only screen and (max-width: 760px), (min-device-width: 768px) and (max-device-width: 1024px) {
            table {
                width: 100%;
            }
            table, thead, tbody, th, td, tr {
                display: block;
            }
            thead tr {
                position: absolute;
                top: -9999px;
                left: -9999px;
            }
            tr { border: 1px solid #ccc; }
            td {
                border: none;
                border-bottom: 1px solid #eee;
                position: relative;
                padding-left: 50%;
            }
            td:before {
                position: absolute;
                top: 6px;
                left: 6px;
                width: 45%;
                padding-right: 10px;
                white-space: nowrap;
                content: attr(data-column);
                color: #000;
                font-weight: bold;
            }
        }
    </style>
</head>
<body>
    <?php
    session_start();

    if (!isset($_SESSION['employeeid'])) {
        header('Location: adminlogin.php');
        exit();
    }

    include 'header.php';
    require_once('../dbConnect.php');

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['approve'])) {
            approve($_POST['id']);
        } elseif (isset($_POST['reject'])) {
            reject($_POST['id']);
        }
    }

    function approve($regno) {
        global $conn;
        $sql = "UPDATE leaverequests SET status='approved' WHERE regno='$regno'";
        if (mysqli_query($conn, $sql)) {
            echo 'Leave approved successfully';
        } else {
            echo 'Error occurred while approving leave';
        }
    }

    function reject($regno) {
        global $conn;
        $sql = "UPDATE leaverequests SET status='rejected' WHERE regno='$regno'";
        if (mysqli_query($conn, $sql)) {
            echo 'Leave rejected successfully';
        } else {
            echo 'Error occurred while rejecting leave';
        }
    }

    $sql = "SELECT * FROM leaverequests";
    $query = mysqli_query($conn, $sql);
    ?>

    <form action="leaverequests.php" method="post">
        <table>
            <thead>
                <tr>
                    <th>Reg No</th>
                    <th>Name</th>
                    <th>Block</th>
                    <th>Room No</th>
                    <th>From Date</th>
                    <th>To Date</th>
                    <th>Reason</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($rows = mysqli_fetch_assoc($query)) { ?>
                    <tr>
                        <td><?php echo $rows['regno']; ?></td>
                        <td><?php echo $rows['name']; ?></td>
                        <td><?php echo $rows['block']; ?></td>
                        <td><?php echo $rows['roomno']; ?></td>
                        <td><?php echo $rows['fromdate']; ?></td>
                        <td><?php echo $rows['todate']; ?></td>
                        <td><?php echo $rows['reason']; ?></td>
                        <td>
                            <?php if ($rows['status'] == "Pending") { ?>
                                <input type="hidden" name="id" value="<?php echo $rows['regno']; ?>">
                                <input type="submit" name="approve" class="approvebtn" value="Approve">
                                <input type="submit" name="reject" class="rejectbtn" value="Reject">
                            <?php } else { ?>
                                <?php echo $rows['status']; ?>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </form>
</body>
</html>

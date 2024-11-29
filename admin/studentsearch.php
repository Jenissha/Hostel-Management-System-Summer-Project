<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title></title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: helvetica;
        }

        .wrapper {
            margin-top: 85px;
            display: flex;
            justify-content: center;
        }

        .search_box {
            background: #643fef;
            height: 80px;
            padding: 15px;
            border-radius: 50px;
            display: flex;
        }

        .search_box .search_btn .btn {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: #7a5cf0;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
            margin-left: 15px;
            cursor: pointer;
        }

        .search_box .input_search {
            outline: none;
            border: 0;
            background: #7a5cf0;
            border-radius: 50px;
            padding: 15px 20px;
            width: 300px;
            height: 50px;
            color: #fff;
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
            padding: 10px;
            text-align: left;
            font-size: 18px;
        }

        td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: left;
            font-size: 18px;
        }

        .edit-btn, .delete-btn {
            background-color: #7a5cf0;
            border: none;
            color: white;
            padding: 8px 16px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 5px;
        }

        .edit-btn:hover, .delete-btn:hover {
            background-color: #643fef;
        }
    </style>
</head>
<body>
<?php include 'header.php'; ?>
<script src="https://kit.fontawesome.com/b99e675b6e.js"></script>

<form action="studentsearch.php" method="post">
    <div class="wrapper">
        <div class="search_box">
            <input type="text" name="name" id="name" class="input_search" placeholder="Enter student name"
                  >
            <div class="search_btn">
                <input class="btn" type="submit" name="submit" value="find">
            </div>
        </div>
    </div>
</form>

<table>
    <thead>
    <tr>
        <th>Reg No</th>
        <th>Name</th>
        <th>Phone no</th>
        <th>Email</th>
        <th>Block</th>
        <th>Room no</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];
        require_once('../dbConnect.php');
        $sql = "SELECT name, regno, email, phoneno, block, roomno FROM users WHERE name='$name';";
        $query = mysqli_query($conn, $sql);
        while ($rows = mysqli_fetch_assoc($query)) {
            ?>
            <tr>
                <td><?php echo $rows['regno']; ?></td>
                <td><?php echo $rows['name']; ?></td>
                <td><?php echo $rows['phoneno']; ?></td>
                <td><?php echo $rows['email']; ?></td>
                <td><?php echo $rows['block']; ?></td>
                <td><?php echo $rows['roomno']; ?></td>
                <td>
                    <a href="edit.php?regno=<?php echo $rows['regno']; ?>" class="edit-btn">Edit</a>
                    <form action="delete.php" method="post" style="display: inline;">
                        <input type="hidden" name="regno" value="<?php echo $rows['regno']; ?>">
                        <input type="submit" value="Delete" class="delete-btn">
                    </form>
                </td>
            </tr>
            <?php
        }
    }
    ?>
    </tbody>
</table>

</body>
</html>

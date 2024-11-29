<?php
// Ensure session is started at the beginning
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Pricing</title>
    <link rel="stylesheet" href="css/pricing.css">
    <style>
        /* Your CSS styles here */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: "Encode Sans Expanded", sans-serif;
        }

        .Nav {
            background: black;
            height: 80px;
            margin-top: 0px;
            display: flex;
            justify-content: center;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .NavbarContainer {
            display: flex;
            justify-content: space-between;
            height: 80px;
            z-index: 1;
            width: 100%;
            padding: 0 24px;
            max-width: 1100px;
        }

        .NavLogo {
            color: red;
            justify-self: flex-start;
            cursor: pointer;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            margin-left: 24px;
            font-weight: bold;
            text-decoration: none;
        }

        .MobileIcon {
            display: none;
        }

        @media screen and (max-width: 768px) {
            .MobileIcon {
                display: block;
                position: absolute;
                top: 0;
                right: 0;
                transform: translate(-100%, 60%);
                font-size: 1.8rem;
                cursor: pointer;
                color: #fff;
            }
        }

        .NavMenu {
            display: flex;
            align-items: center;
            list-style: none;
            text-align: center;
            margin-right: -22px;
        }

        @media screen and (max-width: 768px) {
            .NavMenu {
                display: none;
            }
        }

        .NavItem {
            height: 80px;
        }

        .NavLinks {
            color: #fff;
            display: flex;
            align-items: center;
            text-decoration: none;
            padding: 0 1rem;
            height: 100%;
            cursor: pointer;
        }

        .NavLinks.active {
            border-bottom: 3px solid #01bf71;
        }

        .NavBtn {
            display: flex;
            align-items: center;
        }

        @media screen and (max-width: 768px) {
            .NavBtn {
                display: none;
            }
        }

        .NavBtnLink {
            border-radius: 50px;
            background: #01bf71;
            whitespace: nowrap;
            padding: 10px 22px;
            color: #010606;
            font-size: 16px;
            outline: none;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease-in-out;
            text-decoration: none;
        }

        .NavBtnLink:hover {
            transition: all 0.2s ease-in-out;
            background: #fff;
            color: #010606;
        }
    </style>
    <script type="text/javascript">
        function rtohome() {
            window.location.href = "index.php";
        }

        function logout() {
            window.location.href = "../index.php";
        }

        function change() {
            window.location.href = "registration.php";
        }
    </script>
</head>
<body>
    <div class="Nav" id="Nav1">
        <div class="NavbarContainer">
            <img src="images/jenishalogo.png" alt="Jenisha Logo" class="NavLogo" onclick="rtohome()">
            <div class="MobileIcon">
                <i class="fa fa-bars"></i>
            </div>
            
            <div class="NavBtn">
                <button type="button" name="button" class="NavBtnLink" onclick="change()">Signup</button>
            </div>
        </div>
    </div>

    <div class="pricingcontainer">
        <div class="pricingwrapper">
            <?php
            // Include database connection
            include_once 'dbConnect.php';

            // Query to fetch blocks
            $sql = "SELECT * FROM blocks";
            $result = mysqli_query($conn, $sql);

            // Check if there are any blocks
            if (mysqli_num_rows($result) > 0) {
                // Loop through each row (each block)
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="columns">';
                    echo '<ul class="price">';
                    echo '<li class="header">' . htmlspecialchars($row['block_name']) . '</li>';
                    echo '<div class="imagewrapper">';
                    echo '<img style="height:150px; width:150px;" src="' . htmlspecialchars($row['image_url']) . '" alt="">';
                    echo '</div>';
                    echo '<li class="grey">' . htmlspecialchars($row['price']) . ' / year</li>';
                    // Explode facilities by comma and display each as a list item
                    $facilities = explode(', ', $row['facilities']);
                    foreach ($facilities as $facility) {
                        echo '<li>' . htmlspecialchars($facility) . '</li>';
                    }
                    echo '<li class="grey"><a href="signin.php" class="button">Select</a></li>';
                    echo '</ul>';
                    echo '</div>';
                }
            } else {
                echo '<p>No blocks available.</p>';
            }

            // Close database connection
            mysqli_close($conn);
            ?>
        </div>
    </div>

</body>
</html>

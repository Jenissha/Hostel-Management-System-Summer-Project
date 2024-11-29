<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1" name="viewport" />
  <title>LH Hostel Registration</title>
  <link rel="stylesheet" href="../css/mhreg.css">
</head>
<body>
  <?php session_start(); ?>

  <?php
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $regno = $_SESSION['regno'];
    require_once('../dbConnect.php');

    if (isset($_POST["cblock"])) {
      $blockname = "Cblock";
    }
    if (isset($_POST["dblock"])) {
      $blockname = "Dblock";
    }

    // Fetch the current maximum room number in the selected block for males
    $rowSQL = mysqli_query($conn, "SELECT MAX(roomno) AS max FROM `users` WHERE block='$blockname' AND gender='female';");
    $row = mysqli_fetch_array($rowSQL);
    $largestNumber = $row['max'];

    // Initialize room number based on the maximum found
    if ($largestNumber === null) {
      $largestNumber = 1; // No rooms assigned yet
    }

    // Count the number of students already assigned to the largest room number
    $result = mysqli_query($conn, "SELECT COUNT(*) as total FROM users WHERE block='$blockname' AND gender='female' AND roomno='$largestNumber';");
    $data = mysqli_fetch_assoc($result);
    $count = $data['total'];

    // Determine the room number to assign
    if ($count < 2) {
      $roomno = $largestNumber;
    } else {
      $roomno = $largestNumber + 1;
    }

    // Update user record with selected block and room number
    $sql = "UPDATE `users` SET `block`='$blockname', `roomno`='$roomno' WHERE regno='$regno';";
    $query = mysqli_query($conn, $sql);

    if ($query) {
      echo 'Entry successful';
      header('Location: studentdashboard.php');
      exit;
    } else {
      echo "Error occurred";
    }

    mysqli_close($conn);
  }
  ?>

  <?php include '../header.php';?>
  <form class="" action="lhregistration.php" method="post">
    <section class="cards">
      <article class="card card--3">
        <div class="card__img"></div>
        <a href="#" class="card_link">
          <div class="card__img--hover"></div>
        </a>
        <div class="card__info">
          <span class="card__category"> LH Hostel</span>
          <h3 class="card__title">C Block</h3>
          <input type="submit" name="cblock" id="cblock" class="card__by" value="submit">
        </div>
      </article>

      <article class="card card--4">
        <div class="card__img"></div>
        <a href="#" class="card_link">
          <div class="card__img--hover"></div>
        </a>
        <div class="card__info">
          <span class="card__category"> LH Hostel</span>
             Hostel</span>
          <h3 class="card__title">D Block</h3>
          <input type="submit" name="dblock" id="dblock" class="card__by" value="submit">
        </div>
      </article>
    </section>
  </form>
</body>
</html>

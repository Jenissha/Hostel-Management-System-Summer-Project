<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1" name="viewport" />
  <title>Registration Page</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap">
  <style>
    /* Your CSS styles */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }

    body {
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 10px;
      background: linear-gradient(120deg, #00467F, #A5CC82);
    }

    .container {
      max-width: 700px;
      width: 100%;
      background-color: #fff;
      padding: 25px 30px;
      border-radius: 5px;
      box-shadow: 0 5px 10px rgba(0, 0, 0, 0.15);
    }

    .container .title {
      font-size: 25px;
      font-weight: 500;
      position: relative;
    }

    .container .title::before {
      content: "";
      position: absolute;
      left: 0;
      bottom: 0;
      height: 3px;
      width: 30px;
      border-radius: 5px;
      background: linear-gradient(135deg, #71b7e6, #9b59b6);
    }

    .content form .user-details {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
      margin: 20px 0 12px 0;
    }

    form .user-details .input-box {
      margin-bottom: 15px;
      width: calc(50% - 20px);
    }

    form .input-box span.details {
      display: block;
      font-weight: 500;
      margin-bottom: 5px;
    }

    .user-details .input-box input {
      height: 45px;
      width: 100%;
      outline: none;
      font-size: 16px;
      border-radius: 5px;
      padding-left: 15px;
      border: 1px solid #ccc;
      border-bottom-width: 2px;
      transition: all 0.3s ease;
    }

    .user-details .input-box input:focus,
    .user-details .input-box input:valid {
      border-color: #01BF71;
    }

    form .gender-details .gender-title {
      font-size: 20px;
      font-weight: 500;
    }

    form .category {
      display: flex;
      width: 80%;
      margin: 14px 0;
      justify-content: space-between;
    }

    form .category label {
      display: flex;
      align-items: center;
      cursor: pointer;
    }

    form .category label .dot {
      height: 18px;
      width: 18px;
      border-radius: 50%;
      margin-right: 10px;
      background: #d9d9d9;
      border: 5px solid transparent;
      transition: all 0.3s ease;
    }

    #dot-1:checked~.category label .one,
    #dot-2:checked~.category label .two {
      background: #01BF71;
      border-color: #d9d9d9;
    }

    form input[type="radio"] {
      display: none;
    }

    form .button {
      height: 45px;
      margin: 35px 0;
      display: flex;
    }

    form .button input {
      height: 100%;
      width: 100%;
      background: #00467F;
      border: none;
      color: white;
      font-size: 18px;
      font-weight: 500;
      cursor: pointer;
      outline: none;
      border-radius: 5px;
      transition: all 0.3s ease;
    }

    form .button input:hover {
      background: #00111F;
    }

    .error-message {
      color: red;
      margin-top: 10px;
      font-size: 14px;
    }
  </style>
</head>
<body>
  <?php 
  session_start();
  $errmsg = '';

  if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $regno = $_POST['regno'];
    $phoneno = $_POST['phoneno'];
    $password = $_POST['password'];
    $confirmpassword = $_POST['confirmpassword'];
    $gender = $_POST['gender'];

    // Validation and error checking
    if (empty($name) || empty($email) || empty($regno) || empty($phoneno) || empty($password) || empty($confirmpassword) || empty($gender)) {
      $errmsg = "* All fields are required";
    } elseif (!preg_match("/^[a-zA-Z\s]*$/", $name)) {
      $errmsg = "* Name should only contain letters and spaces.";
    } elseif (!preg_match("/^\d{10}$/", $phoneno)) {
      $errmsg = "* Phone number should be exactly 10 digits.";
    } elseif (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,16}$/", $password)) {
      $errmsg = "* Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character, and be between 8 to 16 characters.";
    } elseif ($password != $confirmpassword) {
      $errmsg = "* Password and confirm password do not match.";
    } else {
      // Check if regno already exists
      require_once(__DIR__ . '/dbConnect.php');
      $check_sql = "SELECT regno FROM users WHERE regno = '$regno'";
      $check_result = mysqli_query($conn, $check_sql);

      if (mysqli_num_rows($check_result) > 0) {
        $errmsg = "* Registration number '$regno' is already in use. Please try another.";
      } else {
        // Perform password validation and insertion
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (name, regno, email, phoneno, password, gender, block) VALUES ('$name', '$regno', '$email', '$phoneno', '$hashed_password', '$gender', NULL)";
        $query = mysqli_query($conn, $sql);

        if ($query) {
          $errmsg = '* Entry successful';
          $_SESSION['regno'] = $regno;

          // Redirect based on gender
          if ($gender == "male") {
            header('Location: student/mhregistration.php');
            exit;
          } elseif ($gender == "female") {
            header('Location: student/lhregistration.php');
            exit;
          }
        } else {
          $errmsg = "* Error occurred. Please try again later.";
        }
      }
      mysqli_close($conn);
    }
  }
  ?>

  <div class="container">
    <div class="title">Registration</div>
    <div class="content">
      <form action="registration.php" method="post">
        <div class="user-details">
          <div class="input-box">
            <span class="details">Full Name</span>
            <input name="name" type="text" placeholder="Enter your name" pattern="[a-zA-Z\s]+" title="Only letters and spaces allowed" value="<?php echo isset($name) ? htmlspecialchars($name) : ''; ?>" required>
          </div>
          <div class="input-box">
            <span class="details">Reg No</span>
            <input type="text" placeholder="Enter your regno" name="regno" value="<?php echo isset($regno) ? htmlspecialchars($regno) : ''; ?>" required>
          </div>
          <div class="input-box">
            <span class="details">Email</span>
            <input type="email" placeholder="Enter your email" name="email" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>" required>
          </div>
          <div class="input-box">
            <span class="details">Phone Number</span>
            <input type="number" pattern="[0-9]{10}" placeholder="Enter your number" name="phoneno" value="<?php echo isset($phoneno) ? htmlspecialchars($phoneno) : ''; ?>" required>
          </div>
          <div class="input-box">
            <span class="details">Password</span>
            <input type="password" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,16}$" title="Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character, and be between 8 to 16 characters." placeholder="Enter your password" name="password" required>
          </div>
          <div class="input-box">
            <span class="details">Confirm Password</span>
            <input type="password" placeholder="Confirm your password" name="confirmpassword" required>
          </div>
          <div class="gender-details">
            <input type="radio" name="gender" id="dot-1" value="male" required>
            <input type="radio" name="gender" id="dot-2" value="female" required>
            <span class="gender-title">Gender</span>
            <div class="category">
              <label for="dot-1" class="one">
                <div class="dot one"></div>
                <span class="gender">Male</span>
              </label>
              <label for="dot-2" class="two">
                <div class="dot two"></div>
                <span class="gender">Female</span>
              </label>
            </div>
          </div>
        </div>
        <div class="button">
          <input type="submit" name="submit" value="Register">
        </div>
        <span class="error-message"><?php echo $errmsg; ?></span>
      </form>
    </div>
  </div>
</body>
</html>

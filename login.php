<!DOCTYPE html>
<html>
<link rel="icon" href="images\logo.jpg" type="image/icon type">
<title>DRM - Login</title>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="/images/favicon.ico">
    <link rel="stylesheet" href="styles\login.css">
</head>

<body>
    <!-- <script src="script\login.js"></script> -->

    <div class="navbar">
        <div class="logo">
            <img class="logo" src="images\logo.jpg" alt="Page Logo" />
        </div>
        <div class="navbar-links">
            <a class="first-btn" href="home.html"><button class="btn">Home</button></a>
            <a href="team.html"><button class="btn">Team</button></a>
            <a href="about.html"><button class="btn">About</button></a>
            <a href="contact.html"><button class="btn">Contact</button></a>
        </div>
    </div>

    <div class="main">
        <h2>Welcome to DRM!</h2>
        <div class="loginBox">
            <form action="login.php" method="post">
                <h1>Login</h1>
                <b></b>
                <!-- Add this code inside your form -->
<?php
if (isset($_GET['error'])) {
    echo '<div class="error-message">' . htmlspecialchars($_GET['error']) . '</div>';
}
?>

                    <label>User ID:</label><br>
                <input type=text name="user_id" placeholder="Enter user id here..."><br><br>
                <label><b></b>Password:</label><br>
                <input type="password" name="password" placeholder="Enter password here... "><br><br>
                <a href="login.php">
                    <button type="submit" >Login</button>
                </a>
                <div class="forgot-psw">
                    <a href="forgot-psw.html">Forgot Password</a>
                </div>
                <!-- <input name="loginSubmit" type="button" id="loginSubmit" onclick="loginValidate()"Login> -->
                <!-- <button name="loginSubmit" type="button" id="loginSubmit" onclick="addEventListener()">Login</button> -->
            </form>
        </div>
    </div>

</body>

</html>

<?php
session_start();
include "db_conn.php";

// Define the validate function first
function validate($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;   
}

if(isset($_POST['user_id']) && isset($_POST['password'])) {
    $uid = validate($_POST['user_id']);
    $pass = validate($_POST['password']);


    if(empty($uid) && $pass) {
        header("location: login.php?error=user id is required");
        exit();
    }
    else if($uid && empty($pass)) {
        header("location: login.php?error=password is required");
        exit();
    }
    else if(empty($uid) && empty($pass)) {
        header("location: login.php?error= user id and password required"); // Correct the typo here
       exit();
  }

    $sql = "SELECT * FROM users where user_id='$uid' AND password='$pass'";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result); // Change 'rows' to 'row' here
        if($row['user_id'] === $uid && $row['password'] === $pass) {
            echo "Logged In!";
            $_SESSION['fname'] = $row['fname'];
            $_SESSION['lname'] = $row['lname'];
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['password'] = $row['password'];
            $_SESSION['sno'] = $row['sno'];
            header("location: dashboard.html");
            exit();
        }
        else {
            header("location: login.php?error=Incorrect user id or password"); // Correct the typo here
           exit();
      }
    }
    else{
         header("location: login.php");
         exit();
    }
}
?>
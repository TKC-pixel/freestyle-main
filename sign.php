<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST['form_type'] === 'signin') {
        $Susername = $_POST['Sname'];
        $Spassword = $_POST['Spassword'];

        $connection = mysqli_connect('localhost', 'root', '', 'mentor-mentee');
        if (!$connection) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $query1 = "SELECT username FROM `mentor-mentee-signup` WHERE username=? AND password=?";
        $statement1 = mysqli_prepare($connection, $query1);
        mysqli_stmt_bind_param($statement1, "ss", $Susername, $Spassword);
        mysqli_stmt_execute($statement1);
        $result1 = mysqli_stmt_get_result($statement1);

        if (mysqli_num_rows($result1) > 0) {
            $_SESSION['username'] = $Susername;
            header("Location: user.php");
            exit;
        } else {
            $query2 = "SELECT username FROM `mentor-mentee-mentor` WHERE username=? AND password=?";
            $statement2 = mysqli_prepare($connection, $query2);
            mysqli_stmt_bind_param($statement2, "ss", $Susername, $Spassword);
            mysqli_stmt_execute($statement2);
            $result2 = mysqli_stmt_get_result($statement2);

            if (mysqli_num_rows($result2) > 0) {
                $_SESSION['username'] = $Susername;
                header("Location: mentorfeed.php");
                exit;
            } else {
                $query3 = "SELECT surname FROM `admin` WHERE `surname`=? AND password=?";
                $statement3 = mysqli_prepare($connection, $query3);
                mysqli_stmt_bind_param($statement3, "ss", $Susername, $Spassword);
                mysqli_stmt_execute($statement3);
                $result3 = mysqli_stmt_get_result($statement3);

                if (mysqli_num_rows($result3) > 0) {
                    $_SESSION['surname'] = $Susername; // Correctly setting the session variable
                    header("Location: admin.php"); 
                    exit;
                } else {
                    echo "<script>alert('Incorrect Login Details. Make sure you have signed up.');</script>";
                }
            }
        }

        mysqli_stmt_close($statement1);
        mysqli_stmt_close($statement2);
        mysqli_stmt_close($statement3);
        mysqli_close($connection);
    } else if ($_POST['form_type'] === 'signup') {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $firstname = $_POST['fName'];
        $lastname = $_POST['lName'];
        $country = $_POST['country'] ?? 'N/A';
        $num = $_POST['mNumber'];
        $password = $_POST['password'];
        $cpassword = $_POST['cPassword'];
        $current = $_POST['current'];

        if ($password !== $cpassword) {
            echo "<script>alert('Passwords do not match');</script>";
            exit();
        }

        if (isset($_FILES['pic']) && $_FILES['pic']['error'] == UPLOAD_ERR_OK) {
            $pic_temp = $_FILES['pic']['tmp_name'];
            $pic_path = 'users/profiles/' . $username . '.png';

            if (!move_uploaded_file($pic_temp, $pic_path)) {
                echo "<script>alert('Failed to upload image');</script>";
                exit();
            }
        } else {
            echo "<script>alert('No image uploaded or there was an upload error');</script>";
            exit();
        }

        $connection = new mysqli('localhost', 'root', '', 'mentor-mentee');
        if ($connection->connect_error) {
            die('Connection Error: ' . $connection->connect_error);
        }

        $stmt = $connection->prepare("INSERT INTO `mentor-mentee-signup` (username, email, `first-name`, `last-name`, country, `current`, phone, password, `profile`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("sssssssss", $username, $email, $firstname, $lastname, $country, $current, $num, $password, $pic_path);
            if ($stmt->execute()) {
                echo "<script>alert('Registration Successful');</script>";
                header("Location: sign.php");
                exit();
            } else {
                echo "<script>alert('Failed to insert data into database');</script>";
            }
            $stmt->close();
        } else {
            echo "Error preparing statement: " . $connection->error;
        }

        $connection->close();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/sign2.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
    
    <link
      href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
      rel="stylesheet"
    />
   
</head>
<body>
  <header>
    <nav class="nav2">
       <input type="checkbox" id="check" />
        <label for="check" id="checkBtn"> <i class="fas fa-bars"></i></label>

      <span class="nav2Header"><a href="#">Mentor-Mentee Connection</a></span>
      <span class="secNav">
        <a href="home.html">Home</a>
        <a href="about.html">About Us</a>
        
        <a href="FAQ.html">FAQ</a>
        <a href="contactUs.html">Contact Us</a>
      </span>
    </nav>
  </header>
  <main>
    <div class="container">
      <div class="forms-container">
        <div class="signin-signup">
          <form action="" method="POST" class="sign-in-form">
              <h2 class="title">Sign in</h2>
              <div class="input-field">
                <i class="fas fa-user"></i>
                <input type="text" placeholder="Username" name="Sname" />
              </div>
              <div class="input-field">
                <i class="fas fa-lock"></i>
                <input type="password" placeholder="Password" name="Spassword"/>
              </div>
              <input type="submit" value="Login" class="btn solid" />
              <input type="hidden" name="form_type" value="signin">
              <p class="social-text">Or Sign in with social platforms</p>
              <div class="social-media">
                <a href="#" class="social-icon">
                  <i class="fab fa-facebook-f"></i>
                </a>
                <a href="#" class="social-icon">
                  <i class="fab fa-twitter"></i>
                </a>
                <a href="#" class="social-icon">
                  <i class="fab fa-google"></i>
                </a>
                <a href="#" class="social-icon">
                  <i class="fab fa-linkedin-in"></i>
                </a>
              </div>
            </form>
            
          <form action="" class="sign-up-form" method="post" enctype="multipart/form-data">
            <h2 class="title">Sign up as a Mentee</h2>
            <div class="input-field">
              <i class="fas fa-user"></i>
              <input type="text" placeholder="Username" name="username" />
            </div>
            <div class="input-field">
              <i class="fas fa-envelope"></i>
              <input type="email" placeholder="Email" name="email"/>
            </div>
            <div class="input-field">
              <i class="fas fa-portrait"></i>
              <input type="text" placeholder="First Name" name="fName" />
            </div>
            <div class="input-field">
              <i class="fas fa-portrait"></i>
              <input type="text" placeholder="Surname"  name="lName"/>
            </div>
            <div class="input-field">
              <i class="fas fa-globe-africa"></i>
              <input type="text" placeholder="Country"  name="country"/>
            </div>
            
            <div class="input-field">
              <i class="fas fa-phone"></i>
              <input type="text" placeholder="Mobile Number" name="mNumber" />
            </div>
            <div class="input-field" style="height: 80px">
              <i class="fas fa-question-circle" style="margin-top: 30%"></i>
              <textarea name="current" style="background-color: transparent; border: none; padding:5%; border-radius: 55px" id="" placeholder="Tell us about your carear."></textarea>
            </div>
            <div class="input-field">
              <i class="fas fa-id-card"></i>
              <input style="margin-top:3%" type="file" name="pic"/>
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" placeholder="Password" name="password"/>
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" placeholder="Confirm Password" name="cPassword"/>
            </div>
            <input type="submit" class="btn" value="Sign up" />
            <br>
            <a href="mentor.php" style="color: #2270e2; text-decoration: none;" id="mentor">Sign up as a Mentor</a>
            <input type="hidden" name="form_type" value="signup">
            <p class="social-text">Or Sign up with social platforms</p>
            <div class="social-media">
              <a href="#" class="social-icon">
                <i class="fab fa-facebook-f"></i>
              </a>
              <a href="#" class="social-icon">
                <i class="fab fa-twitter"></i>
              </a>
              <a href="#" class="social-icon">
                <i class="fab fa-google"></i>
              </a>
              <a href="#" class="social-icon">
                <i class="fab fa-linkedin-in"></i>
              </a>
            </div>
          </form>
          
        
        </div>
      </div>

      <div class="panels-container">
        <div class="panel left-panel">
          <div class="content">
            <h3>Don't have an account?</h3>
            <p>Create an account with us so you can chat and interact with mentors and other mentees.</p>
            <button class="btn transparent" id="sign-up-btn">
              Sign up
            </button>
          </div>
          <img src="img/log.svg" class="image" alt="" />
        </div>
        <div class="panel right-panel">
          <div class="content">
            <h3>Already have an account?</h3>
            <p>Login using your username and password or using your social media platforms.</p>
            <button class="btn transparent" id="sign-in-btn">
              Sign in
            </button>
          </div>
          <img src="img/register.svg" class="image" alt="" />
        </div>
      </div>
    </div>
  </main>
  <footer>
    <div class="footer">
      <div class="social-media" >
        <h3>Mentor-Mentee Connection</h3>
        <div class="footer-Icons">
          <a href=""><i class="bx bxl-facebook-square"></i></a>
          <a href=""><i class="bx bxl-twitter"></i></a>
          <a href=""><i class="bx bxl-youtube"></i></a>
          
        </div>
      </div>
      <div class="pages" style="margin-top: 20px">
        <h3>Pages</h3>
        <div class="pageCont">
          <a href="home.html">Home</a>
          <a href="about.html">About Us</a>
          
          <a href="FAQ.html">FAQ</a>
          <a href="contactUs.html">Contact Us</a>
        </div>
      </div>
      <div class="contact">
        <h3>Working hours</h3>
        

        <p><i class="bx bx-time"></i> Mon - Fri : 9 am - 6 pm</p>
        
      </div>
    </div>
  </footer>
</body>
</html>
<script src="js/scroll.js"></script>
<script src="js/sign.js"></script>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $firstname = $_POST['fName'];
    $lastname = $_POST['lName'];
    $country = $_POST['country'];
    $num = $_POST['mNumber'];
    $Password = $_POST['password'] ; 
    $Cpassword =$_POST['cPassword'];
    $exp = $_POST['exp'];

    $cert_temp = $_FILES["cert"]["tmp_name"];
    $id_temp = $_FILES["id"]["tmp_name"];
    $pic_temp = $_FILES["pic"]["tmp_name"];
    $uploads_dir = 'users';
    

    $connection = mysqli_connect('localhost', 'root', '', 'mentor-mentee');
    if ($connection->connect_error) {
        die('Connection Error : ' . $connection->connect_error);
    } else {
      if($Password==$Cpassword){
        $cert_path = $uploads_dir . '/certificates/' . $username . '.pdf'; 
        $id_path = $uploads_dir . '/identities/' . $username . '.pdf'; 
        $pic_path = $uploads_dir . '/profiles/' . $username . '.png'; 

        move_uploaded_file($cert_temp, $cert_path);
        move_uploaded_file($id_temp, $id_path);
        move_uploaded_file($pic_temp, $pic_path);
        $stmt = $connection->prepare("INSERT INTO `mentor-mentee-mentor` (username, email, `first-name`, `last-name`, country, phone, password, certificate, identification, experience, `profile-pic`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssssss", $username, $email, $firstname, $lastname, $country, $num, $Password, $cert_path, $id_path, $exp, $pic_path);
        $stmt->execute();
        $stmt->close();
        $connection->close();
        
        echo "<script>alert('Registration Successful. You can now sign in.');</script>";
        header("Location: sign.php");
        exit();
        } 
      else {
        echo '<script>
                  var notesDiv = document.querySelector(".notes");
                  var paragraph = document.createElement("p");
                  var textNode = document.createTextNode("Passwords not matching.");
                  paragraph.textContent = textNode.textContent;
                  notesDiv.appendChild(paragraph);
              </script>';
    }
    
    
    
        
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/mentor.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
    <link
      href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
      rel="stylesheet"
    />
   
</head>
<body>
  <header>
    <nav class="nav2" >
      <span class="nav2Header"><a href="#" >Mentor-Mentee Connection</a></span>
      <span class="secNav" >
        <a href="home.html">Home</a>
        <a href="about.html">About Us</a>
        
        <a href="FAQ.html">FAQ</a>
        <a href="contactUs.html">Contact Us</a>
      </span>
    </nav>
  </header>
  <main>
    <div class="container">
    <form action="" class="sign-up-form" method="post" enctype="multipart/form-data">
        <h2 class="title">Sign up as a Mentor</h2>
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
        <div class="input-field">
          <i class="fas fa-lock"></i>
          <input type="password" placeholder="Password" name="password"/>
        </div>
        <div class="input-field">
          <i class="fas fa-lock"></i>
          <input type="password" placeholder="Confirm Password" name="cPassword"/>
        </div>
        <h5>Upload certificates</h5>
        <div class="input-field">
          <i class="fas fa-file-pdf"></i>
          <input style="margin-top:3%" type="file" name="cert"/>
        </div>
        <h5>Upload ID/Passport</h5>
        <div class="input-field">
          <i class="fas fa-id-card"></i>
          <input style="margin-top:3%" type="file" name="id"/>
        </div>
        <h5>Upload Profile Picture</h5>
        <div class="input-field">
          <i class="fas fa-id-card"></i>
          <input style="margin-top:3%" type="file" name="pic"/>
        </div>
        <div class="input-field" style="height: 100px">
          <i class="fas fa-question-circle" style="margin-top: 50%"></i>
          <textarea name="exp" style="background-color: transparent; border: none; padding:10%; border-radius: 55px" name="info" id="" placeholder="Work Experience"></textarea>
        </div>
        <input type="submit" class="btn" value="Sign up" />
        <br>
        <div class="notes">

        </div>
        <br>
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

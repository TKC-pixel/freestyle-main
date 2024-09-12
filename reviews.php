<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Mentor-Mentee</title>
    <link
      rel="stylesheet"
      href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"
    />
    <link rel="stylesheet" href="css/reviews.css" />
    <link
      href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
      rel="stylesheet"
    />
  </head>
  <body>
    <header>
      <nav class="nav2">
        <span class="nav2Header"><a href="#">Mentor-Mentee Connection</a></span>
        <span class="secNav">
          <a href="home.html">Home</a>
          <a href="about.html"  >About Us</a>
          
          <a href="FAQ.html">FAQ</a>
          <a href="contactUs.html">Contact Us</a>
        </span>

        <span class="btn">
          <a href="sign.html">Sign in</a>
        </span>
      </nav>
    </header>

    <main>

      <h1>Reviews</h1>
      <div id="myvid">
            <video src="images/reviews.mp4" autoplay loop muted></video>
      </div>
      <div class="reviewMain">
        <?php
        
        $connection = mysqli_connect('localhost', 'root', '', 'mentor-mentee');
        
        if(!$connection){
            die("Connection failed: " . mysqli_connect_error());
        }
        else{
            
            $query = "SELECT name, role, review FROM `reviews`";
            $result = mysqli_query($connection, $query);
            while($row = mysqli_fetch_assoc($result)){
                echo "<img src=\"images\kenny-eliason-y_6rqStQBYQ-unsplash.jpg\">";
                //echo "<img src='" . $row['image_src'] . "'>";
                echo "<h3>" .$row['name']. "</h3>";
                echo "<h5>" .$row['role']. "</h5>";
                echo "<p>" .$row['review']. "</p>";
            }
        }
        ?>
      </div>
      <div class="bottom">
      <div class="sect">
            <h2>Get Involved</h2>
        
        <p>Whether you're a seasoned professional looking to share your expertise or a motivated individual seeking guidance on your career journey, Mentor-Mentee Connection welcomes you. Join our community today and embark on a transformative mentorship experience that will propel you towards your goals.</p>
        <br>
        <br>
        <a href="sign.php" id="newSign" class="sect">Sign Up Now</a>
        <br>
        <br>
        </div>
        <div class="sect">
            <h2>Contact Us</h2>
        
            <p>Have questions or feedback? We'd love to hear from you! For more info <a href="">Click here</a>.</p>
            <br>
            <br>
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
  <script src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
  <script src="js/script.js"></script>
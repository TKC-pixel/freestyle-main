<?php
  session_start();
  if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
  } 
  else{
    header("Location: sign.php");
    exit();
  }
?>
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
    <link
      href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
      rel="stylesheet"
    />
    
    <link rel="stylesheet" href="css/mentorfeed.css" />
  </head>
  <body>
    <header>
      <nav class="nav2">
        <span class="nav2Header"><a href="#">Mentor-Mentee Connection</a></span>
        <span class="secNav">
          <a href="user.php" id="active">Home</a>
          <a href="">Dashboard</a>
          <a href="chatM.php">Messages</a>
          <a href="mentorProfile.php">Profile</a>
        </span>
       
      </nav>
    </header>
    <div class="pop">
      <div class="popContent">
        <div class="close">
          <i class="fas fa-times" id="close"></i>
        </div>
          
          <h3>Create your post</h3>
          <form action="" method="post" enctype="multipart/form-data">
              <textarea name="post-t" cols="60" rows="10" placeholder="Enter your text here!"></textarea>
              <br>
              <h5>Attach an Image</h5>
              <br>
              <i class="fas fa-images"></i>
              <input type="file" name="post-I">
              <br>
              <input type="submit" value="Post">
          </form>

          <?php
         if ($_SERVER["REQUEST_METHOD"] == "POST") {
          $postT = htmlspecialchars($_POST['post-t']);
          
          if (isset($_FILES['post-I']) && $_FILES['post-I']['error'] == UPLOAD_ERR_OK) {
              $pic_temp = $_FILES['post-I']['tmp_name'];
              $uploads_dir = 'mentees';
                  
                  if (!is_dir($uploads_dir)) {
                      mkdir($uploads_dir, 0777, true);
                  }
                  $pic_path = $uploads_dir . '/posts/' . $postT . '.png'; 
                  
                  if (move_uploaded_file($pic_temp, $pic_path)) {
                      $connection = new mysqli('localhost', 'root', '', 'mentor-mentee');
                      
                      if ($connection->connect_error) {
                          die('Connection Error: ' . $connection->connect_error);
                      } 
                      else{
                          $stmt = $connection->prepare("INSERT INTO `mentee-posts` VALUES (?, ?, ?)");
                          if ($stmt) {
                              $stmt->bind_param("sss", $username, $postT, $pic_path);
                              if ($stmt->execute()) {
                                  echo "<script>alert('Post saved successfully.');</script>";
                              } else {
                                  echo "<script>alert('Failed to save post.');</script>";
                              }
                              $stmt->close();
                          } else {
                              echo "Error preparing statement: " . $connection->error;
                          }
                          $connection->close();
                      }
                  } else {
                      echo "<script>alert('Failed to upload image.');</script>";
                  }
              } else {
                  echo "<script>alert('No image uploaded or there was an upload error.');</script>";
              }
          }
          ?>
      </div>
    </div>
    <main>
      <div class="Mcontent">
        
        <div class="background">
          <div class="mid">
            <div class="share-box">
              <div class="share-content">
                <button class="share-button" id="start">Create a post</button>
              </div>
            </div>
            
            <div class="feed-post">
              <img
              src=https://pbs.twimg.com/profile_images/66175239/TT_-_Studna__Lower_Quality5__400x400.jpg
              alt="Profile Picture" class="profile-picture">
  
              <div class="post-content">
                <h3 class="author-name">Joe Doe</h3>
  
                <p class="author-profession">Data Scientist</p>
  
                <p class="post-text">
                  Joe Doe is a seasoned data scientist based in Cape Town, South
                  Africa, currently serving as Principal Data Scientist at
                  Kinetic. He holds a PhD in Computer Science from North-West
                  University, where his research focused on the development of a
                  machine learning-based framework for anomaly detection. Prior to
                  this, he earned an MPhil in Engineering Management from the
                  University of Cape Town. Richard is highly skilled in Machine
                  Learning, Data Science, and Python.
                </p>
  
                <div class="post-actions">
                  <button class="like-button">Like</button>
                  <button class="comment-button">Comment</button>
                  <button class="share-button">Share</button>
                </div>
              </div>
            </div>
            <div class="feed-post">
              <img
                src="images/pexels-hawk-i-i-75310404-19547592 new.jpg"
                alt="Profile Picture"
                class="profile-picture"
              />
  
              <div class="post-content">
                <h3 class="author-name">Nomfundo Jileka</h3>
  
                <p class="author-profession">Graduate in Cardiologist</p>
  
                <p class="post-text">
                  Seeking mentorshio in Cardiologist I'm a recent graduate in
                  Cardiologist, eager to learn and grow in the industry. I've been
                  inspired by the work of professionals like Dr. Michal DeBakey,
                  particularly in Cardiovascular surgeon. I'm seeking mentorship
                  to guide me in the early stages of my career. Any
                  recommendations or connections would be greatly appreciated!
                </p>
  
                <div class="post-actions">
                  <button class="like-button">Like</button>
                  <button class="comment-button">Comment</button>
                  <button class="share-button">Share</button>
                </div>
              </div>
            </div>
            <div class="feed-post">
              <img
                src="images/pexels-olly-3756679new.jpg"
                alt="Profile Picture"
                class="profile-picture"
              />
  
              <div class="post-content">
                <h3 class="author-name">Elizaberth</h3>
  
                <p class="post-text">
                  I have worked with Anna for many months now, and I am very
                  grateful to have her as a mentor! She helped me through a tough
                  time of finding a job in Product Management, and growing in my
                  profession to Group Product Manager. Not only was Anna
                  supporting me with challenge as a product manager, her
                  background in physiology helped me shape my career goals and set
                  the right priorities for me. I would highly recommend Anna as a
                  mentor
                </p>
  
                <div class="post-actions">
                  <button class="like-button">Like</button>
                  <button class="comment-button">Comment</button>
                  <button class="share-button">Share</button>
                </div>
              </div>
            </div>
            <div class="feed-post">
              <img
                src="images/pexels-anna-nekrashevich-6801684.jpg"
                alt="Profile Picture"
                class="profile-picture"
              />
  
              <div class="post-content">
                <h3 class="author-name">Nontsikelelo Shazi</h3>
  
                <p class="author-profession">
                  ML Research and Founder @ APTA Technologies
                </p>
  
                <p class="post-text">
                  As a mentor with a background in both research and industry, I
                  have a wealth of experience of 10+ years to draw upon when
                  guiding individuals through the field of machine learning. My
                  focus is on helping experienced software engineers transition
                  into ML/DS, as well as assisting machine learning engineers in
                  their research endeavors, and getting juniors on the right track
                  for their career. A typical mentorship session with me will
                  begin with a review of your career, skills, and goals. From
                  there, we will assess the steps and skills needed to achieve
                  those goals and develop a long-term plan and specific projects
                  to support your overall objective.
                </p>
  
                <div class="post-actions">
                  <button class="like-button">Like</button>
                  <button class="comment-button">Comment</button>
                  <button class="share-button">Share</button>
                </div>
              </div>
            </div>
            <div class="feed-post">
              <img
                src="images/pexels-griffinw-3970083.jpg"
                alt="Profile Picture"
                class="profile-picture"
              />
  
              <div class="post-content">
                <h3 class="author-name">Karean</h3>
  
                <p class="author-profession">Machine Learning</p>
  
                <p class="post-text">
                  I'm a Software engineer & Technical product manager with over 10
                  years of experience in the industry across a variety of
                  technology stacks and ecosystems. What sets me apart is my
                  significant involvement in mentoring and hiring engineering
                  teams at my previous companies. I've had the privilege of
                  mentoring developers across the experience spectrum and i've
                  owned the engineering hiring process at various companies for
                  the past 7 years. I'm deeply committed to following best
                  practices when it comes to software engineering. My expertise
                  extends to building Microservices (And when not to build them)
                  and Modular monoliths and platform-agnostic architectures.
                </p>
  
                <div class="post-actions">
                  <button class="like-button">Like</button>
                  <button class="comment-button">Comment</button>
                  <button class="share-button">Share</button>
                </div>
              </div>
            </div>
            <div class="feed-post">
              <img
                src="images/pexels-cottonbro-7579829.jpg"
                alt="Profile Picture"
                class="profile-picture"
              />
  
              <div class="post-content">
                <h3 class="author-name">Nosipha Khalala</h3>
  
                <p class="author-profession">Graduate in Radiography</p>
  
                <p class="post-text">
                  I am currently on the lookout for a mentor in Radiography. I am
                  passionate about finding joy in capturing precise images that
                  aid in accurate diagnosis, ensuring patients receive optimal
                  care, and I believe that guidance from an experienced mentor
                  could greatly enhance my journey.I am particularly interested in
                  connecting with individuals who have a strong background in
                  Angiography. If you or someone you know has experience in this
                  area and would be open to sharing insights, advice, and support,
                  I would love to connect.My goal is to learn from the best and to
                  continuously grow both personally and professionally. I am open
                  to flexible arrangements, whether it's occasional coffee
                  meetings, virtual check-ins, or more structured mentorship
                  sessions.
                </p>
  
                <div class="post-actions">
                  <button class="like-button">Like</button>
                  <button class="comment-button">Comment</button>
                  <button class="share-button">Share</button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="right">
          <h3 style="margin-left: 30%;">Explore</h3>
          <a href="explore.php">Find mentees</a>
          <br>
          <a href="exploreMentor.php">Find other mentors</a>
          <br>
          <p></p>
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
            <a href="user.php">Home</a>
            
            <a href="classes.html">Classes</a>
            <a href="meetMentors.html">Mentors</a>
            <a href="">Notifications</a>
            <a href="userchat.html">Messages</a>
          </div>
        </div>
        <div class="contact">
          <h3>Working hours</h3>
          

          <p><i class="bx bx-time"></i> Mon - Fri : 9 am - 6 pm</p>
          
        </div>
      </div>
    </footer>
  </body>
  
  
  <script src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
  <script src="js/user.js"></script>
</html>
<script>
    document.getElementById("logout").addEventListener("click", function(event) {
        event.preventDefault();
        if (confirm("Are you sure you want to logout?")) {
              window.location.href = "sign.php";
        }
    });
</script>

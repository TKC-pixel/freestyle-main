<?php
session_start();
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    header("Location: sign.php");
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["post"])) {
    $postT = htmlspecialchars($_POST['post-t']);

    if (isset($_FILES['post-I']) && $_FILES['post-I']['error'] == UPLOAD_ERR_OK) {
        $pic_temp = $_FILES['post-I']['tmp_name'];
        $uploads_dir = 'mentees/posts';

        if (!is_dir($uploads_dir)) {
            mkdir($uploads_dir, 0777, true);
        }

        $safe_postT = preg_replace('/[^a-zA-Z0-9-_]/', '_', $postT);

        $pic_path = $uploads_dir . '/' . $safe_postT . '.png';

        if (move_uploaded_file($pic_temp, $pic_path)) {
            $connection = new mysqli('localhost', 'root', '', 'mentor-mentee');

            if ($connection->connect_error) {
                die('Connection Error: ' . $connection->connect_error);
            } else {
                $stmt = $connection->prepare("INSERT INTO `mentee-posts`(`poster`, `text`, `image`) VALUES (?, ?, ?)");
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
            }
        } else {
            echo "<script>alert('Failed to upload image.');</script>";
        }
    } else {
        echo "<script>alert('No image uploaded or there was an upload error.');</script>";
    }

    $connection->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Mentor-Mentee</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/user.css" />
</head>

<body>
    <header>
        <nav class="nav2">
            <span class="nav2Header"><a href="#">Mentor-Mentee Connection</a></span>
            <span class="secNav">
                <a href="user.php" id="active">Home</a>
                <a href="classes.php">Classes</a>

                <a href="meetMentors.html">Meet our team</a>

                <a href="chat.php">Messages</a>
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
                <input type="submit" value="Post" name="post">
            </form>


        </div>
    </div>

    <main style="margin-left: 1%;">
        <div class="Mcontent">
            <div class="left">
                <h3>Username : <?php echo htmlspecialchars($username); ?></h3>
                <a href="user_profile.php">Edit Profile</a><br><br>
                <a href="user_post.php">Manage your Posts</a><br><br>
                
                <a href="">Help?</a><br><br>
                <a href="#" id="logout" style="background-color: #2270e2; color: white; border-radius: 10px; padding: 3%;">Logout</a>
            </div>
            <div class="background">
                <div class="mid">
                    <div class="share-box">
                        <div class="share-content">
                            <button class="share-button" id="start">Create a post</button>
                        </div>
                    </div>
                    <?php
                    $connection = mysqli_connect("localhost", "root", "", "mentor-mentee");
                    if (!$connection) {
                        die("Connection failed: " . mysqli_connect_error());
                    } else {
                        $sql = "SELECT `poster`, `text`, `image`, `likes` FROM `mentee-posts` WHERE `poster` != '$username'";
                        $result = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<div class='feed-post'>";
                                echo "<div class='post'>";
                                echo "<img src='users/profiles/" . $row['poster'] . ".png' alt='' class='profile-picture'>";
                                echo "<div class='post-content'>";
                                echo "<h3 class='author-name'>" . $row['poster'] . "</h3>";
                                echo "<p class='post-text'>" . $row['text'] . "</p>";
                                
                                echo "</div>";
                                echo "</div>";
                                echo "</div>";
                            }
                        } else {
                            echo "Nothing to display";
                        }
                        mysqli_close($connection);
                    }
                    ?>
                    
              </div>
          </div>
          <div class="right">
              <h3 style="margin-left: 30%;">Explore</h3>
              <a href="explore.php">Find other mentees</a><br>
              <a href="exploreMentor.php">Find mentors</a><br>
              <p></p>
          </div>
      </div>
  </main>
  <div class="review" id="review">
      <h3>Add review</h3>
      <form action="" method="post">
          <textarea name="reviewT" cols="60" rows="5" placeholder="Text here!"></textarea>
          <br>
          <br>
          <input type="submit" value="Post" name="review">
      </form>
      <?php

      $connection = new mysqli("localhost", "root", "", "mentor-mentee");
      if ($connection->connect_error) {
          die('Connection Error: ' . $connection->connect_error);
      } else {
          if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['review'])) {
              $review = $_POST['reviewT'];

              if (!empty($review)) {
                  $sql = "INSERT INTO `reviews` VALUES (?, ?)";

                  if ($stmt = $connection->prepare($sql)) {
                      $stmt->bind_param("ss", $username, $review);

                      if ($stmt->execute()) {
                          echo "<script>alert('Review posted!');</script>";
                      } else {
                          echo "<script>alert('Review not posted!');</script>";
                      }

                      $stmt->close();
                  } else {
                      echo "Error preparing statement: " . $connection->error;
                  }
              } else {
                  echo "<script>alert('Review text cannot be empty!');</script>";
              }
          }
      }

      $connection->close();
      ?>
  </div>
  <footer>
      <div class="footer">
          <div class="social-media">
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

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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/posts.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"/>
    <title>Manage your Posts</title>
    <style>
        .posts-section {
            display: flex;
            flex-wrap: wrap;
            gap: 2%;
        }
        .post {
            flex: 1 1 calc(33.333% - 20px); 
            box-sizing: border-box;
            padding: 1%;
            margin: 1%;
            border: 1px solid #ddd;
            border-radius: 10px;
            text-align: center;
        }
        .post img {
            width: 10%;
            height: auto;
        }
        .profile img{
            width: 10%;
            border-radius: 100%;
        }
        main{
            margin: 0 10%;
        }
    </style>
</head>
<body>
    <header>
        <nav class="nav2">
          <span class="nav2Header"><a href="#">Mentor-Mentee Connection</a></span>
          <span class="secNav">
            <a href="user.php">Home</a>
            <a href="classes.html"  >Classes</a>
            <a href="meetMentors.html">Mentors</a>
            <a href="">Notifications</a>
            <a href="chat.php">Messages</a>
          </span>
        </nav>
    </header>
    <main>
        
        <?php
            echo "<div class='info'>
            <img src='users/profiles/$username.png' alt='Profile Picture'>
            <h2> $username  </h2>
            <a href ='user_profile.php'>Edit Profile</a>
            <br>
            
            <h1>Posts</h1>
            </div>";
            
            echo "<div class='posts-section' style='margin-left: 2%'>";

            $connection = mysqli_connect('localhost', 'root', '', 'mentor-mentee');
            if (!$connection) {
                die('Connection failed: ' . mysqli_connect_error());
            }

            $sql = 'SELECT * FROM `mentee-posts` WHERE `poster` = ?';
            $stmt = mysqli_prepare($connection, $sql);
            if ($stmt === false) {
                die('Prepare failed: ' . mysqli_error($connection));
            }

            mysqli_stmt_bind_param($stmt, 's', $username);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $postText = htmlspecialchars($row['text']);
                    $likes = $row['likes'];
                    echo "
                        <div class='posts'style='max-width: 500px; min-width: 500px; border: 1px solid #2270e2; border-radius: 20px; margin: 2%;'>
                            <img src='mentees/posts/{$postText}.png' alt='Post Image'>
                            <p>{$postText}</p>
                            <p>Likes: {$likes}</p>
                        </div>
                        <br><br><br>
                    ";
                }
            } else {
                echo "<div class='posts'><p>No posts available.</p></div>";
            }

            mysqli_stmt_close($stmt);
            mysqli_close($connection);

            "</div>";
            ?>

            </div>
    </main>
</body>
</html>
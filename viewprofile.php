<?php
session_start();

if (isset($_GET['user'])) {
    $user = $_GET['user'];
    $connection = mysqli_connect('localhost', 'root', '', 'mentor-mentee');
    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT `username`, `first-name`, `last-name`, `country`, `email`, `followers`, `current` FROM `mentor-mentee-signup` WHERE `username` = ?";
    if ($stmt = mysqli_prepare($connection, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $user);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {
            $username = htmlspecialchars($row['username']);
            $firstName = htmlspecialchars($row['first-name']);
            $lastName = htmlspecialchars($row['last-name']);
            $country = htmlspecialchars($row['country']);
            $email = htmlspecialchars($row['email']);
            $followers = htmlspecialchars($row['followers']);
            $current = htmlspecialchars($row['current']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $firstName . " " . $lastName; ?>'s Profile</title>
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/posts.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"/>
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
                <a href="classes.php">Classes</a>
                <a href="meetMentors.html">Mentors</a>
                <a href="chat.php">Messages</a>
            </span>
        </nav>
    </header>
    <main>
        <div class="profile">
            <h1><?php echo $firstName . " " . $lastName; ?>'s Profile</h1>
            <img src="users/profiles/<?php echo $username; ?>.png" alt="Profile Picture">
            <p>Country: <?php echo $country; ?></p>
            <p>Email: <?php echo $email; ?></p>
            <p>Followers: <?php echo $followers; ?></p>
            <p>Current Employment: <?php echo $current; ?></p>
        </div>

        <div class="posts-section">
            <?php
                if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['like'])) {
                    $postText = $_POST['post_text'];
                    $updateLikes = "UPDATE `mentee-posts` SET `likes` = `likes` + 1 WHERE `poster` = ? AND `text` = ?";
                    if ($stmtUpdate = mysqli_prepare($connection, $updateLikes)) {
                        mysqli_stmt_bind_param($stmtUpdate, "ss", $user, $postText);
                        mysqli_stmt_execute($stmtUpdate);
                        mysqli_stmt_close($stmtUpdate);

                        // Refresh the page to show the updated likes
                        echo "<script>window.location.href = window.location.href;</script>";
                        exit();
                    } else {
                        echo "Error preparing statement for likes update: " . mysqli_error($connection);
                    }
                }

                $sqlPosts = "SELECT `text`, `likes` FROM `mentee-posts` WHERE `poster` = ?";
                if ($stmtPosts = mysqli_prepare($connection, $sqlPosts)) {
                    mysqli_stmt_bind_param($stmtPosts, "s", $user);
                    mysqli_stmt_execute($stmtPosts);
                    $resultPosts = mysqli_stmt_get_result($stmtPosts);

                    if (mysqli_num_rows($resultPosts) > 0) {
                        while ($rowPost = mysqli_fetch_assoc($resultPosts)) {
                            $postText = htmlspecialchars($rowPost['text']);
                            $likes = htmlspecialchars($rowPost['likes']);
                            echo "<div class='post'>
                                    <img src='mentees/posts/$username.png' alt='Post Image'>
                                    <p>$postText</p>
                                    <p>Likes: $likes</p>
                                    <form method='post'>
                                        <input type='hidden' name='post_text' value='$postText'>
                                        <input style='background-color: #2270e2; color:white; border:none; border-radius: 20px; padding: 2%' type='submit' value='Like Post' name='like'>
                                    </form>
                                  </div>";
                        }
                    } else {
                        echo "<div class='post'><p>No posts available.</p></div>";
                    }
                    mysqli_stmt_close($stmtPosts);
                } else {
                    echo "Error preparing statement for posts: " . mysqli_error($connection);
                }

                mysqli_close($connection);
            ?>
        </div>
    </main>
</body>
</html>
<?php
        } else {
            echo "No user found with the username: $user";
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($connection);
} else {
    echo "No user specified.";
}
?>

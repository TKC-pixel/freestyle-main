<?php
session_start();

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $connection1 = mysqli_connect('localhost', 'root', '', 'mentor-mentee');
    if (!$connection1) {
        die("Connection failed: " . mysqli_connect_error());
    }
} 
else{
    header("Location: login.html");
    exit();
}

$sqlquery = "SELECT `username`, `first-name`, `last-name`, `country`, `email`, `followers`, `experience` FROM `mentor-mentee-mentor` WHERE `username` != ?";

if ($stmt = mysqli_prepare($connection1, $sqlquery)) {
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
        <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="css/explore.css" />
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            function followUser(follower, following) {
                $.post("Mfollow.php", { follower: follower, following: following }, function(data) {
                    if (data === "Success") {
                        alert("You are now following " + following);
                        location.reload();
                        document.getElementById("follow").textContent = "Following";
                    } else {
                        alert("Failed to follow user.");
                    }
                });
            }
        </script>
    </head>

    <body>
        <header>
            <nav class="nav2">
                <span class="nav2Header"><a href="#">Mentor-Mentee Connection</a></span>
                <span class="secNav">
                    <a href="user.php">Home</a>
                    <a href="classes.html">Classes</a>
                    <a href="meetMentors.html">Mentors</a>
                    <a href="">Notifications</a>
                    <a href="userchat.html">Messages</a>
                </span>
            </nav>
        </header>
        <main>
          <h1>Explore Mentors</h1>
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
                $ment=  htmlspecialchars($row['username']);
                $firstName = htmlspecialchars($row['first-name']);
                $lastname = htmlspecialchars($row['last-name']);
                $country = htmlspecialchars($row['country']);
                $email = htmlspecialchars($row['email']);
                $followers = htmlspecialchars($row['followers']);
                $current = htmlspecialchars($row['experience']);
                $following = htmlspecialchars($row['username']);
                ?>
                <div>
                    <h3>Name: <?php echo $firstName . " " . $lastname; ?></h3>
                    <img style="width:10%; " src="<?php echo 'users/profiles/' . $ment . '.png'; ?>" alt="Profile Image"><p>Country: <?php echo $country; ?></p>
                    <p>Followers: <?php echo $followers; ?></p>
                    <p>Email: <?php echo $email; ?></p>
                    <p>Current employment: <?php echo $current; ?></p>
                    <button id="follow" onclick="followUser('<?php echo $username; ?>', '<?php echo $following; ?>')">Follow</button>
                    <a href="viewprofile.php?user=<?php echo $following; ?>" id="<?php echo $following; ?>">View Profile</a>
                
                </div>
                <?php
            }
            mysqli_stmt_close($stmt);
            mysqli_close($connection1);
            ?>
        </main>
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
    </html>
    <?php
}
?>

<?php
session_start();

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $connection1 = mysqli_connect('localhost', 'root', '', 'mentor-mentee');
    if (!$connection1) {
        die("Connection failed: " . mysqli_connect_error());
    }
} else {
    header("Location: login.html");
    exit();
}

$firstName = '';
$lastname='';
$country='';
$phone='';
$user='';
$sub='';

$sqlquery = "SELECT `first-name`, `last-name`, `country`,`phone`, `username` FROM `mentor-mentee-mentor` WHERE `username`=?";

if ($stmt = mysqli_prepare($connection1, $sqlquery)) {
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_assoc($result)) {
        $firstName = htmlspecialchars($row['first-name']);
		$lastname= htmlspecialchars($row['last-name']);
        $country = htmlspecialchars($row['country']);
        $phone = htmlspecialchars($row['phone']);
        $user = htmlspecialchars($row['username']);
        
    }
    mysqli_stmt_close($stmt);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/user_profiles.css">
    <link rel="stylesheet" href="css/payment.css">
    <link rel="stylesheet" href="css/edit.css">
    <link rel="stylesheet" href="css/subcription.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"/>
    <title>My Profile</title>
    
</head>
<body>
<section id="sidebar">
    <div class="back">
        <a href="user.php">
            <i class="fas fa-arrow-circle-left" style="margin: 0vh 2vh;"></i>
            <span id="back">Back</span>
        </a>
    </div>
    <ul class="side-menu top">
        <li class="active">
            <a href="#section-personal-details">
                <i class='bx bxs-dashboard'></i>
                <span class="text">Personal details</span>
            </a>
        </li>
        <li>
            <a href="#section-subscriptions">
                <i class='bx bxs-bell'></i>
                <span class="text">Notifications</span>
            </a>
        </li>
        
        <li>
            <a href="#section-edit-profile">
                <i class='bx bxs-wrench'></i>
                <span class="text">Edit Passwords</span>
            </a>
        </li>
        <li>
            <a href="#section-help-support">
                <i class='bx bxs-group'></i>
                <span class="text">Help & Support</span>
            </a>
        </li>
        <li>
        <form method="post" action="Mdelete_profile.php" style="color:red">
        <i class="fas fa-trash"></i>
        <input style="background-color: transparent; color: red; padding: 0%; margin-left: -27%; font-size: 15px" type="submit" value="Delete Profile" id="delete">
    </form>
    <script>
        document.getElementById("delete").addEventListener("click", function (event) {
            if (!confirm("Are you sure you want to delete profile?")) {
                event.preventDefault();
            }
        });
    </script>
            
        </li>
        
    </ul>
</section>

<section id="content">
    <nav>
        <i class='bx bx-menu' id="hum"></i>
        <a href="#" class="nav-link">Menu</a>
        <form action="#">
            <div class="form-input">
                <input type="search" placeholder="Search...">
                <button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
            </div>
        </form>
        <input type="checkbox" id="switch-mode" hidden>
        <label for="switch-mode" class="switch-mode"></label>
        
    </nav>

    <main>
        <div class="head-title">
            <div class="left">
                <h1>My Profile</h1>
                <ul class="breadcrumb">
                    <li>
                        <a href="#">Dashboard</a>
                    </li>
                    <li><i class='bx bx-chevron-right'></i></li>
                    <li>
                        <a class="active" href="#active-menu">Personal Details</a>
                    </li>
                </ul>
            </div>
            <a href="#" class="profile">
                <img src="">
            </a>
        </div>
        <div class="table-data">
            <div class="order">
                <div class="head">
                </div>
                <table>
                    <tbody>
                    <div class="personal-details" id="section-personal-details">
                        <div class="profile-pic" style="margin-left:35%">
                            
                            <img style="border-radius: 100%; width:20%" src="users\profiles\<?php echo $user; ?>.png" alt="">
                        </div>
                        <form method="post" action="update.php">
                            <div class="form-group">
                                <label for="name">Name:</label>
                                <input type="text" id="name" name="name" readonly value="<?php echo $firstName; ?>">
                            </div>
                            <div class="form-group">
                                <label for="surname">Surname:</label>
                                <input type="text" id="surname" name="surname" readonly value="<?php echo $lastname; ?>">
                            </div>
                            <div class="form-group">
                                <label for="country">Country:</label>
                                <input type="text" id="address" name="country" readonly value="<?php echo $country; ?>">
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="text" id="dob" name="phone" value="<?php echo $phone; ?>">
                            </div>
                            <div class="form-group">
                                <label for="phone">Username</label>
                                <input type="text" id="user" name="user" value="<?php echo $user; ?>">
                            </div>
                            
                            

                        </form>
                        
                    </div>

                    <div class="subscriptions" style="display:none; " id="section-subscriptions">
                        <div class="wrapper" style="display: inline; ! important">
                            <?php
                                echo "<label style='margin-left: 10%; color:#2270e2'>Follows and Likes</label>";
                                $connection1 = new mysqli('localhost', 'root', '', 'mentor-mentee');
                                if ($connection1->connect_error) {
                                    die("Connection failed: " . $connection1->connect_error);
                                }

                                $sql = "SELECT follower FROM followers WHERE following = ?";
                                if ($stmt = $connection1->prepare($sql)) {
                                    $stmt->bind_param("s", $username);
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<p style='padding-bottom: 5%; margin-left: 10%;'>" . htmlspecialchars($row['follower']) . " started following you.</p>\n";
                                    }
                                    $stmt->close();
                                } else {
                                    echo "Error: " . $connection1->error;
                                }
                                echo "<label style='margin-left: 10%; color:#2270e2; margin-bottom: 1%;'>Messages</label>
                                <a href='chatM.php' style= 'color: white; background-color: #2270e2; text-decoration: none; padding:0.2%; margin-left: 10%; border-radius: 20px; margin-bottom: 5%;'>Open Messages</a>";
                                $sql2 = "SELECT `sender`, `receiver` FROM `conversations` WHERE receiver = ?";
                                if ($stmt = $connection1->prepare($sql2)) {
                                    $stmt->bind_param("s", $username);
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<p style='padding-bottom: 5%; margin-left: 10%;'>" . htmlspecialchars($row['sender']) . " send you a message.</p>\n";
                                    }
                                    $stmt->close();
                                } else {
                                    echo "Error: " . $connection1->error;
                                }
                                
                                echo "<label style='margin-left: 10%; color:#2270e2'>Classes</label>";
                                $sql3 = "SELECT `student`, `date`, `about` FROM `classes`";
                                if ($stmt = $connection1->prepare($sql3)) {
                                    
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<p style='padding-bottom: 5%; margin-left: 10%;'>" . htmlspecialchars($row['student']) . " booked a " . htmlspecialchars($row['about']) . " session for " . htmlspecialchars($row['date'])."
                                            <form method='post'>
                                                <input type='hidden' name='student' value='" . htmlspecialchars($row['student']) . "'>
                                                <input type='hidden' name='about' value='" . htmlspecialchars($row['about']) . "'>
                                                <input type='hidden' name='date' value='" . htmlspecialchars($row['date']) . "'>
                                                <input type='submit' id='confirm' style='background-color: #2270e2; border-radius:20px; border:none; color:white; padding:1%; width: 200px;' value='Confirm Session'>
                                            </form>
                                        </p>";
                                                            }
                                    $stmt->close();
                                } else {
                                    echo "Error: " . $connection1->error;
                                }
                                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                    $student = htmlspecialchars($_POST['student']);
                                    $about = htmlspecialchars($_POST['about']);
                                    $date = htmlspecialchars($_POST['date']);
                                
                                    $stmt = $connection1->prepare("INSERT INTO `conversations` (`sender`, `receiver`, `message`) VALUES (?, ?, ?)");
                                    if ($stmt) {
                                        $message = "I will be taking you for the $about session on $date.";
                                        $stmt->bind_param("sss", $username, $student, $message);
                                
                                        if ($stmt->execute()) {
                                            echo "<script>alert('Session confirmed and message sent.');</script>";
                                        } else {
                                            echo "<script>alert('Failed to confirm session.');</script>";
                                        }
                                        $stmt->close();
                                    } 
                                }
                                else{
                                    echo "Error: " . $connection1->error;
                                }

                                $connection1->close();
                            ?>
                        </div>
                    </div>

                    
                    <div class="edit-profile" style="display:none;" id="section-edit-profile">
                        <h2>Edit Profile</h2>
                        <form>
                            <h5>Current Password</h5>
                            <input type="password" id="password" name="password" required><br><br>
                            <h5>New Password</h5>
                            <input type="password" id="new_password" name="new_password" required><br><br>
                            <h5>Confirm New Password</h5>
                            <input type="password" id="confirm_password" name="confirm_password" required><br><br>
                            <h5>Address</h5>
                            <input type="text" id="address" name="address"><br><br>
                            <h5>Email Address</h5>
                            <input type="email" id="email" name="email" required><br><br><br>
                            <input type="submit" value="Update Profile">
                            <input type="submit" value="Cancel Changes">
                        </form>
                    </div>

                    <div class="help-support" style="display:none;" id="section-help-support">
                        <h2>Help & Support</h2>
                        <div class="one">
                        <form action="https://api.web3forms.com/submit" method="POST">
                            <input
                            type="hidden"
                            name="access_key"
                            value="98fe33f9-54d1-4e4d-8da4-28f34939a327"
                            />
                            <textarea style="border-radius: 10px; padding: 10px; border: 0.5px solid #2270e2;" name="message" id="message" rows="10" cols="125" placeholder="How can we help you?"></textarea>
                            <br>
                            <input type="submit" id="sendMsg" value="SEND MESSAGE"/>
                        </form>
                        </div>
                    </div>
                    
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</section>
<section>
</section>
</body>
</html>
<script src="js/user_profiles.js"></script>

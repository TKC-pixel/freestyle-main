<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: sign.php");
    exit();
}

$username = $_SESSION['username'];

$connection1 = new mysqli('localhost', 'root', '', 'mentor-mentee');
if ($connection1->connect_error) {
    die("Connection failed: " . $connection1->connect_error);
}

$first = "SELECT `subscription` FROM `mentor-mentee-signup` WHERE `username` = ?";
if ($stmt = $connection1->prepare($first)) {
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($subscription);
    $stmt->fetch();
    $stmt->close();

    if ($subscription == "free") {
        $sqlquery = "SELECT `follower`, `following` FROM `followers` WHERE `follower`= ?";
        $followers = [];
        if ($stmt = $connection1->prepare($sqlquery)) {
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $followers[] = $row['following'];
            }
            $stmt->close();
        } else {
            echo "Error: " . $connection1->error;
        }
    } else if ($subscription == "basic" || $subscription == "premium") {
        // Combine queries for basic and premium subscriptions
        $sqlquery = "SELECT `sender`, `receiver` FROM `conversations` WHERE `receiver`= ?";
        $followers = [];
        if ($stmt = $connection1->prepare($sqlquery)) {
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $followers[] = $row['sender'];
            }
            $stmt->close();
        } else {
            echo "Error: " . $connection1->error;
        }

        // Additional queries for premium subscription
        if ($subscription == "premium") {
            // Query 2
            $sqlquery2 = "SELECT `username` FROM `mentor-mentee-signup` WHERE `username`!= ?";
            if ($stmt = $connection1->prepare($sqlquery2)) {
                $stmt->bind_param("s", $username);
                $stmt->execute();
                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()) {
                    $followers[] = $row['username'];
                }
                $stmt->close();
            } else {
                echo "Error: " . $connection1->error;
            }

            // Query 3
            $sqlquery3 = "SELECT `username` FROM `mentor-mentee-mentor`";
            if ($stmt = $connection1->prepare($sqlquery3)) {
                $stmt->execute();
                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()) {
                    $followers[] = $row['username'];
                }
                $stmt->close();
            } else {
                echo "Error: " . $connection1->error;
            }
        }
    }

    $connection1->close();

    $selectedFollowing = '';
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['following'])) {
        $selectedFollowing = htmlspecialchars($_POST['following']);
    }
} else {
    echo "Error: " . $connection1->error;
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.2.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="css/tailwindcss-colors.css">
    <link rel="stylesheet" href="css/chat.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
    <title>Chat</title>
</head>
<body>
    <section class="chat-section">
        <div class="chat-container">
            <aside class="chat-sidebar">
                <a href="user.php" class="chat-sidebar-logo">
                    <i class="fas fa-arrow-circle-left"></i>
                </a>
                <ul class="chat-sidebar-menu">
                    <li class="active"><a href="#" data-title="Chats"><i class="ri-chat-3-line"></i></a></li>
                    <li><a href="#" data-title="Settings"><i class="ri-settings-line"></i></a></li>
                    <li class="chat-sidebar-profile">
                        <button type="button" class="chat-sidebar-profile-toggle">
                        <img style="border-radius: 100%" src="users\profiles\<?php echo $username; ?>.png" alt="">
                        </button>
                        <ul class="chat-sidebar-profile-dropdown">
                            <li><a href="#"><i class="ri-user-line"></i> Profile</a></li>
                            <li><a href="sign.php"><i class="ri-logout-box-line"></i> Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </aside>

            <div class="chat-content">
                <div class="content-sidebar">
                    <div class="content-sidebar-title">Chats</div>
                    <form action="" class="content-sidebar-form" method="POST">
                        <input type="search" class="content-sidebar-input" placeholder="Search...">
                        <button type="submit" class="content-sidebar-submit"><i class="ri-search-line"></i></button>
                    </form>
                    <div class="content-messages">
                        <ul class="content-messages-list">
                            
                            <?php
                            foreach ($followers as $follower) {
                                echo '<div style="display: flex; align-items: center; margin-left: 3%; padding-bottom: 5%">
                                        <img class="content-message-image" src="users/profiles/' . htmlspecialchars($follower) . '.png" alt="" style="margin-right: 10px;">
                                        <span class="content-message-info">
                                            <form method="POST" action="">
                                                <input type="hidden" name="following" value="' . htmlspecialchars($follower) . '">
                                                <button style="border:none; background-color: transparent;" type="submit" class="content-message-name" id="content-message-name">' . htmlspecialchars($follower) . '</button>
                                            </form>
                                        </span>
                                        
                                    </div>';
                            }
                            ?>
                        </ul>
                    </div>
                </div>

                <div class="conversation conversation-default <?php echo $selectedFollowing ? '' : 'active'; ?>">
                    <i class="ri-chat-3-line"></i>
                    <p>Select chat and view conversation!</p>
                </div>

                <div class="conversation <?php echo $selectedFollowing ? 'active' : ''; ?>" id="conversation-2">
                    <div class="conversation-top">
                        <button type="button" class="conversation-back"><i class="ri-arrow-left-line"></i></button>
                        <?php
                        if ($selectedFollowing) {
                            echo '<div class="conversation-user">
                                <img class="content-message-image" src="users/profiles/' . htmlspecialchars($selectedFollowing) . '.png" alt="" style="margin-right: 10px;">
                                <span>' . htmlspecialchars($selectedFollowing) . '</span>
                                  </div>
                                  <div class="conversation-buttons">
                                    <button type="button"><i class="ri-phone-fill"></i></button>
                                    <a href="videoconference.html" style="text-decoration: none;">
                                        <button type="button" id="join-btn" style="background-color: transparent; border: none;">
                                            <i class="ri-vidicon-line"></i>
                                        </button>
                                    </a>
                                    <button type="button"><i class="ri-information-line"></i></button>
                                  </div>';
                        }
                        
                        ?>
                    </div>
                    <div class="conversation-main">
                        <ul class="conversation-wrapper">
                            <?php
                            if ($selectedFollowing) {
                                $connection2 = new mysqli('localhost', 'root', '', 'mentor-mentee');
                                if ($connection2->connect_error) {
                                    die("Connection failed: " . $connection2->connect_error);
                                }

                                $sql1 = "SELECT `sender`, `receiver`, `message`, `timestamp` FROM `conversations` WHERE `sender`= ? AND `receiver`= ? ORDER BY `timestamp` ASC";
                                $sql2 = "SELECT `sender`, `receiver`, `message`, `timestamp` FROM `conversations` WHERE `sender`= ? AND `receiver`= ? ORDER BY `timestamp` ASC";

                                $mergedResults = [];
                                if ($stmt = $connection2->prepare($sql1)) {
                                    $stmt->bind_param("ss", $username, $selectedFollowing);
                                    $stmt->execute();
                                    $result1 = $stmt->get_result();
                                    while ($row = $result1->fetch_assoc()) {
                                        $mergedResults[] = $row;
                                    }
                                    $stmt->close();
                                } else {
                                    echo "Error: " . $connection2->error;
                                }

                                if ($stmt = $connection2->prepare($sql2)) {
                                    $stmt->bind_param("ss", $selectedFollowing, $username);
                                    $stmt->execute();
                                    $result2 = $stmt->get_result();
                                    while ($row = $result2->fetch_assoc()) {
                                        $mergedResults[] = $row;
                                    }
                                    $stmt->close();
                                } else {
                                    echo "Error: " . $connection2->error;
                                }

                                
                                usort($mergedResults, function ($a, $b) {
                                    return strtotime($a['timestamp']) - strtotime($b['timestamp']);
                                });

                                
                                foreach ($mergedResults as $row) {
                                    $isMe = $row['receiver'] === $username;
                                    $messageClass = $isMe ? 'me' : 'other'; 
                                    $messageTime = date("H:i", strtotime($row['timestamp']));
                                    $messageSide = $isMe ? 'right' : 'left'; 
                                    echo '<li class="conversation-item ' . $messageClass . '">
                                            <div class="conversation-item-side ' . $messageSide . '">
                                            </div>
                                            <div class="conversation-item-content">
                                                <div class="conversation-item-wrapper">
                                                    <div class="conversation-item-box">
                                                        <div class="conversation-item-text">
                                                            <p>' . htmlspecialchars($row['message']) . '</p> 
                                                            <div class="conversation-item-time">' . $messageTime . '</div>
                                                        </div>
                                                        <div class="conversation-item-dropdown">
                                                            <button type="button" class="conversation-item-dropdown-toggle"><i class="ri-more-2-line"></i></button>
                                                            <ul class ="conversation-item-dropdown-list">
                                                                <li><a href="#"><i class="ri-share-forward-line"></i> Forward</a></li>
                                                                <li><a href="#"><i class="ri-delete-bin-line"></i> Delete</a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>';
                                }
                                
                                
                                $connection2->close();
                            }
                            ?>
                        </ul>
                    </div>
                    <div class="conversation-bottom">
                        
                        <form method="post" style="width: 100%; display: flex; align-items: center;">
                            <input type="hidden" name="receiver" value="<?php echo htmlspecialchars($selectedFollowing); ?>">
                            <div class="conversation-form-group" style="flex: 1;">
                                <input type="text" name="message" style="width: 100%;" class="conversation-input" placeholder="Type here.....">
                                
                            </div>
                            <button type="submit" class="conversation-submit"><i class="ri-send-plane-2-fill"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="js/chat.js"></script>
    <script src="js/videoconference.js"></script>
</body>
</html>
<?php
            $conn = new mysqli("localhost", "root", "", "mentor-mentee");
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['message'], $_POST['receiver'])) {
                $message = htmlspecialchars($_POST['message']);
                $receiver = htmlspecialchars($_POST['receiver']);
                $sql = "INSERT INTO conversations(`sender`, `receiver` , `message`) VALUES ('$username', '$receiver', '$message')";

                if ($conn->query($sql) === TRUE) {
                    echo "New record created successfully";
                } 
                else {
                    echo "Error: ". $sql. "<br>". $conn->error;
                }
            }
?>

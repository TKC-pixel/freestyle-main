<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

$username = $_SESSION['username'];
$connection1 = mysqli_connect('localhost', 'root', '', 'mentor-mentee');
if (!$connection1) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['follower']) && isset($_POST['following'])) {
    $follower = $_POST['follower'];
    $following = $_POST['following'];
    
    
    $sqlCheckFollower = "SELECT `follower` FROM `followers` WHERE `follower` = ? AND `following` = ?";
    if ($checkStmt = mysqli_prepare($connection1, $sqlCheckFollower)) {
        mysqli_stmt_bind_param($checkStmt, "ss", $follower, $following);
        mysqli_stmt_execute($checkStmt);
        mysqli_stmt_store_result($checkStmt);
        
        if (mysqli_stmt_num_rows($checkStmt) == 0) {
            
            $sqlUpdateFollowers = "UPDATE `mentor-mentee-signup` SET `followers` = `followers` + 1 WHERE `username` = ?";
            if ($updateStmt = mysqli_prepare($connection1, $sqlUpdateFollowers)) {
                mysqli_stmt_bind_param($updateStmt, "s", $following);
                mysqli_stmt_execute($updateStmt);
                mysqli_stmt_close($updateStmt);
            } else {
                echo "Error: " . mysqli_error($connection1);
                mysqli_stmt_close($checkStmt);
                mysqli_close($connection1);
                exit();
            }
            
            $sqlInsertFollower = "INSERT INTO `followers`(`follower`, `following`) VALUES (?, ?)";
            if ($insertStmt = mysqli_prepare($connection1, $sqlInsertFollower)) {
                mysqli_stmt_bind_param($insertStmt, "ss", $follower, $following);
                mysqli_stmt_execute($insertStmt);
                mysqli_stmt_close($insertStmt);
                echo "Success";
            } else {
                //echo "Error: " . mysqli_error($connection1);
            }
        } else {
            echo "This follower is already following the user.";
        }
        
        mysqli_stmt_close($checkStmt);
    } else {
        //echo "Error: " . mysqli_error($connection1);
    }
    
    mysqli_close($connection1);
} else {
    echo "Invalid request.";
}
?>

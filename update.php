<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    session_start();
    $username = $_SESSION['username'];
    $phone=$_POST['phone'];
    $user=$_POST['user'];

    $conn = new mysqli("localhost", "root", "", "mentor-mentee");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("UPDATE `mentor-mentee-signup` SET `username`=?, `phone`=? WHERE `username`=?");
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("sss", $user, $phone, $username);

    if ($stmt->execute()) {
        header("Location: sign.php");
        
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
    $conn->close();
}
?>
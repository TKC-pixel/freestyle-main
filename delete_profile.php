<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    session_start();
    $username = $_SESSION['username'];

    $conn = mysqli_connect("localhost", "root", "", "mentor-mentee");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "DELETE FROM `mentor-mentee-signup` WHERE `username` = '$username'";
    if (mysqli_query($conn, $sql)) {
        header("Location: sign.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>

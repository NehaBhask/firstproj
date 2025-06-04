<?php
session_start();
include("connection.php");

if (isset($_POST['followed_id'])) {
    $follower_id = $_SESSION['user_id'];
    $followed_id = intval($_POST['followed_id']);

    $check = mysqli_query($c, "SELECT * FROM followers WHERE follower_id=$follower_id AND followed_id=$followed_id");
    if (mysqli_num_rows($check) == 0) {
        mysqli_query($c, "INSERT INTO followers (follower_id, followed_id) VALUES ($follower_id, $followed_id)");
        echo "Followed successfully";
    } else {
        echo "Already following";
    }
}
?>

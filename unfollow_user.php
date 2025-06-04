<?php
session_start();
include("connection.php");

if (isset($_POST['username'])) {
    $follower_id = $_SESSION['user_id'];
    $username = mysqli_real_escape_string($c, $_POST['username']);

    $res = mysqli_query($c, "SELECT user_id FROM register WHERE username = '$username'");
    if ($row = mysqli_fetch_assoc($res)) {
        $followed_id = $row['user_id'];
        mysqli_query($c, "DELETE FROM followers WHERE follower_id=$follower_id AND followed_id=$followed_id");
        echo "Unfollowed successfully";
    }
}
?>

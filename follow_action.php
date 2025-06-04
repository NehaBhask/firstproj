<?php
session_start();
include("connection.php");

if (!isset($_SESSION['user_id'])) {
    echo "Login first.";
    exit;
}

$user_id = $_SESSION['user_id'];
$target_id = intval($_POST['target_id']);
$action = $_POST['action'];

if ($action == 'follow') {
    $check = mysqli_query($c, "SELECT * FROM followers WHERE follower_id=$user_id AND followed_id=$target_id");
    if (mysqli_num_rows($check) == 0) {
        mysqli_query($c, "INSERT INTO followers (follower_id, followed_id) VALUES ($user_id, $target_id)");
    }
} elseif ($action == 'unfollow') {
    mysqli_query($c, "DELETE FROM followers WHERE follower_id=$user_id AND followed_id=$target_id");
}
?>

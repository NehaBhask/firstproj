<?php
session_start();
include("connection.php");

if (!isset($_SESSION['user_id'])) {
    echo "Please log in.";
    exit;
}

$user_id = $_SESSION['user_id'];

// Followers: who follows the user
$followerQuery = "SELECT r.username FROM followers f JOIN register r ON f.follower_id = r.user_id WHERE f.followed_id = $user_id";
$followerRes = mysqli_query($c, $followerQuery);

// Following: whom the user follows
$followingQuery = "SELECT r.username FROM followers f JOIN register r ON f.followed_id = r.user_id WHERE f.follower_id = $user_id";
$followingRes = mysqli_query($c, $followingQuery);

echo "<h3>Followers</h3><ul>";
while ($row = mysqli_fetch_assoc($followerRes)) {
    echo "<li>" . htmlspecialchars($row['username']) . "</li>";
}
echo "</ul>";

echo "<h3>Following</h3><ul>";
while ($row = mysqli_fetch_assoc($followingRes)) {
    echo "<li>" . htmlspecialchars($row['username']) . " <button onclick='unfollowUser(\"" . $row['username'] . "\")'>Unfollow</button></li>";
}
echo "</ul>";
?>

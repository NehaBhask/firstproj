<?php
session_start();
include("connection.php");

if (!isset($_SESSION['user_id'])) exit;

$user_id = $_SESSION['user_id'];
$query = mysqli_real_escape_string($c, $_GET['q']);

$sql = "SELECT user_id, username FROM register WHERE username LIKE '%$query%' AND user_id != $user_id";
$res = mysqli_query($c, $sql);

while ($row = mysqli_fetch_assoc($res)) {
    echo "<div>" . htmlspecialchars($row['username']) . 
         " <button onclick='followUser(" . $row['user_id'] . ")'>Follow</button></div>";
}
?>

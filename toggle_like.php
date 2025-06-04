<?php
session_start();
include("connection.php");

$user_id = $_SESSION['user_id'];
$note_id = $_POST['note_id'] ?? 0;

$check = $c->prepare("SELECT * FROM likes WHERE user_id = ? AND note_id = ?");
$check->bind_param("ii", $user_id, $note_id);
$check->execute();
$res = $check->get_result();

if ($res->num_rows > 0) {
    $del = $c->prepare("DELETE FROM likes WHERE user_id = ? AND note_id = ?");
    $del->bind_param("ii", $user_id, $note_id);
    $del->execute();
    echo "Unliked";
} else {
    $ins = $c->prepare("INSERT INTO likes(user_id, note_id) VALUES (?, ?)");
    $ins->bind_param("ii", $user_id, $note_id);
    $ins->execute();
    echo "Liked";
}
?>

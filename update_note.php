<?php
session_start();
include("connection.php");

if (!isset($_SESSION['user_id'])) {
    echo "Unauthorized access.";
    exit;
}

$note_id = intval($_POST['id']);
$title = $_POST['title'];
$content = $_POST['content'];

$query = "UPDATE note SET title='$title', content='$content' WHERE id=$note_id AND userfk=" . $_SESSION['user_id'];
if (mysqli_query($c, $query)) {
    echo "Note updated.";
} else {
    echo "Error updating note.";
}
?>


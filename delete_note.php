<?php
session_start();
include("connection.php");

if (!isset($_SESSION['user_id'])) {
    echo "Unauthorized access.";
    exit;
}

$note_id = intval($_POST['id']);

$query = "DELETE FROM note WHERE id=$note_id AND userfk=" . $_SESSION['user_id'];
if (mysqli_query($c, $query)) {
    echo "Note deleted.";
} else {
    echo "Error deleting note.";
}
?>


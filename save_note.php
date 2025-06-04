<?php
session_start();
include("connection.php");
$title = $_POST['title'];
$people = $_POST['people'];
$places = $_POST['place'];
$experiences = $_POST['experience'];
$content = $_POST['content'];
$emotion = $_POST['emotion'];
$userfk=$_SESSION['user_id'];
$sql = "INSERT INTO note (title, people, places, experiences, content, emotion,userfk)
        VALUES (?, ?, ?, ?, ?, ?,?)";

$stmt = $c->prepare($sql);
$stmt->bind_param("ssssssi", $title, $people, $places, $experiences, $content, $emotion,$userfk);

if ($stmt->execute()) {
    echo "Note saved successfully.";
} else {
    echo "Error: " . $c->error;
}

$stmt->close();
$c->close();
?>

<?php
session_start();
include("connection.php");

$current_user = $_SESSION['user_id'];

$query = "SELECT n.id, n.title, n.content, r.username,
         (SELECT COUNT(*) FROM likes l WHERE l.note_id = n.id) AS like_count,
         (SELECT COUNT(*) FROM likes l WHERE l.note_id = n.id AND l.user_id = ?) AS liked
         FROM followers f
         JOIN note n ON f.followed_id = n.userfk
         JOIN register r ON r.user_id = n.userfk
         WHERE f.follower_id = ? ";

$stmt = $c->prepare($query);
$stmt->bind_param("ii", $current_user, $current_user);
$stmt->execute();
$result = $stmt->get_result();

while ($note = $result->fetch_assoc()) {
    $like_text = $note['liked'] ? 'Unlike' : 'Like';
    echo "<div class='note-card' id='note-{$note['id']}'>
            <h3>{$note['title']}</h3>
            <p><em>By: {$note['username']}</em></p>
            <p>{$note['content']}</p>
            <button onclick='toggleLike({$note['id']})'>{$like_text} ({$note['like_count']})</button>
          </div>";
}
?>

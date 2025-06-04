<?php
session_start();
include("connection.php");

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["error" => "User not logged in"]);
    exit;
}

$user_id = $_SESSION['user_id'];

$query = "SELECT emotion, COUNT(*) as count FROM note WHERE userfk = ? GROUP BY emotion";
$stmt = $c->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$emotion_counts = [
    'happy' => 0,
    'sad' => 0,
    'angry' => 0,
    'excited' => 0,
    'calm' => 0
];

while ($row = $result->fetch_assoc()) {
    $emotion = strtolower($row['emotion']);
    if (array_key_exists($emotion, $emotion_counts)) {
        $emotion_counts[$emotion] = (int)$row['count'];
    }
}

// Pass this to JavaScript as JSON
echo json_encode($emotion_counts);
?>


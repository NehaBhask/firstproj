<?php
session_start();
  include("connection.php");
  echo '
<style>
.note-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 20px;
    padding: 20px;
}
.note-card {
    background-color: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 16px;
    transition: transform 0.2s ease-in-out;
}
.note-card:hover {
    transform: translateY(-5px);
}
.note-card h3 {
    margin-top: 0;
    color: #2c3e50;
}
.note-content {
    background-color: #f0f0f0;
    padding: 10px;
    border-radius: 6px;
    margin: 10px 0;
    max-height: 150px;
    overflow-y: auto;
}
.note-time {
    font-size: 0.8em;
    text-align: right;
    color: #888;
}
</style>
';
  if (!isset($_SESSION['user_id'])) {
    echo "<p>Please log in to see your notes.</p>";
    exit;
}
$user_id = intval($_SESSION['user_id']);

$query = "SELECT * FROM note WHERE userfk = '$user_id' ";
$res = mysqli_query($c, $query);
        //$sq = "SELECT * FROM note";
        //$res =mysqli_query($c,$sq);
        if (!$res) {
    die("Query error: " . mysqli_error($c));
}
        $row=mysqli_num_rows($res);

                
            if($row!=0)
            {
                echo "<div class='note-grid'>";
                while($prim=mysqli_fetch_assoc($res))
            {
                echo '<div class="note-card" id="' . $prim['id'] . '">';
                echo "<h3 contentEditable='false' class='note-title'>".htmlspecialchars($prim['title'])."</h3>";
                echo "<p><strong>People:</strong>".htmlspecialchars($prim['people'])."</p>";
                echo "<p><strong>Places:</strong>".htmlspecialchars($prim['places'])."</p>";
                echo "<p><strong>Experiences:</strong>".htmlspecialchars($prim['experiences'])."</p>";
                echo "<p><strong>Emotion:</strong> <span class='emotion'>".htmlspecialchars($prim['emotion'])."</span></p>";
                echo "<p class='timestamp'>Created: ".htmlspecialchars($prim['created_at'])."</p>";
                echo "<div contentEditable='false' class='note-content'>".$prim['content'] ."</div>";
                echo "<button onclick='editNote(" . $prim['id'] . ")'>Edit</button>";
                echo "<button onclick='deleteNote(" .$prim['id'].")'>Delete</button>";
                echo "<button onclick='saveNote(" . $prim['id'] . ")'>Save</button>";
                echo "</div>";
                echo "<br>";
                } 
                echo "</div>";
            }
            else {
            echo "<p>No notes found.</p>";
        }

?>

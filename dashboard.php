<?php
// Now you can access $_SESSION['user_id'] safely
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

</head>
<body>
    <nav class="sidebar close">
        <header>
            <div class="text header-text">
                <span class="name">Memory Web</span>
            </div>
            <i class='bx bx-chevron-right toggle'></i>
        </header>
        <div class="menu-bar">
            <div class="menu">
                <ul class="menu-links">
                    <li class="nav-link">
                        <a href="#home">
                            <i class='bx bx-home-alt icon'></i>
                            <span class="nav-text">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="#notes">
                            <i class='bx bx-notepad icon'></i>
                            <span class="nav-text">Create Notes</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="#graph">
                            <i class='bx bx-bar-chart-alt icon'></i>
                            <span class="nav-text">Emotion graph</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="#friends">
                            <i class='bx bxs-heart icon'></i>
                            <span class="nav-text">Followers</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="#saved">
                            <i class='bx bxs-save icon'></i>
                            <span class="nav-text">Saved notes</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="#following-notes">
                            <i class='bx bxs-heart icon'></i>
                            <span class="nav-text">Notes of users you follow</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="bottom-content">
                <li class="">
                    <a href="#logout">
                        <i class='bx bx-log-out icon'></i>
                        <span class="nav-text">Logout</span>
                    </a>
                </li>
            </div>
          </div>
    </nav>
    <section id="home" class="tab">
        <h2>Dashboard</h2>
    </section>
    <section id="notes" class="tab">
        <h2>Create Note</h2>
        <form id="noteForm" method="POST">
          <input type="text" id="noteTitle" placeholder="Title" name="title" required />
          <input type="text" id="people" placeholder="People (comma separated)" name="people"/>
          <input type="text" id="places" placeholder="Places (comma separated)" name="place" />
          <input type="text" id="experiences" placeholder="Experiences (comma separated)" name="experience" />
        <div class="note-editor">
            <div class="toolbar">
              
              <select id="emotionSelect" name="emotion" onchange="setEmotion(this.value)">
                <option value="">😊 Add Emotion</option>
                <option value="happy">😊 Happy</option>
                <option value="sad">😢 Sad</option>
                <option value="angry">😠 Angry</option>
                <option value="excited">🤩 Excited</option>
                <option value="calm">😌 Calm</option>
              </select>
            </div>
          
            <div id="editor" class="notebook" contenteditable="true">
                
            </div>
          
            <div id="emotionTag"></div>
          </div>
          
          <button type="submit" name="save">Save Note</button>
          </form>
      </section>
      <section id="graph" class="tab">
        <h2>Emotion Graph</h2>
        <canvas id="emotionChart" width="400" height="200"></canvas>
      </section>
      <section id="friends" class="tab">
        <h2>Followers and Following</h2>
        <input type="text" id="userSearch" placeholder="Search users to follow..." onkeyup="searchUsers()" />

         <div id="searchResults"></div>
         <div id="followersList"></div>
      </section>
      <section id="saved" class="tab">
        <h2>Saved notes</h2>
        <div id="saved-notes-container"></div>
      </section>
      <section id="following-notes" class="tab">
       <h2>Following Users' Notes</h2>
       <div id="following-notes-container"></div>
      </section>
      <section id="logout" class="tab">
      </section>
    <script src="dash.js"></script>
    <script>
function execCmd(command) {
    document.execCommand(command, false, null);
}

function setEmotion(emotion) {
    document.getElementById('emotionTag').innerText = "Emotion: " + emotion;
}

document.getElementById("noteForm").addEventListener("submit", function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    const content = document.getElementById("editor").innerHTML;
    const emotion = document.getElementById("emotionSelect").value;
    let cleanContent = content.replace(/<div><br><\/div>/g, '') // empty lines
                             .replace(/<div>/g, '')             // opening div
                             .replace(/<\/div>/g, '\n');

    formData.append("content", cleanContent);
    formData.append("emotion", emotion);

    fetch("save_note.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.text())
    .then(result => {
        alert(result);
        document.getElementById("noteForm").reset();
        document.getElementById("editor").innerHTML = "";
        document.getElementById("emotionTag").innerText = "";
    })
    .catch(error => {
        console.error("Error:", error);
    });
});
document.querySelector('a[href="#saved"]').addEventListener('click', function () {
    fetch('fetch_notes.php')
        .then(response => response.text())
        .then(data => {
            document.getElementById('saved-notes-container').innerHTML = data;
        })
        .catch(error => {
            document.getElementById('saved-notes-container').innerHTML = "<p>Error loading notes.</p>";
            console.error("Fetch error:", error);
        });
});
</script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const logoutSection = document.querySelector('a[href="#logout"]');
    if (logoutSection) {
        logoutSection.addEventListener("click", function(e) {
            e.preventDefault();
            if (confirm("Are you sure you want to logout?")) {
                window.location.href = "index-login.php";
            }
        });
    }
});
</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
    fetch("emotion-data.php")  // Save the above PHP code as get_emotion_data.php
        .then(response => response.json())
        .then(data => {
            const ctx = document.getElementById('emotionChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Happy', 'Sad', 'Angry', 'Excited', 'Calm'],
                    datasets: [{
                        label: 'Emotion Frequency',
                        data: [
                            data.happy,
                            data.sad,
                            data.angry,
                            data.excited,
                            data.calm
                        ],
                        backgroundColor: [
                            'rgba(255, 206, 86, 0.6)',
                            'rgba(54, 162, 235, 0.6)',
                            'rgba(255, 99, 132, 0.6)',
                            'rgba(255, 159, 64, 0.6)',
                            'rgba(75, 192, 192, 0.6)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });
        })
        .catch(error => console.error("Error loading emotion data:", error));
});
</script>
<script src="notes.js"></script>
<script src="fol.js"></script>
<script>
document.querySelector("a[href='#following-notes']").addEventListener("click", loadFollowingNotes);

function loadFollowingNotes() {
    fetch("following_notes.php")
    .then(res => res.text())
    .then(data => {
        document.getElementById("following-notes-container").innerHTML = data;
    });
}
</script>
<script>
    function toggleLike(noteId) {
    fetch("toggle_like.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "note_id=" + encodeURIComponent(noteId)
    })
    .then(response => response.text())
    .then(data => {
        console.log(data);
        // Optionally reload or update like count dynamically
        loadFollowingNotes(); // If you use a dynamic loader
    })
    .catch(err => console.error("Error liking note:", err));
}
</script>
</body>
</html>

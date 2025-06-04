const body=document.querySelector("body"),
   sidebar=body.querySelector(".sidebar"),
   searchBtn=body.querySelector(".search-box"),
   toggle=body.querySelector(".toggle");
   toggle.addEventListener("click",()=>{
    sidebar.classList.toggle("close");
   });
   function showTabFromHash() {
    const hash = window.location.hash.substring(1) || 'home';
    document.querySelectorAll(".tab").forEach(tab => tab.classList.remove("active"));
    const activeTab = document.getElementById(hash);
    if (activeTab) activeTab.classList.add("active");
  }
  
  window.addEventListener("hashchange", showTabFromHash);
  window.addEventListener("DOMContentLoaded", showTabFromHash);
  function execCmd(command) {
    document.execCommand(command, false, null);
  }
  
  function setEmotion(value) {
    const emotionTag = document.getElementById('emotionTag');
    if (value) {
      const emojis = {
        happy: '😊',
        sad: '😢',
        angry: '😠',
        excited: '🤩',
        calm: '😌'
      };
      emotionTag.innerText = `Emotion: ${emojis[value]} ${value}`;
    } else {
      emotionTag.innerText = '';
    }
  }
  document.getElementById("showNotesBtn").addEventListener("click", function () {
    const notesList = document.getElementById("notesList");

    // Toggle visibility
    if (notesList.style.display === "none") {
        notesList.style.display = "block";
        loadNotes();
        this.textContent = "Hide Saved Notes";
    } else {
        notesList.style.display = "none";
        this.textContent = "Show Saved Notes";
    }
});

document.addEventListener("DOMContentLoaded", () => {
    document.getElementById("loadNotesBtn").addEventListener("click", () => {
        fetch("fetch_notes.php")
            .then(response => response.json())
            .then(data => {
                const container = document.getElementById("savedNotesContainer");
                container.innerHTML = "";

                if (!data.length) {
                    container.innerHTML = "<p>No saved notes found.</p>";
                    return;
                }

                data.forEach(note => {
                    const div = document.createElement("div");
                    div.classList.add("note-card");
                    div.innerHTML = `
                        <h3>${note.title}</h3>
                        <p><strong>People:</strong> ${note.people}</p>
                        <p><strong>Places:</strong> ${note.places}</p>
                        <p><strong>Experiences:</strong> ${note.experiences}</p>
                        <p><strong>Emotion:</strong> ${note.emotion}</p>
                        <p><strong>Created At:</strong> ${note.created_at}</p>
                        <div class="note-content">${note.content}</div>
                        <hr>
                    `;
                    container.appendChild(div);
                });
            })
            .catch(error => {
                console.error("Error loading notes:", error);
            });
    });
});


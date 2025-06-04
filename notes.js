function editNote(noteId) {
    const card = document.getElementById(noteId);
    const title = card.querySelector('.note-title');
    const content = card.querySelector('.note-content');
    const saveBtn = card.querySelector('button:nth-child(3)'); // Save button
    title.setAttribute('contentEditable', 'true');
    content.setAttribute('contentEditable', 'true');
    saveBtn.style.display = 'inline';
}

function saveNote(noteId) {
    const card = document.getElementById(noteId);
    const title = card.querySelector('.note-title').innerText;
    const content = card.querySelector('.note-content').innerHTML;

    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'update_note.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        alert(this.responseText);
        location.reload();
    };
    xhr.send('id=' + noteId + '&title=' + encodeURIComponent(title) + '&content=' + encodeURIComponent(content));
}

function deleteNote(noteId) {
    if (!confirm('Are you sure you want to delete this note?')) return;

    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'delete_note.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        alert(this.responseText);
        location.reload();
    };
    xhr.send('id=' + noteId);
}

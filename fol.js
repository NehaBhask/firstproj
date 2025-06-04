function loadFollowers() {
    fetch('fetch_friends.php')
        .then(res => res.text())
        .then(html => document.getElementById('followersList').innerHTML = html);
}

function searchUsers() {
    const query = document.getElementById('userSearch').value;
    if (query.length > 0) {
        fetch('search_users.php?q=' + encodeURIComponent(query))
            .then(res => res.text())
            .then(data => document.getElementById('searchResults').innerHTML = data);
    } else {
        document.getElementById('searchResults').innerHTML = '';
    }
}

function followUser(userId) {
    fetch('follow_user.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'followed_id=' + userId
    }).then(res => res.text()).then(alert).then(loadFollowers);
}

function unfollowUser(username) {
    fetch('unfollow_user.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'username=' + encodeURIComponent(username)
    }).then(res => res.text()).then(alert).then(loadFollowers);
}

document.querySelector("a[href='#friends']").addEventListener("click", loadFollowers);

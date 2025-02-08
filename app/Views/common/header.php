
<?= $this->section('header_content') ?>

<header>
    <div class="profile-menu">
        <div class="profile-icon" onclick="toggleDropdown()">
            <img src="uploads/<?= $user['image']?>" alt="Profile" style="width: 30px">
            <span class="username"><?= $user['username']?></span>
            <span class="arrow">&#9662;</span>
        </div>
        <div class="dropdown-menu" id="dropdown-menu">

            <a href="/settings">Settings</a>
            <a href="/logout">Logout</a>
        </div>
    </div>
</header>

<script>
     function toggleDropdown() {

const dropdownMenu = document.getElementById('dropdown-menu');
dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';
}

window.onclick = function (event) {
if (!event.target.matches('.profile-icon, .profile-icon *')) {
    const dropdownMenu = document.getElementById('dropdown-menu');
    if (dropdownMenu.style.display === 'block') {
        dropdownMenu.style.display = 'none';
    }
}
};
</script>



<?= $this->endSection(); ?>
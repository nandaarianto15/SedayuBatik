function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('main-content');

    sidebar.classList.toggle('hide');
    mainContent.classList.toggle('full-width');
}

function toggleDropdown() {
    const dropdown = document.getElementById('dropdown');
    dropdown.classList.toggle('show');
}

window.onclick = function(event) {
    if (!event.target.matches('.admin')) {
        const dropdown = document.getElementById('dropdown');
        if (dropdown.classList.contains('show')) {
        dropdown.classList.remove('show');
        }
    }
}
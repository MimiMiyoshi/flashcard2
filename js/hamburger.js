function toggleMenu() {
    const menu = document.querySelector('.menu-container');
    const overlay = document.querySelector('.overlay');
    const isActive = menu.classList.contains('active');

    if (isActive) {
        menu.classList.remove('active');
        overlay.classList.remove('active');
    } else {
        menu.classList.add('active');
        overlay.classList.add('active');
    }
}

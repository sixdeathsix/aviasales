let logout = document.querySelector('.logout');

logout.addEventListener('click', () => {
    localStorage.clear();
    location.href = 'database/logout.php';
});
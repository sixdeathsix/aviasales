let notifications = document.querySelectorAll('.notification');
let btn_more = document.querySelector('.more');

let hides = JSON.parse(localStorage.getItem('hides')) || [];

let items = 5;

if (notifications.length <= items) {
    btn_more.classList.add('none');
}

if (notifications.length === 0) {
    document.querySelector('.profile-orders').innerHTML = `<h2 class="tac">Уведомлений нет</h2>`;
}

notifications.forEach((n, i) => {

    if (i >= items) {
        n.classList.add('none');
    } else {
        n.classList.remove('none');
    }

});

btn_more.addEventListener('click', () => {
    notifications.forEach((u, i) => {
        u.classList.remove('none');
    });
    btn_more.classList.add('none');
});

window.addEventListener('beforeunload', (event) => {
    notifications.forEach(n => {
        if (!hides.includes(n.getAttribute('data-id'))) {
            hides.push(n.getAttribute('data-id'));
        }
    });

    localStorage.setItem('hides', JSON.stringify(hides));
});
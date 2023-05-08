let notifications = document.querySelectorAll('.notification');
let btn_more = document.querySelector('.more');

let hides = JSON.parse(localStorage.getItem('hides')) || [];

let items = 1;

if (notifications.length - hides.length <= items) {
    btn_more.classList.add('none');
}

if (notifications.length === hides.length) {
    document.querySelector('.profile-orders').innerHTML = `<h2 class="tac">Уведомлений нет</h2>`;
}

notifications.forEach((n, i) => {

    if (hides.includes(n.getAttribute('data-id'))) {
        n.classList.add('none');
    } else {
        if (i >= items) {
            n.classList.add('none');
        } else {
            n.classList.remove('none');
        }
    }

});

btn_more.addEventListener('click', () => {
    notifications.forEach((u, i) => {
        if (!hides.includes(u.getAttribute('data-id'))) {
            u.classList.remove('none');
        }
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
let review = document.querySelectorAll('.rew');
let btn_more = document.querySelector('.more');
let stars = document.querySelectorAll('.star-rate');

let items = 5;
let counter = items;

if (review.length < items) {
    btn_more.classList.add('none');
}

const startValue = () => {
    review.forEach((u, i) => {
        if (i >= items) {
            u.classList.add('none');
        } else {
            u.classList.remove('none');
        }
    });
}

startValue();

btn_more.addEventListener('click', () => {
    counter = counter + items;
    review.forEach((u, i) => {
        if (i <= counter - 1) {
            u.classList.remove('none');
        }
        if (review.length < counter) {
            btn_more.classList.add('none');
        }
    });
});
let btnUp = document.querySelector('.btn-up');

window.addEventListener('scroll', () => {
    const scrollY = window.scrollY || document.documentElement.scrollTop;
    scrollY > 800 ? btnUp.classList.remove('btn-up_hide') : btnUp.classList.add('btn-up_hide');
});

btnUp.addEventListener('click', () => {
    window.scrollTo({
        top: 0,
        left: 0
    });
});
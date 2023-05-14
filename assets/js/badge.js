let badge = document.querySelectorAll('.badge');

let not_count = JSON.parse(localStorage.getItem('hides')) || [];

if (not_count.length.toString() !== badge[0].innerText) {
    badge.forEach(b => {
        b.innerText = parseFloat(b.innerText) - not_count.length;
        b.classList.remove('none')
    });
}
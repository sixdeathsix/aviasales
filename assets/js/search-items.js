let search_input = document.getElementById('search');
let array_list = document.querySelectorAll('.search-list');
let pages = document.querySelector('.pagination');

let items = 10;

const startValue = () => {
    array_list.forEach((u, i) => {
        if (i >= items) {
            u.parentNode.classList.add('none');
        } else {
            u.parentNode.classList.remove('none');
        }
    });
}

const paginator = () => {
    if (array_list.length > items) {

        startValue();

        for (let i = 0; i <= array_list.length / items; i++) {
            pages.innerHTML += `
            <a
                class="page-number <?= $_GET['page'] == $i ? 'selected' : '' ?>"
            >
                ${i + 1}
            </a>
        `
        }

        let page = document.querySelectorAll('.page-number');

        page.forEach((p) => {

            p.addEventListener('click', (e) => {
                array_list.forEach((u, i) => {
                    if (i >= (e.target.innerText - 1) * items && i < e.target.innerText * items) {
                        u.parentNode.classList.remove('none');
                    } else {
                        u.parentNode.classList.add('none');
                    }
                });
            });

        })
    }
}

paginator();

search_input.addEventListener('input', (e) => {

    if (e.target.value.length > 3) {
        array_list.forEach((u) => {
            if (!u.innerText.toLowerCase().includes(e.target.value.toLowerCase())) {
                u.parentNode.classList.add('none');
            } else {
                u.parentNode.classList.remove('none');
            }
            pages.classList.add('none');
        });
    } else {
        pages.classList.remove('none');
        startValue();
    }

});
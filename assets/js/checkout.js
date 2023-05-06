let luggage_checkbox = document.querySelectorAll('.luggage-checkbox');
let luggage_text = document.querySelectorAll('.luggage-text');
let food_checkbox = document.querySelectorAll('.food-checkbox');
let food_text = document.querySelectorAll('.food-text');
let checkout_form = document.querySelectorAll('.checkout-form');
let checkout_price = document.getElementById('checkout-price');
let price_input = document.getElementById('price-input');
let pass_btn = document.querySelectorAll('.btn-pass');
let select_lists = document.querySelectorAll('.select-seat');
let birthCertificate = document.querySelectorAll('.birth-certificate');
let passportCheckout = document.querySelectorAll('.passport-checkout');
let checkbox = document.querySelectorAll('.is-small-baby');

let ticket_price = checkout_price.innerText / checkout_form.length;
let luggage = (parseFloat(ticket_price) * 0.15);
let food = (parseFloat(ticket_price) * 0.10);
let seat = (parseFloat(ticket_price) * 0.30);

// select_lists.forEach(s => {
//     s.addEventListener('change', e => {
//         for (let i = 0; i < select_lists.length; i++) {
//             for (let x = 0; x < select_lists[i].children.length; x++) {
//                 if (s.value === 'null') {
//                     s.children[x].disabled = false;
//                 }
//                 if (select_lists[i].children[x].value === s.value && select_lists[i].children[x].value !== 'null') {
//                     select_lists[i].children[x].disabled = true;
//                 }
//             }
//         }
//     });
// });

// let selected_values = [];
//
// for (let i = 0; i < select_lists.length; i++) {
//     select_lists[i].addEventListener('change', function() {
//         let selected_option = this.options[this.selectedIndex];
//         let selected_value = selected_option.value;
//
//         if (!selected_option.disabled) {
//             if (selected_values.indexOf(selected_value) < 0) {
//                 selected_values.push(selected_value);
//             } else {
//                 selected_values.splice(selected_values.indexOf(selected_value), 1);
//             }
//         }
//
//         for (let i = 0; i < select_lists.length; i++) {
//             let options = select_lists[i].options;
//             for (let j = 0; j < options.length; j++) {
//                 let option_value = options[j].value;
//                 if (option_value !== '') {
//                     let index = selected_values.indexOf(option_value);
//                     if (index >= 0 && index !== i) {
//                         options[j].disabled = true;
//                     } else {
//                         options[j].disabled = false;
//                     }
//                 }
//             }
//         }
//     });
// }

luggage_text.forEach(lt => {
    lt.innerText = lt.innerText + `(+${luggage}Р)`;
});

food_text.forEach(ft => {
    ft.innerText = ft.innerText + `(+${food}Р)`;
});

luggage_checkbox.forEach(lg => {
    lg.addEventListener('change', () => {
        if (lg.checked) {
            checkout_price.innerText = parseFloat(checkout_price.innerText) + luggage;
        } else {
            checkout_price.innerText = parseFloat(checkout_price.innerText) - luggage;
        }
        price_input.value = checkout_price.innerText;
    });
});

food_checkbox.forEach(fg => {
    fg.addEventListener('change', () => {
        if (fg.checked) {
            checkout_price.innerText = parseFloat(checkout_price.innerText) + food;
        } else {
            checkout_price.innerText = parseFloat(checkout_price.innerText) - food;
        }
        price_input.value = checkout_price.innerText;
    });
});

select_lists.forEach(sl => {

    let selected = false;

    sl.addEventListener('change', () => {
        if (sl.value !== 'null' && selected === false) {
            selected = true;
            checkout_price.innerText = parseFloat(checkout_price.innerText) + seat;
        } else if (sl.value === 'null') {
            selected = false;
            checkout_price.innerText = parseFloat(checkout_price.innerText) - seat;
        }

        price_input.value = checkout_price.innerText;
    });
});

pass_btn.forEach(btn => {
    btn.addEventListener('click', () => {
        console.log(btn.getAttribute('data-pass'))
    });
});

for (let i = 0; i <= checkbox.length; i++) {
    birthCertificate[i].disabled = true;
    birthCertificate[i].required = false;
    passportCheckout[i].disabled = false;
    passportCheckout[i].required = true;
    checkbox[i].addEventListener('change', function() {
        if (this.checked) {
            passportCheckout[i].classList.add('none');
            passportCheckout[i].disabled = true;
            passportCheckout[i].required = false;
            birthCertificate[i].classList.remove('none');
            birthCertificate[i].disabled = false;
            birthCertificate[i].required = true;
        } else {
            birthCertificate[i].classList.add('none');
            birthCertificate[i].disabled = true;
            birthCertificate[i].required = false;
            passportCheckout[i].classList.remove('none');
            passportCheckout[i].disabled = false;
            passportCheckout[i].required = true;
        }
    });
}
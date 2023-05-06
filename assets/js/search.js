let search_btn = document.getElementById('search-btn');
let from = document.getElementById('search-from');
let to = document.getElementById('search-to');
let there = document.getElementById('search-there');
let back = document.getElementById('search-back');
let flight_class = document.getElementById('search-class');

if (sessionStorage.hasOwnProperty('flight')) {
    let flight = JSON.parse(sessionStorage.getItem('flight'));
    from.value = flight['from'];
    to.value = flight['to'];
    there.value = flight['there'];
    back.value = flight['back'];
    flight_class.value = flight['class'];
}

search_btn.addEventListener('click', () => {
    sessionStorage.setItem('flight', JSON.stringify({
        from: from.value,
        to: to.value,
        there: there.value,
        back: back.value,
        class: flight_class.value
    }));
});
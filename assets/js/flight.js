let dropdowns = document.querySelectorAll(".select-airport");
let from_input = document.getElementById('from');
let to_input = document.getElementById('to');

for (let i = 0; i < dropdowns.length; i++) {
    dropdowns[i].addEventListener("change", function() {
        let selected = this.value;
        for (let j = 0; j < dropdowns.length; j++) {
            if (dropdowns[j] !== this) {
                let options = dropdowns[j].options;
                for (let k = 0; k < options.length; k++) {
                    options[k].disabled = options[k].value === selected;
                }
            }
        }
    });
}

from_input.addEventListener('change', (e) => {
    to_input.min = e.target.value;
});

to_input.addEventListener('change', (e) => {
    from_input.max = e.target.value;
});
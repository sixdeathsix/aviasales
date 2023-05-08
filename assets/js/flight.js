let dropdowns = document.getElementsByTagName("select");

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
let modals = document.querySelectorAll(".modal");
let modalBtns = document.querySelectorAll(".modal-btn");
let modalCloseBtns = document.querySelectorAll(".modal-btn-close");

modalBtns.forEach(btn => {
    btn.addEventListener('click', (event) => {
        modals.forEach(modal => {
            if (modal.getAttribute('data-modal') === btn.getAttribute('data-modal-btn')) {
                modal.style.display = "block";
            }
        });
    });
});

modalCloseBtns.forEach(btn => {
    btn.addEventListener('click', () => {
        modals.forEach(modal => {
            modal.style.display = "none";
            window.location.href='#search-main';
        });
    });
});

window.onclick = function(event) {
   modals.forEach(modal => {
       if (event.target === modal) {
           modal.style.display = "none";
       }
   });
}
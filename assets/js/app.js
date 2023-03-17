let btn  = document.querySelector('.toggle');
let menu = document.querySelector('.menu');
let dateInput = document.querySelectorAll('.date-input');
let dateSearchInput = document.querySelectorAll('.date-serach-input');
let countInput = document.querySelectorAll('.ticket-count');
let phones = document.querySelectorAll('.phone');
let passport = document.querySelectorAll('.passport');
let btnUp = document.querySelector('.btn-up');

btn.addEventListener('click', () => menu.classList.toggle('trans'));

dateSearchInput.forEach(i => {

  i.min = new Date().toISOString().split("T")[0];
  
});

dateInput.forEach(i => {

  i.addEventListener("focus", () => {
    i.type = 'date'; 
    i.showPicker();
  });

  i.addEventListener("blur", () => i.type = 'text');
  
});

countInput.forEach(i => {
  i.addEventListener("change", function() {
    let c = parseInt(this.value);
    if (c < 1) this.value = 1;
    if (c > 9) this.value = this.max;
  });
});

function toImg() {
  htmlToImage.toJpeg(document.getElementById('screenscoot'), { backgroundColor: 'white' })
  .then(function (dataUrl) {
    var link = document.createElement('a');
    link.download = 'ticket.jpeg';
    link.href = dataUrl;
    link.click();
  });
}

phones.forEach(p => {

  p.onkeydown = function(e){
    inputphone(e, p)
  }

});

passport.forEach(p => {

  p.onkeydown = function(e){
    inputpassport(e, p)
  }

});

function inputphone(e, phone){

  function stop(evt) {
    evt.preventDefault();
  }

  let key = e.key, v = phone.value; not = key.replace(/([0-9])/, 1)

  if(not == 1 || 'Backspace' === not){

    if('Backspace' != not){

      if (v.length < 4 || v === '') {
        phone.value = '+7 ('
      }
      if (v.length === 7) {
        phone.value = v + ') '
      }
      if (v.length === 12) {
        phone.value = v + '-'
      }
       if (v.length === 15) {
        phone.value = v + '-'
      }
    }
  } else {
    stop(e)
  }

}

function inputpassport(e, passport){

  function stop(evt) {
    evt.preventDefault();
  }

  let key = e.key, v = passport.value; not = key.replace(/([0-9])/, 1)
    
  if(not == 1 || 'Backspace' === not){

    if('Backspace' != not){ 

      if (v.length === 2) {
        passport.value = v + ' '
      }
      if (v.length === 5) {
        passport.value = v + ' '
      }
    }
  } else {
    stop(e)
  }

}

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
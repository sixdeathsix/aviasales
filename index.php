<?php 
  session_start();

  require_once 'database/requests.php';
  require_once 'templates/notification.php';
  
?>

<!DOCTYPE html>
<html lang="ru">

  <?php require_once 'templates/head.php'; ?>

<body>

  <?php require_once 'templates/header.php'; ?>

  <div id="search-main" class='main'>
    
    <div class="container">
      
      <div class="main-container tac">
        <div class="main-info">
          <h1 class="main-title">Поиск дешёвых авиабилетов</h1>
          <h3 class="main-sub-title">Лёгкий способ купить авиабилеты дешёво</h3>
        </div>

        <?php require 'templates/search.php'; ?>

      </div>

    </div>

  </div>

  <div class="container">

    <div class="cards">
      <div class="card" 
        style="background-image: linear-gradient( rgba(0, 0, 0, 0.35), 
        rgba(0, 0, 0, 0.35) ), url('assets/images/bg-card-1.jpg');">
        <div class="card-title">Санкт-Петербург от 5999 Р</div>
        <div class="card-desc">
          <h3>Бертгольд Центр</h3>
        </div>
      </div>
      <div class="card"
        style="background-image: linear-gradient( rgba(0, 0, 0, 0.35), 
        rgba(0, 0, 0, 0.35) ), url('assets/images/bg-card-2.jpg');">
        <div class="card-title">Казань от 6999 Р</div>
        <div class="card-desc">
          <h3>Океонариум</h3>
        </div>
      </div>
    </div>

    <div class="price-map">
      <div class="price-map-block">
        <p class='price-map-subtitle'>Карта цен</p>
        <p class='price-map-title'>Найдите билеты по лучшей цене</p>
        <a href="#search-main" class='price-map-btn'>Найти билеты</a>
      </div>
    </div>

    <div class="atmosphere">
      <p class='atm-subtitle'>СМЕНИТЬ ОБСТАНОВКУ</p>
      <h2 class='atm-title'>Что насчёт Москвы?</h2>
      <div class='atm-cards'>
        <div class='atm-card'>
          <img class='atm-img' src="assets/images/mos-city.jpeg" alt="">
          <p>Москва-Сити</p>
        </div>
        <div class='atm-card'>
          <img class='atm-img' src="assets/images/mos-gallery.jpg" alt="">
          <p>Третьяковская галерея</p>
        </div>
        <div class='atm-card'>
          <img class='atm-img' src="assets/images/muzeon.jpg" alt="">
          <p>Музеон</p>
        </div>
        <div class='atm-card'>
          <img class='atm-img' src="assets/images/mos-red.jpeg" alt="">
          <p>Красная площадь</p>
        </div>
      </div>
    </div>

    <div class="cards">
      <div class="card"
        style="background-image: linear-gradient( rgba(0, 0, 0, 0.35), 
        rgba(0, 0, 0, 0.35) ), url('assets/images/mos-city.jpeg');">
        <div class="card-title">Москва от 4999 Р</div>
        <div class="card-desc">
          <h3>Москва-Сити</h3>
        </div>
      </div>
      <div class="card"
        style="background-image: linear-gradient( rgba(0, 0, 0, 0.35), 
        rgba(0, 0, 0, 0.35) ), url('assets/images/ekb.jpg');">
        <div class="card-title">Екатеринбург от 3999 Р</div>
        <div class="card-desc">
          <h3>Дендропарк</h3>
        </div>
      </div>
    </div>

    <div class="where-flight">
        
      <div class="where-right">
        <h2>Куда летите?</h2>
        <p>Мы знаем лучшие места в разных городах и покажем вам все!</p>
      </div>

      <div class="where-left">
        <a class='where-btn' href="#search-main">Выбрать город</a>
      </div>

    </div>

  </div>

  <div class="btn-up btn-up_hide"></div>

  <?php require_once 'templates/footer.php'; ?>

  <script>
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
  </script>
</body>
</html>
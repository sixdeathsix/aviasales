<?php
session_start();

require_once 'database/requests.php';
require_once 'templates/notification.php';

$style = 'background: -webkit-gradient( linear, left top, left bottom,from(rgba(0, 0, 0, 0.4)),to(rgba(0, 0, 0, 0.4)) ),center center / cover no-repeat';

$attractions = $provider->getRandomAttractions();
list($attractions1, $attractions2) = array_chunk($attractions, ceil(count($attractions) / 2));


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
        <?php foreach($attractions1 as $attraction): ?>
            <div class="holder-container modal-btn" data-modal-btn="<?= $attraction['attraction_id'] ?>">
                <div class="img-holder holder-bg-3" style="<?= $style ?> url(<?= $attraction['attraction_image'] ?>)"></div>
                <p class="holder-title"><?= $attraction['city'] ?></p>
                <p class="holder-subtitle"><?= $attraction['attraction_title'] ?></p>
            </div>

            <div class="modal" data-modal="<?= $attraction['attraction_id'] ?>">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2><?= $attraction['attraction_title'] ?></h2>
                    </div>
                    <div class="modal-body">
                        <img src="<?= $attraction['attraction_image'] ?>" alt="">
                        <p><?= $attraction['attraction_text'] ?></p>
                    </div>
                    <div class="modal-footer">
                        <button class="w-full btn modal-btn-close">Забронировать билеты</button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
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
        <?php foreach($attractions2 as $attraction): ?>
            <div class="holder-container modal-btn" data-modal-btn="<?= $attraction['attraction_id'] ?>">
                <div class="img-holder holder-bg-3" style="<?= $style ?> url(<?= $attraction['attraction_image'] ?>)"></div>
                <p class="holder-title"><?= $attraction['city'] ?></p>
                <p class="holder-subtitle"><?= $attraction['attraction_title'] ?></p>
            </div>

            <div class="modal" data-modal="<?= $attraction['attraction_id'] ?>">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2><?= $attraction['attraction_title'] ?></h2>
                    </div>
                    <div class="modal-body">
                        <img src="<?= $attraction['attraction_image'] ?>" alt="">
                        <p><?= $attraction['attraction_text'] ?></p>
                    </div>
                    <div class="modal-footer">
                        <button class="w-full btn modal-btn-close">Забронировать билеты</button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
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

<script src="assets/js/btnup.js"></script>
<script src="assets/js/modal.js"></script>
</body>
</html>
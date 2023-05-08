<?php
session_start();

require_once 'database/requests.php';
require_once 'templates/notification.php';
require_once 'functions/methods.php';

$reviews = $provider->getReviews();
$avg = $provider->getAvgReviews();

if (isset($_POST['review_text'])) {
    $provider->addReview($_POST['review_text'], $_SESSION['user']['id'], $_POST['rating']);
    unset($_POST['review_text']);
}

if (isset($_POST['delete'])) {
    $provider->deleteReview($_POST['delete']);
    unset($_POST['delete']);
}

?>

<!DOCTYPE html>
<html lang="ru">

<?php require_once 'templates/head.php'; ?>

<body>

<?php require_once 'templates/header.php'; ?>

<div class="container">

    <?php if($reviews): ?>

        <h1 class="tac">Отзывы &#11088;<?= $avg['avg'] ?></h1>

        <?php foreach($reviews as $item): ?>

            <div class="notification rew">
                <div class="not-title">
                    <b><?= $item['surname'] ?> <?= $item['name'] ?></b> <span class="rate">&#11088;<?= $item['review_rate'] ?></span>
                </div>
                <div class="not-desc">
                    <?= $item['review_text'] ?>
                </div>
                <div class="not-date">
                    <?= $mtd->convDate($item['review_date']) ?>
                    <?php if($_SESSION['user']['role'] == 3): ?>
                        <form method="post">
                            <button class="delete-btn" name="delete" value="<?= $item['review_id'] ?>">удалить</button>
                        </form>
                    <?php endif; ?>
                </div>


            </div>

        <?php endforeach; ?>

        <button class="review-btn more btn">Показать еще</button>

    <?php else: ?>

        <h2 class="tac">Отзывов нет</h2>

    <?php endif; ?>

    <?php if($_SESSION['user']): ?>

        <form class="review" method="post">
            <textarea name="review_text" placeholder="Оставьте отзыв" rows="5" class="review-text" required></textarea>
            <div class="rating">
                <input type="radio" name="rating" value="5" id="rating-5" class="star-rate">
                <label for="rating-5"></label>
                <input type="radio" name="rating" value="4" id="rating-4" class="star-rate">
                <label for="rating-4"></label>
                <input type="radio" name="rating" value="3" id="rating-3" class="star-rate">
                <label for="rating-3"></label>
                <input type="radio" name="rating" value="2" id="rating-2" class="star-rate">
                <label for="rating-2"></label>
                <input type="radio" name="rating" value="1" id="rating-1" class="star-rate">
                <label for="rating-1"></label>
            </div>
            <button class="btn">Отправить</button>
        </form>

    <?php else: ?>

        <h3 class="tac">Чтобы оставить отзыв необходима <a class="blue" href="auth-page.php">авторизация</a></h3>

    <?php endif; ?>

</div>

<div class="btn-up btn-up_hide"></div>

<script src="assets/js/review.js"></script>
</body>
</html>
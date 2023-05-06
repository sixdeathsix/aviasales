<?php
session_start();

require_once 'database/requests.php';
require_once 'templates/notification.php';
require_once 'functions/methods.php';

if (isset($_POST['support_text'])) {
    $provider->addAppeal($_POST['support_text'], $_SESSION['user']['id']);
    unset($_POST['support_text']);
}

?>

<!DOCTYPE html>
<html lang="ru">

<?php require_once 'templates/head.php'; ?>

<body>

<?php require_once 'templates/header.php'; ?>

<div class="container support">

    <?php if($_SESSION['user']): ?>

        <form class="support-body" method="post">
            <h1 class="support-title">Написать нам</h1>
            <textarea name="support_text" placeholder="Текст вопроса" rows="10" class="review-text" required></textarea>
            <button class="btn support-btn">Отправить вопрос</button>
        </form>

    <?php else: ?>

        <h3 class="tac">Чтобы оставить вопрос необходима <a class="blue" href="auth-page.php">авторизация</a></h3>

    <?php endif; ?>

</div>

<div class="btn-up btn-up_hide"></div>

<?php //require_once 'templates/footer.php'; ?>

<script src="assets/js/review.js"></script>
</body>
</html>
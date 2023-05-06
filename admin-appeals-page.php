<?php
session_start();

if ($_SESSION['user']['role'] != 3) {
    header('Location: index.php');
}

require_once 'database/requests.php';
require_once 'functions/methods.php';
require_once 'templates/notification.php';

$appeals = $provider->getAllAppeals();

if ($appeals) {
    $pagination = $mtd->pagination($appeals, 5, $_GET['page']);

    $appeals = $pagination['array'];
    $pages = $pagination['pages'];
}

if (isset($_POST['reply_text'])) {
    $provider->addReplyToAppeal($_POST['reply_text'], $_POST['appeal_id']);
}

?>
<!DOCTYPE html>
<html lang="ru">

<?php require 'templates/head.php'; ?>

<body>

<?php require_once 'templates/header.php'; ?>

<div class="container df jcsb fw">

    <?php require_once 'templates/aside.php'; ?>

    <main class="df fc jcc aic">

        <h3 class="tac admin-title">Список вопросов ожидающих ответа</h3>

        <?php if($appeals): ?>

            <?php foreach($appeals as $item): ?>

                <div class="appeal">
                    <div class="appeal-title">
                        <b>Вопрос задан пользователем <?= $item['surname'] ?> <?= $item['name'] ?> <?= $item['patronymic'] ?></b>
                    </div>
                    <div class="appeal-desc">
                        <?= $item['appeal_text'] ?>
                    </div>
                    <div class="appeal-date">
                        <?= $mtd->convDate($item['appeal_date']) ?> <?= $mtd->convTime($item['appeal_date']) ?>
                    </div>

                    <form method="post">
                        <textarea name="reply_text" placeholder="Текст ответа на вопроса" rows="5" class="review-text" required></textarea>
                        <button class="btn right" name="appeal_id" value="<?= $item['appeal_id'] ?>">Отправить ответ</button>
                    </form>

                </div>

            <?php endforeach; ?>

        <?php else: ?>

            <h2 class="tac">Вопросов нет</h2>

        <?php endif; ?>

        <?php require_once 'templates/pages.php'; ?>

    </main>

</div>

<script src="assets/js/search-user.js"></script>
</body>
</html>
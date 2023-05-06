<?php
session_start();

require_once 'database/requests.php';
require_once 'functions/methods.php';
require_once 'templates/notification.php';

if(!$_SESSION['user']) {
    header('Location: index.php');
}

$user = $_SESSION['user'];

$appeals = $provider->getAppeals($user['id']);

if ($appeals) {
    $pagination = $mtd->pagination($appeals, 5, $_GET['page']);

    $appeals = $pagination['array'];
    $pages = $pagination['pages'];
}

?>

<!DOCTYPE html>
<html lang="ru">

<?php require_once 'templates/head.php'; ?>

<body>

<?php require_once 'templates/header.php'; ?>

<div class="container">

    <div class="profile">

        <?php require_once 'templates/profile.php'; ?>

        <div class="profile-orders">

            <?php if($appeals): ?>

                <?php foreach($appeals as $item): ?>

                    <div class="appeal">
                        <div class="appeal-title">
                            <b>Вопрос № <?= $item['appeal_id'] ?></b>
                        </div>
                        <div class="appeal-desc">
                            <?= $item['appeal_text'] ?>
                        </div>
                        <div class="appeal-date">
                            <?= $mtd->convDate($item['appeal_date']) ?> <?= $mtd->convTime($item['appeal_date']) ?>
                        </div>

                        <?php if($item['appeal_reply']): ?>
                            <div class="appeal-reply-body">
                                <div class="appeal-reply">
                                    <?= $item['appeal_reply'] ?>
                                </div>

                                <div class="appeal-date">
                                    <?= $mtd->convDate($item['appeal_reply_date']) ?> <?= $mtd->convTime($item['appeal_reply_date']) ?>
                                </div>
                            </div>

                        <?php endif; ?>

                    </div>

                <?php endforeach; ?>

            <?php else: ?>

                <h2 class="tac">Вопросов нет</h2>

            <?php endif; ?>

            <?php require_once 'templates/pages.php'; ?>

        </div>

    </div>

</div>

</body>
</html>
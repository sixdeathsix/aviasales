<?php
session_start();

require_once 'database/requests.php';
require_once 'functions/methods.php';
require_once 'templates/notification.php';

if(!$_SESSION['user']) {
    header('Location: index.php');
}

$user = $_SESSION['user'];

$notifications = $provider->getNotifications($user['id']);

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

            <?php if($notifications): ?>

                <?php foreach($notifications as $item): ?>

                    <div class="notification" data-id="<?= $item['notification_id'] ?>">
                        <div class="not-title">
                            <b><?= $item['notification_title'] ?></b>
                        </div>
                        <div class="not-desc">
                            <?= $item['notification_desc'] ?>
                        </div>
                        <div class="not-date">
                            <?= $mtd->convDate($item['notification_date']) ?> <?= $mtd->convTime($item['notification_date']) ?>
                        </div>
                    </div>

                <?php endforeach; ?>

                <button class="review-btn more btn">Показать все</button

            <?php else: ?>

                <h2 class="tac">Уведомлений нет</h2>

            <?php endif; ?>

        </div>

    </div>

</div>

<script src="assets/js/notification.js"></script>
</body>
</html>
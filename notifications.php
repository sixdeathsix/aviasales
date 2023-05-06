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

if ($notifications) {
    $pagination = $mtd->pagination($notifications, 4, $_GET['page']);

    $notifications = $pagination['array'];
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

            <?php if($notifications): ?>

                <?php foreach($notifications as $item): ?>

                    <div class="notification">
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

            <?php else: ?>

                <h2 class="tac">Уведомлений нет</h2>

            <?php endif; ?>

            <?php require_once 'templates/pages.php'; ?>

        </div>

    </div>

</div>

</body>
</html>
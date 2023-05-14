<?php
session_start();

if ($_SESSION['user']['role'] != 3) {
    header('Location: index.php');
}

require_once 'database/requests.php';
require_once 'functions/methods.php';
require_once 'templates/notification.php';

$users = $provider->getAllUsers();

if (isset($_POST['delete'])) {
    $provider->deleteUser($_POST['delete']);
    unset($_POST['delete']);
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

        <h3 class="tac admin-title">Список пользователей</h3>

        <input id="search" placeholder="Поиск" class="w-full" type="text">

        <?php if ($users): ?>

            <?php foreach ($users as $user): ?>
                <div class="w-full padding border border-radius m-5 df jcsb aic admin-user-page">

                    <div class="search-list"><?= $user['surname']; ?> <?= $user['name']; ?> <?= $user['patronymic']; ?></div>

                    <div class="df">
                        <a href="bookings-user-page.php/<?= $user['user_id']; ?>?page=1">
                            <button class="btn-form">Бронь</button>
                        </a>
                        <a href="orders-users-page.php/<?= $user['user_id']; ?>?page=1">
                            <button class="btn-form">История</button>
                        </a>
                        <a href="update-users-page.php?id=<?= $user['user_id']; ?>">
                            <button class="btn-form">&#9997;</button>
                        </a>
                        <form action="" method='post'>
                            <button name='delete' value='<?= $user['user_id']; ?>' class="btn-form" type='submit'>
                                &#10060;
                            </button>
                        </form>
                    </div>

                </div>
            <?php endforeach ?>

        <?php else: ?>
            <h1 class='empty'>Нет данных</h1>
        <? endif; ?>

        <div class="pages pagination"></div>

    </main>

</div>

<script src="assets/js/search-items.js"></script>
</body>
</html>
<?php
session_start();

if($_SESSION['user']['role'] != 3) {
    header('Location: index.php');
}

require_once 'database/requests.php';
require_once 'functions/methods.php';
require_once 'templates/notification.php';

$id = explode('/', $_SERVER['REQUEST_URI'])[2];

$flights = $provider->getPassFromFlight($id);
$sum = $provider->getSumFromFlight($id);

if ($flights) {
    $pagination = $mtd->pagination($flights, 10, $_GET['page']);

    $flights = $pagination['array'];
    $pages = $pagination['pages'];
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

        <div class="history-mobile">

            <h3 class="tac admin-title">Эта страница не доступна на мобильной версии</h3>

        </div>

        <h2 class="tac admin-title">Список бронирующих</h2>

        <?php if($flights): ?>

            <table class='history-table'>

                <tr class='history-tr'>
                    <th>Фамилия</th>
                    <th>Имя</th>
                    <th>Отчество</th>
                    <th>Почта</th>
                    <th>Телефон</th>
                    <th>Класс обслуживания</th>
                    <th>Цена</th>
                </tr>

                <?php foreach($flights as $item): ?>
                    <tr class='history-tr'>
                        <td><?= $item['surname'] ?></td>
                        <td><?= $item['name'] ?></td>
                        <td><?= $item['patronymic'] ?></td>
                        <td><?= $item['contact_email'] ?></td>
                        <td><?= $item['contact_phone'] ?></td>
                        <td><?= $item['class'] ?></td>
                        <td><?= $item['total_amount'] ?></td>
                    </tr>
                <?php endforeach; ?>

            </table>

            <p class="flight-sum">Всего: <?= $sum['sum']; ?></p>

        <?php else: ?>

            <h2 class="tac">Бронирований нет</h2>

        <?php endif; ?>

        <?php require_once 'templates/pages.php'; ?>

    </main>

</div>

</body>
</html>
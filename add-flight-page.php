<?php
session_start();

if ($_SESSION['user']['role'] != 3) {
    header('Location: index.php');
}

require_once 'database/requests.php';
require_once 'templates/notification.php';

$airports = $provider->getAllAirports();
$aircrafts = $provider->getAllAircrafts();

if (isset($_POST['add'])) {
    $provider->registerFlight(
        $_POST['from_date'],
        $_POST['to_date'],
        $_POST['from'],
        $_POST['to'],
        $_POST['aircraft'],
        $_POST['price']
    );
    unset($_POST['add']);
}

?>
<!DOCTYPE html>
<html lang="ru">

<?php require_once 'templates/head.php'; ?>

<body>

<?php require_once 'templates/header.php'; ?>

<div class="container df jcsb fw">

    <?php require_once 'templates/aside.php'; ?>

    <main class="df fc jcc aic">
        <form class="auth-form w-full df fc jcc aic" action="" method='post'>
            <h3 class="tac">Добавить рейс</h3>
            <span>Откуда</span>
            <select class='form-action select-airport' name='from' required>
                <option>
                    Откуда
                </option>
                <?php foreach ($airports as $item): ?>
                    <option value="<?= $item['airport_id']; ?>">
                        <?= $item['airport_name']; ?>
                    </option>
                <?php endforeach ?>
            </select>
            <span>Куда</span>
            <select class='form-action select-airport' name='to' required>
                <option>
                    Куда
                </option>
                <?php foreach ($airports as $item): ?>
                    <option value="<?= $item['airport_id']; ?>">
                        <?= $item['airport_name']; ?>
                    </option>
                <?php endforeach ?>
            </select>
            <span>Самолет</span>
            <select class='form-action' name='aircraft' required>
                <?php foreach ($aircrafts as $item): ?>
                    <option value="<?= $item['aircraft_id']; ?>">
                        <?= $item['model']; ?>
                    </option>
                <?php endforeach ?>
            </select>
            <span>Время отправления</span>
            <input id="from" class='form-action date-search-input' placeholder='Цена' name='from_date' type="datetime-local"
                   required>
            <span>Время прибытия</span>
            <input id="to" class='form-action date-search-input' placeholder='Цена' name='to_date' type="datetime-local"
                   required>

            <input class='form-action' placeholder='Цена' name='price' type="number" min='1' required>
            <button class="form-action btn" name='add' type="submit">
                Зарегистрировать рейс
            </button>
        </form>
    </main>
</div>

<script src="assets/js/flight.js"></script>
</body>
</html>
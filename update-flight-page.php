<?php
session_start();

if($_SESSION['user']['role'] != 3) {
    header('Location: index.php');
}

require_once 'database/requests.php';
require_once 'templates/notification.php';

$airports = $provider->getAllAirports();
$aircrafts = $provider->getAllAircrafts();

$id = explode('/', $_SERVER['REQUEST_URI'])[2];

$flight = $provider->getOneFlight($id);

if(isset($_POST['update'])) {

    $provider->updateFlight(
        $_POST['from_date'],
        $_POST['to_date'],
        $_POST['from'],
        $_POST['to'],
        $_POST['aircraft'],
        $_POST['price'],
        $id
    );
    unset($_POST['update']);
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
            <h3 class="tac">Изменить рейс №</h3>
            <span>Откуда</span>
            <select class='form-action' name='from' required>
                <option value="<?= $flight['da_id'] ?>"><?= $flight['departure_name'] ?></option>
                <?php foreach($airports as $item): ?>
                    <option value="<?= $item['airport_id']; ?>">
                        <?= $item['airport_name']; ?>
                    </option>
                <?php endforeach ?>
            </select>
            <span>Куда</span>
            <select class='form-action' name='to' required>
                <option value="<?= $flight['aa_id'] ?>"><?= $flight['arrival_name'] ?></option>
                <?php foreach($airports as $item): ?>
                    <option value="<?= $item['airport_id']; ?>">
                        <?= $item['airport_name']; ?>
                    </option>
                <?php endforeach ?>
            </select>
            <span>Самолет</span>
            <select class='form-action' name='aircraft' required>
                <option value="<?= $flight['a_id'] ?>"><?= $flight['model'] ?></option>
                <?php foreach($aircrafts as $item): ?>
                    <option value="<?= $item['aircraft_id']; ?>">
                        <?= $item['model']; ?>
                    </option>
                <?php endforeach ?>
            </select>
            <span>Время отправления</span>
            <input class='form-action' type="datetime-local" name="from_date" value="<?= $flight['scheduled_departure'] ?>" required>
            <span>Время прибытия</span>
            <input class='form-action' type="datetime-local" name="to_date" value="<?= $flight['scheduled_arrival'] ?>" required>

            <input class='form-action' placeholder='Цена' value="<?= $flight['price'] ?>" name='price' type="number" min='1' required>
            <button class="form-action btn" name='update' type="submit">
                Применить изменения
            </button>
        </form>
    </main>
</div>

</body>
</html>
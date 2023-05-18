<?php
session_start();

if ($_SESSION['user']['role'] != 3) {
    header('Location: index.php');
}

require_once 'database/requests.php';
require_once 'functions/methods.php';
require_once 'templates/notification.php';

$attractions = $provider->getAllAttractions();
$cities = $provider->getAllCities();

if ($attractions) {
    $pagination = $mtd->pagination($attractions, 5, $_GET['page']);

    $attractions = $pagination['array'];
    $pages = $pagination['pages'];
}

if (isset($_POST['delete'])) {
    $provider->deleteAttraction($_POST['delete']);
    unset($_POST['delete']);
}

if (isset($_POST['attraction_title'])) {
    $provider->addAttraction($_POST['attraction_title'], $_POST['attraction_text'], $_FILES['attraction_image'], $_POST['city_id']);
    unset($_POST['attraction_title']);
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

        <div class="df jcsb w-90 aic">
            <h2 class="tac admin-title">Список достопримечтальностей</h2>
        </div>

        <?php if ($attractions): ?>

            <table class='history-table'>
                <tr class='history-tr'>
                    <th>Достопримечательность</th>
                    <th>Город</th>
                    <th></th>
                </tr>

                <?php foreach ($attractions as $item): ?>
                    <tr class='history-tr'>
                        <td><?= $item['attraction_title'] ?></td>
                        <td><?= $item['city'] ?></td>
                        <td>
                            <form method="post">
                                <button class="delete-btn" name="delete" value="<?= $item['attraction_id'] ?>">удалить</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>

            </table>

        <?php else: ?>

            <h2 class="tac">Нет данных</h2>

        <?php endif; ?>


        <?php require_once 'templates/pages.php'; ?>

        <form class="w-full df fc jcc aic" method='post' enctype="multipart/form-data">
            <h2 class="tac">Добавить достопримечательность</h2>
            <input class='form-action' placeholder="Название достопримечательности" type="text" name="attraction_title" required>
            <select class='form-action' name="city_id" required>
                <?php foreach($cities as $city): ?>
                    <option value="<?= $city['city_id'] ?>"><?= $city['city'] ?></option>
                <?php endforeach; ?>
            </select>
            <textarea name="attraction_text" placeholder="Описание достопримечательности" rows="8" class="form-action" required></textarea>
            <input class='form-action' type="file" name="attraction_image" required>
            <button class="form-action btn">Добавить достопримечательность</button>
        </form>

    </main>

</div>

</body>
</html>
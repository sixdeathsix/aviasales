<?php 
  session_start(); 

  if($_SESSION['user']['role'] != 3) {
    header('Location: index.php');
  }

  require_once 'database/requests.php';
  require_once 'functions/methods.php';
  require_once 'templates/notification.php';

  $history = $provider->getHistoryBookings($_GET['id']);
  $user = $provider->getUserById($_GET['id']);

  if ($history) {
    $pagination = $mtd->pagination($history, 15, $_GET['page']);

    $history = $pagination['array'];
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
      
      <h3 class="tac admin-title">История полетов <?= $user['surname'] ?> <?= $user['name'] ?> <?= $user['patronymic'] ?></h3>

      <?php if($history): ?>

      <?php foreach($history as $item): ?>

      <div class="history-mobile">
        <div class="df jcsb">
          <p>Рейс № <?= $item['flight_id'] ?></p>
          <p>
            <?= $mtd->convDate($item['scheduled_departure']) ?>
            <?= $mtd->convTime($item['scheduled_departure']) ?>
          </p>
        </div>

        <div class="df jcsb">
          <div><?= $item['from_a'] ?>/<?= $item['from_n'] ?></div>
          <div>-</div>
          <div><?= $item['to_a'] ?>/<?= $item['to_n'] ?></div>
        </div>

        <div class="df jcsb">

          <div>Класс: <?= $item['class'] ?></div>

          <?php if($item['status'] == 'Landed'): ?>

            <p class='landed'>Закрыт</p>

          <?php elseif($item['status'] == 'Cancelled'): ?>

            <p class='cancelled'>Отменен</p>

          <?php elseif(!$item['ticket_id']): ?>

            <p class='refund'>Возврат</p>

          <?php endif; ?>

        </div>

        <div class="df jcsb">
          <div>Кол-во билетов: <?= $item['count'] ?></div>
          <div>Сумма: <?= $item['total_amount'] ?> ₽</div>
        </div>

      </div>

      <?php endforeach; ?>

      <table class='history-table'>
        <tr class='history-tr'>
          <th>№</th>
          <th>Откуда</th>
          <th>Куда</th>
          <th>Отправление</th>
          <th class="hide-tr">Класс</th>
          <th>Билетов</th>
          <th>Статус</th>
          <th>Сумма</th>
        </tr>

        <?php foreach($history as $item): ?>
          <tr class='history-tr'>
            <td><?= $item['flight_id'] ?></td>
            <td><?= $item['from_a'] ?>/<?= $item['from_n'] ?></td>
            <td><?= $item['to_a'] ?>/<?= $item['to_n'] ?></td>
            <td>
              <?= $mtd->convDate($item['scheduled_departure']) ?>
              <?= $mtd->convTime($item['scheduled_departure']) ?>
            </td>
            <td class="hide-tr"><?= $item['class'] ?></td>
            <td><?= $item['count'] ?></td>
            <td>

              <?php if($item['status'] == 'Cancelled'): ?>

                <p class='cancelled'>Отменен</p>

              <?php elseif($item['ticket_id'] == null): ?>

                <p class='refund'>Возврат</p>

              <?php elseif($item['status'] == 'Landed'): ?>

                <p class='landed'>Закрыт</p>

              <?php endif; ?>

            </td>
            <td><?= $item['total_amount'] ?> </td>
          </tr>
        <?php endforeach; ?>

      </table>

      <?php else: ?>

      <h2 class="tac">Нет истории</h2>

      <?php endif; ?>
      
      <div class="pages">
        <?php for($i = 1; $i <= $pages; $i++): ?>
          <a 
            class="page-number <?= $_GET['page'] == $i ? 'selected' : '' ?>"
            href="<?= $url; ?>?page=<?= $i ?>">
            <?= $i ?>
          </a>
        <?php endfor; ?>
      </div>

    </main>

  </div>

</body>
</html>
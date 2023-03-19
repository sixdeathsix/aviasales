<?php 
  session_start(); 

  if($_SESSION['user']['role'] != 3) {
    header('Location: index.php');
  }

  require_once 'database/requests.php';
  require_once 'functions/methods.php';
  require_once 'templates/notification.php';

  $flights = $provider->getAllFlights($_SESSION['admin-status']);

  if ($flights) {
    $pagination = $mtd->pagination($flights, 10, $_GET['page']);

    $flights = $pagination['array'];
    $pages = $pagination['pages'];
  }

  if (isset($_POST['sort'])) {
      $_SESSION['admin-status'] = $_POST['sort'];
      $flights = $provider->getAllFlights($_SESSION['admin-status']);
      $pagination = $mtd->pagination($flights, 10, $_GET['page']);
      $flights = $pagination['array'];
      $pages = $pagination['pages'];
      unset($_POST['sort']);
  }

  if (isset($_POST['start'], $_POST['end'])) {
      $_SESSION['admin-status'] = $_POST['sort'];
      $flights = $provider->getAllFlightsWithDate($_SESSION['admin-status'], $_POST['start'], $_POST['end']);
      $pagination = $mtd->pagination($flights, 10, $_GET['page']);
      $flights = $pagination['array'];
      $pages = $pagination['pages'];
      unset($_POST['start']);
      unset($_POST['end']);
  }

  if(isset($_POST['delete'])) {
    $provider->updateFlightStatus($_POST['delete'], 2);
    unset($_POST['delete']);
  }

  if(isset($_POST['accept'])) {
    $provider->updateFlightStatus($_POST['accept'], 3);
    unset($_POST['accept']);
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
        <h2 class="tac admin-title">Список рейсов</h2>
        <a href="add-flight-page.php">
          <button class="btn">Создать рейс</button>
        </a>
      </div>

      <div class="df w-90 jcsb">

          <form method="post">
              <input name="start" type="date">
              <span> - </span>
              <input name="end" type="date">
              <button>обновить</button>
          </form>

          <form method="post">
              <select name="sort" onchange="this.form.submit()">
                  <option value="" hidden>
                      <?php if($_SESSION['status'] == 'Landed'): ?>
                          Закрыт
                      <?php elseif($_SESSION['status'] == 'Cancelled'): ?>
                          Отменен
                      <?php elseif($_SESSION['status'] == 'Check-in'): ?>
                          Новый
                      <?php elseif($_SESSION['status'] == ''): ?>
                          Все
                      <?php endif; ?>
                  </option>
                  <option value="">Все</option>
                  <option value="Landed">Закрыт</option>
                  <option value="Cancelled">Отменен</option>
                  <option value="Check-in">Новый</option>
              </select>
          </form>

      </div>

      <div class="history-mobile">

        <h3 class="tac admin-title">Эта страница не доступна на мобильной версии</h3>

      </div>

      <?php if($flights): ?>

        <table class='history-table'>

          <tr class='history-tr'>
            <th>№</th>
            <th>Откуда</th>
            <th>Куда</th>
            <th>Отправление</th>
            <th>Статус</th>
            <th>П/З*</th>
            <th></th>
          </tr>

          <?php foreach($flights as $item): ?>
            <tr class='history-tr'>
              <td><?= $item['flight_id'] ?></td>
              <td><?= $item['d_name'] ?>/<?= $item['d_code'] ?></td>
              <td><?= $item['a_name'] ?>/<?= $item['a_code'] ?></td>
              <td>
                <?= $mtd->convDate($item['scheduled_departure']) ?>
                <?= $mtd->convTime($item['scheduled_departure']) ?>
              </td>
              <td>

                <?php if($item['status'] == 'Landed'): ?>

                  <p class='landed'><?= $item['status'] ?></p>

                <?php elseif($item['status'] == 'Cancelled'): ?>

                  <p class='cancelled'><?= $item['status'] ?></p>

                <?php elseif($item['status'] == 'Check-in'): ?>

                  <div class='refund'>
                    <?= $item['status'] ?>
                    <form action="" method='post'>
                      <button name='delete' 
                      value='<?= $item['flight_id']; ?>' 
                      class="cancel-btn" type='submit'>&#10060;</button>
                    </form>
                    <form action="" method='post'>
                      <button name='accept' 
                      value='<?= $item['flight_id']; ?>' 
                      class="cancel-btn" type='submit'>&#9989;</button>
                    </form>
                  </div>

                <?php endif; ?>

              </td>
              <td>
                <?= $item['sold'] ?>/<?= $item['booked'] ?>
              </td>
              <td>
                  <a href="flight-pass-page.php/<?= $item['flight_id'] ?>">&#128209;</a>
              </td>
            </tr>
          <?php endforeach; ?>

        </table>

        * - Продано/Забронировано

      <?php else: ?>

        <h2 class="tac">Нет данных</h2>

      <?php endif; ?>

      <?php require_once 'templates/pages.php'; ?>

    </main>

  </div>

</body>
</html>
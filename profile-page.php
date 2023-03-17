<?php 
  session_start();

  require_once 'database/requests.php';
  require_once 'functions/methods.php';
  require_once 'templates/notification.php';

  if(!$_SESSION['user']) {
    header('Location: index.php');
  }

  $user = $_SESSION['user'];

  $history = $provider->getActiveBookings($user['id']);

  if ($history) {
    $pagination = $mtd->pagination($history, 4, $_GET['page']);

    $history = $pagination['array'];
    $pages = $pagination['pages'];
  }

  if (isset($_POST['cancel'])) {
    $provider->cancelBooking($_POST['cancel']);
    unset($_POST['cancel']);
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

      <?php if($history): ?>

          <?php foreach($history as $item): ?>

            <div id='screenscoot' class="profile-ticket padding border border-radius">

              <h2 class='profile-ticket-title'>Flight №: <?= $item['flight_id'] ?></h2>

              <div class="profile-ticket-info">

                <div class="profile-ticket-info-item">
                  <div class='info-item'>
                    <div>Name of passenger:</div>
                    <div><?= $item['surname'] ?> <?= $item['name'] ?> <?= $item['patronymic'] ?></div>
                  </div>
                  <div class='info-item'>
                    <div>Class:</div>
                    <div class='info-item-class'><?= $item['class'] ?> / <?= $item['class_code'] ?></div>
                  </div>
                </div>

                <div class="profile-ticket-info-item">
                  <div>
                    <p>From: <?= $item['from_n'] ?></p>
                    <p>To: <?= $item['to_n'] ?></p>
                  </div>
                  <div>
                    <p>Date:</p>
                    <p><?= $mtd->convDate($item['scheduled_departure']); ?> <?= $mtd->convTime($item['scheduled_departure']); ?></p>
                  </div>
                </div>

              </div>

              <div class='import-cancel'>
                <button  class='cancel-booking-btn' onclick="toImg()">Скачать билет</button>
                
                <form action="" method='post'>
                  <button name='cancel' value='<?= $item['book_id'] ?>' class='cancel-booking-btn'>Отменить бронирование</button>
                </form>
              </div>

            </div>
            
          <?php endforeach; ?>

      <?php else: ?>

        <h2 class="tac">У вас нет активных заказов</h2>

      <?php endif; ?>

      <?php require_once 'templates/pages.php'; ?>

      </div>

    </div>

  </div>

</body>
</html>
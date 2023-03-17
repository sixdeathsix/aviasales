<?php

  session_start();

  if($_SESSION['user']['role'] != 3) {
      header('Location: index.php');
  }

  require_once 'database/requests.php';
  require_once 'functions/methods.php';
  require_once 'templates/notification.php';

  $id = explode('/', $_SERVER['REQUEST_URI'])[2];

  if (!isset($_SESSION['status'])) {
      $_SESSION['status'] = '';
  }

  $user = $provider->getUserById($id);
  $array_data = $provider->getHistoryBookings($id, $_SESSION['status']);
  $page_count = 5;

  if (isset($_POST['sort'])) {
      $_SESSION['status'] = $_POST['sort'];
      $array_data = $provider->getHistoryBookings($id, $_SESSION['status']);
  }

  if (isset($_POST['start'], $_POST['end'])) {
      $array_data = $provider->getHistoryBookingsWithDate($_SESSION['user']['id'], $_SESSION['status'], $_POST['start'], $_POST['end']);
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

        <?php require_once 'templates/status-filter.php'; ?>

        <?php require_once 'templates/user-history.php'; ?>

    </main>

  </div>

</body>
</html>
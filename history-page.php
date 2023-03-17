<?php

  session_start();

  if(!$_SESSION['user']) {
      header('Location: index.php');
  }

  require_once 'database/requests.php';
  require_once 'functions/methods.php';
  require_once 'templates/notification.php';

  if (!isset($_SESSION['status'])) {
      $_SESSION['status'] = '';
  }

  $array_data = $provider->getHistoryBookings($_SESSION['user']['id'], $_SESSION['status']);
  $page_count = 10;

  if (isset($_POST['sort'])) {
      $_SESSION['status'] = $_POST['sort'];
      $array_data = $provider->getHistoryBookings($_SESSION['user']['id'], $_SESSION['status']);
  }

  if (isset($_POST['start'], $_POST['end'])) {
      $array_data = $provider->getHistoryBookingsWithDate($_SESSION['user']['id'], $_SESSION['status'], $_POST['start'], $_POST['end']);
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

          <?php require_once 'templates/status-filter.php'; ?>

          <?php require_once 'templates/user-history.php'; ?>

      </div>

    </div>

  </div>

</body>
</html>
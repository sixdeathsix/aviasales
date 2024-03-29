<?php 
  session_start();

  require_once 'database/requests.php';
  require_once 'templates/notification.php';

  $user = $_SESSION['user'];
  
?>

<div class="profile-info">

  <div class="profile-info-title">
    <?= $user['surname'] ?> <?= $user['name'] ?> <?= $user['patronymic'] ?>
  </div>

  <div class="profile-links">
    <a class="profile-link" href="/profile-page.php?page=1">Мои заказы</a>
    <a class="profile-link" href="/history-page.php?page=1">История заказов</a>
    <a class="profile-link df" href="/notifications-page.php">Уведомления <?php if($provider->getNotifications($_SESSION['user']['id'])): ?><span class="badge none"><?= count($provider->getNotifications($_SESSION['user']['id'])) ?></span><?php endif; ?></a>
    <a class="profile-link" href="/appeals-page.php?page=1">Мои вопросы</a>
    <a class="profile-link" href="/update-profile-page.php">Изменить личные данные</a>
    <a class="profile-link" href="/reset-password.php">Сменить пароль</a>
  </div>

  <form action="database/logout.php" method='post'>
    <button class='btn w-full logout'>Выйти</button>
  </form>

<script src="../assets/js/logout.js"></script>
</div>
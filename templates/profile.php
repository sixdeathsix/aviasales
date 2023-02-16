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
    <a class="profile-link" href="/update-profile-page.php">Изменить личные данные</a>
    <a class="profile-link" href="/reset-password.php">Сменить пароль</a>
  </div>

  <form action="database/logout.php" method='post'>
    <button class='btn w-full'><a href="database/logout.php">Выйти</a></button>
  </form>

</div>
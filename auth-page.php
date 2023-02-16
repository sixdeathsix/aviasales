<?php 
  session_start();
  
  if($_SESSION['user']) {
    header('Location: index.php');
  }

  require_once 'database/requests.php';
  require_once 'templates/notification.php';

  if (isset($_POST['auth'])) {
    $provider->auth($_POST['login'], $_POST['password']);
    unset($_POST['auth']);
  }
  
?>
<!DOCTYPE html>
<html lang="ru">

  <?php require_once 'templates/head.php'; ?>

<body>

  <?php require_once 'templates/header.php'; ?>

  <div class="container">
    <form class="auth-form w-full df fc jcc aic" action="" method='post'>
      <h1 class="tac">Авторизация</h1>
      <input class='form-action' placeholder='Введите логин' name='login' type="text" required>
      <input class='form-action' placeholder='Введите пароль' name='password' type="password" minlength="8" required>
      <button class='form-action btn' name='auth' type='submit'>Войти</button>
      <p class="margin">
        У вас нет аккаунта? - <a href="/register-page.php">Зарегистрируйтесь</a>!
      </p>
    </form>
  </div>

</body>
</html>
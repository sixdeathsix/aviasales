<?php 
  session_start();

  require_once 'database/requests.php';
  require_once 'templates/notification.php';

  if(!$_SESSION['user']) {
    header('Location: index.php');
  }

  $user = $_SESSION['user'];

  if (isset($_POST['reset'])) {
    $provider->resetPassword($user['id'], $_POST['password_old'], $_POST['password'], $_POST['password_confirm']);
    unset($_POST['reset']);
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

      <form class="reset-password" action="" method='post'>
        <h3 class="tac">Изменение пароль</h3>
        <input class='form-action' value='' placeholder='Введите старый пароль' name='password_old' type="password" minlength="8" required>
        <input class='form-action' value='' placeholder='Введите новый пароль' name='password' type="password" minlength="8" required>
        <input class='form-action' value='' placeholder='Повторите новый пароль' name='password_confirm' type="password" minlength="8" required>
        <button class="form-action btn" name='reset' type="submit">Изменить пароль</button>
      </form>

    </div>

  </div>

</body>
</html>
<?php 
  session_start();
  
  if($_SESSION['user']) {
    header('Location: index.php');
  }

  require_once 'database/requests.php';
  require_once 'templates/notification.php';

  if (isset($_POST['submit'])) {
    $provider->register(
      $_POST['surname'],
      $_POST['name'], 
      $_POST['patronymic'],
      $_POST['email'],
      $_POST['phone'],
      $_POST['birth'],
      $_POST['login'],
      $_POST['password'],
      $_POST['password_confirm']);
    unset($_POST['submit']);
  }

?>
<!DOCTYPE html>
<html lang="ru">

  <?php require_once 'templates/head.php'; ?>

<body>

  <?php require_once 'templates/header.php'; ?>

  <div class="container">
    <form class="auth-form w-full df fc jcc aic" action="" method='post'>
      <h1 class="tac">Регистрация</h1>
      <input class='form-action' placeholder='Фамилия' name='surname' type="text" required>
      <input class='form-action' placeholder='Имя' name='name'  type="text" required>
      <input class='form-action' placeholder='Отчество' name='patronymic'  type="text" required>
      <input class='form-action' placeholder='Электронная почта' name='email'  type="email" required>
      <input class='form-action phone' placeholder="+7 (___) ___-__-__" name='phone' type="text" maxlength="18" required>
      <input class='form-action' name='birth' type="date" required>
      <input class='form-action' placeholder='Желаемый логин' name='login'  type="text" required>
      <input class='form-action' placeholder='Пароль' name='password'  type="password" minlength="8" required>
      <input class='form-action' placeholder='Повторите пароль' name='password_confirm'  type="password" minlength="8" required>
      <button class='form-action btn' name='submit' type='submit'>Зарегистрироваться</button>
      <p class='margin'>
        У вас уже есть аккаунт? - <a href="/auth-page.php">Войдите</a>!
      </p>
    </form>
  </div>

</body>
</html>
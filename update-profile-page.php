<?php 
  session_start();

  require_once 'database/requests.php';
  require_once 'templates/notification.php';

  if(!$_SESSION['user']) {
    header('Location: index.php');
  }

  if(isset($_POST['update'])) {
    $provider->updateProfile(
      $_POST['surname'], 
      $_POST['name'],
      $_POST['patronymic'],
      $_POST['email'],
      $_POST['phone'],
      $_POST['birth'],
      $_POST['login'],
      $_SESSION['user']['id']
    );
    unset($_POST['update']);
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
        <h3 class="tac">Личные данные</h3>
        <input class='form-action' value='<?= $user['surname'] ?>' placeholder='Фамилия' name='surname' type="text" required>
        <input class='form-action' value='<?= $user['name'] ?>' placeholder='Имя' name='name'  type="text"  required>
        <input class='form-action' value='<?= $user['patronymic'] ?>' placeholder='Отчество' name='patronymic'  type="text" required>
        <input class='form-action' value='<?= $user['email'] ?>' placeholder='Email' name='email'  type="email" required>
        <input class='form-action phone' value='<?= $user['phone'] ?>' placeholder="+7 (___) ___-__-__" name='phone'  type="text" maxlength="18" required>
        <input class='form-action' value='<?= $user['birth'] ?>' name='birth' type="date" required>
        <input class='form-action' value='<?= $user['login'] ?>' placeholder='Желаемый логин' name='login'  type="text" required>
        <button class="form-action btn" name='update' type="submit">Сохранить изменения</button>
      </form>

    </div>

  </div>

</body>
</html>
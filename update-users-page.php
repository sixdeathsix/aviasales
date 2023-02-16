<?php 
  session_start(); 

  if($_SESSION['user']['role'] != 3) {
    header('Location: index.php');
  }

  require_once 'database/requests.php';
  require_once 'templates/notification.php';

  $roles = $provider->getAllRoles();
  $user = $provider->getUserById($_GET['id']);

  if(isset($_POST['update'])) {
    $provider->updateUser(
      $_POST['surname'], 
      $_POST['name'],
      $_POST['patronymic'],
      $_POST['email'],
      $_POST['phone'],
      $_POST['login'],
      $_POST['password'],
      $_POST['role'],
      $_GET['id']
    );
    unset($_POST['update']);
  }

?>
<!DOCTYPE html>
<html lang="ru">

  <?php require_once 'templates/head.php'; ?>

<body>

  <?php require_once 'templates/header.php'; ?>

  <div class="container df jcsb fw">

    <?php require_once 'templates/aside.php'; ?>

    <main class="df fc jcc aic">
      <form class="auth-form w-full df fc jcc aic" action="" method='post'>
        <h3 class="tac">Редактирование пользователя</h3>
        <input class='form-action' value='<?= $user['surname'] ?>' placeholder='Фамилия' name='surname' type="text" required>
        <input class='form-action' value='<?= $user['name'] ?>' placeholder='Имя' name='name'  type="text"  required>
        <input class='form-action' value='<?= $user['patronymic'] ?>' placeholder='Отчество' name='patronymic'  type="text" required>
        <input class='form-action' value='<?= $user['email'] ?>' placeholder='Email' name='email'  type="email" required>
        <input class='form-action phone' value='<?= $user['phone'] ?>' placeholder="+7 (___) ___-__-__" name='phone'  type="text" maxlength="18" required>
        <input class='form-action' value='<?= $user['login'] ?>' placeholder='Желаемый логин' name='login'  type="text" required>
        <input class='form-action' value='<?= $user['password'] ?>' placeholder='Пароль' name='password' type="password" minlength="8" required>
        <select class='form-action' name='role' required>
          <?php foreach($roles as $role): ?>
            
            <?php if($role['role_id'] == $user['role_id']): ?>

              <option value="<?= $role['role_id']; ?>" selected>
                <?= $role['role']; ?>
              </option>

            <?php else: ?>

              <option value="<?= $role['role_id']; ?>">
                <?= $role['role']; ?>
              </option>

            <?php endif ?>
            
          <?php endforeach ?>
        </select>
        <button class="form-action btn" name='update' type="submit">
          Применить изменения
        </button>
      </form>
    </main>
  </div>

</body>
</html>
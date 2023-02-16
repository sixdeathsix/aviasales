<?php 
  session_start();

  require_once 'database/requests.php';
  require_once 'templates/notification.php';

  if ($_GET['result']) {
    $img = '/assets/images/check.png';
    $text = 'Билеты успешно забронированы';
  } else {
    $img = '/assets/images/close.png';
    $text = 'Произошла ошибка во время бронирования';
  }
  
?>

<!DOCTYPE html>
<html lang="ru">

  <?php require_once 'templates/head.php'; ?>

<body>

  <div class="container">
    
    <div class="result">

      <div class='result-logo'>
        <img src=<?= $img ?> alt="result">
      </div>

      <p class='result-text'><?= $text ?></p>

      <a class='result-link' href="index.php">Вернуться на главную</a>

    </div>

  </div>

</body>
</html>
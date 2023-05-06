<?php
  session_start();

  require_once './database/requests.php';
  require_once 'notification.php';

  $cities = $provider->getAllAirports();
  $classes = $provider->getAllClasses();

  if (isset($_POST['search'])) {
    $provider->getFromToFlight($_POST['from'], $_POST['to'], $_POST['there_date'], $_POST['back_date'], $_POST['class']);
    unset($_POST['search']);
  }

?>

<form id='search' class="main-form-action" action="" method="post">

  <input id="search-from" name='from' list="from" placeholder='Откуда' class='main-input' required>
  <datalist id="from">
    <?php foreach($cities as $city): ?>
      <option value="<?= $city['city'] ?>" >
    <?php endforeach; ?>
  </datalist>

  <input id="search-to" name='to' list="to" placeholder='Куда' class='main-input' required>
  <datalist id="to">
    <?php foreach($cities as $city): ?>
      <option value="<?= $city['city']; ?>" >
    <?php endforeach; ?>
  </datalist>

  <input id="search-there" type="text" placeholder='Когда' name="there_date" class='main-input date-input date-search-input' required>
  <input id="search-back" type="text" placeholder='Обратно' name="back_date" class='main-input date-input date-search-input'>

  <select id="search-class" name='class' class='main-input' required>
     <?php foreach($classes as $class): ?>
        <option value="<?= $class['class_id']; ?>" ><?= $class['class']; ?></option>
     <?php endforeach; ?>
  </select>

  <button id="search-btn" name='search' class='main-input'>Найти билеты</button>

</form>
<script src="../assets/js/search.js"></script>
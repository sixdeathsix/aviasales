<?php 
  session_start();

  require_once 'database/requests.php';
  require_once 'functions/methods.php';
  require_once 'templates/notification.php';

  $class = $_GET['class'];

  if ($class == '3') {
    $kf = 1;
  } elseif ($class == '2'){
    $kf = 1.3;
  } elseif ($class == '1') {
    $kf = 2;
  }
  
  foreach ($_SESSION['flights'] as $key) {

    $there = $key['there']; 
    $back = $key['back']; 

    $amount = ($there['price'] + $back['price']) * $kf;

    $prices[] = $amount;

  }

  if(isset($_POST['filter-price'])) {

    $_SESSION['value'] = $_POST['filter-price'];

    $_SESSION['filtered_flights'] = array_filter($_SESSION['flights'], function($k) {

      $class = $_GET['class'];

      if ($class == '3') {
        $kf = 1;
      } elseif ($class == '2'){
        $kf = 1.3;
      } elseif ($class == '1') {
        $kf = 2;
      }

      $_SESSION['value'] = $_POST['filter-price'];
      $there = $k['there']; 
      $back = $k['back'];
      
      $amount = ($there['price'] + $back['price']) * $kf;

      if ($amount <= $_SESSION['value']) {
        return $k;
      }

    });

    header("Location: flights-page.php?page=1&class=$class");

  } else {

    if (!$_SESSION['value']) {
      $_SESSION['value'] = max($prices);
      $_SESSION['filtered_flights'] = $_SESSION['flights'];
    }
  
  }
  
  $pagination = $mtd->pagination($_SESSION['filtered_flights'], 5, $_GET['page']);

  $flights = $pagination['array'];
  $pages = $pagination['pages'];

  if (isset($_POST['checkout'])) {

    $_SESSION['checkout'] = [
      'there' => $_POST['there'],
      'back' => $_POST['back'],
      'class' => $_GET['class'],
      'price' => $_POST['price'],
      'count' => $_POST['count']
    ];

    header('Location: checkout-page.php');
    unset($_POST['checkout']);
  }

?>
<!DOCTYPE html>
<html lang="ru">

  <?php require_once 'templates/head.php'; ?>

<body>

  <?php require_once 'templates/header.php'; ?>

  <div class='w-full df jcc aic bg padding'>

    <?php require_once 'templates/search.php'; ?>

  </div>

  <div class="container flight-container">

    <div class="tickets">

      <div class='price-filter'>
        <div class='price-filter-form'><span>Стоимость до</span> <span id='filter-price'><?= $_SESSION['value'] ?></span></div>
        <form class='price-filter-form' action="" method='post'>
          <input onchange="this.form.submit()" name='filter-price' class="filter-range" type="range" value="<?= $_SESSION['value'] ?>" min='<?= min($prices) ?>' max='<?= max($prices) ?>'>
        </form>
      </div>

      <?php if(!$flights): ?>

        <h2 class='tac'>Билетов не найдено</h2>

      <?php else: ?>

      <?php foreach($flights as $flight): ?>

        <?php 

          $there = $flight['there']; 
          $back = $flight['back']; 

          if ($back) {
            $seats = $back['seats'] < $there['seats'] ? $back['seats'] : $there['seats'];
          } else {
            $seats = $there['seats'];
          }

        ?>
        
        <form class='flight-form fw' action="" method='post'>

          <div class='flight-left'>

            <div>

              <input type="hidden" name='there' value='<?= $there['flight_id'] ?>'>

              <div>
                <div class="tac time"><?= $mtd->convTime($there['scheduled_departure']); ?></div>
                <div class="tac date"><?= $mtd->convDate($there['scheduled_departure']); ?></div>
              </div>

              <div class='code df jcsb aic w-half'>
                <div>
                  <p class='tac'><?= $there['departure_code']; ?></p>
                  <p class='tac city'><?= $there['departure_city']; ?></p>
                </div>
                <div>
                  <p class='tac'><?= $there['arrival_code']; ?></p>
                  <p class='tac city'><?= $there['arrival_city']; ?></p>
                </div>
              </div>

              <div>
                <div class="tac time"><?= $mtd->convTime($there['scheduled_arrival']); ?></div>
                <div class="tac date"><?= $mtd->convDate($there['scheduled_arrival']); ?></div>
              </div>

            </div>

            <?php if($back): ?>

            <hr>
          
            <div>

              <input type="hidden" name='back' value='<?= $back['flight_id'] ?>'>

              <div>
                <div class="tac time"><?= $mtd->convTime($back['scheduled_departure']); ?></div>
                <div class="tac date"><?= $mtd->convDate($back['scheduled_departure']); ?></div>
              </div>

              <div class='code df jcsb aic w-half'>
                <div>
                  <p class='tac'><?= $back['departure_code']; ?></p>
                  <p class='tac city'><?= $back['departure_city']; ?></p>
                </div>
                <div>
                  <p class='tac'><?= $back['arrival_code']; ?></p>
                  <p class='tac city'><?= $back['arrival_city']; ?></p>
                </div>
              </div>

              <div>
                <div class="tac time"><?= $mtd->convTime($back['scheduled_arrival']); ?></div>
                <div class="tac date"><?= $mtd->convDate($back['scheduled_arrival']); ?></div>
              </div>

            </div>

            <?php endif; ?>

          </div>

          <div class='flight-right'>
            <input id="checkout-price" name='price' value='<?= ($there['price'] + $back['price']) * $kf ?>' type="hidden">
            <p class='price'><?= ($there['price'] + $back['price']) * $kf ?> ₽</p>
            <button name='checkout' type='submit'>Купить</button>
            <?php if($seats > 9): ?>
            <input class='ticket-count' type="number" name='count' value='1' min='1' max='9'>
            <span>количество пассажиров</span>
            <?php else: ?>
            <input class='ticket-count' type="number" name='count' value='1' min='1' max='<?= $seats ?>'>
            <span class='danger'>осталось <?= $seats ?> мест</span>
            <?php endif; ?>
          </div>
          
        </form>

      <?php endforeach; ?>

      <?php endif; ?>

      <div class="pages">
        <?php for($i = 1; $i <= $pages; $i++): ?>
          <a 
            class="page-number <?= $_GET['page'] == $i ? 'selected' : '' ?>"
            href="<?= $url; ?>?page=<?= $i ?>&class=<?= $_GET['class'] ?>">
            <?= $i ?>
          </a>
        <?php endfor; ?>
      </div>

    </div>

  </div>

</body>
</html>
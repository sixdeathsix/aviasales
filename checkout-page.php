<?php 
  session_start();

  require_once 'database/requests.php';
  require_once 'templates/notification.php';

  $genders = $provider->getAllGenders();

  if (!$_SESSION['checkout']) {
    header('Location: index.php');
  }
 
  $there = $_SESSION['checkout']['there'];
  $back = $_SESSION['checkout']['back'];
  $price = $_SESSION['checkout']['price'];
  $class = $_SESSION['checkout']['class'];
  $count = $_SESSION['checkout']['count'];

  $phone = $_SESSION['user'] ? $_SESSION['user']['phone'] : '';
  $email = $_SESSION['user'] ? $_SESSION['user']['email'] : '';
  $surname = $_SESSION['user'] ? $_SESSION['user']['surname'] : '';
  $name = $_SESSION['user'] ? $_SESSION['user']['name'] : '';
  $patronymic = $_SESSION['user'] ? $_SESSION['user']['patronymic'] : '';
  $birth = $_SESSION['user'] ? $_SESSION['user']['birth'] : '';

  $seats = $provider->getSeats($there, $class);

  if(isset($_POST['clicked'])) {

    for ($i = 0; $i < $count; $i++) {
      
      $client = [
        'surname' => $_POST["surname_$i"],
        'name' => $_POST["name_$i"],
        'patronymic' => $_POST["patronymic_$i"],
        'gender' => $_POST["gender_$i"],
        'birth_date' => $_POST["date_$i"],
        'document' => $_POST["document_$i"],
        'seat' => $_POST["seat_$i"],
      ];

      $list[] = $client;

    }

    $provider->checkout(
      $there, 
      $list, 
      $_POST['phone'], 
      $_POST['email'], 
      $_SESSION['user']['id'], 
      $class,
      $_POST['price'],
      $back
    );

    unset($_POST['clicked']);
  }

?>
<!DOCTYPE html>
<html lang="ru">

  <?php require_once 'templates/head.php'; ?>

<body>

  <?php require_once 'templates/header.php'; ?>

  <div class="container">

    <form class="checkout-container" action='' method='post'>

      <div class='checkout-form'>
        <h2>Пассажир <?= 1 ?></h2>
        <div>
          <input class="checkout-input" type="text" name='surname <?= 0 ?>' value='<?= $surname ?>' placeholder='Фамилия' required>
          <input class="checkout-input" type="text" name='name <?= 0 ?>' value='<?= $name ?>' placeholder='Имя' required>
          <input class="checkout-input" type="text" name='patronymic <?= 0 ?>' value='<?= $patronymic ?>' placeholder='Отчество' required>
          <select class="checkout-input" name="gender <?= 0 ?>" required>
            <?php foreach($genders as $gender): ?>
              <option value='<?= $gender['gender_id'] ?>'><?= $gender['gender'] ?></option>
            <?php endforeach; ?>
          </select>
          <input class="checkout-input date-input" type="text" name='date <?= 0 ?>' value='<?= $birth ?>' placeholder='Дата рождения' required>
          <input class="checkout-input passport passport-checkout" type="text" name='document <?= 0 ?>' placeholder='Серия и номер паспорта' maxlength="12" required>
          <input class="checkout-input birth-certificate none" type="text" name='document <?= 0 ?>' placeholder='Номер свидетельства о рождении' maxlength="15" required>
          <div class="is-small">
            <input class="is-small-baby" type="checkbox">
            <span>Несовершеннолетний пассажир</span>
          </div>
          <div class="additional-services">
            <div class="add-checkbox"><input type="checkbox" class="luggage-checkbox"><span class="luggage-text">Добавить багаж</span></div>
            <div class="add-checkbox"><input type="checkbox" class="food-checkbox"><span class="food-text">Добавить питание</span></div>
            <div class="add-checkbox">
              <select class="select-seat" name="seat <?= 0 ?>">
                <option value="null" selected>Выбрать место</option>
                <?php foreach($seats as $seat): ?>
                  <option value='<?= $seat['seat_id'] ?>'><?= $seat['seat_no'] ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
        </div>
      </div>

      <?php for($i = 1; $i < $count; $i++): ?>
        <div class='checkout-form'>
          <h2>Пассажир <?= $i + 1 ?></h2>
          <div>
            <input class="checkout-input" type="text" name='surname <?= $i?>' placeholder='Фамилия' required>
            <input class="checkout-input" type="text" name='name <?= $i?>' placeholder='Имя' required>
            <input class="checkout-input" type="text" name='patronymic <?= $i?>' placeholder='Отчество' required>
            <select class="checkout-input" name="gender <?= $i?>" required>
              <?php foreach($genders as $gender): ?>
                <option value='<?= $gender['gender_id'] ?>'><?= $gender['gender'] ?></option>
              <?php endforeach; ?>
            </select>
            <input class="checkout-input date-input" type="text" name='date <?= $i?>' placeholder='Дата рождения' required>
            <input class="checkout-input passport passport-checkout" type="text" name='document <?= $i?>' placeholder='Серия и номер паспорта' maxlength="12" required>
            <input class="checkout-input birth-certificate none" type="text" name='document <?= $i?>' placeholder='Номер свидетельства о рождении' maxlength="15" required>
            <div class="is-small">
                <input class="is-small-baby" type="checkbox">
                <span>Несовершеннолетний пассажир</span>
            </div>
            <div class="additional-services">
              <div class="add-checkbox"><input type="checkbox" class="luggage-checkbox"><span class="luggage-text">Добавить багаж</span></div>
              <div class="add-checkbox"><input type="checkbox" class="food-checkbox"><span class="food-text">Добавить питание</span></div>
              <div class="add-checkbox">
                <select class="select-seat" name="seat <?= $i?>">
                  <option value="null" selected>Выбрать место</option>
                  <?php foreach($seats as $seat): ?>
                    <option value='<?= $seat['seat_id'] ?>'><?= $seat['seat_no'] ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
          </div>
        </div>
      <?php endfor; ?>
      
      <div class='checkout-contact-form'>

        <div class="checkout-contact">
          
          <span>Оставьте свой email и телефон, и мы будем сообщать вам обо всех изменениях в вашем бронировании или статусе рейса.</span>

          <input class="checkout-contact-input phone" placeholder="+7 (___) ___-__-__" name='phone' value='<?= $phone ?>' type="text" maxlength="18" required>
          <input class="checkout-contact-input" placeholder='Электронная почта' name='email' value='<?= $email ?>' type="email" required>

        </div>

        <div class='checkout-order'>
          <div class="checkout-price">
            <input id="price-input" type="hidden" name="price" value="<?= $price * $count ?>">
            Итого: <span id="checkout-price"><?= $price * $count ?></span> ₽
          </div>
          <button class='checkout-btn' name='clicked' type='submit'>Оформить</button>
        </div>
      </div>

    </form>
      
  </div>

  <script src="assets/js/checkout.js"></script>
</body>
</html>
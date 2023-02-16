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

  $price = $price * $count;

  if(isset($_POST['clicked'])) {

    for ($i = 0; $i < $count; $i++) {
      
      $client = [
        'surname' => $_POST["surname_$i"],
        'name' => $_POST["name_$i"],
        'patronymic' => $_POST["patronymic_$i"],
        'gender' => $_POST["gender_$i"],
        'birth_date' => $_POST["date_$i"],
        'document' => $_POST["document_$i"],
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
      $price,
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
      <?php for($i = 0; $i < $count; $i++): ?>
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
            <input class="checkout-input passport" type="text" name='document <?= $i?>' placeholder='Серия и номер паспорта' maxlength="12" required>
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
            Итого: <span><?= $price ?> ₽</span>
          </div>
          <button class='checkout-btn' name='clicked' type='submit'>Оформить</button>
        </div>
      </div>

    </form>
      
  </div>

</body>
</html>
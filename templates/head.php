<?php 

  session_start();

  $url = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

  if ($url == '/') {
    $title = 'Aviasales';  
  } else if ($url == '/auth-page.php') {
    $title = 'Авторизация';  
  } else if ($url == '/register-page.php') {
    $title = 'Регистрация';  
  }
  
?>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet" crossorigin="anonymous">
  <link rel="stylesheet" href="../assets/css/style.css" crossorigin="anonymous">
  <script defer src="../assets/js/to-image.js"></script>
  <script defer src="../assets/js/mask.js"></script>
  <script defer src="../assets/js/app.js"></script>
  <title><?= $title; ?></title>
</head>
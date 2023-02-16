<header>

  <div class="header df jcsb aic bg">

    <div class="burger">
      <a class="logo" href="/">Aviasales</a>
      <div class="toggle">
        <img class="toggle" src="../assets/images/menu.png" alt="menu">
      </div>
    </div>
    
    <div class="menu">

      <?php if($_SESSION['user']['role'] == '3'): ?>
        <a href="/admin-users-page.php?page=1">Админ Панель</a>
      <?php endif ?>

      <?php if(!$_SESSION['user']): ?>
        <a href="/auth-page.php">Войти</a>
      <?php else: ?>
        <a href="/profile-page.php?page=1">Профиль</a>
      <?php endif ?>
      
    </div>

  </div>

</header>
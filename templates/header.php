<header>

    <div class="header df jcsb aic bg">

        <div class="burger">
            <a class="logo" href="/">BestTravel</a>
            <div class="toggle">
                <img class="toggle" src="../assets/images/menu.png" alt="menu">
            </div>
        </div>

        <div class="menu df">

            <?php if ($_SESSION['user']['role'] == '3'): ?>
                <a href="/admin-users-page.php?page=1">Админ Панель</a>
            <?php endif ?>

            <?php if (!$_SESSION['user']): ?>
                <a href="/reviews-page.php">Отзывы</a>
                <a href="/auth-page.php">Войти</a>
            <?php else: ?>
                <a href="/reviews-page.php">Отзывы</a>
                <a class="df"
                   href="/profile-page.php?page=1">Профиль <?php if ($provider->getNotifications($_SESSION['user']['id'])): ?>
                        <span
                            class="badge"><?= count($provider->getNotifications($_SESSION['user']['id'])) ?></span><?php endif; ?>
                </a>
            <?php endif ?>

        </div>

    </div>

</header>
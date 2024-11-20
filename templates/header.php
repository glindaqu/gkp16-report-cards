<link rel="stylesheet" href="/report/static/css/style.css">

<header>
    <a href="/report/" class="header_logo">
        Report
    </a>
    <div class="header_group">
        <div class="header_options__item"><?= $_COOKIE['user_name'] ?></div>
        <a href="/report/authorize/logout" class="header_options__item">
            <button class="logout">
                Выйти
            </button>
        </a>
    </div>
</header>
<head>
    <link rel="stylesheet" href="style/header_footer_style.css" />
</head>
<div class="header">
    <a href="/index.php" class="header-text main_txt">Главная</a>
    <a href="/collections.php" class="header-text coll_txt">Подборки</a>
    <a href="/Tests.php" class="header-text test_txt">Тесты</a>
    <a href="/support.php" class="header-text help_txt">Помощь</a>
    <?php
    // Проверяем, авторизован ли пользователь
    if (!isset($_COOKIE['user'])) {
        echo ("<a href='/validation-form/login-form.php' class='header-text auth_txt'>войти</a>");
    }
    else echo ("<a href='/validation-form/login-form.php' class='header-text auth_txt'>Профиль</a>");
    ?>
    <a href="/" id="logo"></a>
</div>

<!DOCTYPE html>
<html lang="en">
<header>
    <img src="/style/img/Group_2.svg" class="custom-hdr logo">
    <a href="/index_new.php" class="custom-hdr custom-hdr_txt" id="main">Главная</a>
    <a href="/collections_new.php" class="custom-hdr custom-hdr_txt" id="collections">Задания</a>
    <a href="/support.php" class="custom-hdr custom-hdr_txt" id="help">Помощь</a>
    <?php
    // Проверяем, авторизован ли пользователь
    if (!isset($_COOKIE['user'])) {
        echo ("<a href='validation-form/login-form.php' class='custom-hdr custom-btn'>Войти</a>");
    } else {
        echo ("<a href='validation-form/profile.php' class='custom-hdr custom-btn'>Профиль</a>");
    }
    ?>
</header>
</html>
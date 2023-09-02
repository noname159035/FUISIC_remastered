<!DOCTYPE html>
<html lang="en">
<link href="/libs/bootstrap-5.3.1-dist/css/bootstrap.css" rel="stylesheet">
<div class="container">
    <header class="d-flex pb-2 flex-wrap align-items-center justify-content-center justify-content-md-between mb-4 border-bottom">
        <a href="/index_new.php" class="d-flex align-items-center col-md-2 mb-2 mb-md-0 text-dark text-decoration-none">
            <img src="/style/img/Group_2.svg" alt="" class="bi me-2" role="img" aria-label="Bootstrap">
        </a>

        <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
            <li><a href="/index_new.php" class="nav-link px-2 link-dark fs-4">Главная</a></li>
            <li><a href="/collections_new.php" class="nav-link px-2 link-dark fs-4">Задания</a></li>
            <li><a href="/help.php" class="nav-link px-2 link-dark fs-4">Помощь</a></li>
        </ul>

        <div class="col-md-2 text-end">
            <?php
            // Проверяем, авторизован ли пользователь
            if (!isset($_COOKIE['user'])) {
                echo ("<button type='button' onclick='window.location.href=\"/Validation-form/login-form.php\"' class='btn btn-outline-primary me-2 fs-5'>Войти</button>");
            } else {
                echo ("<button type='button' onclick='window.location.href=\"/Validation-form/profile.php\"' class='btn btn-primary me-2 fs-5'>Профиль</button>");
            }
            ?>
        </div>
    </header>
</div>
</html>
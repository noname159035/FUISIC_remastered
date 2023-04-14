<?php
if (!isset($_COOKIE['user'])) {
    header('Location: /login.php');
    exit();
}

$mysql = new mysqli('localhost', 'root', 'root', 'Test_3');

$user_code = $_COOKIE['user_code'];
$name = filter_var(trim($_POST['name']), FILTER_SANITIZE_STRING);
$second_name = filter_var(trim($_POST['second_name']), FILTER_SANITIZE_STRING);
$birth_day = filter_var(trim($_POST['birth_day']), FILTER_SANITIZE_STRING);

$mysql->query("UPDATE `Пользователи` SET `Имя`='$name', `Фамилия`='$second_name', `Дата рождения`='$birth_day' WHERE `Код пользователя`='$user_code'");
$mysql->close();

header('Location: /profile.php');
?>

<?php
$login = filter_var(trim($_POST['login']), FILTER_SANITIZE_STRING);
$pass = filter_var(trim($_POST['pass']), FILTER_SANITIZE_STRING);
$name = filter_var(trim($_POST['name']), FILTER_SANITIZE_STRING);
$second_name = filter_var(trim($_POST['second_name']), FILTER_SANITIZE_STRING);
$birth_day = filter_var(trim($_POST['birth_day']), FILTER_SANITIZE_STRING);
$birth_day = date('Y-m-d', strtotime($birth_day));

require_once ('../db.php');

global $link;

// Проверяем, существует ли e-mail в базе данных
$result = $link->query("SELECT * FROM `Пользователи` WHERE `e-mail` = '$login'");
if ($result->num_rows > 0) {
  // E-mail уже существует
    $link->close();
  header('Location: /register/email-exists/');
  exit();
}


// Хешируем пароль
$pass = md5($pass. "sadfasd123");

// Добавляем пользователя в базу данных
$link->query("INSERT INTO `Пользователи` (`e-mail`, `Password`, `Имя`, `Фамилия`, `Дата рождения`) VALUES ('$login', '$pass', '$name', '$second_name', '$birth_day')");

// Получаем код пользователя
$result = $link->query("SELECT * FROM `Пользователи` WHERE `e-mail` = '$login' AND `password` = '$pass'");
$user = $result->fetch_assoc();

// Устанавливаем куку с кодом пользователя
setcookie('user', $user['Код пользователя'], time() + 3600, "/");

// Закрываем соединение с базой данных
$link->close();

// Перенаправляем пользователя на страницу профиля
header('Location: /profile/');

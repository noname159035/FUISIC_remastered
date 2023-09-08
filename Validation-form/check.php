<?php
$login = filter_var(trim($_POST['login']), FILTER_SANITIZE_STRING);
$pass = filter_var(trim($_POST['pass']), FILTER_SANITIZE_STRING);
$name = filter_var(trim($_POST['name']), FILTER_SANITIZE_STRING);
$second_name = filter_var(trim($_POST['second_name']), FILTER_SANITIZE_STRING);
$birth_day = filter_var(trim($_POST['birth_day']), FILTER_SANITIZE_STRING);
$birth_day = date('Y-m-d', strtotime($birth_day));

// Проверяем, существует ли e-mail в базе данных
$mysql = new mysqli('localhost', 'p523033_admin', 'eQ5kJ0dN5a', 'p523033_Test_3');
$result = $mysql->query("SELECT * FROM `Пользователи` WHERE `e-mail` = '$login'");
if ($result->num_rows > 0) {
  // E-mail уже существует
  $mysql->close();
  header('Location: /Validation-form/register-form.php?error=email-exists');
  exit();
}


// Хешируем пароль
$pass = md5($pass. "sadfasd123");

// Добавляем пользователя в базу данных
$mysql->query("INSERT INTO `Пользователи` (`e-mail`, `Password`, `Имя`, `Фамилия`, `Дата рождения`) VALUES ('$login', '$pass', '$name', '$second_name', '$birth_day')");

// Получаем код пользователя
$result = $mysql->query("SELECT * FROM `Пользователи` WHERE `e-mail` = '$login' AND `password` = '$pass'");
$user = $result->fetch_assoc();

// Устанавливаем куку с кодом пользователя
setcookie('user', $user['Код пользователя'], time() + 3600, "/");

// Закрываем соединение с базой данных
$mysql->close();

// Перенаправляем пользователя на страницу профиля
header('Location: /validation-form/profile.php');

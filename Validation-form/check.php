<?php

require_once ('../db.php');

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

global $link;

$login = filter_var(trim($_POST['login']), FILTER_SANITIZE_STRING);
$pass = filter_var(trim($_POST['pass']), FILTER_SANITIZE_STRING);
$name = filter_var(trim($_POST['name']), FILTER_SANITIZE_STRING);
$second_name = filter_var(trim($_POST['second_name']), FILTER_SANITIZE_STRING);
$birth_day = filter_var(trim($_POST['birth_day']), FILTER_SANITIZE_STRING);
$birth_day = date('Y-m-d', strtotime($birth_day));

// Проверяем, существует ли e-mail в базе данных
$result = $link->query("SELECT * FROM `Пользователи` WHERE `e-mail` = '$login'");
if ($result->num_rows > 0) {
  // E-mail уже существует
  header('Location: /register/email-exists/');
  exit();
}
else{

    // Хешируем пароль
    $pass = md5($pass. "sadfasd123");

    $query = "INSERT INTO `Пользователи` (`e-mail`, `Password`, `Имя`, `Фамилия`, `Дата рождения`) VALUES (?, ?, ?, ?, ?)";
    $stmt = $link->prepare($query);

    if ($stmt) {
        // Привязываем параметры к подготовленному выражению
        $stmt->bind_param('sssss', $login, $pass, $name, $second_name, $birth_day);

        // Выполняем подготовленное выражение
        if ($stmt->execute()) {
            // Получаем ID вставленной записи
            $user_id = $link->insert_id;
            // Здесь можно добавить дополнительную логику после успешной вставки
        } else {
            // Обработка ошибки выполнения запроса
            die("Ошибка выполнения запроса: " . $stmt->error);
        }

        // Закрываем подготовленное выражение
        $stmt->close();
    } else {
        // Обработка ошибки подготовки запроса
        die("Ошибка подготовки запроса: " . $link->error);
    }
// Устанавливаем куку с кодом пользователя
    setcookie('user', $user_id, time() + 3600, "/");

// Закрываем соединение с базой данных
    $link->close();

// Перенаправляем пользователя на страницу профиля
    header('Location: /profile/');
}



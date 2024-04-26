<?php

require_once ('../db.php');

global $link;

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);


$login = filter_var(trim ($_POST['login']),
    FILTER_SANITIZE_STRING) ;
$pass = filter_var(trim ($_POST['pass']),
    FILTER_SANITIZE_STRING) ;

$pass = md5($pass."sadfasd123");

$query = "SELECT * FROM `Пользователи` WHERE `e-mail` = ? AND `Password` = ?";
$stmt = $link->prepare($query);

if ($stmt) {
    // Привязываем параметры к подготовленному выражению
    $stmt->bind_param('ss', $login, $pass);

    // Выполняем подготовленное выражение
    if ($stmt->execute()) {
        // Получаем ID вставленной записи
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user) {
            setcookie('user', $user['Код пользователя'], time() + 3600, "/");
            header('location: /');
        } else {
            header('Location: /Validation-form/login-form.php?error=account-doesnt_exists');
            exit();
        }
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
<?php

require_once ('../db.php');

global $link;

$login = filter_var(trim ($_POST['login']),
    FILTER_SANITIZE_STRING) ;
$pass = filter_var(trim ($_POST['pass']),
    FILTER_SANITIZE_STRING) ;


$pass = md5($pass."sadfasd123");

$result = $link->query("SELECT * FROM `Пользователи` WHERE `e-mail` = '$login' AND `password` = '$pass'");
if (!$result) {
  echo "Ошибка запроса: " . $link->error;
  exit();
}

$user = $result->fetch_assoc();

if ($user) {
    setcookie('user', $user['Код пользователя'], time() + 3600, "/");
    header('location: /');
} else {
    header('Location: /Validation-form/login-form.php?error=account-doesnt_exists');
    exit();
}

$link->close();
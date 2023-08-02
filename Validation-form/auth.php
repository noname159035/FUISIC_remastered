<?php
$login = filter_var(trim ($_POST['login']),
    FILTER_SANITIZE_STRING) ;
$pass = filter_var(trim ($_POST['pass']),
    FILTER_SANITIZE_STRING) ;


$pass = md5($pass."sadfasd123");

$mysql = new mysqli('localhost', 'p523033_admin', 'eQ5kJ0dN5a', 'p523033_Test_3');

$result = $mysql->query("SELECT * FROM `Пользователи` WHERE `e-mail` = '$login' AND `password` = '$pass'");
if (!$result) {
  echo "Ошибка запроса: " . $mysql->error;
  exit();
}

$user = $result->fetch_assoc();

if (count($user) == 0) {
  echo "Такой пользователь не найден";
  exit ();
}

setcookie('user', $user['Код пользователя'], time() + 3600, "/");
$mysql->close();
header('location: /index_new.php');
?>

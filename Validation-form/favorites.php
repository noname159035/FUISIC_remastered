<?php
// Проверяем, авторизован ли пользователь
if (!isset($_COOKIE['user'])) {
    header('Location: /validation-form/login-form.php');
    exit();
}

$mysql = new mysqli('localhost', 'p523033_admin', 'eQ5kJ0dN5a', 'p523033_Test_3');
$user_id = $_COOKIE['user'];
$result = $mysql->query("SELECT * FROM `Пользователи` WHERE `Код пользователя`='$user_id'");
$sql = "SELECT `Пользователи`.*, `Типы пользователей`.`Тип` FROM `Пользователи`
        INNER JOIN `Типы пользователей` ON `Пользователи`.`Тип пользователя`=`Типы пользователей`.`Код типа пользователя`
        WHERE `Пользователи`.`Код пользователя`='$user_id'";
$result = $mysql->query($sql);
$user = $result->fetch_assoc();

?>
<! DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content=" ie=edge">
    <title>Избранное</title>
    <link rel="stylesheet" href="/style/background_style.css">
</head>
<body>
<div class="background">

    <?php include '../header.php'?>

    <div class="container">
        <h1>Данная страница еще не готова, наберитесь терпения!</h1>

        <a href="login-form.php" class="header-text auth_txt">Вернуться</a>
    </div>

    <?php include '../footer.php'?>

</div>
</body>
</html>


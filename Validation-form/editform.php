<?php
// Проверяем, авторизован ли пользователь
if (!isset($_COOKIE['user'])) {
    header('Location: /login.php');
    exit();
}

// Получаем данные пользователя по коду из куки
$user_code = $_COOKIE['user_code'];
$mysql = new mysqli('localhost', 'root', 'root', 'Test_3');
$result = $mysql->query("SELECT * FROM `Пользователи` WHERE `Код пользователя`='$user_code'");
$user = $result->fetch_assoc();
$mysql->close();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Редактирование данных пользователя</title>
    </head>
    <body>
        <h1>Редактирование данных пользователя</h1>
        <form action="/edit.php" method="post">
            <p>
                <label for="name">Имя:</label>
                <input type="text" id="name" name="name" value="<?php echo $user['Имя']; ?>">
            </p>
            <p>
                <label for="second_name">Фамилия:</label>
                <input type="text" id="second_name" name="second_name" value="<?php echo $user['Фамилия']; ?>">
            </p>
            <p>
                <label for="birth_day">Дата рождения:</label>
                <input type="date" id="birth_day" name="birth_day" value="<?php echo $user['Дата рождения']; ?>">
            </p>
            <p>
                <input type="submit" value="Сохранить">
            </p>
        </form>
    </body>
</html>

<?php
if (!isset($_COOKIE['user'])) {
    header('Location: /validation-form/login-form.php');
    exit();
}

// Подключение к БД
$mysql = new mysqli('localhost', 'p523033_admin', 'eQ5kJ0dN5a', 'p523033_Test_3');

// Получение ID пользователя для удаления
$user_id = $_GET['id'];

// Получение данных пользователя для подтверждения удаления
$result = $mysql->query("SELECT * FROM `Пользователи` WHERE `Код пользователя`='$user_id'");
$user = mysqli_fetch_assoc($result);

// Обработка удаления пользователя
if (isset($_POST['confirm_delete'])) {
    $mysql->query("DELETE FROM `Пользователи` WHERE `Код пользователя`='$user_id'");
    header('Location: users.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Пользователи</title>
    <link rel="stylesheet" href="/style/background_style.css">
</head>
<body>
<div class="background">

    <?php include '../header.php'?>

    <div class="container">
        <h1>Удаление пользователя</h1>
        <p>Вы действительно хотите удалить пользователя <?php echo $user['Имя']. ' ' . $user['Фамилия']?>?</p>
        <form method="post">
            <input type="hidden" name="user_id" value="<?php echo $user_id;?>">
            <button type="submit" name="confirm_delete" class="btn btn-danger">Удалить</button>
            <a href="/Validation-form/Users.php" class="btn btn-secondary">Отменить</a>
        </form>
    </div>

    <?php include '../footer.php'?>

</div>
</body>
</html>
<?php
if (!isset($_COOKIE['user'])) {
    header('Location: /login/');
    exit();
}

// Подключение к БД
require_once ('../db.php');

global $link;


// Получение ID пользователя для удаления
$user_id = $_GET['id'];

// Получение данных пользователя для подтверждения удаления
$result = $link->query("SELECT * FROM `Пользователи` WHERE `Код пользователя`='$user_id'");
$user = mysqli_fetch_assoc($result);

// Обработка удаления пользователя
if (isset($_POST['confirm_delete'])) {
    $link->query("DELETE FROM `Пользователи` WHERE `Код пользователя`='$user_id'");
    header('Location: /users/');
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
</head>
<body class="bg-light">

<?php include '../inc/header.php' ?>

<div class="container">
    <h1>Удаление пользователя</h1>
    <p>Вы действительно хотите удалить пользователя <?php echo $user['Имя']. ' ' . $user['Фамилия']?>?</p>
    <form method="post">
        <input type="hidden" name="user_id" value="<?php echo $user_id;?>">
        <button type="submit" name="confirm_delete" class="btn btn-danger">Удалить</button>
        <a href="/users/" class="btn btn-secondary">Отменить</a>
    </form>
</div>

<?php include '../inc/footer.php' ?>

</body>
</html>
<?php
if (!isset($_COOKIE['user'])) {
    header('Location: /validation-form/login-form.php');
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
        <?php
        // Подключение к БД
        $mysql = new mysqli('localhost', 'p523033_admin', 'eQ5kJ0dN5a', 'p523033_Test_3');
        $user_id = $_COOKIE['user'];
        if (isset($_POST['search_query'])) {
            $search_query = $_POST['search_query'];
            $result = $mysql->query("SELECT * FROM `Пользователи` WHERE `Имя` LIKE '%$search_query%' OR `Фамилия` LIKE '%$search_query%' OR `e-mail` LIKE '%$search_query%'");
        } else {
            $result = $mysql->query("SELECT * FROM `Пользователи` WHERE `Код пользователя`!= '$user_id'");
            $sql = "SELECT `Пользователи`.*, `Типы пользователей`.`Тип` FROM `Пользователи`
        INNER JOIN `Типы пользователей` ON `Пользователи`.`Тип пользователя`=`Типы пользователей`.`Код типа пользователя`
        WHERE `Пользователи`.`Код пользователя`!='$user_id'";
            $result = $mysql->query($sql);
        }
        ?>
        <form class="form-inline my-2 my-lg-0" method="post">
            <label>
                <input class="form-control mr-sm-2" type="text" name="search_query" placeholder="Поиск...">
            </label>
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Найти</button>
            <button class="btn btn-outline-danger my-2 my-sm-0" type="button" onclick="window.location.href='users.php'">Отмена</button>
        </form>

        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Тип</th>
                <th>e-mail</th>
                <th>Имя</th>
                <th>Фамилия</th>
                <th>Пароль</th>
                <th>Дата рождения</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            <?php
            //Кнопка бан будет сделана позже
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<tr>
                    <td>'. $row['Код пользователя']. '</td>
                    <td>'. $row['Тип']. '</td>
                    <td>'. $row['e-mail']. '</td>
                    <td>'. $row['Имя']. '</td>
                    <td>'. $row['Фамилия']. '</td>
                    <td>'. $row['Password']. '</td>
                    <td>'. date('d.m.Y', strtotime($row['Дата рождения'])). '</td>
                    <td>
                        <a href="edit_user.php?id='. $row['Код пользователя']. '" class="btn btn-primary">Редактировать</a>
                        <a href="ban_user.php?id='. $row['Код пользователя']. '" class="btn btn-danger">Бан</a> 
                        <a href="delete_user.php?id='. $row['Код пользователя']. '" class="btn btn-danger">Удалить</a>
                    </td>
                </tr>';
            }
            ?>
            </tbody>
        </table>
        <div class="button">
            <a href="profile.php" class="btn btn-secondary">Отменить</a>
        </div>
    </div>

    <?php include '../footer.php'?>

</div>
</body>
</html>

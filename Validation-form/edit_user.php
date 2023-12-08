<?php
if (!isset($_COOKIE['user'])) {
    header('Location: /login/');
    exit();
}

// Подключение к БД
$mysql = new mysqli('localhost', 'p523033_admin', 'eQ5kJ0dN5a', 'p523033_Test_3');

// Получение ID пользователя и данных для редактирования
$user_id = $_GET['id'];
$result = $mysql->query("SELECT * FROM `Пользователи` WHERE `Код пользователя` = '$user_id'");
$row = mysqli_fetch_assoc($result);

//Обработка отправки формы
if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $userType = $_POST['userType'];
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $password = $_POST['password'];
    $password = md5($password. "sadfasd123");
    $birthdate = $_POST['birthdate'];
    $birthdate = date('Y-m-d', strtotime($birthdate));


// Обновление данных пользователя в БД
    $mysql->query("UPDATE `Пользователи` SET `e-mail` = '$email', `Тип пользователя` = '$userType', `Имя` = '$name', `Фамилия` = '$surname', `Password` = '$password', `Дата рождения` = '$birthdate' WHERE `Код пользователя` = '$user_id'");

// Перенаправление на страницу профиля пользователя
    header('Location: /users/');
    exit();
}
?>


<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Пользователи</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>

<body class="bg-light d-flex flex-column h-100">

    <?php include '../inc/header.php' ?>

    <div class="container">
        <h1>Редактирование профиля</h1>
        <form method="post">
            <div class="form-group">
                <label for="userType">Тип пользователя</label>
                <select class="form-control" id="userType" name="userType" required>
                    <?php
                    $query_dif = "SELECT * FROM `Типы пользователей`";
                    $result_dif = mysqli_query($mysql, $query_dif);

                    while ($row_dif = mysqli_fetch_assoc($result_dif)) {
                        echo '<option value="' . $row_dif['Код типа пользователя'] . '">' . $row_dif['Тип'] . '</option>';
                    }
                    mysqli_free_result($result_dif);
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $row['e-mail']?>">
            </div>
            <div class="form-group">
                <label for="name">Имя:</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $row['Имя']?>">
            </div>
            <div class="form-group">
                <label for="surname">Фамилия:</label>
                <input type="text" class="form-control" id="surname" name="surname" value="<?php echo $row['Фамилия']?>">
            </div>
            <div class="form-group">
                <label for="password">Пароль:</label>
                <input type="password" class="form-control" id="password" name="password" value="<?php echo $row['Password']?>">
            </div>
            <div class="form-group">
                <label for="birthdate">Дата рождения:</label>
                <input type="date" class="form-control" id="birthdate" name="birthdate" value="<?php echo date('d.m.Y', strtotime($row['Дата рождения']))?>">
            </div>
            <a href="/Validation-form/Users.php" class="btn btn-secondary">Отменить</a>
            <button type="submit" class="btn btn-primary" name="submit">Сохранить</button>
        </form>
    </div>

    <?php include '../inc/footer.php' ?>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    // свойства календаря
    flatpickr("#birthdate", {
        allowInput: true,
        dateFormat: "d.m.Y",
        maxDate: "today",
        minDate: "01.01.1900",
    });
</script>

</body>
</html>

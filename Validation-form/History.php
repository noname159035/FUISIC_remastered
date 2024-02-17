<?php
// Подключение к БД
require_once ('../db.php');

global $link;

// Получение данных о зарегистрированном пользователе
if (!isset($_COOKIE['user'])) {
    header('Location: /validation-form/login-form.php');
    exit();
}

$user_id = $_COOKIE['user'];

// Определяем выбранную сортировку
$sort = $_GET['sort'] ?? 'date_desc';
$order = ($sort == 'date_asc') ? 'ASC' : 'DESC';

// Выборка всех записей истории для зарегистрированного пользователя, отсортированных по дате
$query = "SELECT `История`.`Дата прохождения задания`, `Подборки`.`Название` FROM `История` JOIN `Подборки`
          ON `История`.`Подборка` = `Подборки`.`Код подборки`
          WHERE `История`.`Пользователь` = $user_id ORDER BY `История`.`Дата прохождения задания` $order";

$result = mysqli_query($link, $query);

if (!$result) {
    die('Ошибка запроса: ' . mysqli_error($link));
}

$query2 = "SELECT `История тестов`.Дата_прохождения_задания, Тесты.Название, `История тестов`.Результат FROM `История тестов` JOIN Тесты
          ON `История тестов`.Тест = Тесты.Код_Теста
          WHERE `История тестов`.Пользователь = $user_id ORDER BY `История тестов`.Дата_прохождения_задания $order";

$result2 = mysqli_query($link, $query2);

if (!$result2) {
    die('Ошибка запроса: ' . mysqli_error($link));
}
?>
<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <title>История прохождения заданий</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body class="bg-light d-flex flex-column h-100">

<?php include '../inc/header.php' ?>

<div class="container">
    <h2>История прохождения заданий</h2>
    <div class="row">
        <div class="col-md-4 text-center">
            <h4>Сортировать по:</h4>
        </div>
        <div class="col-md-4 text-right">
            <button class="btn btn-default" id="sort-date-asc">По возрастанию</button>
            <button class="btn btn-default" id="sort-date-desc">По убыванию</button>
        </div>
    </div>

    <table class="table">
        <thead>
        <tr>
            <th>#</th>
            <th>Подборка</th>
            <th>Дата прохождения задания</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $i = 1;
        while ($row = mysqli_fetch_assoc($result)) { ?>

            <tr>
                <td><?php echo $i ?></td>
                <td><?php echo $row['Название'] ?></td>
                <td><?php  echo $row['Дата прохождения задания'] ?></td>
            </tr>

            <?php
            $i++;
        }
        ?>
        </tbody>
    </table>

    <table class="table">
        <thead>
        <tr>
            <th>#</th>
            <th>Тест</th>
            <th>Дата прохождения задания</th>
            <th>Результат</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $i = 1;
        while ($row = mysqli_fetch_assoc($result2)) {
            ?>

            <tr>
                <td><?php echo $i ?></td>
                <td><?php echo $row['Название'] ?></td>
                <td><?php  echo $row['Дата_прохождения_задания'] ?></td>
                <td><?php  echo $row['Результат'] ?>%</td>
            </tr>

        <?php
            $i++;
        }
        ?>
        </tbody>
    </table>

    <?php
    // Закрытие соединения с БД
    mysqli_close($link);
    ?>

    <div class="button">
        <a href="/profile/" class="btn btn-secondary float-end">Отменить</a>
    </div>

</div>

<?php include '../inc/footer.php' ?>

<script src="/libs/jquery-3.6.1.min.js"></script>
<script src="/libs/bootstrap-5.3.1-dist/js/bootstrap.min.js"></script>

<script>
    // Обработчики клика по кнопкам сортировки
    $('#sort-date-asc').on('click', function() {
        window.location.href = '/Validation-form/history.php?sort=date_asc';
    });

    $('#sort-date-desc').on('click', function() {
        window.location.href = '/Validation-form/history.php?sort=date_desc';
    });
</script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>История прохождения заданий</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/style/background_style.css"/>
</head>

<body>
<div class="background">

    <?php include '../header.php'?>

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
        <?php
        // Подключение к БД
        $db = new mysqli('localhost', 'p523033_admin', 'eQ5kJ0dN5a', 'p523033_Test_3');

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
        $result = mysqli_query($db, $query);
        if (!$result) {
            die('Ошибка запроса: ' . mysqli_error($db));
        }

        $query2 = "SELECT `История тестов`.Дата_прохождения_задания, Тесты.Название, `История тестов`.Результат FROM `История тестов` JOIN Тесты
          ON `История тестов`.Тест = Тесты.Код_Теста
          WHERE `История тестов`.Пользователь = $user_id ORDER BY `История тестов`.Дата_прохождения_задания $order";
        $result2 = mysqli_query($db, $query2);
        if (!$result2) {
            die('Ошибка запроса: ' . mysqli_error($db));
        }

        // Формирование HTML-таблицы с данными
        echo '<table class="table">';
        echo '<thead>';
        echo '<tr><th>#</th><th>Подборка</th><th>Дата прохождения задания</th></tr>';
        echo '</thead>';
        echo '<tbody>';
        $i = 1;
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr><td>'.$i.'</td><td>'.$row['Название'].'</td><td>'.$row['Дата прохождения задания'].'</td></tr>';
            $i++;
        }
        echo '</tbody>';
        echo '</table>';
        $result = mysqli_query($db, $query);

        if (!$result) {
            die('Ошибка запроса: ' . mysqli_error($db));
        }

        echo '<table class="table">';
        echo '<thead>';
        echo '<tr><th>#</th><th>Тест</th><th>Дата прохождения задания</th><th>Результат</th></tr>';
        echo '</thead>';
        echo '<tbody>';
        $i = 1;
        while ($row = mysqli_fetch_assoc($result2)) {
            echo '<tr><td>'.$i.'</td><td>'.$row['Название'].'</td><td>'.$row['Дата_прохождения_задания'].'</td><td>'.$row['Результат'].'</td></tr>';
            $i++;
        }
        echo '</tbody>';
        echo '</table>';
        $result2 = mysqli_query($db, $query2);

        if (!$result2) {
            die('Ошибка запроса: ' . mysqli_error($db));
        }
        // Закрытие соединения с БД
        mysqli_close($db);
        ?>

        <div class="button">
            <a href="profile.php" class="btn btn-secondary" style="float: right;">Отменить</a>
        </div>

    </div>

    <?php include '../footer.php'?>

</div>

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

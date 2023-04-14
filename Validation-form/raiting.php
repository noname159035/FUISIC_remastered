<!DOCTYPE html>
<html>
    <head>
        <title>Рейтинг пользователей</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    </head>
    <body>
        <div class="container">
            <h2>Рейтинг пользователей</h2>
            <?php
            // Подключение к БД
            $db = new mysqli('localhost', 'root', 'root', 'Test_3');

            // Выборка всех пользователей и их количества выполненных заданий, отсортированных по убыванию
            $query = "SELECT `Пользователи`.`Имя`, COUNT(*) AS `Количество_заданий` FROM `История` JOIN `Пользователи`
          ON `История`.`Пользователь` = `Пользователи`.`Код пользователя` GROUP BY `Пользователи`.`Имя`
          ORDER BY `Количество_заданий` DESC";
            $result = mysqli_query($db, $query);

            // Формирование HTML-таблицы с данными
            echo '<table class="table">';
            echo '<thead>';
            echo '<tr><th>#</th><th>Имя пользователя</th><th>Количество выполненных заданий</th></tr>';
            echo '</thead>';
            echo '<tbody>';
            $i = 1;
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<tr><td>'.$i.'</td><td>'.$row['Имя'].'</td><td>'.$row['Количество_заданий'].'</td></tr>';
                $i++;
            }
            echo '</tbody>';
            echo '</table>';

            if (!$result) {
                die('Ошибка запроса: ' . mysqli_error($db));
            }
            // Закрытие соединения с БД
            mysqli_close($db);
            ?>
            <div class="col-md-4">
                <a href="/Validation-form/profile.php" class="btn btn-primary">Перейти в профиль</a>
            </div>
        </div>
    </body>
</html>

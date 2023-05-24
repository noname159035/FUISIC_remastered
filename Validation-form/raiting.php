<!DOCTYPE html>
<html>
    <head>
        <title>Рейтинг пользователей</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="/style/collections_style.css"/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    </head>
    <body>
    <div class="header">
        <a href="/index.php" class="header-text main_txt">Главная</a>
        <a href="/collections.php" class="header-text coll_txt">Подборки</a>
        <a href="/Tests.php" class="header-text test_txt">Тесты</a>
        <a href="/support.php" class="header-text help_txt">Помощь</a>
        <?php
        // Проверяем, авторизован ли пользователь
        if (!isset($_COOKIE['user'])) {
            echo ("<a href='/validation-form/login-form.php' class='header-text auth_txt'>войти</a>");
        }
        else echo ("<a href='/validation-form/login-form.php' class='header-text auth_txt'>Профиль</a>");
        ?>
        <a href="/index.php" id="logo"></a>

    </div>
        <div class="container">
            <h2>Рейтинг пользователей</h2>
            <?php
            // Подключение к БД
            $db = new mysqli('localhost', 'p523033_admin', 'eQ5kJ0dN5a', 'p523033_Test_3');

            // Выборка всех пользователей и их количества выполненных заданий, отсортированных по убыванию
            $query = "SELECT `Пользователи`.`Имя`, COUNT(*) AS `Количество_заданий` FROM `История` JOIN `Пользователи`
          ON `История`.`Пользователь` = `Пользователи`.`Код пользователя` GROUP BY `Пользователи`.`Имя`
          ORDER BY `Количество_заданий` DESC";
            $result = mysqli_query($db, $query);

            $query2 = "SELECT `Пользователи`.`Имя`, COUNT(*) AS `Количество_заданий_2` FROM `История тестов` JOIN `Пользователи`
          ON `История тестов`.`Пользователь` = `Пользователи`.`Код пользователя` GROUP BY `Пользователи`.`Имя`
          ORDER BY `Количество_заданий_2` DESC";
            $result2 = mysqli_query($db, $query2);

            // Формирование HTML-таблицы с данными
            echo '<h4>Рейтинг по подборкам</h4>';
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

            echo '<h4>Рейтинг по тестам</h4>';
            echo '<table class="table">';
            echo '<thead>';
            echo '<tr><th>#</th><th>Имя пользователя</th><th>Количество выполненных заданий</th></tr>';
            echo '</thead>';
            echo '<tbody>';
            $i = 1;
            while ($row = mysqli_fetch_assoc($result2)) {
                echo '<tr><td>'.$i.'</td><td>'.$row['Имя'].'</td><td>'.$row['Количество_заданий_2'].'</td></tr>';
                $i++;
            }
            echo '</tbody>';
            echo '</table>';

            if (!$result2) {
                die('Ошибка запроса: ' . mysqli_error($db));
            }
            // Закрытие соединения с БД
            mysqli_close($db);
            ?>
        </div>

    </body>
</html>

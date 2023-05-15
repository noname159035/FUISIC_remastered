<!DOCTYPE html>
<html>
    <head>
        <title>История прохождения заданий</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
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
            echo ("<a href='/Validation-form/login-form.php' class='header-text auth_txt'>войти</a>");
        }
        else echo ("<a href='/Validation-form/login-form.php' class='header-text auth_txt'>Профиль</a>");
        ?>
        <a href="index.php" id="logo"></a>

    </div>
        <div class="container">
            <h2>История прохождения заданий</h2>
            <div class="row">
                <div class="col-md-4">
                    <a href="/Validation-form/profile.php" class="btn btn-primary">вернуться</a>
                </div>
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
            // Закрытие соединения с БД
            mysqli_close($db);
            ?>
            <div class="col-md-4">
                <a href="/Validation-form/profile.php" class="btn btn-primary">Перейти в профиль</a>
            </div>
        </div>
        <script>
            // Обработчики клика по кнопкам сортировки
            $('#sort-date-asc').on('click', function() {
                window.location.href = '/validation-form/History.php?sort=date_asc';
            });

            $('#sort-date-desc').on('click', function() {
                window.location.href = '/validation-form/History.php?sort=date_desc';
            });
        </script>
    </body>
</html>

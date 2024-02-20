<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <title>Рейтинг пользователей</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body class="bg-light d-flex flex-column h-100">

<?php include '../inc/header.php' ?>

<div class="container">
    <h2>Рейтинг пользователей</h2>
    <?php
    // Подключение к БД
    require_once ('../db.php');

    global $link;

    // Выборка всех пользователей и их количества выполненных заданий, отсортированных по убыванию
    $query = "SELECT `Пользователи`.`Имя`, COUNT(*) AS `Количество_заданий` FROM `История` JOIN `Пользователи`
          ON `История`.`Пользователь` = `Пользователи`.`Код пользователя` GROUP BY `Пользователи`.`Имя`
          ORDER BY `Количество_заданий` DESC";
    $result = mysqli_query($link, $query);

    $query2 = "SELECT `Пользователи`.`Имя`, COUNT(*) AS `Количество_заданий_2` FROM `История тестов` JOIN `Пользователи`
          ON `История тестов`.`Пользователь` = `Пользователи`.`Код пользователя` GROUP BY `Пользователи`.`Имя`
          ORDER BY `Количество_заданий_2` DESC";
    $result2 = mysqli_query($link, $query2);

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
        die('Ошибка запроса: ' . mysqli_error($link));
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
        die('Ошибка запроса: ' . mysqli_error($link));
    }

    // Закрытие соединения с БД
    mysqli_close($link);
    ?>

    <a href="/profile/" class="btn btn-primary">Вернуться</a>

</div>

<?php include '../inc/footer.php' ?>

<script src="/libs/jquery-3.6.1.min.js"></script>
<script src="/libs/bootstrap-5.3.1-dist/js/bootstrap.min.js"></script>

</body>

</html>

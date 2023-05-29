<!DOCTYPE html>
<html lang="en">
<head>
    <title>База данных</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style/index_style.css">
    <link rel="stylesheet" href="style/collections_style.css">
</head>
<body>
<div class="container">

    <div class="header">
        <a href="index.php" class="header-text main_txt">Главная</a>
        <a href="collections.php" class="header-text coll_txt">Подборки</a>
        <a href="Tests.php" class="header-text test_txt">Тесты</a>
        <a href="support.php" class="header-text help_txt">Помощь</a>
        <?php
        // Проверяем, авторизован ли пользователь
        if (!isset($_COOKIE['user'])) {
            echo ("<a href='validation-form/login-form.php' class='header-text auth_txt'>войти</a>");
        }
        else echo ("<a href='validation-form/login-form.php' class='header-text auth_txt'>Профиль</a>");
        ?>
        <a href="index.php" id="logo"></a>

    </div>
    <form method="GET" action="show_tasks.php">
        <?php
        // подключение к базе данных
        $link = new mysqli('localhost', 'p523033_admin', 'eQ5kJ0dN5a', 'p523033_Test_3');

        // проверка на успешное подключение
        if ($link->connect_error) {
            die("Ошибка подключения: " . $link->connect_error);
        }

        // запрос на выборку данных из таблицы "Разделы"
        $query = "SELECT * FROM Разделы";
        $result = mysqli_query($link, $query);

        // проверка на успешное выполнение запроса
        if (!$result) {
            die("Ошибка выполнения запроса: " . mysqli_error($link));
        }

        // вывод данных на страницу
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<p class="name_of_collections">' . $row['Название'] . '</p>';

            $query2 = "SELECT * FROM Тесты WHERE Раздел = '{$row['Код Раздела']}'";
            $result2 = mysqli_query($link, $query2);

            if (!$result2) {
                die("Ошибка выполнения запроса: " . mysqli_error($link));
            }

            echo '<div class="btn-group-horizontal mt-2" id="conteiner_mt" role="group">';

            while ($row2 = mysqli_fetch_assoc($result2)) {
                echo '<a class="coll_block ph start_ph p_ph" id="coll_block_text" href="show_tasks.php?test=' . $row2['Код_Теста'] . '">' . $row2['Название'] . '</a>';
            }

            echo '</div>';

            mysqli_free_result($result2);
        }

        // очистка результата запроса и закрытие соединения с базой
        mysqli_free_result($result);
        mysqli_close($link);
        ?>
    </form>
</div>


<script>
    function startTest(testId) {
        window.location.href = "test.php?id="+testId;
    }
</script>

<script src="/libs/jquery-3.6.1.min.js"></script>

</body>
</html>
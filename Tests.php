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

    <?php include 'header.php'?>

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

    <?php include 'footer.php'?>

</div>

<script>
    function startTest(testId) {
        window.location.href = "test.php?id="+testId;
    }
</script>

<script src="/libs/jquery-3.6.1.min.js"></script>

</body>
</html>
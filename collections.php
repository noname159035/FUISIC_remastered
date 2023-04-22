<!DOCTYPE html>
<html>
    <head>
        <title>База данных</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="style/index_style.css" />
        <link rel="stylesheet" href="style/collections_style.css">
    </head>
    <body>
        <div class="container">
            <div class="header">
                <a href="index.html" class="header-text main_txt">Главная</a>
                <a href="collections.php" class="header-text coll_txt">Подборки</a>
                <a href="Tests.php" class="header-text test_txt">Тесты</a>
                <a href="support.html" class="header-text help_txt">Помощь</a>
                <a href="Validation-form/login-form.php" class="header-text auth_txt">войти</a>
                <a href="index.html" id="logo"></a>
            

                <p class="name_of_collections"></p>

            </div>

            <form method="GET" action="show_cards.php">
                <?php
                $link = new mysqli('localhost', 'root', 'root', 'Test_3');
                $query = "SELECT * FROM Разделы";
                $result = mysqli_query($link, $query);

                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<p class="name_of_collections">' . $row['Название'] . '</p>';


                    $query2 = "SELECT * FROM Подборки WHERE Раздел = '{$row['Код Раздела']}'";
                    $result2 = mysqli_query($link, $query2);

                    // echo '<div class="btn-group-horizontal mt-2" role="group">';
                    echo '<div class="btn-group-horizontal mt-2" id="conteiner_mt" role="group">';


                    while ($row2 = mysqli_fetch_assoc($result2)) {
                        echo '<a class="coll_block ph start_ph p_ph" id="coll_block_text" href="show_cards.php?podbor=' . $row2['Код подборки'] . '">' . $row2['Название'] . '</a>';
                    }

                    echo '</div>';

                    mysqli_free_result($result2);
                }

                mysqli_free_result($result);
                mysqli_close($link);
                ?>
            </form>
        </div>

        <script src="jquery-3.6.1.min.js"></script>
    </body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <!-- Иконки -->
    <link rel="apple-touch-icon" sizes="180x180" href="/favicons/apple-touch-icon.png"/>
    <link rel="icon" type="image/png" sizes="32x32" href="/favicons/favicon-32x32.png"/>
    <link rel="icon" type="image/png" sizes="16x16" href="/favicons/favicon-16x16.png"/>
    <link rel="manifest" href="/favicons/site.webmanifest"/>
    <link rel="mask-icon" href="/favicons/safari-pinned-tab.svg" color="#5bbads5"/>

    <link rel="stylesheet" href="style/collections_new_style.css" />
    <link rel="stylesheet" href="style/header_footer_style_black.css" />

    <meta name="msapplication-TileColor" content="#2b5797"/>
    <meta
            name="theme-color" content="#ffffff"/>
    <!--    <script src="main.js"></script>-->
    <title>FUISIC</title>
    <!-- Шрифты -->
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet"/>
</head>
<body>

<header>
    <img src="style/img/Group_2.svg" class="hdr logo">

    <a href="#" class="hdr hdr_txt" id="main">Главная</a>
    <a href="#" class="hdr hdr_txt" id="collections">Подборки</a>
    <a href="#" class="hdr hdr_txt" id="tests">Тесты</a>
    <a href="#" class="hdr hdr_txt" id="help">Помощь</a>
    <?php
    // Проверяем, авторизован ли пользователь
    if (!isset($_COOKIE['user'])) {
        echo ("<button class='hdr btn'>Войти</button>");
    }
    else echo ("<button class='hdr btn'>Профиль</button>");
    ?>
</header>
<div class="container">

    <div style="align-items: center; flex-direction: column; display: flex;">
        <div class="search">
            <input type="text" placeholder="Тема подборки или теста" id="search_input">
            <div>
                <img src="style/img/search_ico.svg" alt="" style="cursor: pointer;" id="search_button">
            </div>
        </div>
    </div>

    <a href="collections.php">Старый дизайн</a>

    <div class="filter_conteiner">
        <div style="display: flex; height: 100%; justify-content: space-evenly;">
            <div class="filter nonselected"><p style="margin-top: 5%">Математика</p></div>
            <div class="filter selected sel_purple"><p style="margin-top: 5%">7Класс</p></div>
            <div class="filter selected sel_blue"><p style="margin-top: 5%">Давление</p></div>
            <div class="filter selected sel_green"><p style="margin-top: 5%">Тип</p></div>
        </div>
    </div>


    <?php
    $link = new mysqli('localhost', 'p523033_admin', 'eQ5kJ0dN5a', 'p523033_Test_3');
    $query = "SELECT * FROM Разделы";
    $result = mysqli_query($link, $query);

    while ($row = mysqli_fetch_assoc($result)) {

        $query2 = "SELECT * FROM Подборки WHERE Раздел = '{$row['Код Раздела']}'";
        $result2 = mysqli_query($link, $query2);

        echo '<div class="btn-group-horizontal mt-2" id="container_mt" role="group">';

        while ($row2 = mysqli_fetch_assoc($result2)) {
            $query3 = "SELECT COUNT(*) FROM Карточка WHERE Подборка = '{$row2['Код подборки']}'";
            $result3 = mysqli_query($link, $query3);
            $row_count_cards = mysqli_fetch_assoc($result3)['COUNT(*)'];
            $row_time_cards = round($row_count_cards*1.2);
            ?>
            <form method="GET" action="show_cards.php">
                <a class="coll_block ph start_ph p_ph" id="name_of_collection" href="show_cards.php?podbor=<?php echo $row2['Код подборки'];?>">
                    <div class="collection">
                        <p id="name_of_collection" ><?php echo $row2['Название'];?></p>
                        <p id="name_of_chapter"><?php echo $row['Название'];?></p>
                        <p id="type_of_task">Тип: Карточки</p>
                        <div class="property">
                            <div class="quantity_сont">
                                <p id="number_formul"><?php echo $row_count_cards;?></p>
                                <p style="margin-top: 11%; margin-left: 7%;font-size: 1.2vw; font-family: sans-serif; color: #9587FF">формул(ы)</p>
                            </div>
                            <div class="time_сont">
                                <img src="style/img/clock.svg" style="width: 15%; margin-top: -35%; margin-right: 3%">
                                <p id="number_time" style="margin-top: 5%; font-size: 1.3vw; font-family: sans-serif; color: #9587FF"><?php echo $row_time_cards;?></p>
                                <p style="margin-top: 6%; margin-left: 4%; font-size: 1.2vw; font-family: sans-serif; color: #9587FF">минут(ы)</p>
                            </div>
                        </div>
                    </div>
                </a>
            </form>
            <?php
        }
        echo '</div>';
        mysqli_free_result($result2);


        $query2 = "SELECT * FROM Тесты WHERE Раздел = '{$row['Код Раздела']}'";
        $result2 = mysqli_query($link, $query2);

        while ($row2 = mysqli_fetch_assoc($result2)) {
            $query3 = "SELECT COUNT(*) FROM Задачи WHERE Тест = '{$row2['Код_Теста']}'";
            $result3 = mysqli_query($link, $query3);
            $row_count_cards = mysqli_fetch_assoc($result3)['COUNT(*)'];
            $row_time_cards = round($row_count_cards*1.2);
            ?>
            <form method="GET" action="show_tasks.php">
                <a class="coll_block ph start_ph p_ph" id="name_of_collection" href="show_tasks.php?test=<?php echo $row2['Код_Теста'];?>">
                    <div class="collection">
                        <p id="name_of_collection" ><?php echo $row2['Название'];?></p>
                        <p id="name_of_chapter"><?php echo $row['Название'];?></p>
                        <p id="type_of_task">Тип: Тесты</p>
                        <div class="property">
                            <div class="quantity_сont">
                                <p id="number_formul"><?php echo $row_count_cards;?></p>
                                <p style="margin-top: 11%; margin-left: 7%;font-size: 1.2vw; font-family: sans-serif; color: #9587FF">Задач(а)</p>
                            </div>
                            <div class="time_сont">
                                <img src="style/img/clock.svg" style="width: 15%; margin-top: -35%; margin-right: 3%">
                                <p id="number_time" style="margin-top: 5%; font-size: 1.3vw; font-family: sans-serif; color: #9587FF"><?php echo $row_time_cards;?></p>
                                <p style="margin-top: 6%; margin-left: 4%; font-size: 1.2vw; font-family: sans-serif; color: #9587FF">минут(ы)</p>
                            </div>
                        </div>
                    </div>
                </a>
            </form>
            <?php
        }
        echo '</div>';
        mysqli_free_result($result2);

    }
    mysqli_free_result($result);
    mysqli_close($link);
    ?>

</div>
<footer>
    <div class="media">
        <div class="media_left">
            <div class="media_left_btn">
                <img src="style/img/tg.svg" alt="" style="cursor: pointer; width: 3vw">
                <img src="style/img/mail.svg" alt="" style="cursor: pointer; width: 3vw; margin-left: 2vw">
            </div>
            <div class="text media_left_text"> © 2023 FUISIC, Inc </div>
        </div>

        <div class="media_right">
            <div class="media_right_text text"><p href="" style="cursor: pointer; text-decoration: none;">Поддержка</p></div>
            <div class="media_right_text text"><p href="" style="cursor: pointer; text-decoration: none;">Условия</p></div>
            <div class="media_right_text text"><p href="" style="cursor: pointer; text-decoration: none;">Конфидициальность</p></div>
        </div>
    </div>
</footer>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="scrypts/index_scrypt.js"></script>
<script>
    $(document).ready(function() {
        $('#search_button').click(function() {
            var search_query = $('#search_input').val();
            if (search_query!= '') {
                $('.collection').each(function() {
                    var collection_name = $(this).find('#name_of_collection').text();
                    var chapter_name = $(this).find('#name_of_chapter').text();
                    if (collection_name.toLowerCase().indexOf(search_query.toLowerCase())!= -1 || chapter_name.toLowerCase().indexOf(search_query.toLowerCase())!= -1) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            } else {
                $('.collection').show();
            }
        });
    });
</script>
</body>
</html>
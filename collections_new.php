<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>

    <!-- Стили -->
    <link rel="stylesheet" href="style/collections_new_style.css" />
    <link rel="stylesheet" href="style/header_footer_style_black.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <meta name="msapplication-TileColor" content="#2b5797"/>
    <meta
            name="theme-color" content="#ffffff"/>
    <!--    <script src="main.js"></script>-->

    <title>FUISIC</title>

</head>
<body>



<div class="container_1">

    <?php include 'header.php';?>

    <div style="align-items: center; flex-direction: column; display: flex;">
        <div class="search">
            <input type="text" placeholder="Тема подборки или теста" id="search_input">
            <div>
                <img src="style/img/search_ico.svg" alt="" style="cursor: pointer;" id="search_button">
            </div>
        </div>
    </div>

    <div class="filter_container">
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

                        <div class="property">
                            <div class="quantity_сont">
                                <p id="number_formul" style="margin-top: 5%; font-size: 2vw; font-family: sans-serif; color: #9587FF"><?php echo $row_count_cards;?></p>
                                <p style="margin-top: 15%; margin-left: 7%;font-size: 1.2vw; font-family: sans-serif; color: #9587FF">формул(ы)</p>
                            </div>
                            <div class="time_сont">
<!--                                <img src="style/img/clock.svg" style="width: 15%; margin-top: -35%; margin-right: 3%">-->
                                <p id="number_time" style="margin-top: 7%; font-size: 2vw; font-family: sans-serif; color: #9587FF"><?php echo $row_time_cards;?></p>
                                <p style="margin-top: 17%; margin-left: 4%; font-size: 1.2vw; font-family: sans-serif; color: #9587FF">минут(ы)</p>
                            </div>
                            <p id="name_of_chapter" style="margin-top: 2.5%; margin-left: 7%;font-size: 1.2vw; font-family: sans-serif; color: #9587FF"><?php echo $row['Название'];?></p>
                            <p id="type_of_task" style="margin-top: 2.5%; margin-left: 7%;font-size: 1.2vw; font-family: sans-serif; color: #9587FF">Тип: Карточки</p>
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

        echo '<div class="btn-group-horizontal mt-2" id="container_mt" role="group">';

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
                        <div class="property">
                            <div class="quantity_сont">
                                <p id="number_formul" style="margin-top: 5%; font-size: 2vw; font-family: sans-serif; color: #9587FF"><?php echo $row_count_cards;?></p>
                                <p style="margin-top: 15%; margin-left: 7%;font-size: 1.2vw; font-family: sans-serif; color: #9587FF">Задач(а)</p>
                            </div>
                            <div class="time_сont">
<!--                                <img src="style/img/clock.svg" style="width: 15%; margin-top: -35%; margin-right: 3%">-->
                                <p id="number_time" style="margin-top: 7%; font-size: 2vw; font-family: sans-serif; color: #9587FF"><?php echo $row_time_cards;?></p>
                                <p style="margin-top: 17%; margin-left: 4%; font-size: 1.2vw; font-family: sans-serif; color: #9587FF">минут(ы)</p>
                            </div>
                            <p id="name_of_chapter" style="margin-top: 2.5%; margin-left: 7%;font-size: 1.2vw; font-family: sans-serif; color: #9587FF"><?php echo $row['Название'];?></p>
                            <p id="type_of_task" style="margin-top: 2.5%; margin-left: 7%;font-size: 1.2vw; font-family: sans-serif; color: #9587FF">Тип: Тесты</p>
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

    <?php include 'footer.php';?>
</div>



<script src="libs/jquery-3.6.1.min.js"></script>

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
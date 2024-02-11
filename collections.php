<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content=" ie=edge">
    <title>Задания</title>
</head>
<body class="bg-light d-flex flex-column h-100">

<?php include 'inc/header.php';?>

<!--<div class="container">-->
<!--    <div class="filter_container">-->
<!--        <div style="display: flex; height: 100%; justify-content: space-evenly;">-->
<!--            <div><p style="margin-top: 5%">Математика</p></div>-->
<!--            <div><p style="margin-top: 5%">7Класс</p></div>-->
<!--            <div><p style="margin-top: 5%">Давление</p></div>-->
<!--            <div><p style="margin-top: 5%">Тип</p></div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->

<div class="album py-5">
    <?php
    require_once ('db.php');

    global $link;

    $query = "SELECT * FROM Разделы";
    $result = mysqli_query($link, $query);

    while ($row = mysqli_fetch_assoc($result)) {

    $query2 = "SELECT * FROM Подборки WHERE Раздел = '{$row['Код Раздела']}'";
    $result2 = mysqli_query($link, $query2);
    ?>
    <div class="container">
        <h2 class="mt-3"><?php echo $row['Название'];?></h2>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3 mt-1">
            <?php
            while ($row2 = mysqli_fetch_assoc($result2)) {
                $query3 = "SELECT COUNT(*) FROM Карточка WHERE Подборка = '{$row2['Код подборки']}'";
                $result3 = mysqli_query($link, $query3);
                $row_count_cards = mysqli_fetch_assoc($result3)['COUNT(*)'];
                $row_time_cards = round($row_count_cards*1.2);
                ?>
                <div class="col">
                    <div class="card shadow-sm">
                        <img class="bd-placeholder-img card-img-top" width="100%" height="225"  role="img" alt="" src="/style/img/F_2.svg">
                        <div class="card-body">
                            <h3><?php echo $row2['Название'];?></h3>
                            <p class="card-text"><?php echo $row['Название'];?></p>
                            <p class="card-text">Тип: Карточки</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group">
                                    <a class="btn btn-outline-primary" href="cards/<?php echo $row2['Код подборки'];?>">Начать</a>
                                </div>
                                <small class="text-muted"><?php echo $row_time_cards;?> минут(ы)</small>
                                <small class="text-muted"><?php echo $row_count_cards;?> формул(ы)</small>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
            mysqli_free_result($result2);

            $query2 = "SELECT * FROM Тесты WHERE Раздел = '{$row['Код Раздела']}'";
            $result2 = mysqli_query($link, $query2);

            while ($row2 = mysqli_fetch_assoc($result2)) {
                $query3 = "SELECT COUNT(*) FROM Задачи WHERE Тест = '{$row2['Код_Теста']}'";
                $result3 = mysqli_query($link, $query3);
                $row_count_cards = mysqli_fetch_assoc($result3)['COUNT(*)'];
                $row_time_cards = round($row_count_cards*1.2);
                ?>
                <div class="col">
                    <div class="card shadow-sm">
                        <img class="bd-placeholder-img card-img-top" width="100%" height="225"  role="img" alt="" src="/style/img/F_2.svg">
                        <div class="card-body">
                            <h3><?php echo $row2['Название'];?></h3>
                            <p class="card-text"><?php echo $row['Название'];?></p>
                            <p class="card-text">Тип: Тест</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group">
                                    <a class="btn btn-outline-primary" href="test/<?php echo $row2['Код_Теста'];?>">Начать</a>
                                </div>
                                <small class="text-muted"><?php echo $row_time_cards;?> минут(ы)</small>
                                <small class="text-muted"><?php echo $row_count_cards;?> задач(и)</small>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
            echo '</div>';
            mysqli_free_result($result2);
            ?>
        </div>
        <?php
        }
        mysqli_free_result($result);
        mysqli_close($link);
        ?>
    </div>
</div>

<?php include 'inc/footer.php';?>

<script src="libs/jquery-3.6.1.min.js"></script>
<script src="libs/bootstrap-5.3.1-dist/js/bootstrap.min.js"></script>

</body>
</html>
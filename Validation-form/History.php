<?php
// Подключение к БД
require_once ('../db.php');

global $link;

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

$result = mysqli_query($link, $query);

if (!$result) {
    die('Ошибка запроса: ' . mysqli_error($link));
}

$query2 = "SELECT `История тестов`.Дата_прохождения_задания, Тесты.Название, `История тестов`.Результат FROM `История тестов` JOIN Тесты
          ON `История тестов`.Тест = Тесты.Код_Теста
          WHERE `История тестов`.Пользователь = $user_id ORDER BY `История тестов`.Дата_прохождения_задания $order";

$result2 = mysqli_query($link, $query2);

if (!$result2) {
    die('Ошибка запроса: ' . mysqli_error($link));
}
?>
<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <title>История прохождения заданий</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body class="bg-light d-flex flex-column h-100">

<?php include '../inc/header.php' ?>

<div class="container">
    <h2>История прохождения заданий</h2>
    <div class="row align-items-center">
        <div class="col-md-6">
            <h4 class="mb-0">Сортировать по:</h4>
        </div>
        <div class="col-md-6 text-right">
            <div class="btn-group">
                <button class="btn btn-outline-primary" id="sort-date-asc">По возрастанию</button>
                <button class="btn btn-outline-primary" id="sort-date-desc">По убыванию</button>
            </div>
        </div>
    </div>

    <h3>Подборки</h3>

    <ul class="list-unstyled">
        <?php
        $i = 1;
        while ($row = mysqli_fetch_assoc($result)) { ?>
            <li class="media mb-3 p-3" style="border-bottom: 1px solid #ddd;">
                <!-- Если у вас есть изображения, раскомментируйте этот блок
                <img src="path_to_image" class="mr-3" alt="...">
                -->
                <div class="media-body">
                    <h5 class="mt-0 mb-1" style="color: #0056b3;"><?php echo $i . '. ' . $row['Название']; ?></h5>
                    <p style="font-size: 0.9em; color: #555;">Дата прохождения задания: <?php echo $row['Дата прохождения задания']; ?></p>
                </div>
            </li>
            <?php
            $i++;
        }
        ?>
    </ul>

    <h3>Тесты</h3>

    <ul class="list-unstyled">
        <?php
        $i = 1;
        while ($row = mysqli_fetch_assoc($result2)) { ?>
            <li class="media mb-3 p-3" style="border-bottom: 1px solid #ddd; ">
                <!-- Если у вас есть изображения, раскомментируйте этот блок
                <img src="path_to_image" class="mr-3" alt="...">
                -->
                <div class="media-body">
                    <h5 class="mt-0 mb-1" style="color: #0056b3;"><?php echo $i . '. ' . $row['Название']; ?></h5>
                    <?php
                    $result = $row['Результат'];
                    $color = '';
                    if ($result <= 30) {
                        $color = 'red';
                    } else if ($result <= 60) {
                        $color = 'orange';
                    } else {
                        $color = 'green';
                    }
                    ?>
                    <b class="mt-0 mb-1">Результат: <span style="color: <?php echo $color; ?>"><?php echo $result; ?>%</span></b>
                    <p style="font-size: 0.9em; color: #555;">Дата прохождения задания: <?php echo $row['Дата_прохождения_задания']; ?></p>
                </div>
            </li>
            <?php
            $i++;
        }
        ?>
    </ul>

    <?php
    // Закрытие соединения с БД
    mysqli_close($link);
    ?>

    <a href="/profile/" class="btn btn-primary">Вернуться</a>


</div>

<?php include '../inc/footer.php' ?>

<script src="/libs/jquery-3.6.1.min.js"></script>
<script src="/libs/bootstrap-5.3.1-dist/js/bootstrap.min.js"></script>

<script>
    // Обработчики клика по кнопкам сортировки
    $('#sort-date-asc').on('click', function() {
        window.location.href = '/Validation-form/history.php?sort=date_asc';
    });

    $('#sort-date-desc').on('click', function() {
        window.location.href = '/Validation-form/history.php?sort=date_desc';
    });
</script>
</body>
</html>

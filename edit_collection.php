<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Редактор подборок</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/style/collections_style.css"/>
    <link rel="stylesheet" href="/validation-form/level.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.3.0/css/all.css" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
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
    <?php

    if (!isset($_COOKIE['user'])) {
        header("Location: /validation-form/login-form.php");
        exit;
    }
    if (!isset($_GET['podbor'])) {
        echo "<h1>Подборка не выбрана!</h1>";
        exit();
    }
    $link = new mysqli('localhost', 'p523033_admin', 'eQ5kJ0dN5a', 'p523033_Test_3');
    $query = "SELECT Название FROM Подборки WHERE `Код подборки` = ?";
    $stmt = $link->prepare($query);
    $stmt->bind_param('s', $_GET['podbor']);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 0) {
        echo "<h1>Подборка не найдена!</h1>";
        exit();
    }
    $collectionName = $result->fetch_array(MYSQLI_ASSOC)['Название'];
    ?>
    <h1 class="collection_name">Подборка: <?php echo $collectionName ?></h1>
</div>
<?php

// Получение заданий из базы данных
$query = "SELECT Описание, Формула, Пояснение FROM Карточка WHERE `Подборка` = ? ORDER BY `Код задания` ASC";
$stmt = $link->prepare($query);
$stmt->bind_param('s', $_GET['podbor']);
$stmt->execute();
$result = $stmt->get_result();

$cardArr = [];
while ($row = $result->fetch_assoc()) {
    $card = [
        'formula' => $row['Формула'],
        'description' => $row['Описание'],
        'explanation'=> $row['Пояснение']
    ];
    array_push($cardArr, $card);
}
// Определение текущей карточки
$currentCards = 0;
if (isset($_GET['card']) && $_GET['card'] >= 0 && $_GET['card'] < count($cardArr)) {
    $currentCards = $_GET['card'];
}

// Обработка изменения значений задания
$var = $currentCards + 1;

if (isset($_POST['formula']) && isset($_POST['description']) && isset($_POST['explanation'])) {
    $query = "UPDATE Карточка SET `Формула` = ?, `Описание` = ?, `Пояснение` = ? WHERE `Подборка` = ? AND `Код задания` = ?";
    $stmt = $link->prepare($query);
    $stmt->bind_param('sssss', $_POST['formula'], $_POST['description'], $_POST['explanation'], $_GET['podbor'], $var);
    if ($stmt->execute()) {
        echo "<div class='alert alert-success' role='alert'>Задание успешно изменено!</div>";
        $cardArr[$currentCards]['formula'] = $_POST['formula'];
        $cardArr[$currentCards]['description'] = $_POST['description'];
        $cardArr[$currentCards]['explanation'] = $_POST['explanation'];
    }
    else {
        echo "<div class='alert alert-danger' role='alert'>Не удалось изменить задание!</div>";
    }
}

// Вывод текущей карточки
$card = $cardArr[$currentCards];
echo "<div class='card'>";
echo "<form method='post'>";
echo "<h5 class='mt-3'>Формула:</h5>";
echo "<h3><input type='text' class='form-control' name='card' value='" . $card['formula'] . "'></h3>";
echo "<h5 class='mt-3'>Описание:</h5>";
echo "<textarea class='form-control' name='description' rows='5'>" . $card['description'] . "</textarea>";
echo "<h5 class='mt-3'>Пояснение:</h5>";
echo "<textarea class='form-control' name='explanation' rows='10'>" . $card['explanation'] . "</textarea>";
echo "<p>Задача " . ($currentCards + 1) . " из " . count($cardArr) . "</p>";
?>
<div class='buttons'>
    <?php
    // Предыдущая карточка
    if ($currentCards > 0) {
        $prevCard = $currentCards - 1;
        echo "<a href='?podbor=" . $_GET['podbor'] . "&card=" . $prevCard . "' class='button prev-button'><svg width='82' height='64' viewBox='0 0 82 64' fill='none' xmlns='http://www.w3.org/2000/svg'><path d='M51.25 16L30.75 32L51.25 48' stroke='#0C507C' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'/></svg></a>";
    } else {
        echo "<a href='#' class='button prev-button disabled pointer-events-none'><svg width='82' height='64' viewBox='0 0 82 64' fill='none' xmlns='http://www.w3.org/2000/svg'><path d='M51.25 16L30.75 32L51.25 48' stroke='#CDD4D9' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'/></svg></a>";
    }

    // Следующая карточка
    if ($currentCards < count($cardArr) - 1) {
        $nextCard = $var;
        echo "<a href='?podbor=" . $_GET['podbor'] . "&card=" . $nextCard . "' class='button next-button'><svg width='82' height='64' viewBox='0 0 82 64' fill='none' xmlns='http://www.w3.org/2000/svg'><path d='M30.75 48L51.25 32L30.75 16' stroke='#0C507C' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'/></svg></a>";
    } else {
        echo "<a href='#' class='button next-button disabled pointer-events-none'><svg width='82' height='64' viewBox='0 0 82 64' fill='none' xmlns='http://www.w3.org/2000/svg'><path d='M30.75 48L51.25 32L30.75 16' stroke='#CDD4D9' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'/></svg></a>";
    }
    ?>
    <button type='button' class='btn btn-success mt-3' onclick='addCards()'>Добавить задачу</button>
    <?php
    if (count($cardArr) > 1) {
        echo "<button type='button' class='btn btn-danger mt-3' onclick='deleteCards()'>Удалить задачу</button>";
    }
    ?>
    <button type='submit' class='btn btn-primary mt-3'>Сохранить</button>
    <a href='/my_base.php' class='btn btn-info mt-3'>Закончить</a>
</div>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script>
    function addCards() {
        var url = "/add_card.php?podbor=<?php echo $_GET['podbor'] ?>";
        window.location.href = url;
    }

    function deleteCards() {
        if (confirm("Вы уверены, что хотите удалить задачу?")) {
            var url = "/delete_card.php?pobor=<?php echo $_GET['podbor'] ?>&card=<?php echo $currentCards ?>";
            window.location.href = url;
        }
    }
</script>
</html>


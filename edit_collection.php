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

<?php
include("header.php");
?>

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
    $podborName = $result->fetch_array(MYSQLI_ASSOC)['Название'];
    ?>
    <h1 class="podbor_name">Подборка: <?php echo $podborName ?></h1>
</div>

<?php

// Получение заданий из базы данных
$query = "SELECT `Код задания`, Формула, Описание, Пояснение FROM Карточка WHERE `Подборка` = ? ORDER BY `Код задания` ASC";
$stmt = $link->prepare($query);
$stmt->bind_param('s', $_GET['podbor']);
$stmt->execute();
$result = $stmt->get_result();

$cardArr = [];

while ($row = $result->fetch_assoc()) {
    $card = [
        'card_id' => $row['Код задания'], // Значение поля Код_задачи
        'formula' => $row['Формула'],
        'description' => $row['Описание'],
        'explanation'=> $row['Пояснение']
    ];
    array_push($cardArr, $card);
}

// Определение текущей карточки
$currentCard = 0;
if (isset($_GET['card']) && $_GET['card'] >= 0 && $_GET['card'] < count($cardArr)) {
    $currentCard = $_GET['card'];
}

// Обработка изменения значений задания
if (isset($_POST['formula']) && isset($_POST['description']) && isset($_POST['explanation'])) {
    $query = "UPDATE Карточка SET `Формула` = ?, `Описание` = ?, `Пояснение` = ? WHERE `Подборка` = ? AND `Код задания` = ?";
    $stmt = $link->prepare($query);
    $stmt->bind_param('sssss', $_POST['formula'], $_POST['description'], $_POST['explanation'], $_GET['podbor'], $_POST['card_id']);
    if ($stmt->execute()) {
        echo "<div class='alert alert-success' role='alert'>Задание успешно изменено!</div>";
        $cardArr[$currentCard]['formula'] = $_POST['formula'];
        $cardArr[$currentCard]['description'] = $_POST['description'];
        $cardArr[$currentCard]['explanation'] = $_POST['explanation'];
    }
    else {
        echo "<div class='alert alert-danger' role='alert'>Не удалось изменить задание!</div>";
    }
}

// Вывод текущей карточки
$card = $cardArr[$currentCard];
if (count($cardArr) == 0) {
    echo "<h1>Карточки в подборке не найдены</h1>";
    echo "<p>Добавьте карточки в подборку, чтобы начать редактирование</p>";
}
else {
    // Вывод формы редактирования
    echo "<div class='formula'>";
    echo "<form method='post'>";
    echo "<h5 class='mt-3'>формула:</h5>";
    echo "<textarea class='form-control' name='formula' rows='3'>" . $card['formula'] . "</textarea>";
    echo "<h5 class='mt-3'>Описание:</h5>";
    echo "<textarea type='text' class='form-control' name='description' rows='5'>" . $card['description'] . "</textarea>";
    echo "<h5 class='mt-3'>Пояснение:</h5>";
    echo "<textarea class='form-control' name='explanation' rows='10'>" . $card['explanation'] . "</textarea>";
    echo "<p>Карточка " . ($currentCard + 1) . " из " . count($cardArr) . "</p>";
    echo "<input type='hidden' name='card_id' value=' " . $card['card_id'] . "'>";
}

?>

<div class='buttons'>

    <?php
    // Предыдущая карточка
    if ($currentCard > 0) {
        $prevCard = $currentCard - 1;
        echo "<a href='?podbor=" . $_GET['podbor'] . "&card=" . $prevCard . "' class='button prev-button'><svg width='82' height='64' viewBox='0 0 82 64' fill='none' xmlns='http://www.w3.org/2000/svg'><path d='M51.25 16L30.75 32L51.25 48' stroke='#0C507C' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'/></svg></a>";
    } else {
        echo "<a href='#' class='button prev-button disabled pointer-events-none'><svg width='82' height='64' viewBox='0 0 82 64' fill='none' xmlns='http://www.w3.org/2000/svg'><path d='M51.25 16L30.75 32L51.25 48' stroke='#CDD4D9' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'/></svg></a>";
    }

    // Следующая карточка
    if ($currentCard < count($cardArr) - 1) {
        $nextCard = $currentCard + 1;
        echo "<a href='?podbor=" . $_GET['podbor'] . "&card=" . $nextCard . "' class='button next-button'><svg width='82' height='64' viewBox='0 0 82 64' fill='none' xmlns='http://www.w3.org/2000/svg'><path d='M30.75 48L51.25 32L30.75 16' stroke='#0C507C' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'/></svg></a>";
    } else {
        echo "<a href='#' class='button next-button disabled pointer-events-none'><svg width='82' height='64' viewBox='0 0 82 64' fill='none' xmlns='http://www.w3.org/2000/svg'><path d='M30.75 48L51.25 32L30.75 16' stroke='#CDD4D9' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'/></svg></a>";
    }
    ?>

    <button type='button' class='btn btn-success mt-3' onclick='addCard()'>Добавить карточку</button>
    <?php
    echo "<button type='button' class='btn btn-danger mt-3' onclick='deleteCard()'>Удалить карточку</button>";
    ?>
    <button type='submit' class='btn btn-primary mt-3'>Сохранить</button>
    <a href='my_base.php' class='btn btn-info mt-3'>Закончить</a>
</div>

<?php
include("footer.php");
?>

</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script>

    function addCard() {
        var url = "/add_card.php?podbor=<?php echo $_GET['podbor'] ?>";
        window.location.href = url;
    }

    function deleteCard() {
        if (confirm("Вы уверены, что хотите удалить карточку?")) {
            var url = "/delete_card.php?podbor=<?php echo $_GET['podbor'] ?>&card=<?php echo $card['card_id'] ?>";
            window.location.href = url;
        }
    }
</script>
</html>


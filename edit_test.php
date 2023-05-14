<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Редактор тестов</title>
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
    <a href="/" id="logo"></a>
</div>

<div class="container">
    <?php

    if (!isset($_COOKIE['user'])) {
        header("Location: /validation-form/login-form.php");
        exit;
    }
    if (!isset($_GET['test'])) {
        echo "<h1>Тест не выбран!</h1>";
        exit();
    }
    $link = new mysqli('localhost', 'p523033_admin', 'eQ5kJ0dN5a', 'p523033_Test_3');
    $query = "SELECT Название FROM Тесты WHERE `Код_Теста` = ?";
    $stmt = $link->prepare($query);
    $stmt->bind_param('s', $_GET['test']);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 0) {
        echo "<h1>Тест не найден!</h1>";
        exit();
    }
    $testName = $result->fetch_array(MYSQLI_ASSOC)['Название'];
    ?>
    <h1 class="test_name">Тест: <?php echo $testName ?></h1>
</div>
<?php

// Получение заданий из базы данных
$query = "SELECT Задача, Ответ, Решение FROM Задачи WHERE `Тест` = ? ORDER BY `Код_задачи` ASC";
$stmt = $link->prepare($query);
$stmt->bind_param('s', $_GET['test']);
$stmt->execute();
$result = $stmt->get_result();

$taskArr = [];
while ($row = $result->fetch_assoc()) {
    $task = [
        'task' => $row['Задача'],
        'answer' => $row['Ответ'],
        'explanation'=> $row['Решение']
    ];
    array_push($taskArr, $task);
}
// Определение текущей карточки
$currentTask = 0;
if (isset($_GET['task']) && $_GET['task'] >= 0 && $_GET['task'] < count($taskArr)) {
    $currentTask = $_GET['task'];
}

// Обработка изменения значений задания
$var = $currentTask + 1;
if (isset($_POST['task']) && isset($_POST['answer']) && isset($_POST['explanation'])) {
    $query = "UPDATE Задачи SET `Задача` = ?, `Ответ` = ?, `Решение` = ? WHERE `Тест` = ? AND `Код_задачи` = ?";
    $stmt = $link->prepare($query);
    $stmt->bind_param('sssss', $_POST['task'], $_POST['answer'], $_POST['explanation'], $_GET['test'], $var);
    if ($stmt->execute()) {
        echo "<div class='alert alert-success' role='alert'>Задание успешно изменено!</div>";
        $taskArr[$currentTask]['task'] = $_POST['task'];
        $taskArr[$currentTask]['answer'] = $_POST['answer'];
        $taskArr[$currentTask]['explanation'] = $_POST['explanation'];
    }
    else {
        echo "<div class='alert alert-danger' role='alert'>Не удалось изменить задание!</div>";
    }
}

// Вывод текущей карточки
$task = $taskArr[$currentTask];
echo "<div class='task'>";
echo "<form method='post'>";
echo "<h5 class='mt-3'>Задача:</h5>";
echo "<h3><input type='text' class='form-control' name='task' value='" . $task['task'] . "'></h3>";
echo "<h5 class='mt-3'>Ответ:</h5>";
echo "<textarea class='form-control' name='answer' rows='5'>" . $task['answer'] . "</textarea>";
echo "<h5 class='mt-3'>Решение:</h5>";
echo "<textarea class='form-control' name='explanation' rows='10'>" . $task['explanation'] . "</textarea>";
echo "<p>Задача " . ($currentTask + 1) . " из " . count($taskArr) . "</p>";
?>
<div class='buttons'>
    <?php
    // Предыдущая карточка
    if ($currentTask > 0) {
        $prevCard = $currentTask - 1;
        echo "<a href='?test=" . $_GET['test'] . "&task=" . $prevCard . "' class='button prev-button'><svg width='82' height='64' viewBox='0 0 82 64' fill='none' xmlns='http://www.w3.org/2000/svg'><path d='M51.25 16L30.75 32L51.25 48' stroke='#0C507C' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'/></svg></a>";
    } else {
        echo "<a href='#' class='button prev-button disabled pointer-events-none'><svg width='82' height='64' viewBox='0 0 82 64' fill='none' xmlns='http://www.w3.org/2000/svg'><path d='M51.25 16L30.75 32L51.25 48' stroke='#CDD4D9' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'/></svg></a>";
    }

    // Следующая карточка
    if ($currentTask < count($taskArr) - 1) {
        $nextCard = $var;
        echo "<a href='?test=" . $_GET['test'] . "&task=" . $nextCard . "' class='button next-button'><svg width='82' height='64' viewBox='0 0 82 64' fill='none' xmlns='http://www.w3.org/2000/svg'><path d='M30.75 48L51.25 32L30.75 16' stroke='#0C507C' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'/></svg></a>";
    } else {
        echo "<a href='#' class='button next-button disabled pointer-events-none'><svg width='82' height='64' viewBox='0 0 82 64' fill='none' xmlns='http://www.w3.org/2000/svg'><path d='M30.75 48L51.25 32L30.75 16' stroke='#CDD4D9' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'/></svg></a>";
    }
    ?>
    <button type='button' class='btn btn-success mt-3' onclick='addTask()'>Добавить задачу</button>
    <?php
    if (count($taskArr) > 1) {
        echo "<button type='button' class='btn btn-danger mt-3' onclick='deleteTask()'>Удалить задачу</button>";
    }
    ?>
    <button type='submit' class='btn btn-primary mt-3'>Сохранить</button>
    <a href='my_base.php' class='btn btn-info mt-3'>Закончить</a>
</div>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script>
    function addTask() {
        var url = "/add_task.php?test=<?php echo $_GET['test'] ?>";
        window.location.href = url;
    }

    function deleteTask() {
        if (confirm("Вы уверены, что хотите удалить задачу?")) {
            var url = "/delete_task.php?test=<?php echo $_GET['test'] ?>&task=<?php echo $currentTask ?>";
            window.location.href = url;
        }
    }
</script>
</html>


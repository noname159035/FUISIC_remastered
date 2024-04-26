<?php

$id = $_GET['id'];
$task_id = $_GET['task_id'];

require_once ('../db.php');

global $link;

// Получение заданий из базы данных
$query = "SELECT Задача, Ответ, Решение FROM Задачи WHERE `Код_задачи` =?";
$stmt = $link->prepare($query);
$stmt->bind_param('s', $id);
$stmt->execute();
$result = $stmt->get_result();
$row = mysqli_fetch_assoc($result);

if (isset($_POST['submit'])) {
    $task = mysqli_real_escape_string($link, $_POST['task']);
    $answer = mysqli_real_escape_string($link, $_POST['answer']);
    $explanation = mysqli_real_escape_string($link, $_POST['explanation']);

// Обновление данных пользователя в БД
    $link->query("UPDATE `Задачи` SET `Задача` = '$task', `Ответ` = '$answer', `Решение` = '$explanation' WHERE `Код_задачи` = '$id'");

// Перенаправление на страницу профиля пользователя
    header('Location: /my_base/edit/test/'.$task_id);
    exit();
}?>

<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Редактор карточки</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="/style/keyboardcommon2.css">
    <link rel="stylesheet" href="/libs/mathquill-0.10.1/mathquill.css" />
</head>
<body class="bg-light d-flex flex-column h-100">

<?php include '../inc/header.php' ?>

<div class="container">
    <h1>Редактирование Задачи</h1>
    <form method="post">
        <div class="form-group">
            <label for="task">Задача</label>
            <input type="text" class="form-control" id="task" name="task" value="<?php echo $row['Задача']?>">
        </div>
        <div class="form-group">
            <label for="answer">Ответ</label>
            <input type="text" class="form-control" id="answer" name="answer" value="<?php echo $row['Ответ']?>">
        </div>
        <div class="form-group">
            <label for="explanation">Решение</label>
            <textarea type="text" class="form-control" id="explanation" name="explanation"><?php echo $row['Решение']?></textarea>
        </div>
        <?php
        if ($row['Задача'] == '' && $row['Решение'] == '' && $row['Ответ'] == ''){
            ?>
            <a href="/my_base/delete_task/<?php echo $task_id.'/'.$id?>" class="btn btn-secondary">Отменить</a>
            <?php
        }
        else{
            ?>
            <a href="/my_base/edit/test/<?php echo $task_id ?>" class="btn btn-secondary">Отменить</a>
            <?php
        }
        ?>

        <button type="submit" class="btn btn-primary" name="submit">Сохранить</button>
    </form>
</div>

<?php include '../inc/footer.php' ?>

</body>
</html>

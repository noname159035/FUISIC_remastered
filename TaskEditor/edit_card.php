<?php

$id = $_GET['id'];
$cards_id = $_GET['cards_id'];

require_once ('../db.php');

global $link;

// Получение заданий из базы данных
$query = "SELECT Формула, Описание, Пояснение FROM Карточка WHERE `Код задания` =?";
$stmt = $link->prepare($query);
$stmt->bind_param('s', $id);
$stmt->execute();
$result = $stmt->get_result();
$row = mysqli_fetch_assoc($result);


if (isset($_POST['submit'])) {
    $formula = mysqli_real_escape_string($link, $_POST['formula']);
    $description = mysqli_real_escape_string($link, $_POST['description']);
    $explanation = mysqli_real_escape_string($link, $_POST['explanation']);

// Обновление данных пользователя в БД
    $link->query("UPDATE `Карточка` SET `Формула` = '$formula', `Описание` = '$description', `Пояснение` = '$explanation' WHERE `Код задания` = '$id'");

// Перенаправление на страницу профиля пользователя
    header('Location: /my_base/edit/cards/'.$cards_id);
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
</head>
<body class="bg-light d-flex flex-column h-100">

<?php include '../inc/header.php' ?>

<div class="container">
    <h1>Редактирование карточки</h1>
    <form method="post">
        <div class="form-group">
            <label for="formula">Формула</label>
            <input class="form-control" id="formula" name="formula" value="<?php echo $row['Формула']?>">
        </div>
        <div class="form-group">
            <label for="description">Описание</label>
            <input type="text" class="form-control" id="description" name="description" value="<?php echo $row['Описание']?>">
        </div>
        <div class="form-group">
            <label for="explanation">Пояснение</label>
            <textarea type="text" class="form-control" id="explanation" name="explanation"><?php echo $row['Пояснение']?></textarea>
        </div>
        <?php
        if ($row['Формула'] == '' && $row['Описание'] == '' && $row['Пояснение'] == ''){
            ?>
            <a href="/my_base/delete_card/<?php echo $cards_id.'/'.$id?>" class="btn btn-secondary">Отменить</a>
            <?php
        }
        else{
            ?>
            <a href="/my_base/edit/cards/<?php echo $cards_id ?>" class="btn btn-secondary">Отменить</a>
            <?php
        }
        ?>

        <button type="submit" class="btn btn-primary" name="submit">Сохранить</button>
    </form>
</div>

<?php include '../inc/footer.php' ?>
</body>
</html>
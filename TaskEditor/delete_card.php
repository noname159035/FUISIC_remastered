<?php
if (isset($_GET['id'])) {
    $cards_id =$_GET['cards_id'];

    require_once ('../db.php');

    global $link;

    $query = "DELETE FROM `Карточка` WHERE `Код задания` = ?";
    $stmt = $link->prepare($query);
    $stmt->bind_param('s', $_GET['id']);
    if ($stmt->execute()) {
        echo "<div class='alert alert-success' role='alert'>Задание успешно удалено!</div>";
        // Перенаправляем пользователя на предыдущую страницу
        header("Location: /my_base/edit/cards/$cards_id");
    }
    else {
        echo "<div class='alert alert-danger' role='alert'>Не удалось удалить задание!</div>";
    }
}
else {
    echo "<h1>Ошибка удаления задачи!</h1>";
}
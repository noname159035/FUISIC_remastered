<?php
if (isset($_GET['id'])) {
    $cards_id =$_GET['task_id'];

    require_once ('../db.php');

    global $link;

    $query = "DELETE FROM `Задачи` WHERE `Код_задачи` = ?";
    $stmt = $link->prepare($query);
    $stmt->bind_param('s', $_GET['id']);
    if ($stmt->execute()) {
        echo "<div class='alert alert-success' role='alert'>Задача успешно удалена!</div>";
        // Перенаправляем пользователя на предыдущую страницу
        header("Location: /my_base/edit/test/$cards_id");
    }
    else {
        echo "<div class='alert alert-danger' role='alert'>Не удалось удалить задачу!</div>";
    }
}
else {
    echo "<h1>Ошибка удаления задачи!</h1>";
}
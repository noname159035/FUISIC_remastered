<?php
if (isset($_GET['id'])) {

    require_once ('../db.php');

    global $link;

    $query = "INSERT INTO Задачи (`Тест`, `Задача`, `Ответ`, `Решение`) VALUES (?, '', '', '')";
    $stmt = $link->prepare($query);

    $stmt->bind_param('s', $_GET['id']);
    if ($stmt->execute()) {
        $taskId = $stmt->insert_id;
        echo "<div class='alert alert-success' role='alert'>Задание успешно удалено!</div>";
        // Перенаправляем пользователя на предыдущую страницу
        header("Location: /my_base/edit_task/".$_GET['id'].'/'.$taskId);
    }
    else {
        echo "<div class='alert alert-danger' role='alert'>Не удалось удалить задание!</div>";
    }
}
else{
    echo "<h1>Тест не выбран!</h1>";
}

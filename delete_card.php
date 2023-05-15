<?php
if (isset($_GET['podbor']) && isset($_GET['card'])) {
    $link = new mysqli('localhost', 'p523033_admin', 'eQ5kJ0dN5a', 'p523033_Test_3');
    $query = "DELETE FROM `Карточка` WHERE `Подборка` = ? AND `Код задания` = ?";
    $stmt = $link->prepare($query);
    $stmt->bind_param('ss', $_GET['podbor'], $_GET['card']);
    if ($stmt->execute()) {
        echo "<div class='alert alert-success' role='alert'>Задание успешно удалено!</div>";
        // Перенаправляем пользователя на предыдущую страницу
        header("Location: {$_SERVER['HTTP_REFERER']}");
    }
    else {
        echo "<div class='alert alert-danger' role='alert'>Не удалось удалить задание!</div>";
    }
}
else {
    echo "<h1>Ошибка удаления задачи!</h1>";
}
?>
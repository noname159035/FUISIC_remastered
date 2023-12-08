<?php
if (isset($_GET['id'])) {
    $link = new mysqli('localhost', 'p523033_admin', 'eQ5kJ0dN5a', 'p523033_Test_3');
    $query = "INSERT INTO Карточка (`Подборка`, `Формула`, `Описание`, `Пояснение`) VALUES (?, '', '', '')";
    $stmt = $link->prepare($query);
    $stmt->bind_param('s', $_GET['id']);
    if ($stmt->execute()) {
        $CardId = $stmt->insert_id;
        echo "<div class='alert alert-success' role='alert'>Задание успешно удалено!</div>";
        // Перенаправляем пользователя на предыдущую страницу
        header("Location: /my_base/edit_card/".$_GET['id'].'/'.$CardId);
    }
    else {
        echo "<div class='alert alert-danger' role='alert'>Не удалось удалить задание!</div>";
    }
}
else {
    echo "<h1>Ошибка удаления задачи!</h1>";
}



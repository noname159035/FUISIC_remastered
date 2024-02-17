<?php
if (isset($_GET['id'])) {
    
    require_once ('../db.php');

    global $link;
    
    $query = "INSERT INTO Карточка (`Подборка`, `Формула`, `Описание`, `Пояснение`) VALUES (?, '', '', '')";
    $stmt = $link->prepare($query);

    $stmt->bind_param('s', $_GET['id']);
    if ($stmt->execute()) {
        $CardId = $stmt->insert_id;
        echo "<div class='alert alert-success' role='alert'>Задание успешно создано!</div>";
        // Перенаправляем пользователя на предыдущую страницу
        header("Location: /my_base/edit_card/".$_GET['id'].'/'.$CardId);
    }
    else {
        echo "<div class='alert alert-danger' role='alert'>Не удалось создать задание!</div>";
    }
}
else {
    echo "<h1>Ошибка создания задания!</h1>";
}



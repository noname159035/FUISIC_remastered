<?php
if (!isset($_GET['podbor']) || !isset($_GET['task'])) {
    echo "<h1>Подборка или карточка не выбраны!</h1>";
    exit();
}

$link = new mysqli('localhost', 'p523033_admin', 'eQ5kJ0dN5a', 'p523033_Test_3');

// Удаление задачи из базы
$query = "DELETE FROM Карточка WHERE `Подборка` = ? AND `Код задания` = ?";
$stmt = $link->prepare($query);
$var = $_GET['task'] + 1;
$stmt->bind_param('ss', $_GET['podbor'], $var);
if ($stmt->execute()) {
    // Обновление номеров задач в тесте
    $query = "UPDATE Карточка SET `Код задания` = `Код задания` - 1 WHERE `Подборка` = ? AND `Код задания` > ?";
    $stmt = $link->prepare($query);
    $stmt->bind_param('ss', $_GET['podbor'], $var);
    $stmt->execute();
    echo header('Location: ' . $_SERVER['HTTP_REFERER']);
}
else {
    echo "<h1>Не удалось удалить карточку!</h1>";
}
?>

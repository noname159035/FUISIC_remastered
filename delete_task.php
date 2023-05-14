<?php
if (!isset($_GET['test']) || !isset($_GET['task'])) {
    echo "<h1>Тест или задание не выбраны!</h1>";
    exit();
}

$link = new mysqli('localhost', 'p523033_admin', 'eQ5kJ0dN5a', 'p523033_Test_3');

// Удаление задачи из базы
$query = "DELETE FROM Задачи WHERE `Тест` = ? AND `Код_задачи` = ?";
$stmt = $link->prepare($query);
$var = $_GET['task'] + 1;
$stmt->bind_param('ss', $_GET['test'], $var);
if ($stmt->execute()) {
    // Обновление номеров задач в тесте
    $query = "UPDATE Задачи SET `Код_задачи` = `Код_задачи` - 1 WHERE `Тест` = ? AND `Код_задачи` > ?";
    $stmt = $link->prepare($query);
    $stmt->bind_param('ss', $_GET['test'], $var);
    $stmt->execute();
    echo header('Location: ' . $_SERVER['HTTP_REFERER']);
}
else {
    echo "<h1>Не удалось удалить задание!</h1>";
}
?>

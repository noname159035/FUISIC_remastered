<?php
if (!isset($_GET['podbor'])) {
    echo "<h1>Подборка не выбрана!</h1>";
    exit();
}

$link = new mysqli('localhost', 'p523033_admin', 'eQ5kJ0dN5a', 'p523033_Test_3');

// Получение количества карточек в подборке
$query = "SELECT COUNT(*) AS cnt FROM Задачи WHERE `Тест` = ?";
$stmt = $link->prepare($query);
$stmt->bind_param('s', $_GET['podbor']);
$stmt->execute();
$result = $stmt->get_result();
$cnt = $result->fetch_array(MYSQLI_ASSOC)['cnt'];

// Добавление новой задачи в базу
$query = "INSERT INTO Карточка (`Подборка`, `Код задания`, `Формула`, `Описание`, `Пояснение`) VALUES (?, ?, '', '', '')";
$stmt = $link->prepare($query);
$var = $cnt + 1;
$stmt->bind_param('ss', $_GET['podbor'], $var);
if ($stmt->execute()) {
    echo header('Location: ' . $_SERVER['HTTP_REFERER']);
}
else {
    echo "<h1>Не удалось добавить задание!</h1>";
}
?>
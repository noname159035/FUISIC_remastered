<?php
if (!isset($_GET['test'])) {
    echo "<h1>Тест не выбран!</h1>";
    exit();
}

$link = new mysqli('localhost', 'p523033_admin', 'eQ5kJ0dN5a', 'p523033_Test_3');

// Получение количества задач в тесте
$query = "SELECT COUNT(*) AS cnt FROM Задачи WHERE `Тест` = ?";
$stmt = $link->prepare($query);
$stmt->bind_param('s', $_GET['test']);
$stmt->execute();
$result = $stmt->get_result();
$cnt = $result->fetch_array(MYSQLI_ASSOC)['cnt'];

// Добавление новой задачи в базу
$query = "INSERT INTO Задачи (`Тест`, `Код_задачи`, `Задача`, `Ответ`, `Решение`) VALUES (?, ?, '', '', '')";
$stmt = $link->prepare($query);
$var = $cnt + 1;
$stmt->bind_param('ss', $_GET['test'], $var);
if ($stmt->execute()) {
    echo header('Location: ' . $_SERVER['HTTP_REFERER']);
}
else {
    echo "<h1>Не удалось добавить задание!</h1>";
}
?>
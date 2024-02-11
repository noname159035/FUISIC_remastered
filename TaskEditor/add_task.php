<?php
if (!isset($_GET['test'])) {
    echo "<h1>Тест не выбран!</h1>";
    exit();
}

require_once ('../db.php');

global $link;

if ($link->connect_error) {
    die("Ошибка подключения: " . $link->connect_error);
}

// Добавление новой задачи в базу
$query = "INSERT INTO Задачи (`Тест`, `Задача`, `Ответ`, `Решение`) VALUES (?, '', '', '')";
$stmt = $link->prepare($query);

$stmt->bind_param('s', $_GET['test']);
if ($stmt->execute()) {
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
} else {
    echo "<h1>Не удалось добавить задание!</h1>";
}
?>
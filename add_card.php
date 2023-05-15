<?php
if (!isset($_GET['podbor'])) {
    echo "<h1>Подборка не выбрана!</h1>";
    exit();
}

$link = new mysqli('localhost', 'p523033_admin', 'eQ5kJ0dN5a', 'p523033_Test_3');
if ($link->connect_error) {
    die("Ошибка подключения: " . $link->connect_error);
}

// Добавление новой задачи в базу
$query = "INSERT INTO Карточка (`Подборка`, `Формула`, `Описание`, `Пояснение`) VALUES (?, '', '', '')";
$stmt = $link->prepare($query);

$stmt->bind_param('s', $_GET['podbor']);
if ($stmt->execute()) {
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
} else {
    echo "<h1>Не удалось добавить карточку!</h1>";
}
?>
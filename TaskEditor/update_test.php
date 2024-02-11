<?php
// Подключение к базе данных
require_once ('../db.php');

global $link;

if (!$link) {
    echo "Ошибка: Невозможно установить соединение с MySQL." . PHP_EOL;
    echo "Код ошибки errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Текст ошибки error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

// Получение данных из запроса
$id = mysqli_real_escape_string($link, $_POST['id']);
$title = mysqli_real_escape_string($link, $_POST['title']);

// Обновление названия подборки
$query = "UPDATE Тесты SET Название='$title' WHERE `Код_Теста`='$id'";
$result = mysqli_query($link, $query);

if (!$result) {
    echo "Ошибка: Невозможно выполнить запрос к базе данных." . PHP_EOL;
    echo "Код ошибки errno: " . mysqli_errno($link) . PHP_EOL;
    echo "Текст ошибки error: " . mysqli_error($link) . PHP_EOL;
    exit;
}

echo "Название подборки успешно обновлено.";

mysqli_close($link);
?>
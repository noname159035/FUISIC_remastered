<?php
// Подключение к базе данных
$link = mysqli_connect('localhost', 'p523033_admin', 'eQ5kJ0dN5a', 'p523033_Test_3');

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
$query = "UPDATE Подборки SET Название='$title' WHERE `Код подборки`='$id'";
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
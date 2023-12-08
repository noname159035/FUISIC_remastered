<?php
// Получаем ID подборки из параметра GET запроса
if (isset($_GET['id'])) {
    $collection_id = $_GET['id'];
} else {
    // Если ID не передан, выводим сообщение об ошибке и завершаем скрипт
    echo "Ошибка: ID подборки не передан." . PHP_EOL;
    exit;
}

// Подключение к базе данных
$link = mysqli_connect('localhost', 'p523033_admin', 'eQ5kJ0dN5a', 'p523033_Test_3');

if (!$link) {
    echo "Ошибка: Невозможно установить соединение с MySQL." . PHP_EOL;
    echo "Код ошибки errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Текст ошибки error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

// Проверяем, авторизован ли пользователь
if (!isset($_COOKIE['user'])) {
    header("Location: /login");
    exit;
}

// Выбираем подборку из базы данных
$query = "SELECT * FROM Подборки WHERE `Код подборки`=$collection_id";
$result = mysqli_query($link, $query);

if (mysqli_num_rows($result) == 0) {
    // Если нет подборки с таким ID, выводим сообщение об ошибке и завершаем скрипт
    echo "Ошибка: Подборка с заданным ID не найдена." . PHP_EOL;
    exit;
}

// Удаляем подборку из базы данных
$query = "DELETE FROM Подборки WHERE `Код подборки`=$collection_id";
mysqli_query($link, $query);

// Возвращаемся на страницу со списком подборок
header("Location: /my_base/");
exit;
?>

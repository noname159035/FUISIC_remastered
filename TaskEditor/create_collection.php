<?php
// Подключение к базе данных и установка нужных полей
$link = mysqli_connect('localhost', 'p523033_admin', 'eQ5kJ0dN5a', 'p523033_Test_3');
// Получаем название подборки из POST-запроса
$title = $_POST['title'];
$section = $_POST['section'];


// Проверяем, авторизован ли пользователь
if (!isset($_COOKIE['user'])) {
    header("Location: /validation-form/login-form.php");
    exit;
}

// Получаем ID пользователя
$user_id = $_COOKIE['user'];

// Выполняем запрос INSERT для создания новой записи в таблице
$query = "INSERT INTO Подборки (Название, Раздел, Автор) VALUES ('$title', '$section', '$user_id')";
if (mysqli_query($link, $query)) {
    // Если запись успешно создана, получаем ее код
    $collection_id = mysqli_insert_id($link);
    // Возвращаем код подборки в виде ответа на AJAX-запрос
    echo $collection_id;
} else {
    // Если произошла ошибка при создании записи, возвращаем ошибку в виде ответа на AJAX-запрос
    echo "Ошибка: " . mysqli_error($link);
}

// Освобождаем ресурсы
mysqli_close($link);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Мои задания</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/validation-form/level.css">
    <link rel="stylesheet" href="/style/collections_style.css"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.3.0/css/all.css" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
</head>
<body>
<div class="header">
    <a href="/index.php" class="header-text main_txt">Главная</a>
    <a href="/collections.php" class="header-text coll_txt">Подборки</a>
    <a href="/Tests.php" class="header-text test_txt">Тесты</a>
    <a href="/support.php" class="header-text help_txt">Помощь</a>
    <?php
    // Проверяем, авторизован ли пользователь
    if (!isset($_COOKIE['user'])) {
        echo ("<a href='/validation-form/login-form.php' class='header-text auth_txt'>войти</a>");
    }
    else echo ("<a href='/validation-form/login-form.php' class='header-text auth_txt'>Профиль</a>");
    ?>
    <a href="/index.php" id="logo"></a>
</div>
<?php
// Проверяем, авторизован ли пользователь
if (!isset($_COOKIE['user'])) {
    header("Location: /validation-form/login-form.php");
    exit;
}

// Получаем ID пользователя
$user_id = $_COOKIE['user'];

// Подключение к базе данных
$link = mysqli_connect('localhost', 'p523033_admin', 'eQ5kJ0dN5a', 'p523033_Test_3');

if (!$link) {
    echo "Ошибка: Невозможно установить соединение с MySQL." . PHP_EOL;
    echo "Код ошибки errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Текст ошибки error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

// Получаем информацию о пользователе
$sql = "SELECT `Пользователи`.*, `Типы пользователей`.`Тип` FROM `Пользователи`
        INNER JOIN `Типы пользователей` ON `Пользователи`.`Тип пользователя`=`Типы пользователей`.`Код типа пользователя`
        WHERE `Пользователи`.`Код пользователя`='$user_id'";
$result = $link->query($sql);
$user = $result->fetch_assoc();

// Создаем кнопки для создания подборки и теста
echo '<div class="mb-3">';
echo '<a class="btn btn-success" href="create_collection.php">Создать подборку</a>';
echo '<a class="btn btn-success" href="create_test.php">Создать тест</a>';
echo '</div>';


// Выбираем все разделы
$query_sections = "SELECT * FROM Разделы";
$result_sections = mysqli_query($link, $query_sections);

while ($row_sections = mysqli_fetch_assoc($result_sections)) {
    // Выводим название раздела
    echo '<h3>' . $row_sections['Название'] . '</h3>';

    if ($user['Тип'] == 'Администратор') {
        $query_collections = "SELECT * FROM Подборки WHERE Раздел = {$row_sections['Код Раздела']}";
    }
    else {
        $query_collections = "SELECT * FROM Подборки WHERE Раздел = {$row_sections['Код Раздела']} AND Автор = $user_id";
    }
    $result_collections = mysqli_query($link, $query_collections);

    if (mysqli_num_rows($result_collections) > 0) {
        // Выводим заголовок для списка подборок
        echo '<h4>Подборки:</h4>';

        // Выводим список подборок
        echo '<ul class="list-group list-group-flush list-group-podborok">';
        while ($row_collections = mysqli_fetch_assoc($result_collections)) {
            echo '<li class="list-group-item d-flex justify-content-between align-items-center">' . $row_collections['Название'];
            echo '<div class="btn-group" role="group">';
            echo '<a class="btn btn-sm btn-primary ml-auto" href="edit_collection.php?id=' . $row_collections['Код подборки'] . '">Редактировать</a>';
            echo '<a class="btn btn-sm btn-danger mr-auto" href="#" data-toggle="modal" data-target="#confirmDeleteModal" data-href="delete_collection.php?id=' . $row_collections['Код подборки'] . '">Удалить</a>';
            echo '</div>';
            echo '</li>';
        }
        echo '</ul>';
    }
    mysqli_free_result($result_collections);

    // Выбираем все тесты созданные пользователем в данном разделе
    if ($user['Тип'] == 'Администратор') {
        $query_tests = "SELECT * FROM Тесты WHERE Раздел = {$row_sections['Код Раздела']}";
    } else {
        $query_tests = "SELECT * FROM Тесты WHERE Раздел = {$row_sections['Код Раздела']} AND Автор = $user_id";
    }
    $result_tests = mysqli_query($link, $query_tests);

    if (mysqli_num_rows($result_tests) > 0) {
        // Выводим заголовок для списка тестов
        echo '<h4>Тесты:</h4>';

        // Выводим список тестов
        echo '<ul class="list-group list-group-flush list-group-testov">';
        while ($row_tests = mysqli_fetch_assoc($result_tests)) {
            echo '<li class="list-group-item d-flex justify-content-between align-items-center">' . $row_tests['Название'];
            echo '<div class="btn-group" role="group">';
            echo '<a class="btn btn-sm btn-primary ml-auto" href="edit_test.php?id=' . $row_tests['Код_Теста'] . '">Редактировать</a>';
            echo '<a class="btn btn-sm btn-danger mr-auto" href="#" data-toggle="modal" data-target="#confirmDeleteModal" data-href="delete_test.php?id='  . $row_tests['Код_Теста'] . '">Удалить</a>';
            echo '</div>';
            echo '</li>';
        }
        echo '</ul>';
    }
    mysqli_free_result($result_tests);
}

// Освобождаем ресурсы
mysqli_free_result($result_sections);
mysqli_close($link);
?>

<div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel">Удаление</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Вы уверены, что хотите удалить запись?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                <a id="confirmDeleteButton" class="btn btn-danger" href="#">Удалить</a>
            </div>
        </div>
    </div>
</div>

</body>
</html>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.3/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function () {
        // Обработчик клика на кнопке подтверждения удаления
        $('#confirmDeleteModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var href = button.data('href');
            var confirmBtn = $(this).find('#confirmDeleteButton');
            confirmBtn.attr('href', href);
        });
    });
</script>

<!-- Добавляем стили -->
<style>
    .btn-success{
        margin-top: 100px;
    }
    h3 {
        margin-top: 50px;
    }

    .mb-3 {
        margin-bottom: 30px;
    }
</style>
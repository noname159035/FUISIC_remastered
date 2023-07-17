<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Мои задания</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/validation-form/level.css">
    <link rel="stylesheet" href="/style/collections_style.css"/>
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
</head>
<body>

<div class="header">
    <a href="index.php" class="header-text main_txt">Главная</a>
    <a href="collections_new.php" class="header-text coll_txt">Подборки</a>
    <a href="Tests.php" class="header-text test_txt">Тесты</a>
    <a href="support.php" class="header-text help_txt">Помощь</a>
    <?php
    // Проверяем, авторизован ли пользователь
    if (!isset($_COOKIE['user'])) {
        echo ("<a href='validation-form/login-form.php' class='header-text auth_txt'>войти</a>");
    }
    else echo ("<a href='validation-form/login-form.php' class='header-text auth_txt'>Профиль</a>");
    ?>
    <a href="index.php" id="logo"></a>

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
echo '<button class="btn btn-success create-collection-btn">Создать подборку</button>';
echo '<button class="btn btn-success create-test-btn">Создать тест</button>';
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
        echo '<ul class="list-group list-group-flush">';
           while ($row_collections = mysqli_fetch_assoc($result_collections)) {
               echo '<li class="list-group-item d-flex justify-content-between align-items-center" data-collection-id="' . $row_collections['Код подборки'] . '">';
               echo '<span class="collection-title">' . $row_collections['Название'] . '</span>';
               echo '<div class="btn-group" role="group">';
               echo '<button class="btn btn-sm btn-primary ml-auto edit-collection-btn" data-toggle="modal" data-target="#editCollectionModal" data-collection-id="' . $row_collections['Код подборки'] . '">Переименовать</button>'; // *Добавляем кнопку "Редактировать"
               echo '<a class="btn btn-sm btn-primary ml-auto" href="edit_collection.php?podbor=' . $row_collections['Код подборки'] . '">Редактировать</a>';
               echo '<a class="btn btn-sm btn-danger mr-auto" href="#" data-toggle="modal" data-target="#confirmDeleteModal" data-href="delete_collection.php?id=' . $row_collections['Код подборки'] . '">Удалить</a>';
               echo '</div>';
               echo '</li>';
           }
           echo '</ul>';
       } else {
           // Вывод сообщения, если у пользователя не найдено подборок в данном разделе
           echo '<div class="alert alert-info" role="alert">У вас пока нет подборок в данном разделе.</div>';
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
            echo '<li class="list-group-item d-flex justify-content-between align-items-center" data-test-id="' . $row_tests['Код_Теста'] . '">';
            echo '<span class="test-title">' . $row_tests['Название'] . '</span>';
            echo '<div class="btn-group" role="group">';
            echo '<button class="btn btn-sm btn-primary ml-auto edit-test-btn" data-toggle="modal" data-target="#editTestModal" data-test-id="' . $row_tests['Код_Теста'] . '">Переименовать</button>'; // *Добавляем кнопку "Редактировать"
            echo '<a class="btn btn-sm btn-primary ml-auto" href="edit_test.php?test=' . $row_tests['Код_Теста'] . '">Редактировать</a>';
            echo '<a class="btn btn-sm btn-danger mr-auto" href="#" data-toggle="modal" data-target="#confirmDeleteModal" data-href="delete_test.php?id=' . $row_tests['Код_Теста'] . '">Удалить</a>';
            echo '</div>';
            echo '</li>';
        }

    } else {
 //Выводим сообщение, если у пользователя не найдено подборок в данном разделе
        echo '<div class="alert alert-info" role="alert">У вас пока нет тестов в данном разделе.</div>';
    }
    mysqli_free_result($result_tests);

}
?>


<div class="modal fade" id="editCollectionModal" tabindex="-1" role="dialog" aria-labelledby="editCollectionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCollectionModalLabel">Редактирование подборки</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editCollectionForm">
                    <div class="form-group">
                        <label for="editCollectionTitle">Название подборки</label>
                        <input type="text" class="form-control" id="editCollectionTitle" name="editCollectionTitle" required>
                        <input type="hidden" id="editCollectionId" name="editCollectionId"> <!-- *Добавляем скрытое поле для передачи ID подборки -->
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-primary" id="editCollectionSubmit">Сохранить изменения</button> <!-- *Добавляем кнопку "Сохранить изменения" -->
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editTestModal" tabindex="-1" role="dialog" aria-labelledby="editTestModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTestModalLabel">Редактирование теста</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editTestForm">
                    <div class="form-group">
                        <label for="editTestTitle">Название теста</label>
                        <input type="text" class="form-control" id="editTestTitle" name="editTestTitle" required>
                        <input type="hidden" id="editTestId" name="editTestId"> <!-- *Добавляем скрытое поле для передачи ID теста -->
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-primary" id="editTestSubmit">Сохранить изменения</button> <!-- *Добавляем кнопку "Сохранить изменения" -->
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="createCollectionModal" tabindex="-1" role="dialog" aria-labelledby="createCollectionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document"><div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createCollectionModalLabel">Создание подборки</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="collectionSection">Раздел</label>
                    <select class="form-control" id="collectionSection" name="collectionSection" required>
                        <?php
                        $query_sections = "SELECT * FROM Разделы";
                        $result_sections = mysqli_query($link, $query_sections);

                        while ($row_sections = mysqli_fetch_assoc($result_sections)) {
                            echo '<option value="' . $row_sections['Код Раздела'] . '">' . $row_sections['Название'] . '</option>';
                        }

                        mysqli_free_result($result_sections);
                        ?>
                    </select>
                </div>
                <form id="createCollectionForm">
                    <div class="form-group">
                        <label for="collectionTitle">Название подборки</label>
                        <input type="text" class="form-control" id="collectionTitle" name="collectionTitle" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-primary" id="createCollectionSubmit">Создать подборку</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="createTestModal" tabindex="-1" role="dialog" aria-labelledby="createTestModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document"><div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createTestLabel">Создание теста</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="testSection">Раздел</label>
                    <select class="form-control" id="testSection" name="testSection" required>
                        <?php
                        $query_sections = "SELECT * FROM Разделы";
                        $result_sections = mysqli_query($link, $query_sections);

                        while ($row_sections = mysqli_fetch_assoc($result_sections)) {
                            echo '<option value="' . $row_sections['Код Раздела'] . '">' . $row_sections['Название'] . '</option>';
                        }

                        mysqli_free_result($result_sections);
                        ?>
                    </select>
                </div>
                <form id="createTestForm">
                    <div class="form-group">
                        <label for="testTitle">Название теста</label>
                        <input type="text" class="form-control" id="testTitle" name="testTitle" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-primary" id="createTestSubmit">Создать тест</button>
            </div>
        </div>
    </div>
</div>

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


<script src="/libs/jquery-3.6.1.min.js"></script>
<script src="/libs/bootstrap-4/js/bootstrap.min.js"></script>
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

    $(document).ready(function () {
        // Обработчик клика на кнопку "Создать подборку"
        $('.create-collection-btn').click(function () {
            $('#createCollectionModal').modal('show');
        });

        // Обработчик клика на кнопку "Создать подборку" в модальном окне
        $('#createCollectionSubmit').click(function (e) {
            e.preventDefault();
            var collectionTitle = $('#collectionTitle').val();
            var collectionSection = $('#collectionSection').val();
            if (collectionTitle == '') {
                alert('Введите название подборки');
                return;
            }
            else {
                $.ajax({
                    url: 'create_collection.php',
                    data: {'title': collectionTitle, 'section': collectionSection}, // Добавляем передачу кода раздела
                    type: 'POST',
                    success: function (response) {
                        window.location.href = '/edit_collection.php?podbor=' + response;
                    }
                });
            }
        });
    });

    $(document).ready(function () {
        // Обработчик клика на кнопку "Создать тест"
        $('.create-test-btn').click(function () {
            $('#createTestModal').modal('show');
        });

        // Обработчик клика на кнопку "Создать тест" в модальном окне
        $('#createTestSubmit').click(function (e) {
            e.preventDefault();
            var testTitle = $('#testTitle').val();
            var testSection = $('#testSection').val();
            if (testTitle == '') {
                alert('Введите название теста');
                return;
            }
            else {
                $.ajax({
                    url: 'create_test.php',
                    data: {'title': testTitle, 'section': testSection}, // Добавляем передачу кода раздела
                    type: 'POST',
                    success: function (response) {
                        window.location.href = '/edit_test.php?test=' + response;
                    }
                });
            }
        });
    });

    $(document).ready(function () {
// Обработчик клика на кнопке "Редактировать"
        $('.edit-collection-btn').click(function () {
            var collectionId = $(this).data('collection-id');
            var collectionTitle = $(this).parent().siblings('.collection-title').text();
            $('#editCollectionId').val(collectionId);
            $('#editCollectionTitle').val(collectionTitle);
        });

// Обработчик клика на кнопку "Сохранить изменения"
        $('#editCollectionSubmit').click(function () {
            var collectionId = $('#editCollectionId').val();
            var collectionTitle = $('#editCollectionTitle').val();
            if (collectionTitle == '') {
                alert('Введите название подборки');
                return;
            }
            else {
                $.ajax({
                    url: 'update_collection.php',
                    data: {'id': collectionId, 'title': collectionTitle},
                    type: 'POST',
                    success: function (response) {
                        $('#editCollectionModal').modal('hide');
                        window.location.reload();
                    }
                });
            }
        });
    });

    $(document).ready(function () {
        // Обработчик клика на кнопке "Редактировать"
        $('.edit-test-btn').click(function () {
            var testId = $(this).data('test-id');
            var testTitle = $(this).parent().siblings('.test-title').text();
            $('#editTestId').val(testId);
            $('#editTestTitle').val(testTitle);
        });

        // Обработчик клика на кнопку "Сохранить изменения"
        $('#editTestSubmit').click(function () {
            var testId = $('#editTestId').val();
            var testTitle = $('#editTestTitle').val();
            if (testTitle == '') {
                alert('Введите название теста');
                return;
            }
            else {
                $.ajax({
                    url: 'update_test.php',
                    data: {'id': testId, 'title': testTitle},
                    type: 'POST',
                    success: function (response) {
                        $('#editTestModal').modal('hide');
                        window.location.reload();
                    }
                });
            }
        });
    });




</script>
</body>
</html>

<?php
// Освобождаем ресурсы
mysqli_free_result($result_sections);
mysqli_close($link);
?>


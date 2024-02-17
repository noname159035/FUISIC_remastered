<?php
// Проверяем, авторизован ли пользователь
if (!isset($_COOKIE['user'])) {
    header("Location: /Validation-form/login-form.php");
    exit;
}

// Получаем ID пользователя
$user_id = $_COOKIE['user'];

// Подключение к базе данных
require_once ('../db.php');

global $link;

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

// Выбираем все разделы
$query_sections = "SELECT * FROM Разделы";
$result_sections = mysqli_query($link, $query_sections);
?>


<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <meta charset="UTF-8">
    <title>Мои задания</title>
    <!-- Добавляем стили -->
</head>
<body class="bg-light d-flex flex-column h-100">

<?php include '../inc/header.php' ?>

<div class="container">
    <div class="btn-group">
        <button class="btn btn-outline-success create-collection-btn">Создать подборку</button>
        <button class="btn btn-outline-success create-test-btn">Создать тест</button>
    </div>
    <?php

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

// Выводим заголовок для списка подборок
        echo '<h4>Подборки:</h4>';
        if (mysqli_num_rows($result_collections) > 0) {

            // Выводим список подборок
            echo '<ul class="list-group list-group-item-light ">';
            while ($row_collections = mysqli_fetch_assoc($result_collections)) {
                echo '<li class="list-group-item d-flex justify-content-between align-items-center" data-collection-id="' . $row_collections['Код подборки'] . '">';
                echo '<a href = "/collections/cards/'. $row_collections['Код подборки'] .'" class="collection-title">' . $row_collections['Название'] . '</a>';
                echo '<div class="btn-group" role="group">';
                echo '<button class="btn btn-sm btn-primary ml-auto edit-collection-btn" data-toggle="modal" data-target="#editCollectionModal" data-collection-id="' . $row_collections['Код подборки'] . '">Переименовать</button>'; // *Добавляем кнопку "Редактировать"
                echo '<a class="btn btn-sm btn-primary ml-auto" href="/my_base/edit/cards/' . $row_collections['Код подборки'] . '">Редактировать</a>';
                echo '<a class="btn btn-sm btn-danger mr-auto" href="#" data-toggle="modal" data-target="#confirmDeleteModal" data-href="/TaskEditor/delete_collection.php?id=' . $row_collections['Код подборки'] . '">Удалить</a>';
                echo '</div>';
                echo '</li>';
            }
            echo '</ul>';
        } else {
            // Вывод сообщения, если у пользователя не найдено подборок в данном разделе
            echo '<div class="alert alert-primary" role="alert">У вас пока нет подборок в данном разделе.</div>';
        }
        mysqli_free_result($result_collections);

        // Выбираем все тесты созданные пользователем в данном разделе
        if ($user['Тип'] == 'Администратор') {
            $query_tests = "SELECT * FROM Тесты WHERE Раздел = {$row_sections['Код Раздела']}";
        } else {
            $query_tests = "SELECT * FROM Тесты WHERE Раздел = {$row_sections['Код Раздела']} AND Автор = $user_id";
        }
        $result_tests = mysqli_query($link, $query_tests);

        // Выводим заголовок для списка тестов
        echo '<h4>Тесты:</h4>';
        if (mysqli_num_rows($result_tests) > 0) {

            // Выводим список тестов
            echo '<ul class="list-group list-group-item-light list-group-testov">';
            while ($row_tests = mysqli_fetch_assoc($result_tests)) {
                echo '<li class="list-group-item d-flex justify-content-between align-items-center" data-test-id="' . $row_tests['Код_Теста'] . '">';
                echo '<a href = "/collections/test/'. $row_tests['Код_Теста'] .'" class="test-title">' . $row_tests['Название'] . '</a>';
                echo '<div class="btn-group" role="group">';
                echo '<button class="btn btn-sm btn-primary ml-auto edit-test-btn" data-toggle="modal" data-target="#editTestModal" data-test-id="' . $row_tests['Код_Теста'] . '">Переименовать</button>'; // *Добавляем кнопку "Редактировать"
                echo '<a class="btn btn-sm btn-primary ml-auto" href="/my_base/edit/test/' . $row_tests['Код_Теста'] . '">Редактировать</a>';
                echo '<a class="btn btn-sm btn-danger mr-auto" href="#" data-toggle="modal" data-target="#confirmDeleteModal" data-href="/TaskEditor/delete_test.php?id=' . $row_tests['Код_Теста'] . '">Удалить</a>';
                echo '</div>';
                echo '</li>';
            }

        } else {
            //Выводим сообщение, если у пользователя не найдено подборок в данном разделе
            echo '<div class="alert alert-primary" role="alert">У вас пока нет тестов в данном разделе.</div>';
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
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <?php
                        ?>
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
                        <div class="row">
                            <div class="col">
                                <label for="collectionDif">Сложность</label>
                                <select class="form-control" id="collectionDif" name="collectionDif" required>
                                    <?php
                                    $query_dif = "SELECT * FROM Сложность";
                                    $result_dif = mysqli_query($link, $query_dif);

                                    while ($row_dif = mysqli_fetch_assoc($result_dif)) {
                                        echo '<option value="' . $row_dif['Код_Сложности'] . '">' . $row_dif['Название'] . '</option>';
                                    }
                                    mysqli_free_result($result_dif);
                                    ?>
                                </select>
                            </div>
                            <div class="col">
                                <label for="collectionClass">Для кого</label>
                                <select class="form-control" id="collectionClass" name="collectionClass" required>
                                    <?php
                                    $query_class = "SELECT * FROM Классификация";
                                    $result_class = mysqli_query($link, $query_class);

                                    while ($row_class = mysqli_fetch_assoc($result_class)) {
                                        echo '<option value="' . $row_class['Код_Классификации'] . '">' . $row_class['Название'] . '</option>';
                                    }
                                    mysqli_free_result($result_class);
                                    ?>
                                </select>
                            </div>
                        </div>
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
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
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
                        <div class="row">
                            <div class="col">
                                <label for="testDif">Сложность</label>
                                <select class="form-control" id="testDif" name="testDif" required>
                                    <?php
                                    $query_dif = "SELECT * FROM Сложность";
                                    $result_dif = mysqli_query($link, $query_dif);

                                    while ($row_dif = mysqli_fetch_assoc($result_dif)) {
                                        echo '<option value="' . $row_dif['Код_Сложности'] . '">' . $row_dif['Название'] . '</option>';
                                    }
                                    mysqli_free_result($result_dif);
                                    ?>
                                </select>
                            </div>
                            <div class="col">
                                <label for="testClass">Для кого</label>
                                <select class="form-control" id="testClass" name="testClass" required>
                                    <?php
                                    $query_class = "SELECT * FROM Классификация";
                                    $result_class = mysqli_query($link, $query_class);

                                    while ($row_class = mysqli_fetch_assoc($result_class)) {
                                        echo '<option value="' . $row_class['Код_Классификации'] . '">' . $row_class['Название'] . '</option>';
                                    }
                                    mysqli_free_result($result_class);
                                    ?>
                                </select>
                            </div>
                        </div>
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
</div>
<?php include '../inc/footer.php' ?>
</body>
<script src="/libs/jquery-3.6.1.min.js"></script>
<script src="/libs/bootstrap-4/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function () {
        // Обработчик клика на кнопке подтверждения удаления
        $('#confirmDeleteModal').on('show.bs.modal', function (event) {
            const button = $(event.relatedTarget);
            const href = button.data('href');
            const confirmBtn = $(this).find('#confirmDeleteButton');
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
            const collectionTitle = $('#collectionTitle').val();
            const collectionSection = $('#collectionSection').val();
            const collectionDif = $('#collectionDif').val();
            const collectionClass = $('#collectionClass').val();
            if (collectionTitle === '') {
                alert('Введите название подборки');
            }
            else {
                $.ajax({
                    url: '/TaskEditor/create_collection.php',
                    data: {'title': collectionTitle, 'section': collectionSection, 'dif': collectionDif, 'class': collectionClass }, // Добавляем передачу кода раздела
                    type: 'POST',
                    success: function (response) {
                        window.location.href = '/my_base/edit/cards/' + response;
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
            const testTitle = $('#testTitle').val();
            const testSection = $('#testSection').val();
            const testDif = $('#testDif').val();
            const testClass = $('#testClass').val();
            if (testTitle === '') {
                alert('Введите название теста');
            }
            else {
                $.ajax({
                    url: '/TaskEditor/create_test.php',
                    data: {'title': testTitle, 'section': testSection, 'dif' : testDif, 'class' : testClass }, // Добавляем передачу кода раздела
                    type: 'POST',
                    success: function (response) {
                        window.location.href = '/my_base/edit/test/' + response;
                    }
                });
            }
        });
    });

    $(document).ready(function () {
// Обработчик клика на кнопке "Редактировать"
        $('.edit-collection-btn').click(function () {
            const collectionId = $(this).data('collection-id');
            const collectionTitle = $(this).parent().siblings('.collection-title').text();
            $('#editCollectionId').val(collectionId);
            $('#editCollectionTitle').val(collectionTitle);
        });

// Обработчик клика на кнопку "Сохранить изменения"
        $('#editCollectionSubmit').click(function () {
            const collectionId = $('#editCollectionId').val();
            const collectionTitle = $('#editCollectionTitle').val();
            if (collectionTitle === '') {
                alert('Введите название подборки');
            }
            else {
                $.ajax({
                    url: '/TaskEditor/update_collection.php',
                    data: {'id': collectionId, 'title': collectionTitle},
                    type: 'POST',
                    success: function () {
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
            const testId = $(this).data('test-id');
            const testTitle = $(this).parent().siblings('.test-title').text();
            $('#editTestId').val(testId);
            $('#editTestTitle').val(testTitle);
        });

        // Обработчик клика на кнопку "Сохранить изменения"
        $('#editTestSubmit').click(function () {
            const testId = $('#editTestId').val();
            const testTitle = $('#editTestTitle').val();
            if (testTitle === '') {
                alert('Введите название теста');
            }
            else {
                $.ajax({
                    url: '/TaskEditor/update_test.php',
                    data: {'id': testId, 'title': testTitle},
                    type: 'POST',
                    success: function () {
                        $('#editTestModal').modal('hide');
                        window.location.reload();
                    }
                });
            }
        });
    });
</script>
</html>

<?php
// Освобождаем ресурсы
mysqli_close($link);
?>


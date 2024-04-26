<?php

require_once ('../db.php');

//TODO Починить кнопки переименовать и удалить

global $link;


// Проверяем, авторизован ли пользователь
if (!isset($_COOKIE['user'])) {
    header('Location: /login/');
    exit();
}

// Получаем данные пользователя по коду из куки
$user_id = $_COOKIE['user'];

$sql = "SELECT `Пользователи`.*, `Типы пользователей`.`Тип` FROM `Пользователи`
        INNER JOIN `Типы пользователей` ON `Пользователи`.`Тип пользователя`=`Типы пользователей`.`Код типа пользователя`
        WHERE `Пользователи`.`Код пользователя`='$user_id'";
$result = $link->query($sql);
$user = $result->fetch_assoc();


?>

<!doctype html>
<html lang="en" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <title>Мои классы</title>
</head>
<body class="bg-light d-flex flex-column h-100">

<?php include '../inc/header.php';?>

<div class="container">

    <h2>Мои классы</h2>

    <?php
    if($user['Тип'] == 'Базовый') {
        echo '<div id="error-message-get-students" class="alert alert-danger mt-3 text-center" role="alert"><h3>Отказано в доступе</h3></div>';
        echo '<a href="/profile/courses/" class="btn btn-primary">Вернуться</a>';
    }

    if($user['Тип'] == 'Преподаватель' || $user['Тип'] == 'Администратор') {
        ?>
            <div class="btn-group">
                <button class="btn btn-outline-success mt-3" id="createCourseBtn">Создать класс</button>
                <a href="/profile/" class="btn btn-outline-danger mt-3"> Вернуться</a>
            </div>

        <div id="error-message-get" class="alert alert-primary mt-3 visually-hidden" role="alert"></div>

        <div class="courses mt-3">

            <div id="spinner-1" class="spinner-border text-primary mt-3" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>

        </div>

        <?php
    }

    if($user['Тип'] == 'Премиум' || $user['Тип'] == 'Администратор') {
        ?>

        <div class="btn-group">
            <button class="btn btn-outline-primary mt-3" id="joinCourseBtn">Присоединиться к классу</button>
            <a href="/profile/" class="btn btn-outline-danger mt-3"> Вернуться</a>
        </div>

        <div id="error-message-get-students" class="alert alert-primary mt-3 visually-hidden" role="alert"></div>

        <div class="courses-students mt-3">

            <div id="spinner-2" class="spinner-border text-primary mt-3" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>

        </div>

        <?php
    }

    ?>

</div>

<!--Модальное окно создания класса-->
<div class="modal fade" id="classModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="createForm">
                <div class="modal-header">
                    <h5 class="modal-title">Создание класса</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="error-message-create" class="text-danger"></div>
                    <div class="form-group">
                        <label for="name">Введите название класса:</label>
                        <input type="text" class="form-control" id="name" placeholder="Название">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                    <button type="button" class="btn btn-primary" id="createButton">Создать</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--Модальное окно присоединения к классу-->
<div class="modal fade" id="joinModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="joinForm">
                <div class="modal-header">
                    <h5 class="modal-title">Присоединиться к классу</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="error-message-join" class="text-danger"></div>
                    <div class="form-group">
                        <label for="accessCode">Введите код доступа:</label>
                        <input type="text" class="form-control" id="accessCode" placeholder="Код доступа">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                    <button type="button" class="btn btn-primary" id="joinButton">Присоединиться</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Модальное окно для удаления курса -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel">Удаление</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Вы уверены, что хотите удалить класс?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                <a id="confirmDeleteButton" class="btn btn-danger" href="#">Удалить</a>
            </div>
        </div>
    </div>
</div>

<!-- Модальное окно для переименования курса -->
<div class="modal fade" id="renameModal" tabindex="-1" role="dialog" aria-labelledby="renameModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="renameModalLabel">Редактирование подборки</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="renameForm">
                    <div class="form-group">
                        <label for="renameTitle">Переименовать</label>
                        <input type="text" class="form-control" id="renameTitle" placeholder="Новое название курса">
                        <input type="hidden" id="renameId" name="renameId"> <!-- *Добавляем скрытое поле для передачи ID подборки -->
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-primary" id="renameSubmit">Сохранить изменения</button> <!-- *Добавляем кнопку "Сохранить изменения" -->
            </div>
        </div>
    </div>
</div>

<?php include '../inc/footer.php';?>

</body>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function(){
        $("#createCourseBtn").click(function(){
            $("#classModal").modal("show");
        });
        $("#joinCourseBtn").click(function(){
            $("#joinModal").modal("show");
        });
    });

    // Присоединение к классу
    document.getElementById('joinButton').addEventListener('click', function() {
        let accessCode = document.getElementById('accessCode').value;
        let user = <?php  echo $user['Код пользователя']?>;
        let formData = new FormData();
        formData.append('event', 'check_course_code');
        formData.append('accessCode', accessCode);
        formData.append('user', user);
        // Добавляем спиннер в кнопку и блокируем ее
        let button = document.getElementById('joinButton');
        button.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Отправка...';
        button.disabled = true;

        // Очищаем блок с текстом об успешности
        document.getElementById('error-message-join').innerText = '';

        fetch('/courses/handler.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = '/courses/' + data.course_id + '/study';
                } else {
                    document.getElementById('error-message-join').innerText = data.message;
                }

                // Восстанавливаем кнопку после получения данных
                button.innerHTML = 'Присоединиться';
                button.disabled = false;
            })
            .catch(error => console.error('Error:', error));
    });

    // Создание класса
    document.getElementById('createButton').addEventListener('click', function() {
        let name = document.getElementById('name').value;
        let user = <?php  echo $user['Код пользователя']?>;
        let formData = new FormData();
        formData.append('event', 'add_course');
        formData.append('name', name);
        formData.append('user', user);
        // Добавляем спиннер в кнопку и блокируем ее
        let button = document.getElementById('createButton');
        button.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Отправка...';
        button.disabled = true;

        // Очищаем блок с текстом об успешности
        document.getElementById('error-message-create').innerText = '';

        fetch('/courses/handler.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = '/courses/' + data.course_id + '/editor';
                } else {
                    document.getElementById('error-message-create').innerText = data.message;
                }

                // Восстанавливаем кнопку после получения данных
                button.innerHTML = 'Создать';
                button.disabled = false;
            })
            .catch(error => console.error('Error:', error));
    });

    // Получение всех доступных пользователю классов
    document.addEventListener('DOMContentLoaded', function() {
        let user_type = '<?php echo $user['Тип'] ?>';
        let user = <?php echo $user['Код пользователя'] ?>;
        let formData = new FormData();

        if(user_type === 'Преподаватель' || user_type === 'Администратор'){
            let spinner = document.getElementById('spinner-1');
            spinner.style.display = 'block';

            formData.append('event', 'get_courses');
            formData.append('user', user);

            fetch('/courses/handler.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    let coursesDiv = document.querySelector('.courses');
                    coursesDiv.innerHTML = '';

                    if (data.length > 0) {
                        data.forEach(course => {
                            let courseElement = document.createElement('div');
                            courseElement.classList.add('card', 'mb-3');

                            let cardBody = document.createElement('div');
                            cardBody.classList.add('card-body', 'd-flex', 'justify-content-between', 'align-items-center');

                            let courseLink = document.createElement('a');
                            courseLink.textContent = course.name;
                            courseLink.href = '/courses/' + course.id + '/editor';
                            courseLink.classList.add('card-title', 'text-decoration-none', 'text-primary', 'fs-4'); // fs-4 для увеличения размера шрифта
                            courseLink.addEventListener('click', function(event) {
                                event.preventDefault();
                                window.location.href = courseLink.href;
                            });

                            let actionsDiv = document.createElement('div');
                            actionsDiv.classList.add('d-flex', 'btn-group');


                            let copyButton = document.createElement('btn');
                            copyButton.classList.add('btn', 'btn-primary');
                            let copyIcon = document.createElement('i');
                            copyIcon.classList.add('bi', 'bi-copy');
                            copyButton.appendChild(copyIcon);
                            copyButton.addEventListener('click', function() {
                                navigator.clipboard.writeText(course.referral_code)
                                    .then(() => {
                                        alert('Реферальный код скопирован в буфер обмена');
                                    })
                                    .catch(err => {
                                        console.error('Ошибка при копировании: ', err);
                                    });
                            });

                            let renameButton = document.createElement('button');
                            renameButton.type="button";
                            renameButton.classList.add('btn', 'btn-secondary');
                            let renameIcon = document.createElement('i');
                            renameIcon.classList.add('bi', 'bi-pencil-square');
                            renameButton.appendChild(renameIcon);
                            renameButton.setAttribute('data-bs-toggle', 'modal');
                            renameButton.setAttribute('data-bs-target', '#renameModal');

                            let deleteButton = document.createElement('button');
                            deleteButton.type="button";
                            deleteButton.classList.add('btn', 'btn-danger');
                            let deleteIcon = document.createElement('i');
                            deleteIcon.classList.add('bi', 'bi-trash');
                            deleteButton.appendChild(deleteIcon);
                            deleteButton.setAttribute('data-bs-toggle', 'modal');
                            deleteButton.setAttribute('data-bs-target', '#deleteModal');

                            actionsDiv.appendChild(copyButton);
                            actionsDiv.appendChild(renameButton);
                            actionsDiv.appendChild(deleteButton);

                            cardBody.appendChild(courseLink);
                            cardBody.appendChild(actionsDiv);
                            courseElement.appendChild(cardBody);
                            coursesDiv.appendChild(courseElement);
                        });
                    } else {
                        let courses = document.getElementById('error-message-get');
                        courses.innerText = 'У пользователя пока нет курсов.';
                        courses.classList.remove('visually-hidden');
                    }

                    // Инициализация модальных окон
                    let renameModal = new bootstrap.Modal(document.getElementById('renameModal'));
                    let deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));

                    // Добавление обработчиков для кнопок "Переименовать" и "Удалить"
                    document.querySelectorAll('[data-bs-toggle="modal"]').forEach(button => {
                        button.addEventListener('click', () => {
                            let targetModalId = button.getAttribute('data-bs-target').slice(1);
                            if (targetModalId === 'renameModal') {
                                renameModal.show();
                            } else if (targetModalId === 'deleteModal') {
                                deleteModal.show();
                            }
                        });
                    });

                    spinner.style.display = 'none';
                })
                .catch(error => console.error('Error:', error));
        }
        if(user_type === 'Премиум' || user_type === 'Администратор'){

            let spinner = document.getElementById('spinner-2');
            spinner.style.display = 'block';

            formData.append('event', 'get_courses_for_students');
            formData.append('user', user);

            fetch('/courses/handler.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    let coursesDiv = document.querySelector('.courses-students');
                    coursesDiv.innerHTML = '';

                    if (data.length > 0) {
                        data.forEach(course => {
                            let courseElement = document.createElement('div');
                            courseElement.classList.add('card', 'mb-3');

                            let cardBody = document.createElement('div');
                            cardBody.classList.add('card-body', 'd-flex', 'justify-content-between', 'align-items-center');

                            let courseLink = document.createElement('a');
                            courseLink.textContent = course.name;
                            courseLink.href = '/courses/' + course.id + '/study';
                            courseLink.classList.add('card-title', 'text-decoration-none', 'text-primary', 'fs-4'); // fs-4 для увеличения размера шрифта
                            courseLink.addEventListener('click', function(event) {
                                event.preventDefault();
                                window.location.href = courseLink.href;
                            });

                            let actionsDiv = document.createElement('div');
                            actionsDiv.classList.add('d-flex', 'gap-2');


                            let leaveButton = document.createElement('button');
                            leaveButton.textContent = 'Покинуть';
                            leaveButton.classList.add('btn', 'btn-danger');
                            leaveButton.setAttribute('data-bs-toggle', 'modal');
                            leaveButton.setAttribute('data-bs-target', '#deleteModal');

                            actionsDiv.appendChild(leaveButton);

                            cardBody.appendChild(courseLink);
                            cardBody.appendChild(actionsDiv);
                            courseElement.appendChild(cardBody);
                            coursesDiv.appendChild(courseElement);

                            // Обработка модального окна для удаления
                            leaveButton.addEventListener('click', function() {
                                let deleteModal = document.getElementById('deleteModal');
                                let modal = new bootstrap.Modal(deleteModal);
                                modal.show();
                            });
                        });
                    } else {
                        let courses = document.getElementById('error-message-get-students');
                        courses.innerText = 'У пользователя пока нет курсов.';
                        courses.classList.remove('visually-hidden');
                    }

                    spinner.style.display = 'none';
                })
                .catch(error => console.error('Error:', error));
        }
    });
</script>
</html>

<?php

require_once ('../db.php');

global $link;

// Проверяем, авторизован ли пользователь
if (!isset($_COOKIE['user'])) {
    header('Location: /login/');
    exit();
}

$user_id = $_COOKIE['user'];
$course_id = $_GET['id'];

$course_name = '';

if(!empty($course_id)){
    $query = "SELECT * FROM Courses WHERE user_id  = ? AND id = ?";
    $stmt = $link->prepare($query);
    $stmt->bind_param('ss', $user_id, $course_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result-> num_rows > 0) {
        $continue = true;

        $course = $result->fetch_assoc();

        $course_name = $course['name'];
    }
    else{
        $continue = false;
    }
}
else{
    $continue = false;
}
?>

<!doctype html>
<html lang="en" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <!-- Подключение стилей Quill -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <title>Мой класс</title>
    <style>
        .text-truncate {
            max-width: 100px; /* Максимальная ширина текста */
            white-space: nowrap; /* Текст не переносится на новую строку */
            overflow: hidden; /* Скрытие содержимого, выходящего за пределы элемента */
            text-overflow: ellipsis; /* Добавление многоточия в конце обрезанного текста */
        }
        textarea {
            min-height: 100px; /* Минимальная высота */
            max-height: 300px; /* Максимальная высота */
            width: 100%; /* Ширина поля в процентах от родительского элемента */
            resize: vertical; /* Позволяет пользователю изменять размер только по вертикали */
        }
    </style>
</head>
<body class="bg-light d-flex flex-column h-100">

<?php include '../inc/header.php';?>



<div class="container">
    <?php
    if(!$continue){
        echo '<div id="error-message-get-students" class="alert alert-danger mt-3 text-center" role="alert"><h3>Отказано в доступе</h3></div>';
        echo '<a href="/profile/courses/" class="btn btn-primary">Вернуться</a>';
    }
    else{
        ?>

        <h2>Редактор класса: <?php echo $course_name ?></h2>

        <div class="btn-group">
            <button type="button" class="btn btn-outline-success mt-3" data-bs-toggle="modal" data-bs-target="#createSectionModal">Создать раздел</button>
            <a href="/profile/courses/" class="btn btn-outline-danger mt-3">Закончить</a>
        </div>

        <div id="error-message-get" class="alert alert-primary mt-3 visually-hidden" role="alert"></div>

        <div class="row">
            <div class="col-md-2">
                <div class="courses-menu mt-3"></div>
            </div>
            <div class="col-md-10">
                <div class="courses mt-3">
                    <div id="spinner" class="spinner-border text-primary mt-3" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>

        <!--   Создание раздела     -->
        <div class="modal fade" id="createSectionModal" tabindex="-1" role="dialog" aria-labelledby="createSectionModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createSectionModalLabel">Создать раздел</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="createSectionForm">
                            <div class="mb-3">
                                <label for="sectionName" class="form-label">Название раздела:</label>
                                <input type="text" class="form-control" id="sectionName" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                        <button type="button" class="btn btn-primary" onclick="createSection()">Создать</button>
                    </div>
                </div>
            </div>
        </div>

        <!--   Создание текстового блока     -->
        <div class="modal fade" id="createTextModal" tabindex="-1" role="dialog" aria-labelledby="createTextModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="width: 500px;">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createTextModalLabel">Создать текстовый блок</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="createTextForm">
                            <div class="mb-3">
                                <label for="textData" class="form-label">Введите текст</label>
                                <div id="editor-container" style="height: 300px;"></div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                        <button type="button" class="btn btn-primary" onclick="createSection()">Создать</button>
                    </div>
                </div>
            </div>
        </div>

        <!--   Создание Видео блока     -->
        <div class="modal fade" id="createVideoModal" tabindex="-1" role="dialog" aria-labelledby="createVideoModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createVideoModalLabel">Создать раздел</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="createVideoForm">
                            <div class="mb-3">
                                <label for="sectionName" class="form-label">Название раздела:</label>
                                <input type="text" class="form-control" id="sectionName" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                        <button type="button" class="btn btn-primary" onclick="createSection()">Создать</button>
                    </div>
                </div>
            </div>
        </div>

        <!--   Создание Фото блока     -->
        <div class="modal fade" id="createPhotoModal" tabindex="-1" role="dialog" aria-labelledby="createPhotoModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createPhotoModalLabel">Создать раздел</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="createPhotoForm">
                            <div class="mb-3">
                                <label for="sectionName" class="form-label">Название раздела:</label>
                                <input type="text" class="form-control" id="sectionName" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                        <button type="button" class="btn btn-primary" onclick="createSection()">Создать</button>
                    </div>
                </div>
            </div>
        </div>

        <!--   Создание блока карточек    -->
        <div class="modal fade" id="createCardsModal" tabindex="-1" role="dialog" aria-labelledby="createCardsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createCardsModalLabel">Создать раздел</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="createCardsForm">
                            <div class="mb-3">
                                <label for="sectionName" class="form-label">Название раздела:</label>
                                <input type="text" class="form-control" id="sectionName" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                        <button type="button" class="btn btn-primary" onclick="createSection()">Создать</button>
                    </div>
                </div>
            </div>
        </div>

        <!--   Создание блока теста    -->
        <div class="modal fade" id="createTestModal" tabindex="-1" role="dialog" aria-labelledby="createTestModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createTestModalLabel">Добавить тест</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="createTestForm">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="exampleRadios" id="1" value="option1" checked>
                                <label class="form-check-label" for="1">
                                    <a href="/">Задачи для начинающих</a>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="exampleRadios" id="2" value="option2" >
                                <label class="form-check-label" for="2">
                                    <a href="/">Итоговый тест</a>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="exampleRadios" id="3" value="option3" >
                                <label class="form-check-label" for="3">
                                    <a href="/">Проверка знаний</a>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="exampleRadios" id="4" value="option4" >
                                <label class="form-check-label" for="4">
                                    <a href="/">Новые задачи</a>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="exampleRadios" id="5" value="option5" >
                                <label class="form-check-label" for="5">
                                    <a href="/">Экзамен</a>
                                </label>
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                        <button type="button" class="btn btn-primary" onclick="">Добавить</button>
                    </div>
                </div>
            </div>
        </div>

        <?php
    }
    ?>
</div>

<?php include '../inc/footer.php';?>

</body>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<!-- Подключение скриптов Quill -->
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
    const quill = new Quill('#editor-container', {
        theme: 'snow' // или 'bubble' для другого стиля
    });
</script>
<script>

    let user =  <?php  echo $user_id?>;
    let course_id = <?php  echo $course_id?>;
    let formData = new FormData();

    function fetchSections() {
        formData.append('event', 'get_all_data_for_teacher');
        formData.append('course_id', course_id);
        formData.append('user', user);

        // Добавляем спиннер
        let spinner = document.getElementById('spinner');
        spinner.style.display = 'block';

        let coursesContainer = document.querySelector('.courses');
        let coursesMenu = document.querySelector('.courses-menu');
        coursesContainer.innerHTML = '';
        coursesMenu.innerHTML = '';

        fetch('/courses/handler.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                // Обработка полученных данных
                spinner.style.display = 'none';

                const menu = document.createElement('div');
                menu.classList.add('sidebar','card','pb-3');

                const menu_ul = document.createElement('ul');
                menu_ul.classList.add('nav','flex-column');

                if (data.length > 0) {


                    data.forEach(section => {

                        const card = document.createElement('div');
                        card.classList.add('card', 'my-3'); // Добавляем отступы между карточками
                        const cardHeader = document.createElement('div');

                        cardHeader.classList.add('card-header', 'd-flex', 'justify-content-between', 'align-items-center');
                        cardHeader.id = section.id;

                        const headerName = document.createElement('h3');
                        headerName.textContent = section.name
                        cardHeader.appendChild(headerName);

                        const toggleIcon = document.createElement('i');
                        toggleIcon.classList.add('bi', 'bi-chevron-down'); // Иконка для раскрытия/скрытия
                        cardHeader.appendChild(toggleIcon);
                        card.appendChild(cardHeader);

                        const cardBody = document.createElement('div');
                        cardBody.classList.add('card-body');

                        const create_btn_group= document.createElement('div');
                        create_btn_group.classList.add('btn-group','mb-3', 'd-flex', 'justify-content-between', 'align-items-center');

                        const create_btn_text= document.createElement('btn');
                        create_btn_text.type="button";
                        create_btn_text.setAttribute('data-bs-toggle', 'modal');
                        create_btn_text.setAttribute('data-bs-target', '#createTextModal');
                        create_btn_text.classList.add('btn','btn-primary');
                        create_btn_text.textContent = 'Добавить текстовый блок';
                        create_btn_group.appendChild(create_btn_text);

                        const create_btn_video= document.createElement('btn');
                        create_btn_video.type="button";
                        create_btn_video.setAttribute('data-bs-toggle', 'modal');
                        create_btn_video.setAttribute('data-bs-target', '#createVideoModal');
                        create_btn_video.classList.add('btn','btn-primary', 'disabled');
                        create_btn_video.textContent = 'Добавить видео (будет позже)';
                        create_btn_group.appendChild(create_btn_video);

                        const create_btn_photo= document.createElement('btn');
                        create_btn_photo.type="button";
                        create_btn_photo.setAttribute('data-bs-toggle', 'modal');
                        create_btn_photo.setAttribute('data-bs-target', '#createPhotoModal');
                        create_btn_photo.classList.add('btn','btn-primary', 'disabled');
                        create_btn_photo.textContent = 'Добавить фото (будет позже)';
                        create_btn_group.appendChild(create_btn_photo);

                        const create_btn_cards= document.createElement('btn');
                        create_btn_cards.type="button";
                        create_btn_cards.setAttribute('data-bs-toggle', 'modal');
                        create_btn_cards.setAttribute('data-bs-target', '#createCardsModal');
                        create_btn_cards.classList.add('btn','btn-primary');
                        create_btn_cards.textContent = 'Добавить набор карточек';
                        create_btn_group.appendChild(create_btn_cards);

                        const create_btn_test= document.createElement('btn');
                        create_btn_test.type="button";
                        create_btn_test.setAttribute('data-bs-toggle', 'modal');
                        create_btn_test.setAttribute('data-bs-target', '#createTestModal');
                        create_btn_test.classList.add('btn','btn-primary');
                        create_btn_test.textContent = 'Добавить тест';
                        create_btn_group.appendChild(create_btn_test);

                        cardBody.appendChild(create_btn_group);

                        const menuItem = document.createElement('li');
                        menuItem.classList.add('nav-item', 'd-flex', 'align-items-center', 'justify-content-between','mt-3');

                        // Создаем ссылку с названием раздела
                        const menuItemLink = document.createElement('a');
                        menuItemLink.classList.add('btn', 'btn-link', 'text-truncate'); // 'text-truncate' для обрезания текста
                        menuItemLink.textContent = section.name;
                        menuItemLink.href = '#' + section.id;
                        menuItemLink.title = section.name; // Полное название во всплывающей подсказке
                        menuItemLink.style.maxWidth = '100px'; // Максимальная ширина текста, после которой он будет обрезаться
                        menuItem.appendChild(menuItemLink);

                        const buttonGroup = document.createElement('div');
                        buttonGroup.classList.add('btn-group');

                        const renameBtn = document.createElement('button');
                        renameBtn.classList.add('btn', 'btn-outline-secondary');
                        renameBtn.setAttribute('title', 'Rename'); // Добавляем всплывающую подсказку
                        const renameIcon = document.createElement('i');
                        renameIcon.classList.add('bi', 'bi-pencil-square');
                        renameBtn.appendChild(renameIcon);
                        buttonGroup.appendChild(renameBtn);

                        const deleteBtn = document.createElement('button');
                        deleteBtn.classList.add('btn', 'btn-outline-danger');
                        deleteBtn.setAttribute('title', 'Delete'); // Добавляем всплывающую подсказку
                        const deleteIcon = document.createElement('i');
                        deleteIcon.classList.add('bi', 'bi-trash');
                        deleteBtn.appendChild(deleteIcon);
                        buttonGroup.appendChild(deleteBtn);

                        if(section.data.length >0){
                            section.data.forEach(item =>{
                                const itemName = document.createElement('h4');
                                itemName.classList.add('d-flex', 'justify-content-between'); // Добавляем классы для Flexbox
                                const itemButtonGroup = document.createElement('div');
                                itemButtonGroup.classList.add('btn-group');
                                let itemBody= document.createElement('p');
                                if(item.data_type_id === 1){
                                    itemName.textContent = 'Текстовый блок';
                                    itemBody.textContent = item.data;
                                }
                                else{
                                    if(item.data_type_id === 2){
                                        itemName.textContent = 'Видеоматериал';
                                    }
                                    if(item.data_type_id === 3){
                                        itemName.textContent = 'Набор карточек';
                                    }
                                    if(item.data_type_id === 4){
                                        itemName.textContent = 'Тест';
                                    }
                                    itemBody= document.createElement('a');
                                    itemBody.href = item.data;
                                    itemBody.textContent = item.name;
                                }

                                const renameButton = document.createElement('button');
                                renameButton.classList.add('btn', 'btn-outline-secondary');
                                let renameIcon = document.createElement('i');
                                renameIcon.classList.add('bi', 'bi-pencil-square');
                                renameButton.appendChild(renameIcon);

                                const deleteButton = document.createElement('button');
                                deleteButton.classList.add('btn', 'btn-outline-danger');
                                let deleteIcon = document.createElement('i');
                                deleteIcon.classList.add('bi', 'bi-trash');
                                deleteButton.appendChild(deleteIcon);

                                itemButtonGroup.appendChild(renameButton);
                                itemButtonGroup.appendChild(deleteButton);

                                itemName.appendChild(itemButtonGroup);
                                cardBody.appendChild(itemName);

                                cardBody.appendChild(itemBody);

                            })
                        }
                        else{
                            const itemName= document.createElement('h4');
                            itemName.textContent = 'В данном разделе пока нет материалов';
                            cardBody.appendChild(itemName);
                        }

                        card.appendChild(cardBody);
                        coursesContainer.appendChild(card);

                        menuItem.appendChild(buttonGroup);
                        menu_ul.appendChild(menuItem);

                        menu.appendChild(menu_ul);
                        coursesMenu.appendChild(menu);

                        cardHeader.addEventListener('click', () => {
                            cardBody.style.display = cardBody.style.display === 'none' ? 'block' : 'none';
                            toggleIcon.classList.toggle('bi-chevron-down'); // Переключение иконки при раскрытии/скрытии
                            toggleIcon.classList.toggle('bi-chevron-up');
                        });

                        // // Инициализация модальных окон
                        // let createTextModal = new bootstrap.Modal(document.getElementById('createTextModal'));
                        // let createCardsModal = new bootstrap.Modal(document.getElementById('createCardsModal'));
                        //
                        // // Добавление обработчиков для кнопок "Переименовать" и "Удалить"
                        // document.querySelectorAll('[data-bs-toggle="modal"]').forEach(button => {
                        //     button.addEventListener('click', () => {
                        //         let targetModalId = button.getAttribute('data-bs-target').slice(1);
                        //         switch(targetModalId){
                        //             case 'createTextModal':{
                        //                 createTextModal.show();
                        //                 break;
                        //             }
                        //             case 'createCardsModal':{
                        //                 createCardsModal.show();
                        //                 break;
                        //             }
                        //         }
                        //     });
                        // });

                        renameBtn.addEventListener('click', function() {
                            // Добавьте здесь логику для переименования раздела
                        });

                        deleteBtn.addEventListener('click', function() {
                            // Добавьте здесь логику для удаления раздела
                        });
                    });
                }
                else{
                    let courses = document.getElementById('error-message-get');
                    courses.innerText = 'У вас пока нет разделов, давайте добавим их';
                    courses.classList.remove('visually-hidden');
                }

            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

    //Создание раздела
    function createSection() {

        const sectionName = document.getElementById('sectionName').value;
        formData.append('event', 'add_section');
        formData.append('course_id', course_id);
        formData.append('user', user);
        formData.append('sectionName', sectionName);

        fetch('/courses/handler.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                // После успешного создания раздела закройте модальное окно
                const modalElement = document.getElementById('createSectionModal');
                const modal = bootstrap.Modal.getInstance(modalElement);
                modal.hide();

                // Обновление списка разделов
                location.reload()
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

    document.addEventListener('DOMContentLoaded', function() {

        fetchSections();

        const menuItems = document.querySelectorAll('.menu a');

        // Обработка бокового меню
        menuItems.forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.getAttribute('href').substring(1);
                const targetSection = document.getElementById(targetId);

                if (targetSection) {
                    window.scrollTo({
                        top: targetSection.offsetTop,
                        behavior: 'smooth'
                    });
                }
            });
        });
    });

</script>

</html>
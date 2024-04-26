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
    $query = "SELECT * FROM Course_students WHERE user_id  = ? AND course_id = ?";
    $stmt = $link->prepare($query);
    $stmt->bind_param('ss', $user_id, $course_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result-> num_rows > 0) {
        $continue = true;
        $course = $result->fetch_assoc();

        $course_id = $course['course_id'];

        $query = "SELECT * FROM Courses WHERE id = ?";
        $stmt = $link->prepare($query);
        $stmt->bind_param('s',  $course_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $course_name = $result->fetch_assoc()['name'];
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
    <title>Мой класс</title>
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
        <h2><?php echo $course_name ?></h2>

        <div class="btn-group">
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
    <?php
    }
    ?>

</div>

<?php include '../inc/footer.php';?>

</body>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>

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
                menu.classList.add('sidebar','card');

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


                        const menuItem = document.createElement('li');
                        menuItem.classList.add('nav-item', 'd-flex', 'align-items-center', 'justify-content-between');

                        // Создаем ссылку с названием раздела
                        const menuItemLink = document.createElement('a');
                        menuItemLink.classList.add('btn', 'btn-link', 'text-truncate'); // 'text-truncate' для обрезания текста
                        menuItemLink.textContent = section.name;
                        menuItemLink.href = '#' + section.id;
                        menuItemLink.title = section.name; // Полное название во всплывающей подсказке
                        menuItemLink.style.maxWidth = '100px'; // Максимальная ширина текста, после которой он будет обрезаться
                        menuItem.appendChild(menuItemLink);

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

                        menu_ul.appendChild(menuItem);

                        menu.appendChild(menu_ul);
                        coursesMenu.appendChild(menu);

                        cardHeader.addEventListener('click', () => {
                            cardBody.style.display = cardBody.style.display === 'none' ? 'block' : 'none';
                            toggleIcon.classList.toggle('bi-chevron-down'); // Переключение иконки при раскрытии/скрытии
                            toggleIcon.classList.toggle('bi-chevron-up');
                        });
                    });
                }
                else{
                    let courses = document.getElementById('error-message-get');
                    courses.innerText = 'В данном классе пока нет материалов, вернитесь позже';
                    courses.classList.remove('visually-hidden');
                }

            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

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
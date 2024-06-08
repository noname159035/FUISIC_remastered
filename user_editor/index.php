<?php
if (!isset($_COOKIE['user'])) {
    header('Location: /login/');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Пользователи</title>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
</head>
<body class="bg-light d-flex flex-column h-100">

<?php include '../inc/header.php' ?>

<div class="container">
    <div class="row justify-content-between align-items-center mt-3">
        <div class="col-md-6">
            <label for="search-input">Поиск:</label>
            <input type="text" id="search-input" class="form-control" placeholder="Введите запрос...">
        </div>
        <div class="col-md-3 text-md-end">
            <a href="/profile/" class="btn btn-danger">Вернуться</a>
        </div>
    </div>

    <div id="error-message-get" class="alert alert-primary mt-3 visually-hidden" role="alert"></div>
    <div class="users">
        <div id="spinner-1" class="spinner-border text-primary mt-3" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
</div>

<!-- Модальное окно для редактирования пользователя -->
<div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="renameModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Редактировать пользователя</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Форма для редактирования пользователя -->
                <form id="editUserForm" method="post">
                    <input type="hidden" id="editUserId" name="userId">
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email">
                    </div>
                    <div class="form-group">
                        <label for="name">Имя:</label>
                        <input type="text" class="form-control" id="name" name="name" >
                    </div>
                    <div class="form-group">
                        <label for="surname">Фамилия:</label>
                        <input type="text" class="form-control" id="surname" name="surname" >
                    </div>
                    <div class="form-group">
                        <label for="password">Пароль:</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password" name="password" >
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility()">
                                <i class="bi bi-eye-slash" id="password-toggle-icon"></i>
                            </button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="birthdate">Дата рождения:</label>
                        <input type="date" class="form-control" id="birthdate" name="birthdate">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                        <button type="submit" class="btn btn-primary">Сохранить</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<!-- Модальное окно для подтверждения удаления пользователя -->
<div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog" aria-labelledby="renameModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Удалить пользователя</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Вы уверены, что хотите удалить этого пользователя?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                <button type="button" class="btn btn-danger">Удалить</button>
            </div>
        </div>
    </div>
</div>

<?php include '../inc/footer.php' ?>

</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    let formData = new FormData();
    let spinner = document.getElementById('spinner-1');
    spinner.style.display = 'block';

    function getAllUsers() {
        const formData = new FormData();
        formData.append('event', 'get_all_users');
        fetch('/user_editor/handler.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(users => {
                const availableTags = []; // Создаем массив для хранения доступных тегов

                // Заполняем массив доступных тегов данными пользователей
                users.forEach(user => {
                    availableTags.push(user['e-mail']);
                    availableTags.push(user['Имя'] + ' ' + user['Фамилия']);
                    // Добавьте другие поля, по которым хотите осуществлять поиск
                });

                $("#search-input").autocomplete({
                    source: availableTags,
                    select: function(event, ui) {
                        const selectedUser = users.find(user => user['e-mail'] === ui.item.value || (user['Имя'] + ' ' + user['Фамилия']) === ui.item.value);
                        displayFilteredUsers([selectedUser]);
                    }
                });

                $("#search-input").on('input', function() {
                    const query = $(this).val().toLowerCase();
                    console.log(query);
                    const filteredUsers = users.filter(user => {
                        return user['e-mail'].toLowerCase().includes(query) ||
                            user['Имя'].toLowerCase().includes(query) ||
                            user['Фамилия'].toLowerCase().includes(query) ||
                            (user['Имя'] + ' ' + user['Фамилия']).toLowerCase().includes(query);
                    });
                    displayFilteredUsers(filteredUsers);
                });
                if (users.length > 0) {
                    displayFilteredUsers(users); // Отображаем всех пользователей при загрузке страницы
                } else {
                    const errorMessage = document.getElementById('error-message-get');
                    errorMessage.innerText = 'Других пользователей кроме вас нет!';
                    errorMessage.classList.remove('visually-hidden');
                }
                spinner.style.display = 'none';
            })
            .catch(error => console.log('Ошибка при загрузке данных:', error));
    }

    function displayFilteredUsers(filteredUsers) {
        const container = document.querySelector('.users');
        container.innerHTML = ''; // Очищаем контейнер перед отображением отфильтрованных пользователей
        const errorMessage = document.getElementById('error-message-get');
        errorMessage.classList.add('visually-hidden');
        if (filteredUsers.length > 0) {
            container.innerHTML = `
                <table class="table mt-3">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Тип</th>
                            <th>e-mail</th>
                            <th>Имя</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
            `;
            filteredUsers.forEach(user => {
                const userElement = document.createElement('tr');
                userElement.innerHTML = `
                    <td>${user['Код пользователя']}</td>
                    <td>${user['Тип']}</td>
                    <td>${user['e-mail']}</td>
                    <td>${user['Имя']} ${user['Фамилия']}</td>
                    <td>
                        <div class="btn-group">
                            <button class="btn btn-outline-primary" onclick="editUser(${user.id})">Редактировать</button>
                            <button class="btn btn-outline-danger disabled" onclick="editUser(${user.id})">Бан</button>
                            <button class="btn btn-outline-danger" onclick="deleteUser(${user.id})">Удалить</button>
                        </div>
                    </td>
                `;
                container.querySelector('tbody').appendChild(userElement);
            });
            container.innerHTML += `</tbody></table>`;
        } else {
            const errorMessage = document.getElementById('error-message-get');
            errorMessage.innerText = 'По вашему запросу ничего не найдено';
            errorMessage.classList.remove('visually-hidden');
        }
    }

    $(document).ready(function() {
        getAllUsers();
    });

    function editUser(userId) {
        // Здесь можно заполнить форму редактирования данными пользователя с указанным ID
        // const user = users.find(user => user.id === userId);

        // Заполняем поля формы редактирования данными пользователя
        // document.getElementById('editUserId').value = user.id;
        // document.getElementById('editUserEmail').value = user['e-mail'];
        // document.getElementById('editUserName').value = user['Имя'];
        // document.getElementById('editUserLastName').value = user['Фамилия'];
        $('#editUserModal').modal('show');
    }

    function deleteUser(userId) {
        $('#deleteUserModal').modal('show');
    }

    function togglePasswordVisibility() {
        const passwordInput = document.getElementById("password");
        const passwordToggleIcon = document.getElementById("password-toggle-icon");
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            passwordToggleIcon.classList.remove("bi-eye-slash");
            passwordToggleIcon.classList.add("bi-eye");
        } else {
            passwordInput.type = "password";
            passwordToggleIcon.classList.remove("bi-eye");
            passwordToggleIcon.classList.add("bi-eye-slash");
        }
    }
</script>
</html>

<?php
// Проверяем, авторизован ли пользователь
if (!isset($_COOKIE['user'])) {
    header('Location: /login/');
    exit();
}

require_once ('../db.php');

global $link;

// Получаем данные пользователя по коду из куки
$user_id = $_COOKIE['user'];

$sql = "SELECT `Пользователи`.*, `Типы пользователей`.`Тип` FROM `Пользователи`
        INNER JOIN `Типы пользователей` ON `Пользователи`.`Тип пользователя`=`Типы пользователей`.`Код типа пользователя`
        WHERE `Пользователи`.`Код пользователя`='$user_id'";
$result = $link->query($sql);
$user = $result->fetch_assoc();

if (isset($_POST['submit'])) {

    //Задаем пользовательские данные
    $new_email = $_POST['new_email'];
    $new_first_name = $_POST['new_first_name'];
    $new_last_name = $_POST['new_last_name'];
    $new_date_of_birth = $_POST['new_date_of_birth'];
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    $user_id = $_POST['user_id'];

    // Проверка текущего пароля
    if (md5($current_password. "sadfasd123")!= $user['Password']) {
        // Текущий пароль неверный
        $error = "Неверный текущий пароль";
    } else {
        // Текущий пароль верный, продолжаем
        if (!empty($new_password)) {
            // Новый пароль задан, проверяем его
            if ($new_password!= $confirm_password) {
                // Пароли не совпадают
                $error = "Пароли не совпадают";
            } else {
                // Пароли совпадают, сохраняем новый пароль
                $new_password = md5($new_password. "sadfasd123");
            }
        } else {
            // Новый пароль не задан, сохраняем старый пароль
            $new_password = $user['Password'];
        }

        // Проверка корректности введенных данных
        if (!filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
            $error = "Некорректный e-mail";
        } elseif (strlen($new_first_name) < 2 || strlen($new_first_name) > 30) {
            $error = "Имя должно содержать от 2 до 30 символов";
        } elseif (strlen($new_last_name) < 2 || strlen($new_last_name) > 30) {
            $error = "Фамилия должна содержать от 2 до 30 символов";
        } elseif (!preg_match('/^\d{2}\.\d{2}\.\d{4}$/', $new_date_of_birth)) {
            $error = "Некорректная дата рождения";
        }

        // Проверка наличия e-mail в базе данных
        $email_check_query = "SELECT * FROM Пользователи WHERE `e-mail`='$new_email' AND `Код пользователя` != '$user_id'";
        $email_check_result = $link->query($email_check_query);

        if ($email_check_result->num_rows > 0) {
            $error = "E-mail уже занят";
        }

        if (!isset($error)){
            // Обновляем данные пользователя в базе данных
            $new_date_of_birth = date('Y-m-d', strtotime($new_date_of_birth));
            $query = "UPDATE Пользователи SET `e-mail`='$new_email', Имя='$new_first_name', Фамилия='$new_last_name', `Дата рождения`='$new_date_of_birth', Password='$new_password' WHERE `Код пользователя`='$user_id'";
            $link->query($query);
            header('Location: /profile/');
            exit();
        }
    }
}

$query = "SELECT * FROM Уровни ORDER BY id";
$result = mysqli_query($link, $query);
$levels = []; // массив с информацией о каждом уровне

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $levels[] = $row;
    }
} else {
    die('Ошибка запроса: ' . mysqli_error($link));
}

$query = "SELECT IFNULL((SELECT COUNT(*) FROM История WHERE Пользователь = $user_id), 0) + IFNULL((SELECT COUNT(*) FROM История тестов WHERE Пользователь = $user_id), 0) AS Количество_заданий";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_assoc($result);
$count = $row['Количество_заданий']/2;
$currentLevel = 0; // текущий уровень пользователя

foreach ($levels as $level) {
    if ($count >= $level['мин_кол_заданий']) {
        $currentLevel = $level['id'];
    } else {
        break;
    }
}

$max_value = $levels[count($levels) - 1]['мин_кол_заданий'];
$nextLevel = null; // следующий уровень

foreach ($levels as $level) {
    if ($count < $level['мин_кол_заданий']) {
        $nextLevel = $level;
        break;
    }
}

// Получение информации о следующем уровне
if ($nextLevel) {
$remaining = $nextLevel['мин_кол_заданий'] - $count;
$current_min_value = $levels[$currentLevel - 1]['мин_кол_заданий'];
$next_min_value = $nextLevel['мин_кол_заданий'];
$next_max_value = $nextLevel['мин_кол_заданий'];
$next_percent = (($count - $current_min_value) / ($next_max_value - $current_min_value)) * 100;
?>

<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <meta charset="UTF-8">
    <title>Данные пользователя</title>
    <link rel="stylesheet" href="/style/level.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.3.0/css/all.css" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

</head>
<body class="bg-light d-flex flex-column h-100">

<?php include '../inc/header.php';?>

<div class="container">
    <div class="row">
        <!-- Блок кнопок -->
        <div class="col-md-3">
            <h1>Меню</h1>
            <!-- Здесь будут наши кнопки -->
            <ul class="list-group">
                <!--<li class="list-group-item"><a href="/"><i class="fa-solid fa-house"></i> Главная страница</a></li>-->
                <li class="list-group-item"><a href="/history/" class="text-decoration-none"><i class="bi bi-clock-history"></i> История</a></li>
                <li class="list-group-item"><a href="/favorites/" class="text-decoration-none"><i class="bi bi-star"></i> Избранное</a></li>
                <li class="list-group-item"><a href="/archives/" class="text-decoration-none"><i class="bi bi-trophy"></i> Достижения</a></li>
                <li class="list-group-item"><a href="/rating/" class="text-decoration-none"><i class="bi bi-bar-chart"></i> Рейтинг</a></li>
                <?php
                if ($user['Тип'] == 'Администратор' ) {
                    echo "<li class='list-group-item'><a href='/profile/courses/' class='text-decoration-none'><i class='bi bi-journal-check'></i> Мои классы</a></li>";
                } else if($user['Тип'] == 'Премиум' || $user['Тип'] == 'Преподаватель') {
                    echo "<li class='list-group-item' title='Будет доступно позже'><a href='/404' class='text-decoration-none'><i class='bi bi-journal-check'></i> Мои классы</a></li>";
                }
                if ($user['Тип'] == 'Администратор' || $user['Тип'] == 'Премиум' || $user['Тип'] == 'Преподаватель') {
                    echo "<li class='list-group-item'><a href='/my_base/' class='text-decoration-none'><i class='bi bi-list-task'></i> Мои задания</a></li>";
                }
                if ($user['Тип'] == 'Администратор') {
                    echo "<li class='list-group-item'><a href='/users/' class='text-decoration-none'><i class='bi bi-people'></i> Пользователи</a></li>";
                }
                ?>
                <li class="list-group-item"><a href="/logout/" class="text-decoration-none"><i class="bi bi-box-arrow-right"></i> Выход</a></li>
            </ul>
        </div>
        <!-- Блок профиля -->
        <div class="col-md-6">
            <h1>Личный кабинет</h1>
            <!--Редактирование пользователей-->
            <?php if(isset($_GET['edit'])):
                if (isset($error)) {

                    // Если есть ошибки, выводим их
                    echo "<div class='alert alert-danger' role='alert'>$error</div>";}?>
                <form method="post">

                    <!-- E-mail -->
                    <div class="form-group">
                        <label for="new_email">E-mail:</label>
                        <input type="email" class="form-control" name="new_email" id = "new_email" value="<?php echo $user['e-mail'];?>" required>
                        <div class="invalid-feedback"></div>
                    </div>

                    <!-- Имя -->
                    <div class="form-group">
                        <label for="new_first_name">Имя:</label>
                        <input type="text" class="form-control" name="new_first_name" id = "new_first_name" value="<?php echo $user['Имя'];?>" required>
                        <div class="invalid-feedback"></div>
                    </div>

                    <!-- Фамилия -->
                    <div class="form-group">
                        <label for="new_last_name">Фамилия:</label>
                        <input type="text" class="form-control" name="new_last_name" id = "new_last_name" value="<?php echo $user['Фамилия'];?>" required>
                        <div class="invalid-feedback"></div>
                    </div>

                    <!-- Дата рождения -->
                    <div class="form-group">
                        <label for="new_date_of_birth">Дата рождения:</label>
                        <input type="text" class="form-control" name="new_date_of_birth" id="new_date_of_birth" value="<?php echo date('d.m.Y', strtotime($user['Дата рождения']));?>" required >
                        <div class="invalid-feedback"></div>
                    </div>

                    <!-- Текущий пароль -->
                    <div class="form-group">
                        <label for="current_password">Текущий пароль (Необходим для сохранения изменений) :</label>
                        <div class="input-group">
                            <input type="password" class="form-control" name="current_password" id="current_password" required>
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('current_password')" style="border-top-left-radius: 0; border-bottom-left-radius: 0; height: 100%;">
                                    <i class="bi bi-eye-slash" id="current_password_toggle_icon"></i>
                                </button>
                            </div>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>

                    <!-- Новый пароль -->
                    <div class="form-group">
                        <label for="new_password">Новый пароль:</label>
                        <div class="input-group">
                            <input type="password" class="form-control" name="new_password" id="new_password">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('new_password')" style="border-top-left-radius: 0; border-bottom-left-radius: 0; height: 100%;">
                                    <i class="bi bi-eye-slash" id="new_password_toggle_icon"></i>
                                </button>
                            </div>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>

                    <!-- Подтвердите новый пароль -->
                    <div class="form-group">
                        <label for="confirm_password">Подтвердите новый пароль:</label>
                        <div class="input-group">
                            <input type="password" class="form-control" name="confirm_password" id="confirm_password">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('confirm_password')" style="border-top-left-radius: 0; border-bottom-left-radius: 0; height: 100%;">
                                    <i class="bi bi-eye-slash" id="confirm_password_toggle_icon"></i>
                                </button>
                            </div>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>

                    <input type="hidden" name="user_id" value="<?php echo $user_id;?>">


                    <div class="button">
                        <button type="submit" class="btn btn-primary" name="submit">Сохранить изменения</button>
                        <a href="/profile/" class="btn btn-secondary" style="float: right;">Отменить</a>
                    </div>
                </form>

                <!--Вывод данных пользователя-->
            <?php else: ?>
                <div class="table-responsive border">
                    <table class="table">
                        <tbody>
                        <tr>
                            <th scope="row">Тип пользователя</th>
                            <td><?php echo $user['Тип'];?></td>
                        </tr>
                        <tr>
                            <th scope="row">E-mail</th>
                            <td><?php echo $user['e-mail'];?></td>
                        </tr>
                        <tr>
                            <th scope="row">Имя</th>
                            <td><?php echo $user['Имя'];?></td>
                        </tr>
                        <tr>
                            <th scope="row">Фамилия</th>
                            <td><?php echo $user['Фамилия'];?></td>
                        </tr>
                        <tr>
                            <th scope="row" style="border-bottom-width: 0 !important;">Дата рождения</th>
                            <td style="border-bottom-width: 0 !important;"><?php echo date('d.m.Y', strtotime($user['Дата рождения']));?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <div class="button d-flex justify-content-end">
                    <a href="/profile/edit/" class="btn btn-primary">Редактировать данные</a>
                </div>
            <?php endif; ?>

        </div>
        <!-- Блок Прогресса -->
        <div class="col-md-3">
            <h1>Прогресс</h1>
                <div class="level-info border">
                    <div class="current-level">
                        <p>Текущий уровень: <b><?php echo $levels[$currentLevel - 1]['название_уровня'];?></b></p>
                        <p>Выполнено заданий: <b><?php echo $count;?></b></p>
                    </div>
                    <div class="next-level">
                        <p>Следующий уровень: <b><?php echo $nextLevel['название_уровня'];?></b> </p>
                    </div>
                    <div class="progress-container" style="display: flex;">
                        <span><b><?php echo $levels[$currentLevel - 1]['мин_кол_заданий'];?></b></span>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar"
                                 aria-valuenow="<?php echo $count;?>"
                                 aria-valuemin="<?php echo $current_min_value;?>"
                                 aria-valuemax="<?php echo $next_max_value;?>"
                                 style="width: <?php echo $next_percent;?>%;">
                            </div>
                        </div>
                        <span><b><?php echo $next_max_value;?></b></span>
                    </div>
                    <p>(осталось решить <?php echo $remaining;?> заданий)</p>
                </div>
                <?php
            } else {
                // Все уровни пройдены
                ?>
                <div class="level-info">
                    <div class="current-level">
                        Текущий уровень: <?php echo $levels[$currentLevel - 1]['название_уровня']; ?>
                    </div>
                    <div class="next-level">
                        Поздравляем! Вы прошли все уровни!
                    </div>
                </div>
                <?php
            }
            // Закрытие соединения с БД
            mysqli_close($link);
            ?>
        </div>

    </div>
</div>

<?php include '../inc/footer.php';?>

</body>
<!-- Календарь -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<!-- Остальное -->
<script src="/libs/jquery-3.6.1.min.js"></script>
<script src="/libs/bootstrap-5.3.1-dist/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

<script>
    // свойства календаря
    flatpickr("#new_date_of_birth", {
        allowInput: true,
        dateFormat: "d.m.Y",
        maxDate: "today",
        minDate: "01.01.1900",
    });
    <!-- Валидация e-mail -->
    $('input[name="new_email"]').on('input', function() {
        const form = $(this).closest('form')[0];
        const login = $(this).val();
        const loginRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (login.length !== 0 ) {
            if (!loginRegex.test(login)) {
                $(this).addClass('is-invalid');
                $(this).siblings('.invalid-feedback').text('Введите корректный e-mail');
            } else {
                $(this).removeClass('is-invalid');
                $(this).siblings('.invalid-feedback').text('');
            }
        } else {
            $(this).removeClass('is-invalid');
            $(this).siblings('.invalid-feedback').text('');
        }
        const invalidCount = form.querySelectorAll('.is-invalid').length;
        form.querySelector('button[type="submit"]').disabled = invalidCount > 0;
    });

    <!-- Валидация имени и фамилии -->
    $('input[name="new_first_name"], input[name="new_last_name"]').on('input', function() {
        const form = $(this).closest('form')[0];
        const name = $(this).val();
        const nameRegex = /^[A-Я][а-я]*$/; // Изменяем регулярное выражение, чтобы разрешить только кириллицу
        if (name.length !== 0 ) {
            if (!nameRegex.test(name)) {
                $(this).addClass('is-invalid');
                $(this).siblings('.invalid-feedback').text('Имя и фамилия должны начинаться с заглавной буквы и содержать только кириллицу');
            } else {
                $(this).removeClass('is-invalid');
                $(this).siblings('.invalid-feedback').text('');
            }
        } else {
            $(this).removeClass('is-invalid');
            $(this).siblings('.invalid-feedback').text('');
        }
        const invalidCount = form.querySelectorAll('.is-invalid').length;
        form.querySelector('button[type="submit"]').disabled = invalidCount > 0;
    });
    <!-- Валидация текущего пароля -->
    $('input[name="current_password"]').on('input', function() {
        const form = $(this).closest('form')[0];
        const pass = $(this).val();
        if (pass.length !== 0 ) {
            if (pass.length < 5) {
                $(this).addClass('is-invalid');
                $(this).siblings('.invalid-feedback').text('Длина пароля должна быть не менее 5 символов');
            } else {
                $(this).removeClass('is-invalid');
                $(this).siblings('.invalid-feedback').text('');
            }
        } else {
            $(this).removeClass('is-invalid');
            $(this).siblings('.invalid-feedback').text('');
        }
        const invalidCount = form.querySelectorAll('.is-invalid').length;
        form.querySelector('button[type="submit"]').disabled = invalidCount > 0;
    });
    <!-- Валидация нового пароля -->
    $('input[name="new_password"]').on('input', function() {
        const form = $(this).closest('form')[0];
        const pass = $(this).val();
        if (pass.length !== 0 ) {
            if (pass.length < 5) {
                $(this).addClass('is-invalid');
                $(this).siblings('.invalid-feedback').text('Длина пароля должна быть не менее 5 символов');
            } else {
                $(this).removeClass('is-invalid');
                $(this).siblings('.invalid-feedback').text('');
            }
        } else {
            $(this).removeClass('is-invalid');
            $(this).siblings('.invalid-feedback').text('');
        }
        const invalidCount = form.querySelectorAll('.is-invalid').length;
        form.querySelector('button[type="submit"]').disabled = invalidCount > 0;
    });
    <!-- Валидация подтверждающего пароля -->
    $('input[name="confirm_password"]').on('input', function() {
        const form = $(this).closest('form')[0];
        const pass = $(this).val();
        const passwordInput = form.querySelector('input[name="new_password"]');
        if (pass.length !== 0 ) {
            if (pass.length < 5) {
                $(this).addClass('is-invalid');
                $(this).siblings('.invalid-feedback').text('Длина пароля должна быть не менее 5 символов');
            } else {
                if (pass !== passwordInput.value) {
                    $(this).siblings('.invalid-feedback').text('Пароли не совпадают');
                } else {
                    $(this).removeClass('is-invalid');
                    $(this).siblings('.invalid-feedback').text('');
                }
            }

        } else {
            $(this).removeClass('is-invalid');
            $(this).siblings('.invalid-feedback').text('');
        }
        const invalidCount = form.querySelectorAll('.is-invalid').length;
        form.querySelector('button[type="submit"]').disabled = invalidCount > 0;
    });

</script>
<script>
    <!-- скрипт для кнопки раскрытия пароля -->
    function togglePasswordVisibility(inputId) {
        const passwordInput = document.getElementById(inputId);
        const passwordToggleIcon = document.getElementById(`${inputId}_toggle_icon`);
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

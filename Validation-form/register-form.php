<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.3.0/css/all.css" crossorigin="anonymous">
</head>

<body class="bg-light d-flex flex-column h-100">

<?php include '../inc/header.php' ?>

<div class="container justify-content-center">
    <section class="d-flex justify-content-center">
    <div class="card mt-5">
        <div class="m-3">
            <?php
            if (!isset($_COOKIE['user'])):

            if (isset($_GET['error'])) {
                $error = $_GET['error'];
                if ($error == 'email-exists') {
                    echo "<div class='alert alert-danger' role='alert'>Этот e-mail уже занят.</div>";
                }
            }
            ?>
                <h1 class="text-center">Регистрация</h1>
                <form action="/Validation-form/check.php" method="post">
                    <!-- First and Last name -->
                    <div class="form-group">
                        <label for="name">Имя:</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Введите имя" required>
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="form-group">
                        <label for="second_name">Фамилия:</label>
                        <input type="text" class="form-control" name="second_name" id="second_name" placeholder="Введите фамилию" required>
                        <div class="invalid-feedback"></div>
                    </div>

                    <!-- E-mail -->
                    <div class="form-group">
                        <label for="login">E-mail:</label>
                        <input type="email" class="form-control" name="login" id="login" placeholder="Введите адрес электронной почты" required>
                        <div class="invalid-feedback" id="email-error"></div>
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label for="pass">Пароль:</label>
                            <div class="input-group has-validation">
                                <input type="password" class="form-control " name="pass" id="pass" placeholder="Придумайте пароль" required>
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility()">
                                    <i class="bi bi-eye-slash" id="password-toggle-icon"></i>
                                </button>
                                <div class="invalid-feedback"></div>
                            </div>
                    </div>

                    <!-- Confirm Password -->
                    <div class="form-group">
                        <label for="confirm_password">Повторите пароль:</label>
                        <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Повторите пароль" required>
                        <div class="invalid-feedback"></div>
                    </div>

                    <!-- Date of birth -->
                    <div class="form-group">
                        <label for="birth_day">Дата рождения:</label>
                        <input type="text" class="form-control" name="birth_day" id="birth_day" placeholder="Введите дату рождения в формате ДД.ММ.ГГГГ" required>
                        <div class="invalid-feedback"></div>
                    </div>

                    <button class="btn btn-primary w-100 mt-4" type="submit" disabled>Зарегистрировать</button>

                    <div class="text-center mt-4">
                        <p>Уже есть аккаунт? <a href="/login/" class="text-decoration-none">Войти</a></p>

                        <p>Или войти при помощи:</p>
                        <button type="button" class="btn btn-link btn-floating mx-1">
                            <i class="fab fa-vk"></i>
                        </button>

                        <button type="button" class="btn btn-link btn-floating mx-1">
                            <i class="fab fa-telegram"></i>
                        </button>

                        <button type="button" class="btn btn-link btn-floating mx-1">
                            <i class="fab fa-yandex"></i>
                        </button>
                    </div>

                    <div class="mt-3 d-flex justify-content-center">
                        <a href="/" class="btn btn-outline-danger">Отмена</a>
                    </div>
                </form>
            <?php else: ?>
                <?php header('Location: /profile/') ?>
            <?php endif;?>
        </div>
    </div>
    </section>
</div>

<?php include '../inc/footer.php' ?>

<script src="/libs/jquery-3.6.1.min.js"></script>
<script src="/libs/bootstrap-5.3.1-dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
    flatpickr("#birth_day", {
        allowInput: true,
        dateFormat: "d.m.Y",
        maxDate: "today",
        minDate: "01.01.1900",
    });

    $('input[name="login"]').on('input', function() {
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

    $('input[name="pass"]').on('input', function() {
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

    $('input[name="confirm_password"]').on('input', function() {
        const form = $(this).closest('form')[0];
        const password = $(this).val();
        const passwordInput = form.querySelector('input[name="pass"]');
        if (password.length !== 0 ) {
            if (password!== passwordInput.value) {
                $(this).addClass('is-invalid');
                $(this).siblings('.invalid-feedback').text('Пароли не совпадают');
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

    $('input[name="name"], input[name="second_name"]').on('input', function() {
        const form = $(this).closest('form')[0];
        const name = $(this).val();
        const nameRegex = /^[A-Я][а-яё]*$/; // Изменяем регулярное выражение, чтобы разрешить только кириллицу
        if (name.length !== 0 ) {
            if (!nameRegex.test(name)) {
                $(this).addClass('is-invalid');
                $(this).siblings('.invalid-feedback').text('Имя и фамилия должны начинаться с заглавной буквы');
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
</script>

<script>
    function togglePasswordVisibility() {
        const passwordInput = document.getElementById("pass");
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

</body>
</html>

<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <meta charset="UTF-8">
    <title>Авторизация</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.3.0/css/all.css" crossorigin="anonymous">

</head>
<body class="bg-light d-flex flex-column h-100">

<?php include '../inc/header.php' ?>

<div class="container justify-content-center">
    <section class="d-flex justify-content-center">
    <div class="card mt-5">
        <div class="m-3">
            <?php
            if (!isset($_COOKIE['user'])) {
                if (isset($_GET['error'])) {
                    $error = $_GET['error'];
                    if ($error == 'account-doesnt_exists') {
                        echo "<div class='alert alert-danger' role='alert'>Неверный e-mail или пароль</div>";

                    }
                }
                ?>
                <h1 class="text-center">Авторизация</h1>
                <form action="/Validation-form/auth.php" method="post">
                    <!-- E-mail -->
                    <div class="form-group">
                        <label for="login">E-mail:</label>
                        <input type="email" class="form-control" name="login" id="login" placeholder="Введите адрес электронной почты" required>
                        <div class="invalid-feedback"></div>
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label for="pass">Пароль:</label>
                        <div class="input-group has-validation">
                            <input type="password" class="form-control" name="pass" id="pass" placeholder="введите пароль" required>
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility()">
                                <i class="bi bi-eye-slash" id="password-toggle-icon"></i>
                            </button>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col d-flex justify-content-center">
                            <!-- Checkbox -->
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="form2Example31">
                                <label class="form-check-label" for="form2Example31"> Запомнить меня </label>
                            </div>
                        </div>

                        <div class="col">
                            <!-- Simple link -->
                            <a href="forgot-pass/" class=" d-flex justify-content-center text-decoration-none ">Забыли пароль?</a>
                        </div>
                    </div>

                    <button class="btn btn-primary w-100 mt-4" type ="submit">Авторизоваться</button>

                    <div class="text-center mt-4">
                        <p>Нет аккаунта? <a href="/register/" class="text-decoration-none">Зарегистрироваться</a></p>
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
                <?php
            } else {
                // Перенаправление на страницу профиля
                header('Location: /profile/');
                exit();
            }
            ?>
        </div>
        </div>
    </section>
</div>

<?php include '../inc/footer.php' ?>

</body>

<script src="/libs/jquery-3.6.1.min.js"></script>
<script src="/libs/bootstrap-5.3.1-dist/js/bootstrap.min.js"></script>

<script>
    $('input[name="login"]').on('input', function() {
        const form = $(this).closest('form')[0];
        const login = $(this).val();
        const loginRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (login.length!== 0 ) {
            if (!loginRegex.test(login)) {
                $(this).addClass('is-invalid');
                $(this).siblings('.invalid-feedback').text('Введите корректный e-mail');
            } else { $(this).removeClass('is-invalid');
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
        if (pass.length!== 0 ) {
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
</html>

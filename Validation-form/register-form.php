<! DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content=" ie=edge">
    <title>Регистрация</title>
    <link rel="stylesheet" href="/style/background_style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <style>
        .buttons {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>

</head>

<body>

<div class="background">

    <?php include '../header.php'?>

    <div class="container-md mx-auto mt-6">
        <?php
        if (!isset($_COOKIE['user'])):

        if (isset($_GET['error'])) {
            $error = $_GET['error'];
            if ($error == 'email-exists') {
                echo "<div class='alert alert-danger' role='alert'>Этот e-mail уже занят.</div>";
            }
        }
        ?>

        <div class="row">
            <div class="col">
                <h1>Регистрация</h1>
                <form action="/Validation-form/check.php" method="post">

                    <!-- E-mail -->
                    <div class="form-group">
                        <label for="login">E-mail:</label>
                        <input type="email" class="form-control" name="login" id="login" placeholder="Введите адрес электронной почты" required>
                        <div class="invalid-feedback" id="email-error"></div>
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label for="pass">Пароль:</label>
                        <div class="input-group">
                            <input type="password" class="form-control" name="pass" id="pass" placeholder="Придумайте пароль" required>
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility()" style="border-top-left-radius: 0; border-bottom-left-radius: 0; padding-top: 10px !important; padding-bottom: 10px !important;">
                                    <i class="bi bi-eye-slash" id="password-toggle-icon"></i>
                                </button>
                            </div>

                            <div class="invalid-feedback"></div>
                        </div>
                    </div>

                    <!-- Confirm Password -->
                    <div class="form-group">
                        <label for="confirm_password">Повторите пароль:</label>
                        <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Повторите пароль" required>
                        <div class="invalid-feedback"></div>
                    </div>


                    <!-- First and Last name -->
                    <div class="form-group">
                        <div class="row">
                            <div class="col">
                                <label for="name">Имя:</label>
                                <input type="text" class="form-control" name="name" id="name" placeholder="Введите имя" required>
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="col">
                                <label for="second_name">Фамилия:</label>
                                <input type="text" class="form-control" name="second_name" id="second_name" placeholder="Введите фамилию" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Date of birth -->
                    <div class="form-group">
                        <label for="birth_day">Дата рождения:</label>
                        <input type="text" class="form-control" name="birth_day" id="birth_day" placeholder="Введите дату рождения" required>
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="buttons" style="margin-top: 24px">
                        <button class="btn btn-primary" type="submit" disabled>Зарегистрировать</button>

                        <a href="login-form.php" class="header-text auth_txt">Уже есть аккаунт?</a>
                        <a href="/index_new.php" class="header-text auth_txt">Отмена</a>
                    </div>


                </form>
            </div>

            <?php else: ?>
                <?php header('Location: /validation-form/profile.php') ?>
            <?php endif;?>
        </div>
    </div>

    <?php include '../footer.php'?>

</div>

<script src="/libs/jquery-3.6.1.min.js"></script>
<script src="/libs/bootstrap-5.3.1-dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>

    flatpickr("#birth_day", {
        allowInput: true,
        dateFormat: "d.m.Y",
        maxDate: "today",
        minDate: "01.01.1900",
        defaultDate: "01.01.2000"
    });

    $('input[name="login"]').on('input', function() {
        const form = $(this).closest('form')[0];
        const login = $(this).val();
        const loginRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!loginRegex.test(login)) {
            $(this).addClass('is-invalid');
            $(this).siblings('.invalid-feedback').text('Введите корректный e-mail');
        } else {
            $(this).removeClass('is-invalid');
            $(this).siblings('.invalid-feedback').text('');
        }
        const invalidCount = form.querySelectorAll('.is-invalid').length;
        form.querySelector('button[type="submit"]').disabled = invalidCount > 0;
    });

    $('form').on('submit', function(event) {
        event.preventDefault(); // Отменяем отправку формы

        const login = $('input[name="login"]').val();

        $.ajax({
            url: '/Validation-form/check.php',
            type: 'POST',
            data: { login: login },
            success: function(response) {
                const $submitButton = $('button[type="submit"]');

                if (response === 'true') {
                    $('#email-error').text('Такой e-mail уже существует');
                    $submitButton.prop('disabled', true);
                } else if (response === 'false') {
                    $('#email-error').text('Введите корректный e-mail');
                    $submitButton.prop('disabled', true);
                } else {
                    $('#email-error').text('');
                    $submitButton.prop('disabled', false);
                }
            }
        });
    });

    $('input[name="pass"]').on('input', function() {
        const form = $(this).closest('form')[0];
        const pass = $(this).val();
        if (pass.length < 5) {
            $(this).addClass('is-invalid');
            $(this).siblings('.invalid-feedback').text('Длина пароля должна быть не менее 5 символов');
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
        const nameRegex = /^[A-Я][a-я]*$/;
        if (!nameRegex.test(name)) {
            $(this).addClass('is-invalid');
            $(this).siblings('.invalid-feedback').text('Имя и фамилия должны начинаться с заглавной буквы');
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
        if (password!== passwordInput.value) {
            $(this).addClass('is-invalid');
            $(this).siblings('.invalid-feedback').text('Пароли не совпадают');
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

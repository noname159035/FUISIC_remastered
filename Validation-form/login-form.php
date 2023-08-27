<! DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content=" ie=edge">
    <title>FUISIC</title>
    <link rel="stylesheet" href="/style/support_style.css">
    <style>
        .buttons {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>
</head>
<body>
<div class="container_1">

    <?php include '../header.php'?>

    <div class="container-md mx-auto mt-6">
        <?php
        if (!isset($_COOKIE['user'])) {
            // Выводите форму авторизации
            ?>
            <div class="col">
                <h1>Авторизация</h1>
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
                        <input type="password" class="form-control" name="pass" id="pass" placeholder="введите пароль" required>
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="buttons" style="margin-top: 24px">
                        <button class="btn btn-primary" type ="submit">Авторизоваться</button>

                        <a href="register-form.php" class="header-text auth_txt">Зарегистрироваться</a>
                        <a href="/index_new.php" class="header-text auth_txt">Отмена</a>
                    </div>

                    <div class="buttons" style="margin-top: 24px">
                        <a href="forgot_pass.php" class="header-text auth_txt">Забыли пароль?</a>
                    </div>

                </form>
            </div>
            <?php
        } else {
            // Перенаправление на страницу профиля
            header('Location: /Validation-form/profile.php');
            exit();
        }
        ?>
    </div>

    <?php include '../footer.php'?>

</div>
</body>

<script src="/libs/jquery-3.6.1.min.js"></script>
<script src="/libs/bootstrap-5.3.1-dist/js/bootstrap.min.js"></script>

<script>
    $('input[name="login"]').on('input', function() {
        var form = $(this).closest('form')[0];
        var login = $(this).val();
        var loginRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
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

    $('input[name="pass"]').on('input', function() {
        var form = $(this).closest('form')[0];
        var pass = $(this).val();
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
</script>
</html>

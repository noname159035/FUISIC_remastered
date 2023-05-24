<! DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content=" ie=edge">
        <title>FUISIC</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/styles.css">
    </head>
    <body>
        <div class="container-md mx-auto mt-6">
            <?php
            if($_COOKIE['user'] == ''):
            ?>
                <div class="col">
                    <h1>Авторизациия</h1>
                    <form action="/validation-form/auth.php" method="post">
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

                        <button class="btn btn-primary" type ="submit">Авторизоваться</button>

                        <a href="register-form.php" class="header-text auth_txt">зарегистрироваться</a>
                        <a href="/index.php" class="header-text auth_txt">Отмена</a>
                    </form>
                <?php else: ?>
                <?php header('Location: /validation-form/profile.php') ?>
                <?php endif;?>
            </div>
        </div>

    </body>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
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

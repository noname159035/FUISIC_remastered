<?php
// Проверяем, авторизован ли пользователь
if (!isset($_COOKIE['user'])) {
    header('Location: /validation-form/login-form.php');
    exit();
}

// Получаем данные пользователя по коду из куки

$mysql = new mysqli('localhost', 'p523033_admin', 'eQ5kJ0dN5a', 'p523033_Test_3');
$user_id = $_COOKIE['user'];
$result = $mysql->query("SELECT * FROM `Пользователи` WHERE `Код пользователя`='$user_id'");
$sql = "SELECT `Пользователи`.*, `Типы пользователей`.`Тип` FROM `Пользователи`
        INNER JOIN `Типы пользователей` ON `Пользователи`.`Тип пользователя`=`Типы пользователей`.`Код типа пользователя`
        WHERE `Пользователи`.`Код пользователя`='$user_id'";
$result = $mysql->query($sql);
$user = $result->fetch_assoc();
if (!$result) {
    die('Ошибка запроса: ' . mysqli_error($mysql));
}
// Обработка изменений данных пользователя
if (isset($_POST['submit'])) {
    $new_email = $_POST['new_email'];
    $new_first_name = $_POST['new_first_name'];
    $new_last_name = $_POST['new_last_name'];
    $new_date_of_birth = $_POST['new_date_of_birth'];

    $new_password = "";

    if(!empty($_POST['new_password'])) {
        $new_password = md5($_POST['new_password'] . "sadfasd123");
        $mysql->query("UPDATE Пользователи SET Password='$new_password' WHERE `Код пользователя`='$user_id'");
    }

    // Обновляем данные пользователя в базе данных
    $query = "UPDATE Пользователи SET `e-mail`='$new_email', Имя='$new_first_name', Фамилия='$new_last_name', `Дата рождения`='$new_date_of_birth'";
    if (!empty($new_password)) {
        $query .= ", Password='$new_password'";
    }
    $query .= " WHERE `Код пользователя`='$user_id'";
    $mysql->query($query);

    // Обновляем данные в переменной $user, чтобы они были актуальны на странице
    $result = $mysql->query("SELECT * FROM Пользователи WHERE `Код пользователя`='$user_id'");
    $user = $result->fetch_assoc();
}
mysqli_close($mysql);
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Данные пользователя</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="/validation-form/level.css">
        <link rel="stylesheet" href="/style/collections_style.css"/>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.3.0/css/all.css" crossorigin="anonymous">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

    </head>
    <body>
    <div class="header">
        <a href="/index.php" class="header-text main_txt">Главная</a>
        <a href="/collections.php" class="header-text coll_txt">Подборки</a>
        <a href="/Tests.php" class="header-text test_txt">Тесты</a>
        <a href="/support.php" class="header-text help_txt">Помощь</a>
        <?php
        // Проверяем, авторизован ли пользователь
        if (!isset($_COOKIE['user'])) {
            echo ("<a href='/validation-form/login-form.php' class='header-text auth_txt'>войти</a>");
        }
        else echo ("<a href='/validation-form/login-form.php' class='header-text auth_txt'>Профиль</a>");
        ?>
        <a href="index.php" id="logo"></a>

    </div>
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <!-- Здесь будут наши кнопки -->
                    <ul class="list-group">
                        <li class="list-group-item"><a href="/"><i class="fa-solid fa-house"></i> Главная страница</a></li>
                        <li class="list-group-item"><a href="/validation-form/History.php"><i class="fas fa-user"></i> История</a></li>
                        <li class="list-group-item"><a href="/validation-form/profile.php"><i class="fas fa-heart"></i> Избранное</a></li>
                        <li class="list-group-item"><a href="/validation-form/profile.php"><i class="fas fa-trophy"></i> Достижения</a></li>
                        <li class="list-group-item"><a href="/validation-form/raiting.php"><i class="fas fa-star"></i> Рейтинг</a></li>
                        <li class="list-group-item"><a href="/validation-form/exit.php"><i class="fas fa-sign-out-alt"></i> Выход</a></li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <h1>Личный кабинет</h1>
                    <?php if(isset($_GET['edit'])): ?> 
                    <form method="post">
                        <div class="form-group">
                            <label for="new_email">E-mail:</label>
                            <input type="email" class="form-control" name="new_email" value="<?php echo $user['e-mail']; ?>" required>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="new_first_name">Имя:</label>
                            <input type="text" class="form-control" name="new_first_name" value="<?php echo $user['Имя']; ?>" required>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="new_last_name">Фамилия:</label>
                            <input type="text" class="form-control" name="new_last_name" value="<?php echo $user['Фамилия']; ?>" required>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="new_date_of_birth">Дата рождения:</label>
                            <div class="input-group date">
                            <input type="date" class="form-control" name="new_date_of_birth" value="<?php echo $user['Дата рождения']; ?>" min="1900-01-01" required>
                            <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="current_password">Текущий пароль:</label>
                            <input type="password" class="form-control" name="current_password" required>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="new_password">Новый пароль:</label>
                            <input type="password" class="form-control" name="new_password">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="confirm_password">Подтвердите новый пароль:</label>
                            <input type="password" class="form-control" name="confirm_password">
                        </div>
                        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                        <button type="submit" class="btn btn-primary" name="submit">Сохранить изменения</button>
                        <a href="?cancel" class="btn btn-secondary">Отменить</a>
                    </form>
                    <?php else: ?>
                    <p><strong>Тип пользователя:</strong> <?php echo $user['Тип']; ?></p>
                    <p><strong>E-mail:</strong> <?php echo $user['e-mail']; ?></p>
                    <p><strong>Имя:</strong> <?php echo $user['Имя']; ?></p>
                    <p><strong>Фамилия:</strong> <?php echo $user['Фамилия']; ?></p>
                    <p><strong>Дата рождения:</strong> <?php echo $user['Дата рождения']; ?></p>
                    <a href="?edit=<?php echo $user_id; ?>" class="btn btn-primary">Редактировать данные</a>
                    <?php endif; ?>
                </div>
                <div class="col-md-3">
                    <?php
                    $db = new mysqli('localhost', 'p523033_admin', 'eQ5kJ0dN5a', 'p523033_Test_3');
                    $query = "SELECT * FROM Уровни ORDER BY id ASC";
                    $result = mysqli_query($db, $query);
                    $levels = []; // массив с информацией о каждом уровне

                    if ($result) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $levels[] = $row;
                        }
                    } else {
                        die('Ошибка запроса: ' . mysqli_error($db));
                    }
                    $query = "SELECT (SELECT COUNT(*) FROM История WHERE Пользователь = $user_id) + (SELECT COUNT(*) FROM История тестов WHERE Пользователь = $user_id) AS Количество_заданий";
                    $result = mysqli_query($db, $query);
                    $row = mysqli_fetch_assoc($result);
                    $count = $row['Количество_заданий'];
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
                    <div class="level-info">
                        <div class="current-level">
                            Текущий уровень: <?php echo $levels[$currentLevel - 1]['название_уровня']; ?>
                        </div>
                        <div class="next-level">
                            <p>Следующий уровень: <?php echo $nextLevel['название_уровня']; ?></p>
                        </div>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar"
                                 aria-valuenow="<?php echo $count; ?>" aria-valuemin="<?php echo $current_min_value; ?>"
                                 aria-valuemax="<?php echo $next_max_value; ?>" style="width: <?php echo $next_percent; ?>%;">
                                <?php echo $count; ?>
                            </div>
                        </div>
                        <p>(осталось решить <?php echo $remaining; ?> заданий)</p>
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
                    mysqli_close($db);
                    ?>
                </div>
            </div>
        </div>
    </body>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <script>

        // функция для проверки полей на корректность
        
        $('input[name="current_password"]').on('input', function() {
            var form = $(this).closest('form')[0];
            var $this = $(this); // сохраняем значение $(this) в переменной $this
            var currentPassword = $this.val();
            $.post('check_password.php', {password: currentPassword}, function(response) {
                if (response !== 'OK') {
                    $this.addClass('is-invalid');
                    $this.siblings('.invalid-feedback').text('Текущий пароль введен неверно');
                } else {
                    $this.removeClass('is-invalid');
                    $this.siblings('.invalid-feedback').text('');
                }
                const form = $('form')[0];
                const invalidCount = form.querySelectorAll('.is-invalid').length;
                form.querySelector('button[name="submit"]').disabled = invalidCount > 0;
            });
            const invalidCount = form.querySelectorAll('.is-invalid').length;
            form.querySelector('button[name="submit"]').disabled = invalidCount > 0;
        }); 
        
        $('input[name="new_email"]').on('input', function() {
            var form = $(this).closest('form')[0];
            var email = $(this).val();
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                $(this).addClass('is-invalid');
                $(this).siblings('.invalid-feedback').text('Введите корректный e-mail');
            } else {
                $(this).removeClass('is-invalid');
                $(this).siblings('.invalid-feedback').text('');
            }
            const invalidCount = form.querySelectorAll('.is-invalid').length;
            form.querySelector('button[name="submit"]').disabled = invalidCount > 0;
        });
            
        $('input[name="new_password"], input[name="confirm_password"]').on('input', function() {
            var form = $(this).closest('form')[0];
            var newPassword = $('input[name="new_password"]').val();
            var confirmPassword = $('input[name="confirm_password"]').val();
            if (newPassword !== confirmPassword) {
                $('input[name="new_password"], input[name="confirm_password"]').addClass('is-invalid');
                $('input[name="new_password"]').siblings('.invalid-feedback').text('Пароли не совпадают');
            } else {
                $('input[name="new_password"], input[name="confirm_password"]').removeClass('is-invalid');
                $('input[name="new_password"]').siblings('.invalid-feedback').text('');
            }
            const invalidCount = form.querySelectorAll('.is-invalid').length;
            form.querySelector('button[name="submit"]').disabled = invalidCount > 0;
        });
        
        $('input[name="new_first_name"]').on('input', function() {
            var form = $(this).closest('form')[0];
            var firstName = $(this).val();
            var firstNameRegex = /^[a-zA-Zа-яА-ЯёЁ\s\-']+$/u;
            if (!firstNameRegex.test(firstName)) {
                $(this).addClass('is-invalid');
                $(this).siblings('.invalid-feedback').text('Введите корректное имя');
            } else {
                $(this).removeClass('is-invalid');
                $(this).siblings('.invalid-feedback').text('');
            }
            const invalidCount = form.querySelectorAll('.is-invalid').length;
            form.querySelector('button[name="submit"]').disabled = invalidCount > 0;
        });

        $('input[name="new_last_name"]').on('input', function() {
            var form = $(this).closest('form')[0];
            var lastName = $(this).val();
            var lastNameRegex = /^[a-zA-Zа-яА-ЯёЁ\s\-']+$/u;
            if (!lastNameRegex.test(lastName)) {
                $(this).addClass('is-invalid');
                $(this).siblings('.invalid-feedback').text('Введите корректную фамилию');
            } else {
                $(this).removeClass('is-invalid');
                $(this).siblings('.invalid-feedback').text('');
            }
            const invalidCount = form.querySelectorAll('.is-invalid').length;
            form.querySelector('button[name="submit"]').disabled = invalidCount > 0;
        });
        
        $('input[name="new_date_of_birth"]').on('input', function() {
            var form = $(this).closest('form')[0];
            var dob = $(this).val();
            var today = new Date();
            var dobDate = new Date(dob);
            var maxDate = new Date(today.getFullYear(), today.getMonth(), today.getDate()); 
            if (dobDate > maxDate) {
                $(this).addClass('is-invalid');
                $(this).siblings('.invalid-feedback').text('Дата рождения не должна превышать текущую дату');
            } else {
                $(this).removeClass('is-invalid');
                $(this).siblings('.invalid-feedback').text('');
            }
            const invalidCount = form.querySelectorAll('.is-invalid').length;
            form.querySelector('button[name="submit"]').disabled = invalidCount > 0;
        });
        
        $('input[name="current_password"]').on('input', function() {
            var form = $(this).closest('form')[0];
            var currentPassword = $(this).val();
            $.post('check_password.php', {password: currentPassword}, function(response) {
                if (response !== 'OK') {
                    $(this).addClass('is-invalid');
                    $(this).siblings('.invalid-feedback').text('Текущий пароль введен неверно');
                } else {
                    $(this).removeClass('is-invalid');
                    $(this).siblings('.invalid-feedback').text('');
                }
            });
            const invalidCount = form.querySelectorAll('.is-invalid').length;
            form.querySelector('button[name="submit"]').disabled = invalidCount > 0;
        });
    </script>
</html>

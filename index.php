<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8"/>
        <link rel="stylesheet" href="style/index_style.css"/>
        <!-- Иконки -->
        <link rel="apple-touch-icon" sizes="180x180" href="/favicons/apple-touch-icon.png"/>
        <link rel="icon" type="image/png" sizes="32x32" href="/favicons/favicon-32x32.png"/>
        <link rel="icon" type="image/png" sizes="16x16" href="/favicons/favicon-16x16.png"/>
        <link rel="manifest" href="/favicons/site.webmanifest"/>
        <link rel="mask-icon" href="/favicons/safari-pinned-tab.svg" color="#5bbads5"/>
        <meta name="msapplication-TileColor" content="#2b5797"/>
        <meta
        name="theme-color" content="#ffffff"/>
        <!--    <script src="main.js"></script>-->
        <title>FUISIC</title>
        <!-- Шрифты -->
        <link rel="preconnect" href="https://fonts.googleapis.com"/>
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet"/>
    </head>
    <body>
        <div id="conteiner">
            <div class="header">
                <a href="index.php" class="header-text main_txt">Главная</a>
                <a href="collections.php" class="header-text coll_txt">Подборки</a>
                <a href="Tests.php" class="header-text test_txt">Тесты</a>
                <a href="support.php" class="header-text help_txt">Помощь</a>
                <?php
                // Проверяем, авторизован ли пользователь
                if (!isset($_COOKIE['user'])) {
                    echo ("<a href='Validation-form/login-form.php' class='header-text auth_txt'>войти</a>");
                }
                else echo ("<a href='Validation-form/login-form.php' class='header-text auth_txt'>Профиль</a>");
                ?>
                <a href="index.php" id="logo"></a>

            </div>
            <div id="back_img_1"></div>
            <div id="triangle">
                <p id="trang_heading">FUISIC</p>
                <p id="trang_text">ТРЕНАЖЕР ДЛЯ ЗАПОМИНАНИЯ</p>
                <p id="trang_text">ФОРМУЛ ПО ФИЗИКЕ И МАТЕМАТИКЕ</p>
            </div>
            <div id="conteiner_background_img"></div>
            <div id="top_info_block">
                <p id="top_info_toptext" class="top_info_text">
                    Мы не только помогаем запоминать самые сложные законы с помощью особых
                                                  алгоритмов, но и даем подробное объяснение
                </p>
                <p id="top_info_bottomtext" class="top_info_text">
                    Выберите предмет, формулы (законы) которого хотите изучить
                </p>
            </div>
            <div class="menu_button" id="menu_physics">
                <h1 class="button_name" id="phys_name">ФИЗИКА</h1>
            </div>
            <div class="menu_button" id="menu_math">
                <h1 class="button_name" id="math_name">МАТЕМАТИКА</h1>
            </div>
            <div id="bottom_info_block">
                <p id="bottom_info_toptext" class="top_info_text">
                    Подборки всех необходимых формул в рамках школьных программ
                                                  “Математики” и “Физики”
                </p>
            </div>
            <div id="footer">
                <p id="footer_heading">FIUSIC</p>
                <br/>
                <p id="footer_text">Контакты: avmineev@edu.hse.ru</p>
            </div>
        </div>
        <script src="scrypts/index_scrypt.js"></script>
    </body>
</html>

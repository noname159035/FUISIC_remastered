<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8"/>
        <!-- Иконки -->
        <link rel="apple-touch-icon" sizes="180x180" href="/favicons/apple-touch-icon.png"/>
        <link rel="icon" type="image/png" sizes="32x32" href="/favicons/favicon-32x32.png"/>
        <link rel="icon" type="image/png" sizes="16x16" href="/favicons/favicon-16x16.png"/>
        <link rel="manifest" href="/favicons/site.webmanifest"/>
        <link rel="mask-icon" href="/favicons/safari-pinned-tab.svg" color="#5bbads5"/>

        <link rel="stylesheet" href="style/collections_new_style.css" />
        <link rel="stylesheet" href="style/header_footer_style.css" />

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
        <div class="conteiner">
            <header>
               <img src="style/img/test.svg" class="hdr logo">
               <a href="#" class="hdr hdr_txt" id="main">Главная</a>
               <p class="hdr hdr_txt pnt">•</p>
               <a href="#" class="hdr hdr_txt" id="collections">Подборки</a>
               <p class="hdr hdr_txt pnt">•</p>
               <a href="#" class="hdr hdr_txt" id="tests">Тесты</a>
               <p class="hdr hdr_txt pnt">•</p>
               <a href="#" class="hdr hdr_txt" id="help">Помощь</a>
                <?php
                // Проверяем, авторизован ли пользователь
                if (!isset($_COOKIE['user'])) {
                    echo ("<button class='hdr btn'>Войти</button>");
                }
                else echo ("<button class='hdr btn'>Профиль</button>");
                ?>

            </header>

            <div>
                <img src="style/img/bbl.svg" alt="" class="areas">

                <div class="areas_conteiner">
                    <div class="fuisic_areas text">FUISIC</div>
                    <p class="fuisic_areas areas_top_text text">Тренажер по запоминанию формул</p>
                    <p class="fuisic_areas areas_bottom_text text">физики и математики</p>
                </div>
            </div>
            <br>

            <div style="align-items: center; flex-direction: column; display: flex;">
                <div class="search">
                    <input type="text" placeholder="Тема подборки или теста">
                    <div>
                        <img src="style/img/search_ico.svg" alt="" style="cursor: pointer;">
                    </div>
                </div>
            </div>
            <a href="show_cards_new.php">asdasdsa</a>
            <div class="filter_conteiner">
                <div style="display: flex; height: 100%; justify-content: space-evenly;">
                    <div class="filter nonselected"><p style="margin-top: 4%">Предмет</p></div>
                    <div class="filter selected"><p style="margin-top: 4%">Предмет</p></div>
                </div>
            </div>

            <div class="collection">
                <p id="name_of_collection">Давление в жидкостях</p>
                <div class="property">
                    <div class="quantity_сont">
                        <p id="number_formul">9</p>
                        <p style="margin-top: 11%; margin-left: 7%;font-size: 1.2vw; font-family: sans-serif; color: #9587FF">формул</p>
                    </div>
                    <div class="time_сont">
                        <img src="style/img/clock.svg" style="width: 15%; margin-top: -35%; margin-right: 3%">
                        <p id="number_time" style="margin-top: 5%; font-size: 1.3vw; font-family: sans-serif; color: #9587FF">17</p>
                        <p style="margin-top: 6%; margin-left: 4%; font-size: 1.2vw; font-family: sans-serif; color: #9587FF">минут</p>
                    </div>
                </div>
            </div>
            <div class="collection">
                <p id="name_of_collection">Давление в жидкостях</p>
                <div class="property">
                    <div class="quantity_сont">
                        <p id="number_formul">9</p>
                        <p style="margin-top: 11%; margin-left: 7%;font-size: 1.2vw; font-family: sans-serif; color: #9587FF">формул</p>
                    </div>
                    <div class="time_сont">
                        <img src="style/img/clock.svg" style="width: 15%; margin-top: -35%; margin-right: 3%">
                        <p id="number_time" style="margin-top: 5%; font-size: 1.3vw; font-family: sans-serif; color: #9587FF">17</p>
                        <p style="margin-top: 6%; margin-left: 4%; font-size: 1.2vw; font-family: sans-serif; color: #9587FF">минут</p>
                    </div>
                </div>
            </div>

            <footer>
                <div class="media">
                    <div class="media_left">
                        <div class="media_left_btn">
                            <img src="style/img/tg.svg" alt="" style="cursor: pointer; width: 3vw">
                            <img src="style/img/mail.svg" alt="" style="cursor: pointer; width: 3vw; margin-left: 2vw">
                        </div>
                        <div class="text media_left_text"> © 2023 FUISIC, Inc </div>
                    </div>

                    <div class="media_right">
                        <div class="media_right_text text"><p href="" style="cursor: pointer; text-decoration: none;">Поддержка</p></div>
                        <div class="media_right_text text"><p href="" style="cursor: pointer; text-decoration: none;">Условия</p></div>
                        <div class="media_right_text text"><p href="" style="cursor: pointer; text-decoration: none;">Конфидициальность</p></div>
                    </div>
                </div>
            </footer>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="scrypts/index_scrypt.js"></script>
    </body>
</html>
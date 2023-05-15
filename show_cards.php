<!DOCTYPE html>
<html>
    <head>
        <title>Карточки</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="style/cards_style.css">
        <!-- Подключаем стили и скрипты библиотеки MathQuill -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mathquill/0.10.1/mathquill.css" integrity="sha512-1i2kdU6oq3PAzrP6r/QkjDiuclLRhjFeT7L+d1X8C43ndhAR51ZgA+PSVwvH8Wmc7VhjzMG/n1Q5j5Fx9Pa5GA==" crossorigin="anonymous" />

    </head>


    <body>

        <div id="conteiner">
            <div class="header">
                <a href="index.html" class="header-text main_txt">Главная</a>
                <a href="collections.php" class="header-text coll_txt">Подборки</a>

                <a href="support.html" class="header-text help_txt">Помощь</a>
                <a href="Validation-form/login-form.php" class="header-text auth_txt">войти</a>
                <a href="index.html" id="logo"></a>

                <a href="Tests.php" class="header-text test_txt">Тесты</a>
                <a href="support.php" class="header-text help_txt">Помощь</a>
                <?php
                // Проверяем, авторизован ли пользователь
                if (!isset($_COOKIE['user'])) {
                    echo ("<a href='validation-form/login-form.php' class='header-text auth_txt'>войти</a>");
                }
                else echo ("<a href='validation-form/login-form.php' class='header-text auth_txt'>Профиль</a>");
                ?>
                <a href="index.php" id="logo"></a>

            </div>

            <?php
            // Подключение к базе данных
            $link = new mysqli('localhost', 'p523033_admin', 'eQ5kJ0dN5a', 'p523033_Test_3');
            $query = "SELECT Название FROM Подборки WHERE `код подборки` = ?";
            $stmt = $link->prepare($query);
            $stmt->bind_param('s', $_GET['podbor']);
            $stmt->execute();
            $result = $stmt->get_result();
            $podborName = $result->fetch_array(MYSQLI_ASSOC)['Название'];
            ?>
            <h1 class="podbor_name">Подборка: <?php echo $podborName ?></h1>
            <div class="container_1">
                <?php

    // Подключение к базе данных
    $link = new mysqli('localhost', 'p523033_admin', 'eQ5kJ0dN5a', 'p523033_Test_3');
                $query = "SELECT * FROM `Карточка` WHERE Подборка = ?";
                $stmt = $link->prepare($query);
                $stmt->bind_param('s', $_GET['podbor']);
                $stmt->execute();
                $result = $stmt->get_result();
                $userId = $_COOKIE['user'];
                $podborId = $_GET['podbor'];
                $time = date("Y-m-d H:i:s");

                if (isset($_POST['finish'])) {
                    // Код для записи данных в таблицу "История"
                    $query = "INSERT INTO История (Пользователь, `Дата прохождения задания`, Подборка) VALUES (?, ?, ?)";
                    $stmt = $link->prepare($query);
                    $stmt->bind_param('sss', $userId, $time, $podborId);
                    $stmt->execute();
                    if (!$stmt) {
                        echo "Error: " . mysqli_error($link);
                    }
                    // Перенаправление на страницу example.php с передачей данных в POST-запросе
                    header("Location: collections.php");
                    exit();

                } else {
                    // Код для вывода карточек
                    if (isset($_GET['podbor']) && $_GET['podbor'] != 0) {

                        if ($link->connect_error) {
                            die("Connection failed: " . $link->connect_error);
                        }

                        // Подготовка запроса


                        // Создание массива всех карточек
                        $cardsArr = [];
                        while ($row = $result->fetch_assoc()) {
                            $card = [
                                'formula' => $row['Формула'],
                                'description' => $row['Описание'],
                                'explanation'=> $row['Пояснение']
                            ];
                            array_push($cardsArr, $card);
                        }

                        // Проверка на наличие карточек
                        if (count($cardsArr) > 0) {
                            // Определение текущей карточки
                            $currentCard = 0;
                            if (isset($_GET['card']) && $_GET['card'] >= 0 && $_GET['card'] < count($cardsArr)) {
                                $currentCard = $_GET['card'];
                            }

                            // Вывод текущей карточки
                            $card = $cardsArr[$currentCard];
                            echo "<div class='card'>";
                            echo "<div class='card-front'>";
                            echo "<h3><div class='mathjax-latex'>" . $card['formula'] . "</div></h3>";
                            echo "</div>";
                            echo "<div class='card-back'>";
                            echo "<p>" . $card['description'] . "</p>";
                            echo "</div>";
                            echo "</div>";

                            // Кнопки переключения карточек
                            echo "<div class='buttons'>";

                            if ($currentCard > 0) {
                                $prevCard = $currentCard - 1;
                                echo "<a href='?podbor=" . $_GET['podbor'] . "&card=" . $prevCard . "' class='button prev-button'><svg width='82' height='64' viewBox='0 0 82 64' fill='none' xmlns='http://www.w3.org/2000/svg'><path d='M51.25 16L30.75 32L51.25 48' stroke='#0C507C' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'/></svg></a>";
                            }
                            if ($currentCard < count($cardsArr) - 1) {
                                $nextCard = $currentCard + 1;
                                echo "<a href='?podbor=" . $_GET['podbor'] . "&card=" . $nextCard . "' class='button next-button'><svg width='82' height='64' viewBox='0 0 82 64' fill='none' xmlns='http://www.w3.org/2000/svg'><path d='M30.75 48L51.25 32L30.75 16' stroke='#0C507C' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'/></svg></a>";

                            }

                            echo "</div>";

                            // Скрипт для переворота карточки при клике на нее
                            echo "<script>
                    var card = document.querySelector('.card');
                    card.addEventListener('click', function() {
                        card.classList.toggle('is-flipped');
                    });
                    </script>";
                        } else {
                            header('Location: /collections.php');
                            exit();
                        }

                    } else {
                        header('Location: /');
                        exit();
                    }
                }
                ?>
                <form method="POST" action="/show_cards.php<?php echo"?podbor=" . $_GET['podbor']?>">

                    <!-- Счетчик карточек и кнопка "Finish" -->
                    <div class="buttons" id="counter">
                        <div>
                            <!-- <div class="counter"> -->
                            <?php
    // Вывод счетчика всех карточек и текущей
    echo "<p>Карточка " . ($currentCard + 1) . " из " . count($cardsArr) . "</p>";
                            ?>
                            <!-- </div>     -->
                        </div>
                    </div>
                    <button type="submit" name="finish" class="button buttons finish-button">Закончить</button>
                    <button id="button_tren" class="button buttons training-button" type="button">Тренажер</button>
                    <button id="button_exp" class="button buttons exp-button" type="button" onclick="showExplanation()"></button>
                </form>
            </div>
        </div>
        <div id="explanation" style="display:none;">
            <?php echo "<h2>Пояснение</h2>" . $card['explanation']?>
            <button onclick="hideExplanation()">Понятно</button>
        </div>


        <div class="footer_conteiner">
            <div id="footer">
                <p id="footer_heading">FUISIC</p>
                <br/>
                <p id="footer_text">Контакты: avmineev@edu.hse.ru</p>
            </div>
        </div>
        



        <script>
            function showExplanation() {
                document.getElementById("explanation").style.display = "block";
            }

            function hideExplanation() {
                document.getElementById("explanation").style.display = "none";
            }
            function showExplanation() {
                var explanation = document.getElementById('explanation');
                if (explanation.style.display === 'none') {
                    explanation.style.display = 'block';
                    explanation.scrollIntoView();
                } else {
                    explanation.style.display = 'none';
                }
            }
        </script>
        <!-- Подключаем скрипт библиотеки MathQuill -->
        <!-- Подключаем скрипт библиотеки MathJax -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/MathJax.js?config=TeX-MML-AM_CHTML"></script>

        <!-- Инициализируем MathJax -->
        <script type="text/javascript">
            MathJax.Hub.Config({
                showMathMenu: false,
                tex2jax: {
                    inlineMath: [ ['$','$'], ['\\(','\\)'] ]
                }
            });
            MathJax.Hub.Queue(["Typeset",MathJax.Hub]);
        </script>
        <script>
            document.getElementById("button_tren").addEventListener('click', function (event){
                window.location.href = "traning.php<?php echo"?podbor=" . $_GET['podbor']?>";
            });
        </script>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <script src="scrypts/cards_scrypt.js"></script>
    </body>
    <?php
    $link->close();
    ?>
</html>

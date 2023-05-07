<html lang="en">
    <head>
        <title>Тест</title>
        <title>Карточки</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="style/cards_style.css">
        <!-- Подключаем стили и скрипты библиотеки MathQuill -->
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
                echo ("<a href='validation-form/login-form.php' class='header-text auth_txt'>войти</a>");
            }
            else echo ("<a href='validation-form/login-form.php' class='header-text auth_txt'>Профиль</a>");
            ?>
            <a href="index.php" id="logo"></a>
        </div>
    <?php
    $link = new mysqli('localhost', 'p523033_admin', 'eQ5kJ0dN5a', 'p523033_Test_3');
    $query = "SELECT Название FROM Тесты WHERE `Код_Теста` = ?";
    $stmt = $link->prepare($query);
    $stmt->bind_param('s', $_GET['test']);
    $stmt->execute();
    $result = $stmt->get_result();
    $testName = $result->fetch_array(MYSQLI_ASSOC)['Название'];
    session_start();
    if (!isset($_SESSION['correct_answers'])) {
        $_SESSION['correct_answers'] = 0;
    }

    if (!isset($_SESSION['answered_tasks'])) {
        $_SESSION['answered_tasks'] = [];
    }

    ?>
    <h1 class="podbor_name">Тест: <?php echo $testName ?></h1>
    <div class="container_1">
        <?php
        // Подключение к базе данных
        $link = new mysqli('localhost', 'p523033_admin', 'eQ5kJ0dN5a', 'p523033_Test_3');
        $query = "SELECT * FROM `Задачи` WHERE Тест = ?";
        $stmt = $link->prepare($query);
        $stmt->bind_param('s', $_GET['test']);
        $stmt->execute();
        $result = $stmt->get_result();
        $userId = $_COOKIE['user'];
        $testId = $_GET['test'];
        $time = date("Y-m-d H:i:s");

        if (isset($_POST['finish'])) {
// Количество правильных ответов
            $correctAnswers = $_SESSION['correct_answers'];

// Код для записи данных в таблицу "История"
            $query = "INSERT INTO `История тестов` (Пользователь, Дата_прохождения_задания, Тест, Результат) VALUES (?, ?, ?, ?)";
            $stmt = $link->prepare($query);
            $stmt->bind_param('sssi', $userId, $time, $testId, $correctAnswers);
            $stmt->execute();
            session_unset();
            session_destroy();
            if (!$stmt) {
                echo "Error: " . mysqli_error($link);
            }

// Перенаправление на страницу Tests.php
            header("Location: Tests.php");
            exit();

        } else {
            // Код для вывода карточек
            if (isset($_GET['test']) && $_GET['test'] != 0) {

                if ($link->connect_error) {
                    die("Connection failed: " . $link->connect_error);
                }

                // Подготовка запроса


                // Создание массива всех карточек
                $taskArr = [];
                while ($row = $result->fetch_assoc()) {
                    $task = [
                        'task' => $row['Задача'],
                        'answer' => $row['Ответ'],
                        'explanation'=> $row['Решение']
                    ];
                    array_push($taskArr, $task);
                }

                // Проверка на наличие карточек
                if (count($taskArr) > 0) {
                    // Определение текущей карточки
                    $currentTask = 0;
                    if (isset($_GET['task']) && $_GET['task'] >= 0 && $_GET['task'] < count($taskArr)) {
                        $currentTask = $_GET['task'];
                    }

                    // Вывод текущей карточки
                    $task = $taskArr[$currentTask];
                    echo "<div class='task'>";
                    echo "<h3><div class='mathjax-latex' id='main_text'>" . $task['task'] . "</div></h3>";
                    echo "</div>";
                    unset($_SESSION['answered_tasks'][$currentTask]);

                    // Кнопки переключения карточек
                    echo "<div class='buttons'>";

                    if ($currentTask > 0) {
                        $prevCard = $currentTask - 1;
                        echo "<a href='?test=" . $_GET['test'] . "&task=" . $prevCard . "' class='button prev-button'><svg width='82' height='64' viewBox='0 0 82 64' fill='none' xmlns='http://www.w3.org/2000/svg'><path d='M51.25 16L30.75 32L51.25 48' stroke='#0C507C' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'/></svg></a>";
                    }
                    if ($currentTask < count($taskArr) - 1) {
                        $nextCard = $currentTask + 1;
                        echo "<a href='?test=" . $_GET['test'] . "&task=" . $nextCard . "' class='button next-button'><svg width='82' height='64' viewBox='0 0 82 64' fill='none' xmlns='http://www.w3.org/2000/svg'><path d='M30.75 48L51.25 32L30.75 16' stroke='#0C507C' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'/></svg></a>";

                    }
                    echo "</div>";

                    if (isset($_POST['check-answer'])) {
                        $userAnswer = $_POST['user-answer'];
                        $currentTask = isset($_POST['task']) ? (int)$_POST['task'] : null;

                        if (in_array($currentTask, $_SESSION['answered_tasks'])) {
// Если на это задание уже ответили, выводим сообщение
                            echo "<div class='alert alert-warning'>Вы уже ответили на это задание. Повторная проверка невозможна.</div>";
                        } elseif (empty($userAnswer)) {
// Если ответ пустой, выводим сообщение об ошибке
                            echo "<div class='alert alert-danger'>Введите ответ.</div>";
                        } else {
// Если это новый ответ и ответ не пустой, проверяем его на правильность
                            if ($userAnswer == $taskArr[$currentTask]['answer']) {
                                array_push($_SESSION['answered_tasks'], $currentTask);
                                $_SESSION['correct_answers']++;
                                echo "<div class='alert alert-success'>Правильно!</div>";
                            } else {
                                echo "<div class='alert alert-danger'>Неправильно! Попробуйте еще раз.</div>";
                            }
                        }
                    }

                } else {
                    session_unset();
                    session_destroy();
                    header('Location: /Tests.php');
                    exit();
                }

            } else {
                session_unset();
                session_destroy();
                header('Location: /');
                exit();
            }
        }
        ?>
        <form method="POST" action="/show_tasks.php<?php echo"?test=" . $_GET['test'] . "&task=" . $currentTask ?>">
            <input type="hidden" name="task" value="<?php echo $currentTask ?>">
            <!-- Счетчик карточек и кнопка "Finish" -->
            <div class="buttons" id="counter">
                <div>
                    <?php
                    // Вывод счетчика всех карточек и текущей
                    echo "<p>Задача " . ($currentTask + 1) . " из " . count($taskArr) . "</p>";
                    ?>
                </div>
            </div>
            <div class="answer">
                <label for="user-answer">Ответ:</label>
                <input type="text" id="user-answer" name="user-answer">
            </div>
            <button type="submit" name="check-answer" class="button buttons check-button">Проверить</button>
            <button type="submit" name="finish" class="button buttons finish-button">Закончить</button>
            <button id="button_exp" class="button buttons exp-button" type="button" onclick="showExplanationscroll()"></button>
        </form>
    </div>
    <div id="explanation" style="display:none;">
        <?php echo "<h2>Решение</h2>" . $task['explanation']?>
        <button onclick="hideExplanation()">Понятно</button>
    </div>
    <script>
        function showExplanation() {
            document.getElementById("explanation").style.display = "block";
        }

        function hideExplanation() {
            document.getElementById("explanation").style.display = "none";
        }
        function showExplanationscroll() {
            var explanation = document.getElementById('explanation');
            if (explanation.style.display === 'none') {
                explanation.style.display = 'block';
                explanation.scrollIntoView();
            } else {
                explanation.style.display = 'none';
            }
        }
    </script>
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
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    </body>
    <?php
    $link->close();
    ?>
</html>
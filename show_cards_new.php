<?php
// Подключение к базе данных
$link = new mysqli('localhost', 'p523033_admin', 'eQ5kJ0dN5a', 'p523033_Test_3');

//Проверяем, авторизован ли пользователь
if (isset($_COOKIE['user'])) {
    $userId = $_COOKIE['user'];
}

// Берем название подборки из БД
$query = "SELECT Название FROM Подборки WHERE `код подборки` = ?";
$stmt = $link->prepare($query);
$stmt->bind_param('s', $_GET['podbor']);
$stmt->execute();
$result = $stmt->get_result();
$podborName = $result->fetch_array(MYSQLI_ASSOC)['Название'];

// Берем карточки из бд
$query = "SELECT * FROM `Карточка` WHERE Подборка = ?";
$stmt = $link->prepare($query);
$stmt->bind_param('s', $_GET['podbor']);
$stmt->execute();
$result = $stmt->get_result();

$podborId = $_GET['podbor'];
$time = date("Y-m-d H:i:s");

//Записываем пользователя в историю, если он нажал на кнопку ""
if (isset($_POST['finish'])) {
    if (isset($_COOKIE['user'])) {
        // Код для записи данных в таблицу "История"
        $query = "INSERT INTO История (Пользователь, `Дата прохождения задания`, Подборка) VALUES (?, ?, ?)";
        $stmt = $link->prepare($query);
        $stmt->bind_param('sss', $userId, $time, $podborId);
        $stmt->execute();
        if (!$stmt) {
            echo "Error: " . mysqli_error($link);
        }
    }
    // Перенаправление на страницу example.php с передачей данных в POST-запросе
    header("Location: collections_new.php");
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
            header('Location: /collections_new.php');
            exit();
        }

    } else {
        header('Location: /collections_new.php');
        exit();
    }
}

echo "<p>Карточка " . ($currentCard + 1) . " из " . count($cardsArr) . "</p>";


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <!-- Иконки -->
    <link rel="apple-touch-icon" sizes="180x180" href="style/favicons/apple-touch-icon.png"/>
    <link rel="icon" type="image/png" sizes="32x32" href="style/favicons/favicon-32x32.png"/>
    <link rel="icon" type="image/png" sizes="16x16" href="style/favicons/favicon-16x16.png"/>
    <link rel="manifest" href="style/favicons/site.webmanifest"/>
    <link rel="mask-icon" href="style/favicons/safari-pinned-tab.svg" color="#5bbads5"/>

    <link rel="stylesheet" href="style/cards_style_new.css" />
    <link rel="stylesheet" href="style/background_style.css" />

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
<div class="background">

    <?php include 'header.php';?>

    <div class="container">
        <p class="mt-5 collection_title">Давление в жидкостях</p>
        <div class="liner"></div>

        <div class="filter_conteiner mt-lg-5 mb-5">
            <div style="display: flex; height: 100%; justify-content: space-evenly;">
                <div class="filter nonselected"><p style="margin-top: 5%">Математика</p></div>
                <div class="filter selected sel_purple"><p style="margin-top: 5%">7Класс</p></div>
                <div class="filter selected sel_blue"><p style="margin-top: 5%">Давление</p></div>
                <div class="filter selected sel_green"><p style="margin-top: 5%">Тип</p></div>
            </div>
        </div>

        <div class="container d-flex flex-wrap align-items-center justify-content-center mt-lg-5 ">
            <div id="slider" class="carousel slide" data-ride="carousel">
                <div class="card carousel-item active">abababababababababababababababababababaabababababababa</div>
                <a href="#slider" class="carousel-control-prev" role="button" data-slide="prev" style="color: black">
                    PREV
                </a>
                <a href="#slider" class="carousel-control-next" role="button" data-slide="next" style="color: black">
                    NEXT
                </a>
            </div>
        </div>

        <div id="explanation" style="display:none;">
            <?php echo "<h2>Пояснение</h2>" . $card['explanation']?>
            <button onclick="hideExplanation()">Понятно</button>
        </div>

    </div>

    <?php include 'footer.php';?>
</div>


<script src="/libs/jquery-3.6.1.min.js"></script>
<!--Скрипт показа пояснения-->
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
<script src="scrypts/cards_scrypt.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<!--<script src="scrypts/index_scrypt.js"></script>-->
</body>
</html>
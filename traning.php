<?php
// Подключение к базе данных
$link = new mysqli('localhost', 'p534029_admin', 'pI1aT7nO3h', 'p534029_Test_3');
$query = "SELECT Название FROM Подборки WHERE `код подборки` = ?";
$stmt = $link->prepare($query);
$stmt->bind_param('s', $_GET['id']);
$stmt->execute();
$result = $stmt->get_result();
$podborName = $result->fetch_array(MYSQLI_ASSOC)['Название'];
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <title>Карточки</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style/keyboardcommon2.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <!-- Подключаем стили и скрипты библиотеки MathQuill -->
    <link rel="stylesheet" href="/libs/mathquill-0.10.1/mathquill.css" />
</head>
<body class="bg-light d-flex flex-column h-100">

    <?php include 'inc/header.php' ?>

    <h1 class="podbor_name">Подборка: <?php echo $podborName ?></h1>

    <!--         Карточка-->
    <div class="container_1">
        <?php
        // Подключение к базе данных
        $query = "SELECT * FROM `Карточка` WHERE Подборка = ?";
        $stmt = $link->prepare($query);
        $stmt->bind_param('s', $_GET['id']);
        $stmt->execute();
        $result = $stmt->get_result();
        $userId = $_COOKIE['user'];
        $podborId = $_GET['id'];
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
            header("Location: collections/");
            exit();

        } else {
            // Код для вывода карточек
            if (isset($_GET['id']) && $_GET['id'] != 0) {

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
                    echo "<h2>ваш ответ:</h2>";
                    echo "<span id='input_place' data-placeholder='Введите формулу...'></span>";

                    // Кнопки переключения карточек
                    echo "<div class='buttons'>";


                    if ($currentCard > 0) {
                        $prevCard = $currentCard - 1;
                        echo "<a href='?id=" . $_GET['id'] . "&card=" . $prevCard . "' class='button prev-button'><svg width='82' height='64' viewBox='0 0 82 64' fill='none' xmlns='http://www.w3.org/2000/svg'><path d='M51.25 16L30.75 32L51.25 48' stroke='#0C507C' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'/></svg></a>";
                    }
                    if ($currentCard < count($cardsArr) - 1) {
                        $nextCard = $currentCard + 1;
                        echo "<a href='?id=" . $_GET['id'] . "&card=" . $nextCard . "' class='button next-button'><svg width='82' height='64' viewBox='0 0 82 64' fill='none' xmlns='http://www.w3.org/2000/svg'><path d='M30.75 48L51.25 32L30.75 16' stroke='#0C507C' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'/></svg></a>";

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
                    header('Location: /collections/');
                    exit();
                }

            } else {
                header('Location: /collections/');
                exit();
            }
            echo "<button id='button_check' class='button buttons check-button' type='button' onclick='checkAnswer()'>Проверить</button>";
        }
        ?>
        <form method="POST" action="/traning.php<?php echo"?id=" . $_GET['id']?>">

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
            <button id="button_tren" class="button buttons training-button" type="button">Вернуться</button>
            <button id="button_exp" class="button buttons exp-button" type="button" onclick="showExplanation()"></button>
        </form>
    </div>
    <!--        Пояснение-->
    <div id="explanation" style="display:none;">
        <?php echo "<h2>Пояснение</h2>" . $card['explanation']?>
        <button onclick="hideExplanation()">Понятно</button>
    </div>

    <!-- Клавиатура-->
    <div id = "keyboard">
        <div id="keyboard_1">
            <!--            <span id="input_place"></span>-->
            <div id="conteiner_1">
                <div class="lines_k2">
                    <div class="line_1">
                        <button type="button" class="keyboard_button_2" id="color_xyzi" onClick='input("x")'>
                            x
                        </button>
                        <button type="button" class="keyboard_button_2" id="digital_color" onClick='input("1")'>
                            1
                        </button>
                        <button type="button" class="keyboard_button_2" id="digital_color" onClick='input("2")'>
                            2
                        </button>
                        <button type="button" class="keyboard_button_2" id="digital_color" onClick='input("3")'>
                            3
                        </button>
                        <button type="button" class="keyboard_button_2" id="symbol" onClick='input("+")'>
                            +
                        </button>
                        <button type="button" class="keyboard_button_2" id="symbol" onClick='input("-")'>
                            -
                        </button>
                        <button type="button" class="keyboard_button_2" id="trigan" onclick='input("\\sin")'>sin</button>
                        <button type="button" class="keyboard_button_2" id="trigan" onclick='input("\\cos")'>cos</button>

                        <button type="button" class="keyboard_button_2"  onClick='input("\\^{}")'>
                            <img src="/style/img/x^smth.png" width="18" height="21">
                        </button>
                        <button type="button" id="x_index" class="keyboard_button_2" onClick='input("\\_{}")'>
                            <img src="/style/img/x_index.png" class="math_func" width="17" height="21">
                        </button>
                        <button type="button" class="keyboard_button_2" onClick='input("e")'>
                            e
                        </button>
                    </div>
                    <div class="line_2">
                        <button type="button" class="keyboard_button_2" id="color_xyzi" onClick='input("y")'>
                            y
                        </button>
                        <button type="button" class="keyboard_button_2" id="digital_color" onClick='input("4")'>
                            4
                        </button>
                        <button type="button" class="keyboard_button_2" id="digital_color" onClick='input("5")'>
                            5
                        </button>
                        <button type="button" class="keyboard_button_2" id="digital_color" onClick='input("6")'>
                            6
                        </button>
                        <button type="button" class="keyboard_button_2" id="symbol" onClick='input("=")'>
                            =
                        </button>
                        <button type="button" class="keyboard_button_2" id="symbol" onClick='input("&pm;")'>
                            &plusmn;
                        </button>
                        <button type="button" class="keyboard_button_2" id="trigan" onclick='input("\\tan")'>tg</button>
                        <button type="button" class="keyboard_button_2" id="trigan" onclick='input("\\cot")'>ctg</button>
                        <button type="button" class="keyboard_button_2" onClick='input("\\sqrt{}")'>√</button>
                        <button type="button" class="keyboard_button_2" onClick='input("\\sqrt[]{}")'>
                            <img src="/style/img/sqrt_exp.png" width="22" height="18">
                        </button>
                        <button type="button" class="keyboard_button_2 novision" onClick='input("\\ln")'>ln</button>
                    </div>
                    <div class="line_3">
                        <button type="button" class="keyboard_button_2" id="color_xyzi" onClick='input("z")'>
                            z
                        </button>
                        <button type="button" class="keyboard_button_2" id="digital_color" onClick='input("7")'>
                            7
                        </button>
                        <button type="button" class="keyboard_button_2" id="digital_color" onClick='input("8")'>
                            8
                        </button>
                        <button type="button" class="keyboard_button_2" id="digital_color" onClick='input("9")'>
                            9
                        </button>
                        <button type="button" class="keyboard_button_2" id="symbol" onClick='input("≠")'>
                            ≠
                        </button>
                        <button type="button" class="keyboard_button_2" id="symbol" onClick='input("×")'>
                            ×
                        </button>
                        <button type="button" class="keyboard_button_2" onClick='input("<")'>
                            &lt;
                        </button>
                        <button type="button" class="keyboard_button_2" onClick='input(">")'>
                            &gt;
                        </button>
                        <button type="button" class="keyboard_button_2" onClick='input("\\frac{}{}")'>
                            <img src="/style/img/division.png" width="24" height="17">
                        </button>
                        <button type="button" class="keyboard_button_2" onClick='input("|")'>
                            |
                        </button>
                        <button type="button" class="keyboard_button_2 novision" id="dark" onclick='input("\\log")'>
                            log
                        </button>
                    </div>
                    <div class="line_4">
                        <button type="button" class="keyboard_button_2" id="color_xyzi" onClick='input("i")'>
                            i
                        </button>
                        <button type="button" class="keyboard_button_2" onClick='input("\\%")'>
                            %
                        </button>
                        <button type="button" class="keyboard_button_2" id="digital_color" onClick='input("\\ 0")'>
                            0
                        </button>
                        <button type="button" class="keyboard_button_2" onClick='input("\\infty")'>
                            &#8734;
                        </button>
                        <button type="button" class="keyboard_button_2" onClick='input("\\ (")'>
                            (
                        </button>
                        <button type="button" class="keyboard_button_2" onClick='input("\\ )")'>
                            )
                        </button>
                        <button type="button" class="keyboard_button_2" onClick='input("\\leq")'>
                            &#8804;
                        </button>
                        <button type="button" class="keyboard_button_2" onClick='input("\\geq")'>
                            &#8805;
                        </button>
                        <button type="button" class="keyboard_button_2" onClick="input(String.fromCharCode(39))">
                            &#180;
                        </button>
                        <button
                                type="button"
                                class="keyboard_button_2"
                                id="more_dark"
                                onclick='input("\\vec{}")'
                        >
                            <img src="/style/img/arw_und_x.png" width="13" height="18">
                        </button>
                        <button
                                type="button"
                                class="keyboard_button_2"
                                id="dark"
                                onclick='input("\\log_{} {}")'
                        >
                            <img src="/style/img/log.png" width="27" height="18">
                        </button>
                    </div>
                    <div class="line_5">
                        <button type="button" id="btn2" class="keyboard_button_2">
                            &#8635; abc
                        </button>
                        <button type="button" class="keyboard_button_2" onClick='input(".")'>
                            .
                        </button>
                        <button type="button" class="keyboard_button_2" onClick='input("\\pi")'>
                            π
                        </button>
                        <button type="button" class="keyboard_button_2" onClick='input("\\lim_{}{}")'>
                            <img src="/style/img/lim.png" width="25" height="19">
                        </button>
                        <button
                                type="button"
                                class="keyboard_button_2"
                                onClick='input("\\int_{}^{}")'
                        >
                            <img src="/style/img/integral.png" width="11" height="18">
                        </button>
                        <button type="button" class="keyboard_button_2" onClick='input("\\sum")'>
                            <img src="/style/img/sum.png" width="19" height="20">
                        </button>
                        <button type="button" class="keyboard_button_2" onClick='input("\\Sigma")'>
                            Ʃ
                        </button>
                        <button type="button" class="keyboard_button_2" onClick='input("\\min")'>
                            min
                        </button>
                        <button type="button" class="keyboard_button_2" onClick='input("\\max")'>
                            max
                        </button>
                        <button type="button" class="keyboard_button_2" onClick='input("\\rightarrow")'>
                            →
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div id="keyboard_2">
            <!--                    <span id="input_place"></span>-->
            <div id="conteiner_1">
                <div class="lines_k1">
                    <div class="line_1">
                        <button type="button" class="keyboard_button" onClick='input("\\alpha")'>
                            &#945;
                        </button>
                        <button type="button" class="keyboard_button" onClick='input("\\beta")'>
                            &#946;
                        </button>
                        <button type="button" class="keyboard_button" onClick='input("\\gamma")'>
                            &#947;
                        </button>
                        <button type="button" class="keyboard_button" onClick='input("\\delta")'>
                            &#948;
                        </button>
                        <button type="button" class="keyboard_button" onClick='input("\\epsilon")'>
                            &#949;
                        </button>
                        <button type="button" class="keyboard_button" onClick='input("\\theta")'>
                            &#952;
                        </button>
                        <button type="button" class="keyboard_button" onClick='input("\\lambda")'>
                            &#955;
                        </button>
                        <button type="button" class="keyboard_button" onClick='input("\\mu")'>
                            &#956;
                        </button>
                        <button type="button" class="keyboard_button" onClick='input("\\nu")'>
                            &#957;
                        </button>
                        <button type="button" class="keyboard_button" onClick='input("\\xi")'>
                            &#958;
                        </button>
                        <button type="button" class="keyboard_button" onClick='input("\\rho")'>
                            &#961;
                        </button>
                    </div>
                    <div class="line_2">
                        <button type="button" class="keyboard_button" onClick='input("\\sigma")'>
                            &#963;
                        </button>
                        <button type="button" class="keyboard_button" onClick='input("\\tau")'>
                            &#964;
                        </button>
                        <button type="button" class="keyboard_button" onClick='input("\\chi")'>
                            &#967;
                        </button>
                        <button type="button" class="keyboard_button" onClick='input("\\psi")'>
                            &#968;
                        </button>
                        <button type="button" class="keyboard_button" onClick='input("\\omega")'>
                            &#969;
                        </button>
                        <button type="button" class="keyboard_button" onClick='input("\\Alpha")'>
                            &#913;
                        </button>
                        <button type="button" class="keyboard_button" onClick='input("\\Delta")'>
                            &#916;
                        </button>
                        <button type="button" class="keyboard_button" onClick='input("\\Epsilon")'>
                            &#917;
                        </button>
                        <button type="button" class="keyboard_button" onClick='input("\\Zeta")'>
                            &#918;
                        </button>
                        <button type="button" class="keyboard_button" onClick='input("\\Eta")'>
                            &#919;
                        </button>
                        <button type="button" class="keyboard_button" onClick='input("\\Theta")'>
                            &#921;
                        </button>
                    </div>
                    <div class="line_3">
                        <button type="button" class="keyboard_button" onClick='input("\\Delta")'>
                            &#916;
                        </button>
                        <button type="button" class="keyboard_button" onClick='input("\\Theta")'>
                            &#920;
                        </button>
                        <button type="button" class="keyboard_button" onClick='input("\\Xi")'>
                            &#924;
                        </button>
                        <button type="button" class="keyboard_button" onClick='input("\\Pi")'>
                            &#928;
                        </button>
                        <button type="button" class="keyboard_button" onClick='input("\\Sigma")'>
                            &#931;
                        </button>
                        <button type="button" class="keyboard_button" onClick='input("\\Upsilon")'>
                            &#933;
                        </button>
                        <button type="button" class="keyboard_button" onClick='input("\\Omega")'>
                            &#937;
                        </button>
                        <button type="button" class="keyboard_button" onClick='input("a")'>
                            a
                        </button>
                        <button type="button" class="keyboard_button" onClick='input("b")'>
                            b
                        </button>
                        <button type="button" class="keyboard_button" onClick='input("f")'>
                            f
                        </button>
                        <button type="button" class="keyboard_button" onClick='input("g")'>
                            g
                        </button>
                        <button type="button" class="keyboard_button" onClick='input("h")'>
                            h
                        </button>
                    </div>
                    <div class="line_4">
                        <button type="button" class="keyboard_button" onClick='input("k")'>
                            k
                        </button>
                        <button type="button" class="keyboard_button" onClick='input("l")'>
                            l
                        </button>
                        <button type="button" class="keyboard_button" onClick='input("m")'>
                            m
                        </button>
                        <button type="button" class="keyboard_button" onClick='input("n")'>
                            n
                        </button>
                        <button type="button" class="keyboard_button" onClick='input("p")'>
                            p
                        </button>
                        <button type="button" class="keyboard_button" onClick='input("q")'>
                            q
                        </button>
                        <button type="button" class="keyboard_button" onClick='input("r")'>
                            r
                        </button>
                        <button type="button" class="keyboard_button" onClick='input("s")'>
                            s
                        </button>
                        <button type="button" class="keyboard_button" onClick='input("t")'>
                            t
                        </button>
                        <button type="button" class="keyboard_button" onClick='input("u")'>
                            u
                        </button>
                        <button type="button" class="keyboard_button" onClick='input("v")'>
                            v
                        </button>
                        <button type="button" class="keyboard_button" onClick='input("x")'>
                            x
                        </button>
                    </div>
                    <div class="line_5">
                        <button type="button" id="btn" class="keyboard_button">
                            &#8635; 123
                        </button>
                        <button type="button" class="keyboard_button" onClick='input("y")'>
                            y
                        </button>
                        <button type="button" class="keyboard_button" onClick='input("z")'>
                            z
                        </button>
                        <button type="button" class="keyboard_button" onClick='input("B")'>
                            B
                        </button>
                        <button type="button" class="keyboard_button" onClick='input("C")'>
                            С
                        </button>
                        <button type="button" class="keyboard_button" onClick='input("D")'>
                            D
                        </button>
                        <button type="button" class="keyboard_button" onClick='input("F")'>
                            F
                        </button>
                        <button type="button" class="keyboard_button" onClick='input("Q")'>
                            Q
                        </button>
                        <button type="button" class="keyboard_button" onClick='input("R")'>
                            R
                        </button>
                        <button type="button" class="keyboard_button" onClick='input("S")'>
                            S
                        </button>
                        <button type="button" class="keyboard_button" onClick='input("U")'>
                            U
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'inc/footer.php' ?>

<!-- Подключаем скрипт библиотеки MathQuill -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/mathquill/0.10.1/mathquill.min.js"></script>
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

    document.querySelector("#btn").addEventListener('click', function(){
        document.querySelector(".lines_k1").style.visibility = "hidden";
        document.querySelector(".lines_k2").style.visibility = "visible";


        // document.querySelector("#input_place").style.visibility = "visible";


    });

    document.querySelector("#btn2").addEventListener('click', function(){
        document.querySelector(".lines_k1").style.visibility = "visible";
        document.querySelector(".lines_k2").style.visibility = "hidden";


        // document.querySelector("#input_place").style.visibility = "visible";

    });
    var MQ = MathQuill.getInterface(2);
    var mathFieldSpan = document.getElementById('input_place');
    var mathField = MQ.MathField(mathFieldSpan, {
        spaceBehavesLikeTab: true,
        handlers: {
            edit: function() {
                if (mathField.latex().length > 0) {
                    mathFieldSpan.removeAttribute('data-placeholder');
                } else { // иначе показать плейсхолдер
                    mathFieldSpan.setAttribute('data-placeholder', 'Введите формулу ...');
                }
            }
        }
    });



    function input(str) {
        mathField.write(str);
        mathField.focus();
    }

    var correctAnswer = <?php echo json_encode($card['formula']); ?>;

    function checkAnswer() {
        var userAnswer = '`' + mathField.latex().replace(/\\(left|right)/g, '') + '`';
        if (userAnswer == correctAnswer) {
            swal('Ответ верный!');
        } else {
            swal(`Ответ неверный!\nВаш ответ: ${userAnswer}\nВерный ответ: ${correctAnswer}`);
        }
    }
    document.getElementById("button_tren").addEventListener('click', function (event){
        window.location.href = "show_cards.php<?php echo"?id=" . $_GET['id']?>";
    });




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
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="cards_scrypt.js"></script>



</body>
<?php
$link->close();
?>
</html>
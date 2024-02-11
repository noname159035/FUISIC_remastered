<?php

$id = $_GET['id'];
$cards_id = $_GET['cards_id'];

require_once ('../db.php');

global $link;

// Получение заданий из базы данных
$query = "SELECT Формула, Описание, Пояснение FROM Карточка WHERE `Код задания` =?";
$stmt = $link->prepare($query);
$stmt->bind_param('s', $id);
$stmt->execute();
$result = $stmt->get_result();
$row = mysqli_fetch_assoc($result);
$row['Формула'] =  mysqli_real_escape_string($link, $row['Формула']);


if (isset($_POST['submit'])) {
    $formula = mysqli_real_escape_string($link, $_POST['formula']);
    $description = mysqli_real_escape_string($link, $_POST['description']);
    $explanation = mysqli_real_escape_string($link, $_POST['explanation']);

// Обновление данных пользователя в БД
    $link->query("UPDATE `Карточка` SET `Формула` = '$formula', `Описание` = '$description', `Пояснение` = '$explanation' WHERE `Код задания` = '$id'");

// Перенаправление на страницу профиля пользователя
    header('Location: /my_base/edit/cards/'.$cards_id);
    exit();
}?>
<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Редактор карточки</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="/style/keyboardcommon2.css">
    <link rel="stylesheet" href="/libs/mathquill-0.10.1/mathquill.css" />
</head>
<body class="bg-light d-flex flex-column h-100">

<?php include '../inc/header.php' ?>

<div class="container">
    <h1>Редактирование карточки</h1>
    <form method="post">
        <div class="form-group">
            <label for="formula">Пояснение</label>
            <input type="hidden" id="hidden_formula" name="formula">
            <span class="form-control" id="formula"></span>
        </div>
        <div class="form-group">
            <label for="description">Описание</label>
            <input type="text" class="form-control" id="description" name="description" value="<?php echo $row['Описание']?>">
        </div>
        <div class="form-group">
            <label for="explanation">Пояснение</label>
            <textarea type="text" class="form-control" id="explanation" name="explanation"><?php echo $row['Пояснение']?></textarea>
        </div>
        <?php
        if ($row['Формула'] == '' && $row['Описание'] == '' && $row['Пояснение'] == ''){
            ?>
            <a href="/my_base/delete_card/<?php echo $cards_id.'/'.$id?>" class="btn btn-secondary">Отменить</a>
            <?php
        }
        else{
            ?>
            <a href="/my_base/edit/cards/<?php echo $cards_id ?>" class="btn btn-secondary">Отменить</a>
            <?php
        }
        ?>

        <button type="submit" class="btn btn-primary" name="submit">Сохранить</button>
    </form>
    <div id = "keyboard">
<!--        <span id="input_place" style="background-color: #F0F6FF;" class="w-100 p-3 mb-2"></span>-->
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
                    <div class="line_1">
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
                    <div class="line_1">
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
                    <div class="line_1">
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
                    <div class="line_1">
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
                    <div class="line_2">
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
                    <div class="line_2">
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
                    <div class="line_2">
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
                    <div class="line_2">
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
</div>

<?php include '../inc/footer.php' ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/mathjs/9.4.4/math.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/mathquill/0.10.1/mathquill.min.js"></script>
<script>

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


    const MQ = MathQuill.getInterface(2);
    const mathFieldSpan = document.getElementById('formula');
    const mathField = MQ.MathField(mathFieldSpan, {
        spaceBehavesLikeTab: true,
        handlers: {
            edit: function () {
                if (mathField.latex().length > 0) {
                    mathFieldSpan.removeAttribute('data-placeholder');
                } else { // иначе показать плейсхолдер
                    mathFieldSpan.setAttribute('data-placeholder', 'Введите формулу ...');
                }
            }
        }
    });

    const formulaValue = "<?php echo $row['Формула']; ?>";
    const cleanedFormulaValue = formulaValue.replace(/\$/g, '')
    console.log(cleanedFormulaValue);
    mathField.latex(cleanedFormulaValue);


    function input(str) {
        mathField.write(str);
        mathField.focus();
    }

    const hiddenFormulaInput = document.getElementById('hidden_formula');
    document.querySelector('form').addEventListener('submit', function() {
        hiddenFormulaInput.value = '$' + mathField.latex() + '$';
    });



</script>
</body>
</html>
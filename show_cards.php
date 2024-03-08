<?php
// Подключение к базе данных
require_once ('db.php');

global $link;

if ($link->connect_error) {
    die("Connection failed: " . $link->connect_error);
}

$query = "SELECT Название FROM Подборки WHERE `код подборки` = ?";
$stmt = $link->prepare($query);
$stmt->bind_param('s', $_GET['id']);
$stmt->execute();
$result = $stmt->get_result();
$idName = $result->fetch_array(MYSQLI_ASSOC)['Название'];

if (isset($_COOKIE['user'])) {
    $userId = $_COOKIE['user'];
}

$Id = $_GET['id'];
$time = date("Y-m-d H:i:s");

if (isset($_POST['finish'])) {
    if (isset($_COOKIE['user'])) {
        // Код для записи данных в таблицу "История"
        $query = "INSERT INTO История (Пользователь, `Дата прохождения задания`, Подборка) VALUES (?, ?, ?)";
        $stmt = $link->prepare($query);
        $stmt->bind_param('sss', $userId, $time, $Id);
        $stmt->execute();
    }
    // Перенаправление на страницу example.php с передачей данных в POST-запросе
    header("Location: /collections/");
    exit();
}

// Подключение к базе данных
$query = "SELECT * FROM `Карточка` WHERE Подборка = ?";
$stmt = $link->prepare($query);
$stmt->bind_param('s', $Id);
$stmt->execute();
$result = $stmt->get_result();

// Код для вывода карточек
if (isset($Id) && $Id != 0) {

// Создание массива всех карточек
    $cardsArr = [];
    while ($row = $result->fetch_assoc()) {
        $card = [
            'formula' => $row['Формула'],
            'description' => $row['Описание'],
            'explanation'=> $row['Пояснение']
        ];
        $cardsArr[] = $card;
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
    } else {
        header('Location: /collections/');
        exit();
    }

} else {
    header('Location: /collections/');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <title>Карточки</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Подключаем стили и скрипты библиотеки MathQuill -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mathquill/0.10.1/mathquill.css"
          integrity="sha512-1i2kdU6oq3PAzrP6r/QkjDiuclLRhjFeT7L+d1X8C43ndhAR51ZgA+PSVwvH8Wmc7VhjzMG/n1Q5j5Fx9Pa5GA=="
          crossorigin="anonymous"
    />

    <style>
        body{
            overflow: hidden;
        }

        #card_cont {
            min-height: 300px;
            transition: transform 0.5s;
        }

        .front {
            transform: rotateY(0deg);
        }

        .back {
            transform: rotateY(180deg);
        }

        .flipped {
            transform: rotateY(180deg);
        }

    </style>
</head>

<body class="bg-light d-flex flex-column h-100">

<?php include("inc/header.php"); ?>

<div class="test_div">ТЕСТОВАЯ СТРОКА</div>
<div class="container">
    <h2 class="text-center mb-xl-5" id="cardsName"></h2>

    <div id="cards"></div>
</div>

<!-- Подключение модального окна -->
<div class="modal fade" id="explanationModal" tabindex="-1" role="dialog" aria-labelledby="explanationModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="explanationModalLabel">Пояснение</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h2>Пояснение</h2>
                <div id="explanationText"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>

<?php include("inc/footer.php"); ?>

<!-- Подключение скриптов -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/MathJax.js?config=TeX-MML-AM_CHTML"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/2.0.2/anime.js"></script>
<script>
    let url = window.location.href;
    let id = url.split('/').pop();

    $.ajax({
        url: '/collections/get_cards/' + id,
        type: 'post',
        dataType: 'json',
        success: function(data) {
            // Обработка полученных данных
            let currentCardIndex = 0;
            let cards = data;
            let cardsName = cards[0].id;
            let cardCount = cards.length;
            let cardsNameContainer = $('#cardsName');
            let cardContainer = $('#cards');
            let explanationContainer = $('#explanationText');
            let cardTemplate = '' +
                '<div class="row mb-3">' +
                    '<div class="btn-group">' +
                        '<a  href="/collections/traning/" class="btn btn-outline-primary traning">Тренажер</a>' +
                        '<button type="button" class="btn btn-outline-primary exp-btn" data-toggle="modal" data-target="#explanationModal">Пояснение</button>' +
                        '<a href="/add_to_favorites/" class="btn btn-outline-primary">Добавить в избранное</a>' +
                        '<a href="/collections/" class="btn btn-outline-primary">Закончить</a>' +
                    '</div>' +
                '</div>' +
                '<div class="row card_block">' +
                    '<div class="col-2">' +
                        '<a class="btn btn-outline-light text-dark w-100 h-100 prev-card"><h1 style="margin-top: 50%; font-size: 500%">←</h1></a>' +
                    '</div>' +
                    '<div class="col main_card_block">' +
                        '<div class="card border-primary align-items-center justify-content-center" id="card_cont">' +
                            '<div class="front">' +
                                '<h2>{formula}</h2>' +
                            '</div>' +
                            '<div class="back visually-hidden">' +
                                '<h3>{description}</h3>' +
                            '</div>' +
                        '</div>' +
                    '</div>' +
                    '<div class="col-2">' +
                        '<a class="btn btn-outline-light text-dark w-100 h-100 next-card" id="btn-card"><h1 style="margin-top: 45%; font-size: 500%">→</h1></a>' +
                    '</div>' +
                '</div>'
            ;

            let explanationTemplate = '<p>{explanationText}</p>';

            let cardsNameTemplate = '<p>'+cardsName+'</p>';

            cardsNameContainer.html(cardsNameTemplate);

            function showCard(index) {
                let card = cards[index];
                let formula = card.formula;
                let description = card.description;

                let nav = '<ul class="pagination justify-content-center mt-3">';
                for (let i = 0; i < cardCount; i++) {
                    nav += '<li class="page-item' + (i === currentCardIndex? ' active' : '') + '"><a class="page-link" href="#" data-index="' + i + '">' + (i+1) + '</a></li>';
                }
                nav += '</ul>';

                let html = cardTemplate.replace('{formula}', formula).replace('{description}', description).replace('{CardIndex}', index+1).replace('{CardCount}', cards.length);
                cardContainer.html(html);
                cardContainer.append(nav);

                let card_class = document.querySelector('#card_cont');
                let front = document.querySelector('.front');
                let back = document.querySelector('.back');

                cardContainer.on('click', '.card', function() {
                    card_class.classList.toggle('flipped');
                    front.classList.toggle('visually-hidden');
                    back.classList.toggle('visually-hidden');
                });

                // Найти элемент ссылки по классу (если таких элементов несколько, будет выбран первый)
                const link = document.querySelector('.traning');

                // Проверить, существует ли элемент
                if (link) {
                    // Добавить id к атрибуту href
                    link.href += id;
                }


                // Отображение формулы в нужном виде
                MathJax.Hub.Config({
                    showMathMenu: false,
                    tex2jax: {
                        inlineMath: [ ['$','$'], ['\\(','\\)'] ]
                    }
                });
                MathJax.Hub.Queue(["Typeset",MathJax.Hub]);

            }

            function showNextCard(){
                currentCardIndex++;
                if (currentCardIndex >= cardCount) {
                    currentCardIndex = 0;
                }
                showCard(currentCardIndex);
                anime({
                    targets: ".main_card_block",
                    translateX: [
                        { value: -1700, duration: 400, delay: 0 },
                        { value: +1700, duration: 0, delay: 0 },
                        { value: 0, duration: 400, delay: 0 },
                    ],
                });
            }
            function showPrevCard(){
                currentCardIndex--;
                if (currentCardIndex < 0) {
                    currentCardIndex = cardCount - 1;
                }
                showCard(currentCardIndex);
                anime({
                    targets: ".main_card_block",
                    translateX: [
                        { value: 1700, duration: 400, delay: 0 },
                        { value: -1700, duration: 0, delay: 0 },
                        { value: 0, duration: 400, delay: 0 },
                    ],
                });
            }

            function prepareExplanation(index){

                let card = cards[index];
                let explanation = card.explanation;

                let html = explanationTemplate.replace('{explanationText}', explanation);
                explanationContainer.html(html);

            }
            function showExplanation(){
                prepareExplanation(currentCardIndex);

                // Отображение формулы в нужном виде
                MathJax.Hub.Config({
                    showMathMenu: false,
                    tex2jax: {
                        inlineMath: [ ['$','$'], ['\\(','\\)'] ]
                    }
                });
                MathJax.Hub.Queue(["Typeset",MathJax.Hub]);
            }

            showCard(currentCardIndex);

            cardContainer.on('click', '.page-link', function(event) {
                event.preventDefault();
                let index = $(this).data('index');
                currentCardIndex = index;
                showCard(index);
            });

            cardContainer.on('click', '.prev-card', showPrevCard);
            cardContainer.on('click', '.next-card', showNextCard);
            cardContainer.on('click', '.exp-btn', showExplanation);


        },
        error: function(xhr, status, error) {
            // Вывод ошибки в консоль
            console.log('Error:', error);
        }
    });
</script>
<script>

</script>
</body>
<?php
$link->close();
?>
</html>
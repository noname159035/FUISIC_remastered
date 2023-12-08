<!DOCTYPE html>
<html lang="ru" class="h-100">
<head>
    <title>Тест</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
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

<?php include ('inc/header.php')?>

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

<?php include ('inc/footer.php')?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/MathJax.js?config=TeX-MML-AM_CHTML"></script>

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
                '<div class="btn-group justify-content-center">' +
                '<a  href="/collections/training/" class="btn btn-outline-primary col-1">Тренажер</a>' +
                '<button type="button" class="btn btn-outline-primary exp-btn col-1" data-toggle="modal" data-target="#explanationModal">Пояснение</button>' +
                '<a href="/collections/" class="btn btn-outline-primary col-1">Закончить</a>' +
                '</div>' +
                '</div>' +
                '<div class="row">' +
                    '<div class="card-group justify-content-center">' +
                        '<div class="card btn col-1  border-right-0 border-primary justify-content-center prev-card">←</div>' +
                        '<div class="card col-6  border-right-0 border-primary align-items-center justify-content-center" id="card_cont">' +
                            '<div class="front">' +
                                '<h2>{formula}</h2>' +
                            '</div>' +
                            '<div class="back visually-hidden">' +
                                '<h3>{description}</h3>' +
                            '</div>' +
                        '</div>' +
                        '<div class="card btn col-1 border-primary justify-content-center  next-card">→</div>' +
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


                // Отображение формулы в нужном виде
                MathJax.Hub.Config({
                    showMathMenu: false,
                    tex2jax: {
                        inlineMath: [ ['$','$'], ['\\(','\\)'] ]
                    }
                });
                MathJax.Hub.Queue(["Typeset",MathJax.Hub]);

            }

            function showPrevCard() {
                currentCardIndex--;
                if (currentCardIndex < 0) {
                    currentCardIndex = cardCount - 1;
                }
                showCard(currentCardIndex);
            }

            function showNextCard() {
                currentCardIndex++;
                if (currentCardIndex >= cardCount) {
                    currentCardIndex = 0;
                }
                showCard(currentCardIndex);
            }
            function prepareExplanation(index){

                let card = cards[index];
                let explanation = card.explanation;

                let html = explanationTemplate.replace('{explanationText}', explanation);
                explanationContainer.html(html);

            }
            function showExplanation(){
                prepareExplanation(currentCardIndex);
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
            cardContainer.on('click', '.exp-btn', showExplanation)

        },
        error: function(xhr, status, error) {
            // Вывод ошибки в консоль
            console.log('Error:', error);
        }
    });
</script>

</body>

</html>
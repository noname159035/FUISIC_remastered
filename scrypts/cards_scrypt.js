$(document).ready(function() {
    var currentCardIndex = 0;
    var cards = $('.card');

    // При клике на кнопку "Next"
    $('.btn-next').click(function() {
        if (currentCardIndex < cards.length - 1) {
            currentCardIndex++;
            showCard(currentCardIndex);
        }
    });

    // При клике на кнопку "Previous"
    $('.btn-previous').click(function() {
        if (currentCardIndex > 0) {
            currentCardIndex--;
            showCard(currentCardIndex);
        }
    });

    // При клике на карточку
    cards.click(function() {
        $(this).children('.card-front, .card-back').toggleClass('hidden');
    });

    // Функция отображения карточки с заданным индексом
    function showCard(index) {
        cards.addClass('hidden');
        $(cards[index]).removeClass('hidden');

        // Обновление номера текущей карточки
        $('.counter').text((index + 1) + ' of ' + cards.length);

        // Обновление состояния кнопок "Next" и "Previous"
        $('.btn-next').attr('disabled', index == cards.length - 1);
        $('.btn-previous').attr('disabled', index == 0);
    }
    // Отображение первой карточки
    showCard(currentCardIndex);
});

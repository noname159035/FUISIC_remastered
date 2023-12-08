<?php
$id = $_GET['id']
?>
<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <meta charset="UTF-8"/>

    <link rel="stylesheet" href="style/cards_style_new.css" />

    <meta name="theme-color" content="#ffffff"/>
    <title>Карточки</title>

</head>
<body class="bg-light d-flex flex-column h-100">

    <?php include 'inc/header.php';?>

    <div class="container">
        <p class="mt-5 collection_title">Давление в жидкостях</p>
        <div class="liner"></div>

<!--        <div class="filter_conteiner mt-lg-5 mb-5">-->
<!--            <div style="display: flex; height: 100%; justify-content: space-evenly;">-->
<!--                <div class="filter nonselected"><p style="margin-top: 5%">Математика</p></div>-->
<!--                <div class="filter selected sel_purple"><p style="margin-top: 5%">7Класс</p></div>-->
<!--                <div class="filter selected sel_blue"><p style="margin-top: 5%">Давление</p></div>-->
<!--                <div class="filter selected sel_green"><p style="margin-top: 5%">Тип</p></div>-->
<!--            </div>-->
<!--        </div>-->

        <div class="container d-flex flex-wrap align-items-center justify-content-center mt-lg-5">
            <div id="slider" class="carousel slide" data-ride="carousel">
                    <div class="card active"></div>
                    <a id="prev_btn" class="carousel-control-prev" role="button" data-slide="prev" style="color: black">
                        PREV
                    </a>
                    <a id="next_btn" class="carousel-control-next" role="button" data-slide="next" style="color: black">
                        NEXT
                    </a>
            </div>
        </div>

    </div>

    <?php include 'inc/footer.php';?>

    <script src="/libs/jquery-3.6.1.min.js"></script>
    <script src="/libs/anime.min.js"></script>
    <script>
        document.querySelector("#prev_btn").addEventListener('click', function (){
            anime({
                targets: "#slider",
                translateX: -2050,
                duration: 300,
                easing: 'easeInOutExpo',
                complete: function(anim){
                    //       card.style.visibility = "hidden";
                    anime({
                        targets: "#slider",
                        translateX: +2050,
                        duration: 0,
                        complete: function(anim){
                            anime({
                                targets: "#slider",
                                translateX: 0,
                                easing: 'easeInOutExpo',
                                duration: 300,
                            });
                        }
                    });
                }
            });
        });
        document.querySelector("#next_btn").addEventListener('click', function (){
            anime({
                targets: "#slider",
                translateX: +2050,
                duration: 300,
                easing: 'easeInOutExpo',
                complete: function(anim){
                    playing = false;
                    //       card.style.visibility = "hidden";
                    anime({
                        targets: "#slider",
                        translateX: -2050,
                        duration: 0,
                        complete: function(anim){
                            anime({
                                targets: "#slider",
                                translateX: 0,
                                easing: 'easeInOutExpo',
                                duration: 300,
                            });
                        }
                    });
                }
            });
        });
        document.querySelector(".card").addEventListener('click', function (){

        });
    </script>
</body>
</html>
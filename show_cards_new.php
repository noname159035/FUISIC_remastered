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
<div class="background" style="overflow: hidden">

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

    <?php include 'footer.php';?>
</div>
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
<!--<script src="scrypts/index_scrypt.js"></script>-->
</body>
</html>
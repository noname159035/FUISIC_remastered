<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8"/>
        <!-- Иконки -->
        <link rel="apple-touch-icon" sizes="180x180" href="/favicons/apple-touch-icon.png"/>
        <link rel="icon" type="image/png" sizes="32x32" href="/favicons/favicon-32x32.png"/>
        <link rel="icon" type="image/png" sizes="16x16" href="/favicons/favicon-16x16.png"/>
        <link rel="manifest" href="/favicons/site.webmanifest"/>
        <link rel="mask-icon" href="/favicons/safari-pinned-tab.svg" color="#5bbads5"/>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="style/index_new_style.css" />
        <link rel="stylesheet" href="style/header_footer_style_black.css" />


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
        <div class="container_1">

            <?php include 'header.php';?>

            <div>
                <img src="style/img/bbl.svg" alt="" class="areas">

                <div class="areas_container">
                    <div class="fuisic_areas text">FUISIC</div>
                    <p class="fuisic_areas areas_top_text text">Тренажер по запоминанию формул</p>
                    <p class="fuisic_areas areas_bottom_text text">физики и математики</p>
                </div>
            </div>
            <br>

            <div>
                <img src="style/img/three_bubbles.svg" alt="" class="three_bubbles">
                <div class="bubble_cont">
                    <p class="text bubble_text">Мы не только помогаем запоминать самые</p>
                    <p class="text bubble_text">сложные законы с помощью особых</p>
                    <p class="text bubble_text">алгоритмов, но и даем подробное</p>
                    <p class="text bubble_text">объяснение</p>
                </div>
            </div>

            <div class="separator"></div>

            <div class="block_image_and_text1">
                <div class="image_block">
                    <img src="style/img/image_1.svg" alt="" id="image">
                </div>
                <div class='text_cont1'>
                    <h1 class="text image_block_h">КАК РАБОТАЕТ FUISIC?</h1>
                    <p class="image_block_text text image_text_1">Алгоритм, используемый Quizlet</p>
                    <p class="image_block_text text image_text_2">для запоминания карточек, - это</p>
                    <p class="image_block_text text image_text_3">алгоритм интервального</p>
                    <p class="image_block_text text image_text_4">повторения.</p>
                </div>
            </div>
            
            <div class="block_image_and_text2">
                <div class='text_cont2'>
                    <h1 class="text image_block_h_2" id='image_block_h_2'>ПОЧЕМУ ТАК УДОБНЕЕ</h1>
                    <p class="image_block_text_2 text image_text_2_1">Идея интервального повторения в </p>
                    <p class="image_block_text_2 text image_text_2_2">том, чтобы представлять  информацию</p>
                    <p class="image_block_text_2 text image_text_2_3">через интервальные промежутки</p>
                    <p class="image_block_text_2 text image_text_2_4">времени для более долгосрочного</p>
                    <p class="image_block_text_2 text image_text_2_5">запоминания этой информации.</p>
                </div>
                <div class="image_block_2">
                    <img src="style/img/image_2.svg" alt="" id="image_2">
                </div>
            </div>

            <div class="separator"></div>

            <div class="benefits">
                <h1 class="benefit_h">ЧТО ВЫ ПОЛУЧИТЕ?</h1>
                <img src="style/img/benefits.svg" alt="" style="margin-top: 4vw; width: 50vw;">
                <div class="subjects">
                    <img src="/style/img/Math.svg" alt="" style="width: 25vw">
                    <img src="/style/img/Phys.svg" alt="" style="width: 25vw">
                </div>
            </div>

            <div class="separator"></div>

            <div style="align-items: center">
                <div style="margin-right: 30vw; margin-left: 30vw; padding-top: 2vw">
                    <h1 class="benefit_h text_center">СДЕЛАЙТЕ ОБУЧЕНИЕ ПРОСТЫМ И УДОБНЫМ ВМЕСТЕ С НАМИ</h1>
                </div>

                <button class="registration_btn" onclick="window.location.href='/validation-form/login-form.php'">Зарегистрироваться</button>

                <img src="style/img/three_actions.svg" alt="" class="actions">
            </div>

            <?php include 'footer.php';?>

        </div>
    </body>

    <script src="libs/jquery-3.6.1.min.js"></script>
</html>
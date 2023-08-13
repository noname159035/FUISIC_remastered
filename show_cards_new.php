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

    <link rel="stylesheet" href="style/cards_style_new.css" />

    <meta name="msapplication-TileColor" content="#2b5797"/>
    <meta
        name="theme-color" content="#ffffff"/>
    <!--    <script src="main.js"></script>-->
    <title>FUISIC</title>
    <!-- Шрифты -->
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<body>

    <div style="background-color: #ECF2FE;">
        <div class="container   ">
            <header class="d-flex pb-2 flex-wrap align-items-center justify-content-center justify-content-md-between mb-4 border-bottom">
                <a href="/" class="d-flex align-items-center col-md-2 mb-2 mb-md-0 text-dark text-decoration-none">
                    <img src="style/img/Group_2_1.svg" alt="" class="bi me-2" role="img" aria-label="Bootstrap">
                </a>

                <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
                    <li><a href="#" class="nav-link px-2 link-dark fs-4">Главная</a></li>
                    <li><a href="#" class="nav-link px-2 link-dark fs-4">Подборки</a></li>
                    <li><a href="#" class="nav-link px-2 link-dark fs-4">Тесты</a></li>
                    <li><a href="#" class="nav-link px-2 link-dark fs-4">Помощь</a></li>
                </ul>

                <div class="col-md-2 text-end">
                    <button type="button" class="btn btn-outline-primary me-2 fs-5">Login</button>
                </div>
            </header>

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

        </div>
    </div>


<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<!--<script src="scrypts/index_scrypt.js"></script>-->
</body>
</html>
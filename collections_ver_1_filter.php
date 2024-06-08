<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content=" ie=edge">
    <link rel="stylesheet" href="style/collections_new_style.css">
    <title>Задания</title>
</head>
<body class="bg-light d-flex flex-column h-100">

<?php include 'inc/header.php';?>

<div class="container">
    <h2>Первый вариант</h2>
    <div class="card p-3">
        <div class="row">
            <div class="btn-group">
                <button type="button" class="btn btn-outline-primary">Математика</button>
                <button type="button" class="btn btn-outline-primary">Физика</button>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col">
                <label for="section">Выберите раздел:</label>
                <select class="form-select" id="section">
                    <option>Раздел</option>
                    <option>Раздел</option>
                    <option>Раздел</option>
                    <option>Раздел</option>
                    <option>Раздел</option>
                </select>
            </div>
            <div class="col">
                <label for="theme">Выберите тему:</label>
                <select class="form-select" id="theme">
                    <option>Темы</option>
                    <option>Темы</option>
                    <option>Темы</option>
                    <option>Темы</option>
                    <option>Темы</option>
                </select>
            </div>
            <div class="col">
                <label for="class">Выберите класс:</label>
                <select class="form-select" id="class">
                    <option>Класс</option>
                    <option>Класс</option>
                    <option>Класс</option>
                    <option>Класс</option>
                    <option>Класс</option>
                </select>
            </div>
            <div class="col">
                <label for="difficulty">Выберите сложность:</label>
                <select class="form-select" id="difficulty">
                    <option>Сложность</option>
                    <option>Сложность</option>
                    <option>Сложность</option>
                    <option>Сложность</option>
                    <option>Сложность</option>
                </select>
            </div>
            <div class="col">
                <label>Выберите тип:</label>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="card">
                    <label class="form-check-label" for="card">Карточка</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="test">
                    <label class="form-check-label" for="test">Тест</label>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <h2>ИЛИ второй вариант</h2>
    <div class="container">
        <div class="accordion mt-3" id="mathAccordion">
            <div class="accordion-item">
                <h2 class="accordion-header" id="mathHeading">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#mathCollapse" aria-expanded="true" aria-controls="mathCollapse">
                        Математика
                    </button>
                </h2>
                <div id="mathCollapse" class="accordion-collapse collapse show" aria-labelledby="mathHeading" data-bs-parent="#mathAccordion">
                    <div class="accordion-body">
                        <div class="accordion" id="mathSectionAccordion">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="algebraHeading">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#algebraCollapse" aria-expanded="true" aria-controls="algebraCollapse">
                                        Алгебра
                                    </button>
                                </h2>
                                <div id="algebraCollapse" class="accordion-collapse collapse show" aria-labelledby="algebraHeading" data-bs-parent="#mathSectionAccordion">
                                    <div class="accordion-body">
                                        <div class="accordion" id="algebraTopicAccordion">
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="equationsHeading">
                                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#equationsCollapse" aria-expanded="true" aria-controls="equationsCollapse">
                                                        Уравнения
                                                    </button>
                                                </h2>
                                                <div id="equationsCollapse" class="accordion-collapse collapse show" aria-labelledby="equationsHeading" data-bs-parent="#algebraTopicAccordion">
                                                    <div class="accordion-body">
                                                        <ul>
                                                            <li>Линейные уравнения</li>
                                                            <li>Квадратные уравнения</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="geometryHeading">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#geometryCollapse" aria-expanded="true" aria-controls="geometryCollapse">
                                        Геометрия
                                    </button>
                                </h2>
                                <div id="geometryCollapse" class="accordion-collapse collapse show" aria-labelledby="geometryHeading" data-bs-parent="#mathSectionAccordion">
                                    <div class="accordion-body">
                                        <div class="accordion" id="geometryTopicAccordion">
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="planeGeometryHeading">
                                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#planeGeometryCollapse" aria-expanded="true" aria-controls="planeGeometryCollapse">
                                                        Плоская геометрия
                                                    </button>
                                                </h2>
                                                <div id="planeGeometryCollapse" class="accordion-collapse collapse show" aria-labelledby="planeGeometryHeading" data-bs-parent="#geometryTopicAccordion">
                                                    <div class="accordion-body">
                                                        <ul>
                                                            <li>Треугольники</li>
                                                            <li>Окружности</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="accordion mt-3" id="physicsAccordion">
        <div class="accordion-item">
            <h2 class="accordion-header" id="physicsHeading">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#physicsCollapse" aria-expanded="true" aria-controls="physicsCollapse">
                    Физика
                </button>
            </h2>
            <div id="physicsCollapse" class="accordion-collapse collapse" aria-labelledby="physicsHeading" data-bs-parent="#physicsAccordion">
                <div class="accordion-body">
                    <div class="accordion" id="physicsSectionAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="physicsSectionHeading">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#physicsSectionCollapse" aria-expanded="false" aria-controls="physicsSectionCollapse">
                                    Разделы
                                </button>
                            </h2>
                            <div id="physicsSectionCollapse" class="accordion-collapse collapse" aria-labelledby="physicsSectionHeading" data-bs-parent="#physicsSectionAccordion">
                                <div class="accordion-body">
                                    <div class="accordion" id="physicsTopicAccordion">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="physicsTopicHeading">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#physicsTopicCollapse" aria-expanded="false" aria-controls="physicsTopicCollapse">
                                                    Темы
                                                </button>
                                            </h2>
                                            <div id="physicsTopicCollapse" class="accordion-collapse collapse" aria-labelledby="physicsTopicHeading" data-bs-parent="#physicsTopicAccordion">
                                                <div class="accordion-body">
                                                    <div class="accordion" id="physicsCollectionAccordion">
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header" id="physicsCollectionHeading">
                                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#physicsCollectionCollapse" aria-expanded="false" aria-controls="physicsCollectionCollapse">
                                                                    Подборки
                                                                </button>
                                                            </h2>
                                                            <div id="physicsCollectionCollapse" class="accordion-collapse collapse" aria-labelledby="physicsCollectionHeading" data-bs-parent="#physicsCollectionAccordion">
                                                                <div class="accordion-body">
                                                                    <!-- Содержимое для Подборок -->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="album py-5">
    <div class="container">
        <h2 class="mt-3"></h2>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3 mt-1">
            <div class="col">
                <div class="card shadow-sm card_block">
                    <img class="bd-placeholder-img card-img-top" width="100%" height="225"  role="img" alt="" src="/style/img/F_2.svg">
                    <div class="card-body">
                        <div style='height: 42px; '><h3 style="font-size: 150%; line-height: 20px"></h3></div>
                        <p class="card-text"></p>
                        <p class="card-text">Тип: Карточки</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="btn-group">
                                <a class="btn btn-outline-primary" href="#">Начать</a>
                            </div>
                            <small class="text-muted"> минут(ы)</small>
                            <small class="text-muted"> формул(ы)</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card shadow-sm card_block">
                    <img class="bd-placeholder-img card-img-top" width="100%" height="225"  role="img" alt="" src="/style/img/F_2.svg">
                    <div class="card-body">
                        <div style='height: 42px; '><h3 style="font-size: 150%; line-height: 20px"></h3></div>
                        <p class="card-text"></p>
                        <p class="card-text">Тип: Карточки</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="btn-group">
                                <a class="btn btn-outline-primary" href="#">Начать</a>
                            </div>
                            <small class="text-muted"> минут(ы)</small>
                            <small class="text-muted"> формул(ы)</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card shadow-sm card_block">
                    <img class="bd-placeholder-img card-img-top" width="100%" height="225"  role="img" alt="" src="/style/img/F_2.svg">
                    <div class="card-body">
                        <div style='height: 42px; '><h3 style="font-size: 150%; line-height: 20px"></h3></div>
                        <p class="card-text"></p>
                        <p class="card-text">Тип: Карточки</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="btn-group">
                                <a class="btn btn-outline-primary" href="#">Начать</a>
                            </div>
                            <small class="text-muted"> минут(ы)</small>
                            <small class="text-muted"> формул(ы)</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card shadow-sm card_block">
                    <img class="bd-placeholder-img card-img-top" width="100%" height="225"  role="img" alt="" src="/style/img/F_2.svg">
                    <div class="card-body">
                        <div style='height: 42px; '><h3 style="font-size: 150%; line-height: 20px"></h3></div>
                        <p class="card-text"></p>
                        <p class="card-text">Тип: Карточки</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="btn-group">
                                <a class="btn btn-outline-primary" href="#">Начать</a>
                            </div>
                            <small class="text-muted"> минут(ы)</small>
                            <small class="text-muted"> формул(ы)</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'inc/footer.php';?>


<script src="libs/jquery-3.6.1.min.js"></script>
<script src="libs/bootstrap-5.3.1-dist/js/bootstrap.min.js"></script>

</body>
</html>
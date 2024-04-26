<?php
if (isset($_COOKIE['user'])) {
    $userId = $_COOKIE['user'];
}

$testId = $_GET['id'];

require_once ('db.php');

global $link;

$query = "SELECT Название FROM Тесты WHERE Код_Теста = $testId";
$result = $link->query($query);

$row = $result->fetch_assoc();

$query = "SELECT * FROM Задачи WHERE `Тест` =?";
$stmt = $link->prepare($query);
$stmt->bind_param('s', $testId);
$stmt->execute();
$result = $stmt->get_result();

?>
<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <title>Тест</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Подключаем стили и скрипты библиотеки MathQuill -->
</head>
<body class="bg-light d-flex flex-column h-100">

<?php include("inc/header.php");?>

<div class="container">

    <h2>Тест: <?php echo $row['Название']?></h2>

    <form action="/collections/test/check_answers/" method="post">
        <?php while ($row = $result->fetch_assoc()) { ?>
            <input type="hidden" name="id" class="form-control" value="<?php echo $testId ?>">
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title"><?php echo htmlspecialchars($row['Задача']); ?></h5>
                    <label>
                        <input type="text" name="answers[<?php echo $row['Код_задачи']; ?>]" class="form-control" placeholder="Введите ответ">
                    </label>
                    <button type="button" class="btn btn-link" data-toggle="modal" data-target="#explanationModal<?php echo $row['Код_задачи'] ?>">Решение</button>
                </div>
            </div>
            <!-- Модальные окна и другой код -->
            <div class="modal fade" id="explanationModal<?php echo $row['Код_задачи']?>" tabindex="-1" role="dialog" aria-labelledby="explanationModalLabel<?php echo $row['Код_задачи']?>" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="explanationModalLabel<?php echo $row['Код_задачи']?>">Решение</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p id="explanationText<?php echo $row['Код_задачи']?>"><?php echo $row['Решение']?></p>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

        <!-- Кнопка "Выйти", которая теперь открывает модальное окно -->
        <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#exitModal">
            Выйти
        </button>

        <!-- Кнопка "Закончить тест", которая теперь открывает модальное окно -->
        <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#finishTestModal">
            Закончить тест
        </button>

        <!-- Модальное окно для кнопки "Выйти" -->
        <div class="modal fade" id="exitModal" tabindex="-1" role="dialog" aria-labelledby="exitModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exitModalLabel">Подтверждение выхода</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Вы уверены, что хотите выйти?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                        <a href="/collections/" class="btn btn-danger">Выйти</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Модальное окно для кнопки "Закончить тест" -->
        <div class="modal fade" id="finishTestModal" tabindex="-1" role="dialog" aria-labelledby="finishTestModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="finishTestModalLabel">Подтверждение завершения теста</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Вы уверены, что хотите завершить тест?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                        <button type="submit" class="btn btn-primary">Проверить ответы</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

</div>

<?php include("inc/footer.php");?>

</body>

<script>
    function showExplanation(explanation) {
        document.getElementById("explanationText").innerHTML = explanation;
    }
</script>
<!-- Подключаем скрипт библиотеки MathJax -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/MathJax.js?config=TeX-MML-AM_CHTML"></script>

<!-- Инициализируем MathJax -->
<script type="text/javascript">
    MathJax.Hub.Config({
        showMathMenu: true,
        tex2jax: {
            inlineMath: [ ['$','$'], ['\\(','\\)'] ]
        }
    });
    MathJax.Hub.Queue(["Typeset",MathJax.Hub]);
</script>

<script src="libs/jquery-3.6.1.min.js"></script>

<!-- Подключаем библиотеку Bootstrap -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


<?php
$link->close();
?>
</html>

<?php
if (isset($_COOKIE['user'])) {
    $userId = $_COOKIE['user'];
}

$testId = $_GET['id'];

$time = date("Y-m-d H:i:s");

$link = new mysqli('localhost', 'p523033_admin', 'eQ5kJ0dN5a', 'p523033_Test_3');
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



    <?php while ($row = $result->fetch_assoc()) { ?>
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title"><?php echo $row['Задача']?></h5>
                <label>
                    <input type="text" class="form-control" placeholder="Введите ответ">
                </label>
                <button type="button" class="btn btn-link" data-toggle="modal" data-target="#explanationModal<?php echo $row['Код_задачи'] ?>">Решение</button>
            </div>
        </div>

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

    <a href="/check_answers/" class="btn btn-outline-primary">Закончить</a>

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

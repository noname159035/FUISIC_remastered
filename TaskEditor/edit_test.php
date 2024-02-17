<?php

require_once ('../db.php');

global $link;

if (!isset($_COOKIE['user'])) {
    header("Location: /login/");
    exit;
}

if (!isset($_GET['id'])) {
    echo "<h1>Тест не выбран!</h1>";
    exit;
}

$test_id = $_GET['id'];

// Получение заданий из базы данных
$query = "SELECT `Код_задачи`, Задача, Ответ, Решение FROM Задачи WHERE `Тест` =?";
$stmt = $link->prepare($query);
$stmt->bind_param('s', $test_id);
$stmt->execute();

$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <meta charset="UTF-8">
    <title>Редактор тестов</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.3.0/css/all.css" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mathquill/0.10.1/mathquill.min.css" />
</head>

<body class="bg-light d-flex flex-column h-100">

<?php include '../inc/header.php';?>

<div class="container">

    <a href="/my_base/add_task/<?php echo $test_id; ?>" class="btn btn-primary">Создать задачу</a>
    <?php
    if(mysqli_num_rows($result) == 0){
        ?>
        <p>В данном тесте пока нет задач, нажмите на кнопку создать, чтобы добавить новую задачу</p>
        <?php
    }
    else{
    ?>
    <a href="/my_base/" class="btn btn-outline-danger">Закончить</a>

    <h3>Список задач</h3>
    <table class="table">
        <tr>
            <th>Задача</th>
            <th>Ответ</th>
            <th>Редактировать</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['Задача']; ?></td>
                <td><?php echo $row['Ответ']; ?></td>
                <td>
                    <div class="btn-group">
                        <a href="/my_base/edit_task/<?php echo ($test_id.'/'.$row['Код_задачи']); ?>" class="btn btn-primary">Редактировать</a>
                        <a href="/my_base/delete_task/<?php echo ($test_id.'/'.$row['Код_задачи']); ?>" class="btn btn-danger">Удалить</a>
                    </div>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</div>
<?php } ?>
<?php include '../inc/footer.php';?>
</body>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
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
</html>


<?php

if (!isset($_COOKIE['user'])) {
    header("Location: /login/");
    exit;
}

if (!isset($_GET['id'])) {
    echo "<h1>Подборка не выбрана!</h1>";
    exit;
}

$cards_id = $_GET['id'];

$link = new mysqli('localhost', 'p523033_admin', 'eQ5kJ0dN5a', 'p523033_Test_3');
// Получение заданий из базы данных
$query = "SELECT `Код задания`, Формула, Описание, Пояснение FROM Карточка WHERE `Подборка` =?";
$stmt = $link->prepare($query);
$stmt->bind_param('s', $cards_id);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <meta charset="UTF-8">
    <title>Редактор карточек</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.3.0/css/all.css" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mathquill/0.10.1/mathquill.min.css" />
</head>

<body class="bg-light d-flex flex-column h-100">

<?php include '../inc/header.php';?>

<div class="container">

    <a href="/my_base/add_card/<?php echo $cards_id; ?>" class="btn btn-primary">Создать карточку</a>
    <?php
    if(mysqli_num_rows($result) == 0){
        ?>
        <p>В данной подборке пока нет карточек, нажмите на кнопку создать, чтобы добавить новую карточку</p>
        <?php
    }
    else{
    ?>
    <a href="/my_base/" class="btn btn-outline-danger">Закончить</a>

    <h3>Список карточек</h3>
    <table class="table">
        <tr>
            <th>Формула</th>
            <th>Описание</th>
            <th>Редактировать</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['Формула']; ?></td>
                <td><?php echo $row['Описание']; ?></td>
                <td>
                    <div class="btn-group">
                    <a href="/my_base/edit_card/<?php echo ($cards_id.'/'.$row['Код задания']); ?>" class="btn btn-primary">Редактировать</a>
                    <a href="/my_base/delete_card/<?php echo ($cards_id.'/'.$row['Код задания']); ?>" class="btn btn-danger">Удалить</a>
                    </div>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</div>
<?php } ?>
<?php include '../inc/footer.php';?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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

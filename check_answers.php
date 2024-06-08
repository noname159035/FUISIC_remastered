<?php

require_once('db.php');

global $link;

if (isset($_COOKIE['user'])) {
    $userId = $_COOKIE['user'];
}

$testId = $_POST['id'];

$time = date("Y-m-d H:i:s");

$correct_answers = [];

$query = "SELECT * FROM Задачи WHERE `Тест` =?";
$stmt = $link->prepare($query);
$stmt->bind_param('s', $testId);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $correct_answers[$row['Код_задачи']]['Ответ'] = $row['Ответ'];
    $correct_answers[$row['Код_задачи']]['Задача'] = $row['Задача'];
    $correct_answers[$row['Код_задачи']]['Решение'] = $row['Решение'];
}

// Массив для хранения результатов
$results = [];

$correct_count = 0; // Инициализация переменной для подсчета правильных ответов

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['answers'])) {
    foreach ($_POST['answers'] as $task_id => $user_answer) {
        // Обрезаем пробелы и приводим ответы к одному регистру, если необходимо
        $user_answer = trim($user_answer);
        $correct_answer = trim($correct_answers[$task_id]['Ответ']);

        // Проверяем, совпадает ли ответ пользователя с правильным ответом
        $is_correct = strcasecmp($user_answer, $correct_answer) == 0; // сравнение без учета регистра
        $results[$task_id] = [
            'user_answer' => $user_answer,
            'correct' => $is_correct,
        ];

        // Если ответ верный, увеличиваем счетчик
        if ($is_correct) {
            $correct_count++;
        }
    }
}

$percent = round($correct_count / count($correct_answers) * 100);

if (isset($_COOKIE['user'])) {
    // Код для записи данных в таблицу "История"
    $query = "INSERT INTO `История тестов` (Пользователь, `Дата_прохождения_задания`, Тест, `Результат`) VALUES (?, ?, ?, ?)";
    $stmt = $link->prepare($query);
    $stmt->bind_param('isii', $userId, $time, $testId, $percent);
    $stmt->execute();
}
?>

<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <title>Результат</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Подключаем стили и скрипты библиотеки MathQuill -->
</head>
<body class="bg-light d-flex flex-column h-100">

<?php include("inc/header.php");?>

<div class="container">
    <h3>Ваши результаты</h3>
<?php foreach ($results as $task_id => $result): ?>
    <div class="card mb-3 <?php echo $result['correct'] ? 'bg-success-subtle' : 'bg-danger-subtle'; ?>">
        <div class="card-body">
            <h5 class="card-title">Задача:</h5>
            <p class="text-secondary"><?php echo $correct_answers[$task_id]['Задача']?></p>
            <p>Ваш ответ: <?php echo htmlspecialchars($result['user_answer']); ?></p>
            <p><?php echo $result['correct'] ? 'Правильно!' : 'Неправильно!'; ?></p>
        </div>
    </div>
<?php endforeach; ?>

    <h4>Чтобы вернуться к выбору заданий, нажмите на кнопку ниже</h4>
    <a href="/collections/" class="btn btn-outline-primary">Закончить</a>

</div>

<?php include("inc/footer.php");?>
</body>
</html>

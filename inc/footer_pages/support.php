<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Поддержка</title>
</head>
<body class="bg-light d-flex flex-column h-100">

<?php include '../header.php' ?>

<div class="container">
    <form action="../../mail.php" method="post">
        <div class="form-group">
            <label for="name">Ф.И.О:</label>
            <input type="text" class="form-control" id="name" name="user_name" required>
        </div>
        <div class="form-group">
            <label for="email">E-mail:</label>
            <input type="email" class="form-control" id="email" name="user_email" required>
        </div>
        <div class="form-group">
            <label for="browser">Браузер:</label>
            <input type="text" class="form-control" id="browser" name="user_browser" required>
        </div>
        <div class="form-group">
            <label for="main_textarea">Опишите вашу проблему:</label>
            <textarea class="form-control" id="main_textarea" name="user_question" rows="10" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Отправить</button>
    </form>
</div>

<?php include '../footer.php' ?>

</body>
</html>

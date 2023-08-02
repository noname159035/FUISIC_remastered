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

    <!-- Шрифты -->
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet"/>

    <title>FUISIC</title>

    <!-- Стили -->
    <link rel="stylesheet" href="style/header_footer_style_black.css" />
    <link rel="stylesheet" href="style/support_style.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<?php include 'header.php'?>


<div id="container">

    <form action="mail.php" method="post">
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

<?php include 'footer.php'?>

</body>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</html>

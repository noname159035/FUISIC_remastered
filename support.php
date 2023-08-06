<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>

    <title>FUISIC</title>

    <!-- Стили -->
    <link rel="stylesheet" href="/style/support_style.css" />
    <link rel="stylesheet" href="/style/header_footer_style_black.css" />
    <link rel="stylesheet" href="/libs/bootstrap-4/css/bootstrap.min.css">
</head>

<body>

<div class="container_1">

    <?php include 'header.php'?>

    <div class="container">
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

</div>



</body>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</html>

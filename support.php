<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <!-- Иконки -->
    <link
      rel="apple-touch-icon"
      sizes="180x180"
      href="/favicons/apple-touch-icon.png"
    />
    <link
      rel="icon"
      type="image/png"
      sizes="32x32"
      href="/favicons/favicon-32x32.png"
    />
    <link
      rel="icon"
      type="image/png"
      sizes="16x16"
      href="/favicons/favicon-16x16.png"
    />
    <link rel="manifest" href="/favicons/site.webmanifest" />
    <link
      rel="mask-icon"
      href="/favicons/safari-pinned-tab.svg"
      color="#5bbads5"
    />
    <meta name="msapplication-TileColor" content="#2b5797" />
    <meta name="theme-color" content="#ffffff" />
    <link rel="stylesheet" href="style/support_style.css" />
    <!-- Подключение скрипта -->
<!--    <script src="main.js"></script>-->
    <title>FIUSIC</title>
    <!-- Шрифты -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap"
      rel="stylesheet"
    />
  </head>
  <body>
    <div id="conteiner">

      <?php
      include("header.php");
      ?>

      <form action="mail.php" method="post">
          <input
          name="user_name"
          required
          placeholder="Ф.И.О"
          class="support_input" id="name">
          <input
          name="user_email"
          required
          placeholder="E-mail"
          id="email" class="support_input">
          <input
          name="user_browser"
          required
          placeholder="Браузер"
          id="browser" class="support_input">
          <input
          name="user_screen"
          required
          placeholder="Разрешение экрана"
          id="screen" class="support_input">
          <textarea name="user_question" id="main_textarea" cols="30" rows="10" placeholder="Опишите вашу проблему"></textarea>

          <button id="button_send" type="submit">ОТПРАВИТЬ</button>
      </form>

      <?php
      include("footer.php");
      ?>

    </div>
  </body>
</html>

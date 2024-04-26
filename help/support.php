<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Поддержка</title>
</head>
<body class="bg-light d-flex flex-column h-100">

<?php include '../inc/header.php' ?>

<div class="container">
    <form action="../mail.php" method="post">
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
        <button type="submit" class="btn btn-primary mt-3 btn_send">Отправить</button>
    </form>
</div>

<?php include '../inc/footer.php' ?>
<script>
    function SendMail(){
        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\SMTP;
        use PHPMailer\PHPMailer\Exception;

        require 'vendor/autoload.php';

        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.sendgrid.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'fuisic@mail.ru';                     //SMTP username
            $mail->Password   = '&trOurFdEO32';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('fuisic@mail.ru', 'User_Name');
            $mail->addAddress('fuisic@mail.ru', 'Техподдержка');     //Add a recipient


            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Тестовое сообщение';
            $mail->Body    = 'Тестовое сообщение body';
            $mail->AltBody = 'Альтернативное сообщение';

            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    cardContainer.on('click', '.btn_send', SendMail);
</script>
</body>
</html>

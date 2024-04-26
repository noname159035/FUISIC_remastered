<?php

require_once('libs/phpmailer/PHPMailerAutoload.php');
//$mail = new PHPMailer;
//$mail->CharSet = 'utf-8';

//$name = $_POST['user_name'];
//$email = $_POST['user_email'];
//$browser = $_POST['user_browser'];
//$screen = $_POST['user_screen'];
//$question = $_POST['user_question'];
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//require 'vendor/autoload.php';

$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.sendgrid.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'fuisic@mail.ru';                     //SMTP username
    $mail->Password   = 'v7isicmwptq7FmNe1prr';                               //SMTP password
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

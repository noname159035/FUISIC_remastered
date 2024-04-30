<?php
//
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//
//
//$user_name = $_POST['user_name'];
//$user_email = $_POST['user_email'];
//$user_browser = $_POST['user_browser'];
//$user_question = $_POST['user_question'];
//$message = $user_name.$user_email.$user_browser.$user_question;
//
//$recepient = "fuisic@mail.ru";
//$siteName = "TEST";
//$pagetitle = "Заявка с сайт". $siteName;
//
//mail($recepient, $pagetitle, $message, "Content-type: text/plain; charset='utf-8'\n From: $recepient");
//
//echo 'Успешно';
require_once('libs/phpmailer/PHPMailerAutoload.php');
$mail = new PHPMailer;
$mail->CharSet = 'utf-8';

$name = $_POST['user_name'];
$email = $_POST['user_email'];
$browser = $_POST['user_browser'];
$question = $_POST['user_question'];

//$mail->SMTPDebug = 3;                               // Enable verbose debug output

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.mail.ru';                                                                                              // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'fuisic@mail.ru'; // Ваш логин от почты с которой будут отправляться письма
$mail->Password = 'v7isicmwptq7FmNe1prr'; // Ваш пароль от почты с которой будут отправляться письма
$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 465; // TCP port to connect to / этот порт может отличаться у других провайдеров

$mail->setFrom($email); // от кого будет уходить письмо?
$mail->addAddress('fuisic@mail.ru');     // Кому будет уходить письмо
//$mail->addAddress('ellen@example.com');               // Name is optional
//$mail->addReplyTo('info@example.com', 'Information');
//$mail->addCC('cc@example.com');
//$mail->addBCC('bcc@example.com');
//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'Обращение в техподдержку';
$mail->Body    = '' .$name . ' оставил заявку, его почта ' .$email. '<br>Браузер этого пользователя: ' .$browser. '<br>Вопрос: <br>'.$question;
$mail->AltBody = '';

if(!$mail->send()) {
    echo 'Ошибка: ' . $mail->ErrorInfo;
} else {
    header('Location: thank-you.html');
}

?>
<?php

use PHPMailer\PHPMailer\PHPMailer;

require dirname(__DIR__) . '\vendor\phpmailer\phpmailer\src\Exception.php';
require dirname(__DIR__) . '\vendor\phpmailer\phpmailer\src\PHPMailer.php';
require dirname(__DIR__) . '\vendor\phpmailer\phpmailer\src\SMTP.php';

$mail = new PHPMailer;
$mail->isSMTP();
$mail->Host = 'smtp.mail.ru';
$mail->SMTPAuth = true;
$mail->CharSet = 'UTF-8';
$mail->Username = 'community-webma@mail.ru';
$mail->Password = 'vJpNVudkEmukt7eEKn3f';
$mail->SMTPSecure = 'ssl';
$mail->Port = 465;
$mail->setFrom('community-webma@mail.ru');
$mail->isHTML(true);


function mailFunc($email, $text, $subject)
{
    global $mail;
    $mail->addAddress($email);
    $mail->Subject = $subject;
    $bod = $mail->Body = $text;
    $mail->msgHTML($bod);
    if (!$mail->send()) {
        echo 'Ошибка отправки:' . $mail->ErrorInfo;
    } else {
        echo 'Успешно отправлено!';
    }
};

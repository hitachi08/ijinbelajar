<?php

use PHPMailer\PHPMailer\PHPMailer;

require_once __DIR__ . '/../vendor/autoload.php';

function createMailer()
{
    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'beniliufeto08@gmail.com';
    $mail->Password   = 'xydw svra lhqs zeag';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    $mail->setFrom(
        'beniliufeto08@gmail.com',
        'Sistem Izin Belajar UNDANA'
    );

    $mail->addEmbeddedImage(
        __DIR__ . '/../img/Logo_Undana.png',
        'logo_undana'
    );

    return $mail;
}

<?php
require_once 'mailer.php';
require_once 'verification_template.php';
require_once 'reset_password_template.php';

function sendVerificationEmail($email, $token)
{
    try {
        $mail = createMailer();
        $mail->addAddress($email);

        $verifyLink = "http://localhost/izinbelajar/mail/verify_email.php?token=$token";

        $mail->isHTML(true);
        $mail->Subject = 'Verifikasi Email Akun Anda';
        $mail->Body    = verificationEmailTemplate($verifyLink);

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

function sendResetPasswordEmail($email, $token)
{
    try {
        $mail = createMailer();
        $mail->addAddress($email);

        $resetLink = "http://localhost/izinbelajar/mail/reset_password.php?token=$token";

        $mail->isHTML(true);
        $mail->Subject = 'Reset Password Akun Anda';
        $mail->Body    = resetPasswordEmailTemplate($resetLink);

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

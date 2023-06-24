<?php

require_once '../../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;

function sendRegisterCode($to, $code): bool
{
    return sendEmail($to, "Antx",
        "<!DOCTYPE html><html lang='zh_CN'><head><meta charset='UTF-8'><title>欢迎注册 | Antx</title><meta name='application-name' content='Antx'><meta http-equiv='X-UA-Compatible' content='IE=edge'><meta name='viewport' content='width=device-width, initial-scale=1.0'><meta http-equiv='Content-Security-Policy' content='upgrade-insecure-requests'></head><body><div style='text-align: center'><h3><img  src='https://image.antx.cc/logo/antx/favicon.ico' alt='' width='20px' height='20px'> 欢迎注册 Antx</h3><p>【Antx】验证码: $code, 此验证码用只于账号注册, 5分钟内有效, 请勿泄露和转发。如非本人操作，请忽略此邮件。</p></div></body></html>",
        "验证码: $code, 此验证码用只于账号注册, 5分钟内有效, 请勿泄露和转发。如非本人操作，请忽略此邮件。");
}

function sendLoginCode($to, $code): bool
{
    return sendEmail($to, "Antx",
        "<!DOCTYPE html><html lang='zh_CN'><head><meta charset='UTF-8'><title>欢迎登录 | Antx</title><meta name='application-name' content='Antx'><meta http-equiv='X-UA-Compatible' content='IE=edge'><meta name='viewport' content='width=device-width, initial-scale=1.0'><meta http-equiv='Content-Security-Policy' content='upgrade-insecure-requests'></head><body><div style='text-align: center'><h3><img  src='https://image.antx.cc/logo/antx/favicon.ico' alt='' width='20px' height='20px'> 欢迎登录 Antx</h3><p>【Antx】验证码: $code, 此验证码用只于账号登录, 5分钟内有效, 请勿泄露和转发。如非本人操作，请忽略此邮件。</p></div></body></html>",
        "验证码: $code, 此验证码用只于账号登录, 5分钟内有效, 请勿泄露和转发。如非本人操作，请忽略此邮件。");
}

function sendEmail($to, $subject, $body, $altBody): bool
{
    $mail = new PHPMailer(true);
    $mail->IsSMTP();
    $mail->SMTPDebug = 2;
    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );
    $mail->SMTPAuth = true;
    $mail->Host = 'smtp.antx.cc';
    $mail->Username = 'no-reply@mail.antx.cc';
    $mail->Password = getenv("EMAIL_PASSWORD");
    $mail->SMTPSecure = 'tls';
    $mail->Port = 25;
    $mail->setFrom('no-reply@mail.antx.cc', 'Antx');
    $mail->addAddress($to, 'You');
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $body;
    $mail->AltBody = $altBody;
    $mail->send();
    if (!$mail->Send()) {
        return false;
    } else {
        return true;
    }
}

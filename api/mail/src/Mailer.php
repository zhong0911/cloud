<?php
/**
 * @Author: zhong
 * @Date: 2023-06-24 16-37-12
 * @LastEditors: zhong
 */

use PHPMailer\PHPMailer\PHPMailer;

require '../vendor/autoload.php';

class Mailer
{

    public static function sendEmail()
    {
        $mail = new PHPMailer();
        $mail->IsSMTP(); // active SMTP
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

        // 收件人设置
        $mail->setFrom('no-reply@mail.antx.cc', 'Antx');
        $mail->addAddress('257966051@qq.com', 'Recipient Name');
        // 邮件内容
        $mail->isHTML(true);
        $mail->Subject = 'Test Email';
        $mail->Body = 'This is a test email.';

        $mail->send();
        echo 'Email has been sent';

        if (!$mail->Send()) {
            return false;
        } else {
            return true;
        }
    }

}



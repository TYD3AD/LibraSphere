<?php

namespace utils;

use PHPMailer\PHPMailer\PHPMailer;

class EmailUtils
{
    static function sendEmail($to, $subject, $template, $data): bool
    {
        // Récupération des informations de configuration
        $config = include("configs.php");


        // Construction du message avec la librairie Template
        $message = Template::render("views/emails/$template.php", $data, false);
        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = $config["MAIL_SERVER"] ?: 'localhost';
            $mail->SMTPAuth = false;
            $mail->Port = 1025;

            $mail->setFrom($config["FROM_EMAIL"], "Contact");
            $mail->addAddress($to);
            $mail->Subject = $subject;
            $mail->Body = $message;
            $mail->isHTML(true);
            return $mail->send();
            echo 'Message has been sent';
        } catch (\Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}

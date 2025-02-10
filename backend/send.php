<?php
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';
require 'phpmailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = 'localhost';
    $mail->SMTPAuth = false;
    $mail->Port = 1025;

    $mail->setFrom('prueba@example.com', 'Sistema de Prueba');
    $mail->addAddress('destinatario@example.com', 'Usuario Destino');

    $mail->isHTML(true);
    $mail->Subject = 'Correo de prueba';
    $mail->Body    = 'Este es un correo de prueba enviado con MailHog';

    $mail->send();
    echo json_encode(["status" => "success", "message" => "Correo enviado correctamente"]);
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => "Error: {$mail->ErrorInfo}"]);
}

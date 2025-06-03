<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Composer carga PHPMailer

function enviarCorreo($destinatario, $asunto, $mensajeHtml, $mensajeTextoPlano = '', $nombreDestino = 'Usuario') {
    $mail = new PHPMailer(true);

    try {
        // Configuración SMTP (Gmail)
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'docdinnerbg@gmail.com';        // <-- Cambia esto
        $mail->Password = 'lhoj rmed gnzh znvx';     // <-- Usa contraseña de aplicación si tienes 2FA
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Remitente y destinatario
        $mail->setFrom('docdinnerbg@gmail.com', 'DocDinner'); // <-- Opcionalmente cambia el nombre
        $mail->addAddress($destinatario, $nombreDestino);

        // Contenido
        $mail->isHTML(true);
        $mail->Subject = $asunto;
        $mail->Body    = $mensajeHtml;
        $mail->AltBody = $mensajeTextoPlano ?: strip_tags($mensajeHtml);

        $mail->send();
        return true;
    } catch (Exception $e) {
        // Puedes loguear el error aquí si lo deseas
        return "Error: {$mail->ErrorInfo}";
    }
}
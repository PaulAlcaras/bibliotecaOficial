<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

$mail = new PHPMailer(true);

try {
    // Configuración del servidor SMTP de Gmail
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'bibliotecateca.stgo@gmail.com'; // Tu dirección de correo de Gmail
    $mail->Password   = 'bvuh cdpt skfd vesc';          // Tu contraseña de Gmail
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port       = 465;

    // Destinatario
    $mail->setFrom('bibliotecateca.stgo@gmail.com', 'BibliotecaTeca');
    $mail->addAddress('paula.alcaras@gmail.com'); // Cambia aquí por la dirección de correo de destino

    // Contenido del correo
    $mail->isHTML(true);
    $mail->Subject = 'Prueba de correo';
    $mail->Body    = 'Este es un correo de prueba enviado desde PHPMailer.';

    // Enviar correo
    $mail->send();
    echo 'Correo enviado correctamente';

} catch (Exception $e) {
    echo "No se pudo enviar el correo. Error: {$mail->ErrorInfo}";
}
?>

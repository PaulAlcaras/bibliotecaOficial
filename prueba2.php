<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

// Crear una instancia de PHPMailer
$mail = new PHPMailer(true);

// Variables para mensajes
$mensaje_enviado = '';
$mensaje_error = '';

echo 'hola';

// Procesar el formulario si se ha enviado
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['correo'])) {
    try {
        // Conexión a la base de datos (ajusta los datos de conexión según tu configuración)
        $conexion = new mysqli("localhost", "root", "", "datos");

        if ($conexion->connect_error) {
            die("Error de conexión: " . $conexion->connect_error);
        }
        
echo 'hola';

        // Obtener el correo electrónico enviado por el usuario
        $correo = $_POST['correo'];

        // Consultar la contraseña asociada al correo en la base de datos
        $sql = "SELECT contraseña FROM usuarios WHERE correo = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $stmt->bind_result($contraseña_bd);
        $stmt->fetch();
        
echo 'hola';

        // Verificar si se encontró la cuenta
        if ($contraseña_bd) {
            // Configuración del servidor SMTP de Gmail
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'bibliotecateca.stgo@gmail.com'; // Tu dirección de correo de Gmail
            $mail->Password   = 'bvuh cdpt skfd vesc';          // Tu contraseña de Gmail
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;
            
echo 'hola';

            // Destinatario y contenido del correo
            $mail->setFrom('from@example.com', 'BibliotecaTeca');
            $mail->addAddress($correo); // Agregar el correo del usuario como destinatario
            $mail->isHTML(true);
            $mail->Subject = 'Renovar contraseña BibliotecaTeca';
            $mail->Body    = 'Ingrese a este <a href="http://localhost/aplicacion/restablecer_contraseña.php">enlace</a> para poder cambiarla.<br>Si usted no ha solicitado ningún cambio de contraseña, ignore este mensaje.';

            // Enviar correo
            $mail->send();
            $mensaje_enviado = 'Por favor revise su correo para restablecer su contraseña.';
            
echo 'hola';
        } else {
            $mensaje_error = "No se encontró ninguna cuenta asociada a ese correo electrónico.";
            
echo 'hola';
        }

        // Cerrar la conexión con la base de datos
        
echo 'hola';
        $stmt->close();
        $conexion->close();


    } catch (Exception $e) {
        $mensaje_error = "No se pudo enviar el correo. Error: {$mail->ErrorInfo}";
    }
    
echo 'hola';
}
?>

<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

// Datos de conexión a la base de datos
$user = "root";
$pass = "";
$host = "localhost";
$database = "datos";

// Conectar a la base de datos
$connection = mysqli_connect($host, $user, $pass, $database);

if (!$connection) {
    die("Error al conectar a la base de datos: " . mysqli_connect_error());
}

// Obtener el nombre de usuario de la sesión
$id_usuario = $_SESSION['usuario'];

// Obtener el id del usuario
$sql_usuario = "SELECT id_usuario FROM usuarios WHERE usuario = '$id_usuario'";
$result_usuario = mysqli_query($connection, $sql_usuario);
if (!$result_usuario || mysqli_num_rows($result_usuario) == 0) {
    die("Error al obtener el id del usuario: " . mysqli_error($connection));
}
$row_usuario = mysqli_fetch_assoc($result_usuario);
$id_usuario = $row_usuario['id_usuario'];

// Importar clases PHPMailer en el espacio de nombres global
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
function enviarCorreoConfirmacionRenovacion($titulo, $autor, $fecha_termino, $correo_destinatario)
{
    // Crear una instancia de PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Configuración del servidor
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'bibliotecateca.stgo@gmail.com'; // Tu dirección de correo de Gmail
        $mail->Password   = 'jezt fohm lhng prik';          // Tu contraseña de Gmail
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        // Destinatarios
        $mail->setFrom('bibliotecateca.stgo@gmail.com', 'BibliotecaTeca');
        $mail->addAddress($correo_destinatario);

        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = 'Confirmacion de renovacion';
        $mail->Body    = "Estimado usuario,<br><br>Le confirmamos que el libro <strong>\"$titulo\"</strong> de $autor ha sido renovado exitosamente hasta el $fecha_termino.<br><br>Gracias por utilizar nuestros servicios.<br><br>Atentamente,<br>Su Biblioteca";

        $mail->send();
    } catch (Exception $e) {
        echo "No se pudo enviar el correo. Error: {$mail->ErrorInfo}";
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_libro = $_POST['id_libro'];

    if (empty($id_libro)) {
        die("ID del libro no proporcionado.");
    }

    // Verificar si el libro está prestado al usuario
    $verificar_libro_prestado = "SELECT * FROM situacion WHERE id_libro = '$id_libro' AND estado = 'Prestado'";
    $resultado = mysqli_query($connection, $verificar_libro_prestado);
    if (!$resultado || mysqli_num_rows($resultado) == 0) {
        die("Error: El libro no está prestado o no pertenece al usuario.");
    }

    // Calcular la nueva fecha de término (renovación por 10 días adicionales)
    $fecha_termino = date('Y-m-d', strtotime('+10 days')); 

    // Actualizar la fecha de término en la tabla historial
    $sql_update_historial = "UPDATE historial SET fecha_termino = '$fecha_termino' WHERE id_libro = '$id_libro' AND id_usuario = '$id_usuario'";
    if (!mysqli_query($connection, $sql_update_historial)) {
        die("Error al actualizar la fecha de término en historial: " . mysqli_error($connection));
    }

    // Actualizar la situación del libro
    $sql_update_situacion = "UPDATE situacion SET estado = 'Renovado' WHERE id_libro = '$id_libro' AND estado = 'Prestado'";
    if (!mysqli_query($connection, $sql_update_situacion)) {
        die("Error al actualizar situación: " . mysqli_error($connection));
    }

    // Obtener la información del libro para enviar en el correo de confirmación
    $sql_info_libro = "SELECT titulo, autor FROM libros WHERE id_libro = '$id_libro'";
    $resultado_info_libro = mysqli_query($connection, $sql_info_libro);
    if (!$resultado_info_libro || mysqli_num_rows($resultado_info_libro) == 0) {
        die("Error al obtener información del libro: " . mysqli_error($connection));
    }
    $row_info_libro = mysqli_fetch_assoc($resultado_info_libro);
    $titulo_libro = $row_info_libro['titulo'];
    $autor_libro = $row_info_libro['autor'];

    // Obtener el correo del usuario
    $sql_correo_usuario = "SELECT correo FROM usuarios WHERE id_usuario = '$id_usuario'";
    $resultado_correo_usuario = mysqli_query($connection, $sql_correo_usuario);
    if (!$resultado_correo_usuario || mysqli_num_rows($resultado_correo_usuario) == 0) {
        die("Error al obtener el correo del usuario: " . mysqli_error($connection));
    }
    $row_correo_usuario = mysqli_fetch_assoc($resultado_correo_usuario);
    $correo_usuario = $row_correo_usuario['correo'];

    
    enviarCorreoConfirmacionRenovacion($titulo_libro, $autor_libro, $fecha_termino, $correo_usuario);

    // Redirigir a la página de prorrogas con un mensaje de éxito
    $_SESSION['mensaje'] = "El libro ha sido renovado exitosamente.";
    // Enviar el correo de confirmación de renovación
    header("Location: prorrogas.php");
    exit();
}

// Cerrar la conexión
mysqli_close($connection);
?>

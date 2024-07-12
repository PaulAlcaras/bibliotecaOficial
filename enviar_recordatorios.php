<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

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

// Consultar todos los usuarios con sus libros próximos a vencer o retrasados

$sql_usuarios_libros = "SELECT s.id_libro, l.titulo, l.autor, h.fecha_termino,
                        DATEDIFF(h.fecha_termino, CURDATE()) AS dias_restantes, u.correo 
                        FROM situacion s
                        INNER JOIN libros l ON s.id_libro = l.id_libro
                        INNER JOIN historial h ON s.id_libro = h.id_libro AND s.id_usuario = h.id_usuario
                        INNER JOIN usuarios u ON h.id_usuario = u.id_usuario  -- Join con la tabla usuarios para obtener el correo
                        WHERE h.fecha_termino <= CURDATE() + INTERVAL 2 DAY
                        ORDER BY h.fecha_termino;";

$resultado = mysqli_query($connection, $sql_usuarios_libros);

require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


if ($resultado && mysqli_num_rows($resultado) > 0) {
    // Array para almacenar los libros agrupados por correo de usuario
    $usuarios = [];

    while ($row = mysqli_fetch_assoc($resultado)) {
        //$id_usuario = $row['id_usuario'];
        $correo = $row['correo'];

        // Datos del libro
        $id_libro = $row['id_libro'];
        $titulo = $row['titulo'];
        $autor = $row['autor'];
        $fecha_termino = $row['fecha_termino'];
        $dias_restantes = $row['dias_restantes'];

        // Agrupar libros por correo de usuario
        $usuarios[$correo][] = [
            'id_libro' => $id_libro,
            'titulo' => $titulo,
            'autor' => $autor,
            'fecha_termino' => $fecha_termino,
            'dias_restantes' => $dias_restantes,
        ];
    }


    // Crear una instancia de PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Configuración del servidor
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'bibliotecateca.stgo@gmail.com'; // Tu dirección de correo de Gmail
        $mail->Password   = 'bvuh cdpt skfd vesc';          // Tu contraseña de Gmail
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        // Destinatarios
        $mail->setFrom('bibliotecateca.stgo@gmail.com', 'BibliotecaTeca');

        foreach ($usuarios as $correo => $libros) {
            $mensaje = "Estimado usuario,<br><br>";
            $mensaje .= "Estos son los libros que debe devolver:<br><br>";

            foreach ($libros as $libro) {
                $mensaje .= "- <strong>{$libro['titulo']}</strong> de {$libro['autor']} (";

                if ($libro['dias_restantes'] < 0) {
                    $mensaje .= "¡ATRASADO!";
                } else {
                    $mensaje .= "quedan {$libro['dias_restantes']} día(s)";
                }

                $mensaje .= ")<br>";
            }

            $mensaje .= "<br>Por favor, devuelva los libros a tiempo para evitar sanciones.<br><br>Gracias,<br>Su Biblioteca";

            // Añadir destinatario
            $mail->addAddress($correo);

            // Contenido del correo
            $mail->isHTML(true);
            $mail->Subject = 'Recordatorio de entrega de libros';
            $mail->Body    = $mensaje;

            // Enviar correo
            $mail->send();

            // Limpiar destinatarios para el próximo correo
            $mail->clearAddresses();
        }

        echo "Correos enviados correctamente";

    } catch (Exception $e) {
        echo "No se pudo enviar el correo. Error: {$mail->ErrorInfo}";
    }
} else {
    echo "No se encontraron libros próximos a vencer o retrasados.";
}

// Cerrar la conexión
mysqli_close($connection);
?>

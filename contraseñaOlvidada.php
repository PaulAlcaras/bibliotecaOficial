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

// Procesar el formulario si se ha enviado
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['correo'])) {
    try {
        // Conexión a la base de datos (ajusta los datos de conexión según tu configuración)
        $conexion = new mysqli("localhost", "root", "", "datos");

        if ($conexion->connect_error) {
            die("Error de conexión: " . $conexion->connect_error);
        }

        // Obtener el correo electrónico enviado por el usuario
        $correo = $_POST['correo'];

        // Consultar la contraseña asociada al correo en la base de datos
        $sql = "SELECT contraseña FROM usuarios WHERE correo = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $stmt->bind_result($contraseña_bd);
        $stmt->fetch();

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

            // Destinatario y contenido del correo
            $mail->setFrom('from@example.com', 'BibliotecaTeca');
            $mail->addAddress($correo); // Agregar el correo del usuario como destinatario
            $mail->isHTML(true);
            $mail->Subject = 'Renovar contraseña BibliotecaTeca';
            $mail->Body    = 'Ingrese a este <a href="http://localhost/aplicacion/restablecer_contraseña.php">enlace</a> para poder cambiarla.<br>Si usted no ha solicitado ningún cambio de contraseña, ignore este mensaje.';

            // Enviar correo
            $mail->send();
            $mensaje_enviado = 'Por favor revise su correo para restablecer su contraseña.';
           
        } else {
            $mensaje_error = "No se encontró ninguna cuenta asociada a ese correo electrónico.";
            
        }

        // Cerrar la conexión con la base de datos
        $stmt->close();
        $conexion->close();

    } catch (Exception $e) {
        $mensaje_error = "No se pudo enviar el correo. Error: {$mail->ErrorInfo}";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BiblioTecaTeca | Recuperar Contraseña</title>
  
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <link rel="icon" href="images/logooo.jpeg" type="image/x-icon">
</head>
<body class="login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="#">Biblio<b>TecaTeca</b></a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Recuperar Contraseña</p>

                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" placeholder="Correo" name="correo" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-8">
                            <p class="mt-2 mb-1">
                                <a href="login.php">Regresar a Iniciar Sesión</a>
                            </p>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Enviar</button>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </form>

                <?php if (!empty($mensaje_enviado)): ?>
                    <div class="alert alert-success mt-3" role="alert"><?php echo $mensaje_enviado; ?></div>
                <?php endif; ?>

                <?php if (!empty($mensaje_error)): ?>
                    <div class="alert alert-danger mt-3" role="alert"><?php echo $mensaje_error; ?></div>
                <?php endif; ?>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
</body>
</html>

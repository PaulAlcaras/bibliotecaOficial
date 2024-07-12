<?php
session_start();

// Validar datos del servidor
$user = "root";
$pass = "";
$host = "localhost";
$datab = "datos";

// Conectar a la base de datos
$connection = mysqli_connect($host, $user, $pass);

// Verificar la conexión a la base de datos
if (!$connection) {
    die("No se ha podido conectar con el servidor: " . mysqli_error($connection));
}

// Seleccionar la base de datos
$db = mysqli_select_db($connection, $datab);

if (!$db) {
    die("No se ha podido encontrar la Tabla: " . mysqli_error($connection));
}

// Verificar si se han recibido datos del formulario
if (isset($_POST["usuario"], $_POST["contraseña"])) {
    $usuario = $_POST["usuario"];
    $contraseña = $_POST["contraseña"];

    // Consultar si el usuario existe en la base de datos
    $consulta_usuario = "SELECT * FROM usuarios WHERE usuario='$usuario'";
    $resultado_usuario = mysqli_query($connection, $consulta_usuario);

    // Verificar si se encontraron resultados
    if (mysqli_num_rows($resultado_usuario) == 1) {
        // Obtener la información del usuario
        $usuario_info = mysqli_fetch_assoc($resultado_usuario);

        // Verificar si la contraseña proporcionada coincide con la contraseña almacenada
        if ($contraseña == $usuario_info['contraseña']) {
            $_SESSION['usuario'] = $usuario;
            // Usuario y contraseña válidos, redirigir al usuario a una página de éxito
            header("Location: index.php");
            exit();
        } else {
            //Contraseña incorrecta, mostrar mensaje de error
            $_SESSION['error'] = "Contraseña incorrecta";
            header("Location: login.php");
            exit();
        }
    } else {
        // Usuario no encontrado, mostrar mensaje de error
        $_SESSION['error'] = "Usuario no encontrado";
        header("Location: login.php");
        exit();
    }
}

// Cerrar la conexión con la base de datos
mysqli_close($connection);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BiblioTecaTeca | Inicio sesión</title>
    
    <link rel="icon" href="images/logooo.jpeg" type="image/x-icon">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&amp;display=fallback">
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="dist/css/adminlte.min.css">


</head>
<body class="login-page" style="min-height: 496.781px;">
    <div class="login-box">
        <div class="login-logo">
            <a>Biblio<b>TecaTeca</b></a>
        </div>
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Iniciar sesión</p>

                <form action="login.php" method="post">
                    <div id="toastsContainerTopRight" class="toasts-top-right fixed">
                        <?php if (isset($_SESSION['error'])): ?>
                            <div class="toast bg-danger fade show" role="alert" aria-live="assertive" aria-atomic="true">
                                <div class="toast-header">
                                    <strong class="mr-auto">Error</strong>   
                                </div>
                                <div class="toast-body"><?php echo $_SESSION['error']; ?></div>
                            </div>
                            <?php unset($_SESSION['error']); ?>
                        <?php endif; ?>
                    </div>                  

                   
                <form action="login.php" method="post">

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                        </div>
                        <input type="text" class="form-control" placeholder="Usuario" name="usuario" required>
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                        </div>
                        <input type="password" class="form-control" placeholder="Contraseña" name="contraseña" required>
                    </div>

                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                            </div>
                        </div>
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Entrar</button>
                        </div>
                    </div>
                </form>
                <p class="mb-1">
                    <a href="contraseñaOlvidada.php">Olvidé mi contraseña</a>
                </p>
                <p class="mb-0">
                    <a href="registroUsuario.php" class="text-center">Crear una cuenta</a>
                </p>
            </div>
        </div>
    </div>

    <script src="plugins/jquery/jquery.min.js"></script>
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="dist/js/adminlte.min.js"></script>

    <script>
        <?php if (isset($_SESSION['error'])): ?>
            toastr.error("<?php echo $_SESSION['error']; ?>");
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
    </script>

    <script>
        // Verificar si el usuario ya ha iniciado sesión
        <?php if (isset($_SESSION['usuario'])): ?>
            // Redirigir al usuario si intenta retroceder en el historial
            window.history.pushState(null, null, window.location.href);
            window.onpopstate = function () {
                window.location.href = 'login.php';
            };
        <?php endif; ?>
    </script>

   </body>
</html>


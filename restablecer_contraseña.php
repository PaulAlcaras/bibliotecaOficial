<?php
session_start();

// Validar datos del servidor
$user = "root";
$pass = "";
$host = "localhost";
$datab = "datos";

$connection = mysqli_connect($host, $user, $pass);

if (!$connection) {
    die("No se ha podido conectar con el servidor: " . mysqli_error($connection));
}

$db = mysqli_select_db($connection, $datab);

if (!$db) {
    die("No se ha podido encontrar la Tabla: " . mysqli_error($connection));
}

if (isset($_POST["usuario"], $_POST["contraseña"])) {
    $usuario = $_POST["usuario"];
    $contraseña = $_POST["contraseña"];

    $consulta_usuario = "SELECT * FROM usuarios WHERE usuario=?";
    $stmt = mysqli_prepare($connection, $consulta_usuario);
    mysqli_stmt_bind_param($stmt, "s", $usuario);
    mysqli_stmt_execute($stmt);
    $resultado_usuario = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($resultado_usuario) == 1) {
        $actualizar_contraseña = "UPDATE usuarios SET contraseña=? WHERE usuario=?";
        $stmt = mysqli_prepare($connection, $actualizar_contraseña);
        mysqli_stmt_bind_param($stmt, "ss", $contraseña, $usuario);
        mysqli_stmt_execute($stmt);

        $_SESSION['success'] = "Contraseña restablecida con éxito.";
        header("Location: restablecer_contraseña.php");
        exit();
    } else {
        $_SESSION['error'] = "Usuario no encontrado.";
        header("Location: restablecer_contraseña.php");
        exit();
    }
}

mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BiblioTecaTeca | Restablecer Contraseña</title>
  
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&amp;display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <link rel="icon" href="images/logooo.jpeg" type="image/x-icon">
</head>
<body class="login-page" style="min-height: 496.781px;">
    <div class="login-box">
        <div class="login-logo">
            <a>Biblio<b>TecaTeca</b></a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Restablecer Contraseña</p>

                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
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

                        <?php if (isset($_SESSION['success'])): ?>
                            <div class="toast bg-success fade show" role="alert" aria-live="assertive" aria-atomic="true">
                                <div class="toast-header">
                                    <strong class="mr-auto">Éxito</strong>
                                </div>
                                <div class="toast-body"><?php echo $_SESSION['success']; ?></div>
                            </div>
                            <?php unset($_SESSION['success']); ?>
                        <?php endif; ?>
                    </div>                  

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
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Restablecer Contraseña</button>
                        </div>
                    </div>
                </form>
                <p class="mt-3 mb-1">
                    <a href="login.php">Volver a iniciar sesión</a>
                </p>
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

    <script>
        <?php if (isset($_SESSION['error'])): ?>
            toastr.error("<?php echo $_SESSION['error']; ?>");
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
            toastr.success("<?php echo $_SESSION['success']; ?>");
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>
    </script>
</body>
</html>

<?php
session_start();

$user = "root";
$pass = "";
$host = "localhost";
$datab = "datos";

$connection = mysqli_connect($host, $user, $pass);

if (!$connection) {
    echo "No se ha podido conectar con el servidor: " . mysqli_connect_error();
    exit();
}

$db = mysqli_select_db($connection, $datab);

if (!$db) {
    echo "No se ha podido encontrar la Tabla";
    exit(); 
}

if (isset($_POST["nombre"], $_POST["usuario"], $_POST["genero"], $_POST["nacimiento"], $_POST["direccion"], $_POST["telefono"], $_POST["contraseña"], $_POST["correo"])) {
    $nombre = $_POST["nombre"];
    $usuario = $_POST["usuario"];
    $genero = $_POST["genero"];
    $nacimiento = $_POST["nacimiento"];
    $direccion = $_POST["direccion"];
    $telefono = $_POST["telefono"];
    $contraseña = $_POST["contraseña"];
    $correo = $_POST["correo"];
    $imagen = 'default.png';

    $errores = array();

    $consulta_usuario = "SELECT * FROM usuarios WHERE usuario='$usuario'";
    $resultado_usuario = mysqli_query($connection, $consulta_usuario);
    $consulta_correo = "SELECT * FROM usuarios WHERE correo='$correo'";
    $resultado_correo = mysqli_query($connection, $consulta_correo);

    if (mysqli_num_rows($resultado_usuario) > 0) {
        $errores[] = "El usuario ya existe. Por favor, elija otro.";
    } 

    if (mysqli_num_rows($resultado_correo) > 0) {
        $errores[] = "El correo ya existe. Por favor, ingrese otro.";
    } 

    if ($_POST["contraseña"] != $_POST["contraseña2"]) {
        $errores[] = "Las contraseñas no coinciden.";
    }

    if (!empty($errores)) {
        $_SESSION['errores'] = $errores;
    } else {
        $instruccion_SQL = "INSERT INTO usuarios (nombre, usuario, genero, nacimiento, direccion, telefono, contraseña, correo)
                            VALUES ('$nombre', '$usuario', '$genero', '$nacimiento', '$direccion', '$telefono', '$contraseña', '$correo')";

        $resultado = mysqli_query($connection, $instruccion_SQL);

        if ($resultado) {
            $_SESSION['success'] = "¡La cuenta se ha creado exitosamente! Por favor, inicia sesión.";
           // header("Location: registroUsuario.php");
        } else {
            $_SESSION['error'] = "Error al registrar el usuario: " . mysqli_error($connection);
        }

    }
    
}

mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BiblioTecaTeca | Registro</title>
  
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&amp;display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="icon" href="images/logooo.jpeg" type="image/x-icon">


</head>
<body class="register-page" style="min-height: 570.781px;">
    <div class="register-box">
        <div class="register-logo">
            <a>Biblio<b>TecaTeca</b></a>
        </div>
      
        <div class="card">
            <div class="card-body register-card-body">
                <p class="login-box-msg">Registro nuevo usuario</p>

                <div id="toastsContainerTopRight" class="toasts-top-right fixed">
                    <?php if (isset($_SESSION['errores'])): ?>
                        <?php foreach ($_SESSION['errores'] as $error): ?>
                            <div class="toast bg-danger fade show" role="alert" aria-live="assertive" aria-atomic="true">
                                <div class="toast-header">
                                    <strong class="mr-auto">Error</strong>
                                </div>
                                <div class="toast-body"><?php echo $error; ?></div>
                            </div>
                        <?php endforeach; ?>
                        <?php unset($_SESSION['errores']); ?>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['success'])): ?>
                            <div class="toast bg-success fade show" role="alert" aria-live="assertive" aria-atomic="true">
                                <div class="toast-header">
                                    <strong class="mr-auto"><?php echo $_SESSION['success']?></strong>
                                </div>        
                            </div>
                        <?php unset($_SESSION['success']); ?>
                    <?php endif; ?>
                </div>

                <form id="registroForm" action="registroUsuario.php" method="POST">
                    <label>Nombre:</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-address-card"></i></span>
                      </div>
                      <input type="text" class="form-control" placeholder="Nombre" name="nombre" value="<?php echo isset($_POST['nombre']) ? htmlspecialchars($_POST['nombre']) : ''; ?>" required>
                  </div>
                    <label>Usuario:</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                        </div>
                        <input type="text" class="form-control" placeholder="Usuario" name="usuario" value="<?php echo isset($_POST['usuario']) ? htmlspecialchars($_POST['usuario']) : ''; ?>" required>
                    </div>
                    <label>Correo electrónico:</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        </div>
                        <input type="email" class="form-control" placeholder="Correo electrónico" name="correo" value="<?php echo isset($_POST['correo']) ? htmlspecialchars($_POST['correo']) : ''; ?>" required>
                    </div>                  
                    <label>Género:</label>
                    <div class="input-group mb-3">
                    <div class="input-group-append">
                          <div class="input-group-text">
                              <span class="fas fa-venus-mars"></span>
                          </div>
                      </div>
                      <select class="form-control" name="genero" required>                      
                          <option value="otro">Otro</option>
                          <option value="hombre">Hombre</option>
                          <option value="mujer">Mujer</option>
                      </select> 
                  </div>
                    <label>Fecha de nacimiento:</label>
                    <div class="input-group mb-3">
                    <div class="input-group-append">
                          <div class="input-group-text">
                              <span class="fas fa-calendar-alt"></span>
                          </div>
                      </div>
                      <input type="date" class="form-control" name="nacimiento" value="<?php echo isset($_POST['nacimiento']) ? htmlspecialchars($_POST['nacimiento']) : ''; ?>" required>
                  </div>
                    <label>Dirección:</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                        </div>
                        <input type="text" class="form-control" placeholder="Direccion" name="direccion" value="<?php echo isset($_POST['direccion']) ? htmlspecialchars($_POST['direccion']) : ''; ?>" required>
                    </div>
                    <label>Teléfono:</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                        </div>
                        <input type="number" class="form-control" placeholder="Telefono" name="telefono" value="<?php echo isset($_POST['telefono']) ? htmlspecialchars($_POST['telefono']) : ''; ?>" required>
                    </div>
                    <label>Contraseña:</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        </div>
                        <input type="password" class="form-control" placeholder="Contraseña" name="contraseña" id="contraseña" required>
                        <div class="input-group-append">
                            <span class="input-group-text" onclick="togglePasswordVisibility()">
                                <i class="fas fa-eye-slash" id="togglePassword"></i>
                            </span>
                        </div>
                    </div>
                    <label>Reescriba contraseña:</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        </div>
                        <input type="password" class="form-control" placeholder="Reescriba contraseña" name="contraseña2" id="contraseña2" required>
                        <div class="input-group-append">
                            <span class="input-group-text" onclick="togglePasswordVisibility2()">
                                <i class="fas fa-eye-slash" id="togglePassword2"></i>
                            </span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <button id="registroBtn" type="submit" class="btn btn-primary btn-block">Registrar</button>      
                        </div>
                    </div>
                </form>
          
                <div class="row">
                  <div class="col-12 text-center mt-3">
                      <a href="login.php" style="font-size: 18px;">Ya tengo una cuenta</a>
                  </div>
              </div>
            </div>
        </div>
    </div>
    <!-- /.register-box -->
     <!-- jQuery -->
     <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
    <!-- Toastr -->
    <script src="plugins/toastr/toastr.min.js"></script>
    <!-- SweetAlert2 -->         
    <script src="plugins/sweetalert2/sweetalert2.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

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



    <script>
    function togglePasswordVisibility() {
        var passwordInput = document.getElementById("contraseña");
        var toggleIcon = document.getElementById("togglePassword");

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            toggleIcon.classList.remove("fa-eye-slash");
            toggleIcon.classList.add("fa-eye");
        } else {
            passwordInput.type = "password";
            toggleIcon.classList.remove("fa-eye");
            toggleIcon.classList.add("fa-eye-slash");
        }
    }

    function togglePasswordVisibility2() {
        var passwordInput = document.getElementById("contraseña2");
        var toggleIcon = document.getElementById("togglePassword2");

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            toggleIcon.classList.remove("fa-eye-slash");
            toggleIcon.classList.add("fa-eye");
        } else {
            passwordInput.type = "password";
            toggleIcon.classList.remove("fa-eye");
            toggleIcon.classList.add("fa-eye-slash");
        }
    }
    </script>


    
</body>
</html>

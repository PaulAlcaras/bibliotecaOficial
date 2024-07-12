<?php
// Datos de conexión a la base de datos
$user = "root";
$pass = "";
$host = "localhost";
$database = "datos";

// Conectar a la base de datos
$connection = mysqli_connect($host, $user, $pass, $database);

// Verificar la conexión
if (!$connection) {
    die("Error al conectar a la base de datos: " . mysqli_connect_error());
}

// Iniciar sesión
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

// Obtener el nombre de usuario de la sesión
$usuario = $_SESSION['usuario'];

// Consulta SQL para obtener los datos del usuario en sesión
$sql = "SELECT * FROM usuarios WHERE usuario = '$usuario'";

$resultado = mysqli_query($connection, $sql);

// Verificar si hay resultados
if (mysqli_num_rows($resultado) > 0) {
    $row = mysqli_fetch_assoc($resultado);
} else {
    echo "No se encontraron datos para el usuario: $usuario";
}

// Cerrar la conexión
mysqli_close($connection);
?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>BiblioTecaTeca | Perfil</title>
      
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&amp;display=fallback">
        <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
        <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
        <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
        <link rel="stylesheet" href="dist/css/adminlte.min.css">
        <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
        <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
        <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
        <link rel="icon" href="images/logooo.jpeg" type="image/x-icon">
      </head>

    <body class="sidebar-mini layout-fixed sidebar-open sidebar-collapse" style="height: auto;">
        <div class="wrapper">
        

          <div class="preloader flex-column justify-content-center align-items-center" style="height: 0px;">
            <img class="animation__shake" src="images/logo.jpg" alt="AdminLTELogo" height="60" width="60" style="display: none;">
          </div>
        
          <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
              </li>
            </ul>
        
          <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="index.php" class="brand-link">
              <img src="images/logo.jpg" alt="Biblio Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
              <span class="brand-text font-weight-light">BiblioTecaTeca</span>
            </a>
        
            <div class="sidebar os-host os-theme-light os-host-resize-disabled os-host-transition os-host-foreign os-host-scrollbar-vertical-hidden os-host-overflow os-host-overflow-x">
              <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                  <img src="uploads/<?php echo $row['imagen']; ?>" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                  <a href="usuario.php" class="d-block" id="nombre-usuario-real"><?php echo $usuario; ?></a>
                </div>
              </div>
        
              <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="index.php" class="nav-link">
                      <i class="fas fa-home"></i>
                      <p>Inicio</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="en_prestamo.php" class="nav-link">
                      <i class="fas fa-book-open"></i>
                      <p>En poder</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="historial.php" class="nav-link">
                      <i class="fas fa-book"></i>
                      <p>Historial</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="index.php" class="nav-link">
                      <i class="fas fa-heart"></i>
                      <p>Lista deseos</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="prorrogas.php" class="nav-link">
                      <i class="fas fa-clock"></i>
                      <p>Prórrogas</p>
                    </a>
                  </li>
              <li class="nav-item">
                <a href="usuario.php" class="nav-link">
                  <i class="fas fa-user"></i>
                  <p>Perfil</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="sobrenosotros.php" class="nav-link">
                  <i class="fas fa-arrow-alt-circle-right"></i>
                  <p>Sobre nosotros</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="login.php" class="nav-link">
                  <i class="fas fa-key"></i>
                  <p>Cerrar sesion</p>
                </a>
              </li>
            </ul>
          </nav>
            </div>
        </div>
    </div>
    <div class="os-scrollbar os-scrollbar-horizontal os-scrollbar-unusable os-scrollbar-auto-hidden">
        <div class="os-scrollbar-track">
            <div class="os-scrollbar-handle" style="width: 100%; transform: translate(0px, 0px);">
            </div>
        </div>
    </div>
    <div class="os-scrollbar os-scrollbar-vertical os-scrollbar-unusable os-scrollbar-auto-hidden">
        <div class="os-scrollbar-track">
            <div class="os-scrollbar-handle" style="height: 100%; transform: translate(0px, 0px);">
            </div>
        </div>
    </div>
    <div class="os-scrollbar-corner">
    </div>
    </div>
          </aside>
          <div class="content-wrapper" style="min-height: 559px;">
            <div class="content-header">
              <div class="container-fluid">
                <div class="row mb-2">
                  <div class="col-sm-6">
                    <h1 class="m-0">Perfil</h1>
                  </div>
                </div>
              </div>
            </div>

            <section class="content">
              <div class="container-fluid">
                            <div class="card card-primary card-outline">
                                <div class="card-body box-profile">
                                  <div class="text-center">
                                    <img class="profile-user-img img-fluid img-circle" src="uploads/<?php echo $row['imagen']; ?>" alt="User profile picture">
                                  </div>
                  
                                  <h3 class="profile-username text-center" id="nombre-usuario-real">
                                    <?php echo $usuario; ?>
                                </h3>
                                <ul class="list-group list-group-unbordered mb-3">
                                    <li class="list-group-item">
                                        <b>Nombre</b> <span class="float-right"><?php echo $row['nombre']; ?></span>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Gmail</b> <span class="float-right"><?php echo $row['correo']; ?></span>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Género</b> <span class="float-right"><?php echo $row['genero']; ?></span>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Nacimiento</b> <span class="float-right"><?php echo $row['nacimiento']; ?></span>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Dirección</b> <span class="float-right"><?php echo $row['direccion']; ?></span>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Teléfono</b> <span class="float-right"><?php echo $row['telefono']; ?></span>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Correo electrónico</b> <span class="float-right"><?php echo $row['correo']; ?></span>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Desde</b> <span class="float-right"><?php echo $row['fecha_registro']; ?></span>
                                    </li>
                                </ul>
                                <a href="editarusuario.php" class="btn btn-primary btn-block"><b>Editar perfil</b></a></div>
                        </div>
                    </div>
              </div>
            </section>
          </div>
          <footer class="main-footer">
            <strong>Copyright © 2024 <a href="https://adminlte.io">BiblioTecaTeca</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
              <b>Version</b> 1.0
            </div>
          </footer>
        
        <script src="plugins/jquery/jquery.min.js"></script>
        <script src="plugins/jquery-ui/jquery-ui.min.js"></script>
        <script>
          $.widget.bridge('uibutton', $.ui.button)
        </script>
        <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="plugins/chart.js/Chart.min.js"></script>
        <script src="plugins/sparklines/sparkline.js"></script>
        <script src="plugins/jqvmap/jquery.vmap.min.js"></script>
        <script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
        <script src="plugins/jquery-knob/jquery.knob.min.js"></script>
        <script src="plugins/moment/moment.min.js"></script>
        <script src="plugins/daterangepicker/daterangepicker.js"></script>
        <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
        <script src="plugins/summernote/summernote-bs4.min.js"></script>
        <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
        <script src="dist/js/adminlte.js"></script>
        <script src="dist/js/pages/dashboard.js"></script>
    
        <div class="jqvmap-label" style="display: none;">
        </div>

    <div class="jqvmap-label" style="display: none;"></div></body>
</html>
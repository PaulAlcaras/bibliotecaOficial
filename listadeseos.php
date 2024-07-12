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

// Obtener el id del usuario
$sql_usuario = "SELECT id_usuario, imagen FROM usuarios WHERE usuario = '$usuario'";
$result_usuario = mysqli_query($connection, $sql_usuario);
$row_usuario = mysqli_fetch_assoc($result_usuario);
$id_usuario = $row_usuario['id_usuario'];
$imagen_perfil = $row_usuario['imagen'] ?? 'default.jpg'; // Si no hay imagen en la base de datos, se usa 'default.jpg'

// Obtener la lista de deseos del usuario con los nombres de libros y autores
$sql_lista_deseos = "SELECT ld.id_libro, l.titulo, l.autor
                     FROM lista_deseos ld
                     INNER JOIN libros l ON ld.id_libro = l.id_libro
                     WHERE ld.id_usuario = '$id_usuario'";

$resultado_lista_deseos = mysqli_query($connection, $sql_lista_deseos);

// Cerrar la conexión
mysqli_close($connection);
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BiblioTecaTeca | Lista deseos</title>
  
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
    <style>
      .table-container {
        display: flex;
        justify-content: center;
      }
    </style>
</head>

<body class="sidebar-mini layout-fixed sidebar-open sidebar-collapse" style="height: auto;">
    <div class="wrapper">
    
      <!-- Preloader -->
      <div class="preloader flex-column justify-content-center align-items-center" style="height: 0px;">
        <img class="animation__shake" src="images/logo.jpg" alt="AdminLTELogo" height="60" width="60" style="display: none;">
      </div>
    
      <!-- Navbar -->
      <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
          </li>
        </ul>
    
      <!-- Main Sidebar Container -->
      <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="index.php" class="brand-link">
          <img src="images/logo.jpg" alt="Biblio Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
          <span class="brand-text font-weight-light">BiblioTecaTeca</span>
        </a>
    
        <!-- Sidebar -->
        <div class="sidebar os-host os-theme-light os-host-resize-disabled os-host-transition os-host-foreign os-host-scrollbar-vertical-hidden os-host-overflow os-host-overflow-x">
          <!-- Sidebar user panel (optional) -->
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
              <img src="uploads/<?php echo $imagen_perfil; ?>" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
              <a href="usuario.php" class="d-block"><?php echo $usuario; ?></a>
            </div>
          </div>
    
          <!-- Sidebar Menu -->
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
                    <a href="listadeseos.php" class="nav-link">
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
                      <i class="fas fa-info-circle"></i>
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
    
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper" style="min-height: 559px;">
        <!-- Content Header (Page header) -->
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0">Lista deseos</h1>
              </div>
            </div>
          </div>
        </div>
         <!-- Main content -->
      <section class="content align-items-center">
            <div class="container-fluid">
              <div class="row">
                <?php while ($row_lista_deseos = mysqli_fetch_assoc($resultado_lista_deseos)) : ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title"><?php echo $row_lista_deseos['titulo']; ?></h3>
                                <p class="card-text">Autor: <?php echo $row_lista_deseos['autor']; ?></p>
                                <div class="d-flex justify-content-center">
                                <!-- Botón para pedir el libro -->
                                <form action="agregar_pedido.php" method="post">
                                  <input type="hidden" name="id_libro" value="<?php echo $row_lista_deseos['id_libro']; ?>">
                                  <button type="submit" class="btn btn-info mt-2">Pedir</button>
                                </form>
                                <!-- Formulario para eliminar de la lista de deseos -->
                                <form action="eliminar_lista_deseos.php" method="post">
                                  <input type="hidden" name="id_libro" value="<?php echo $row_lista_deseos['id_libro']; ?>">
                                  <button type="submit" class="btn btn-danger mt-2">Eliminar</button>
                                </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
          </div>
        </section>
        <!-- /.content -->
      </div>
      
     




      <footer class="main-footer">
        <strong>Copyright © 2024 <a href="https://adminlte.io">BiblioTecaTeca</a>.</strong>
        All rights reserved.
        <div class="float-right d-none d-sm-inline-block">
          <b>Version</b> 1.1
        </div>
      </footer>

    <div id="sidebar-overlay"></div></div>
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
    <div class="jqvmap-label" style="display: none;"></div>
    <div class="jqvmap-label" style="display: none;"></div></body>
</html>

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
        <title>BiblioTecaTeca | Quienes somos</title>
      
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
                  <a href="usuario.php" class="d-block"><?php echo $usuario; ?></a>
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
                  <p>
                    Perfil
                  </p>
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
                    <h1 class="m-0">Quienes somos</h1>
                  </div>
                  <div class="col-sm-6"> 
                  </div>
                </div>
              </div>
            </div>

            <section class="content">
              <div class="container-fluid">
                <div class="row">
                    <div class="row" style="margin: auto">
                        <div class="container">
                          <div class="row justify-content-center">
                              <div class="col-lg-8">
                                  <div class="card card-primary card-outline">

                                      <div id="collapseOne" class="collapse show" data-parent="#accordion">
                                          <div class="card-body">
                                              <b>Misión:</b><br>
                                                  La Biblioteca de Santiago, dependiente del Servicio Nacional del Patrimonio Cultural,
                                                  es una biblioteca pública modelo, que entrega servicios innovadores con calidad y equidad, 
                                                  generando igualdad de oportunidades en el acceso a la información, conocimiento, recreación, 
                                                  cultura, educación y fomento a la lectura y escritura, a las y los habitantes de la Región Metropolitana 
                                                  y a las usuarias y usuarios del Sistema Nacional de Bibliotecas Públicas del país, mediante un modelo 
                                                  de gestión que contempla la entrega presencial y virtual de servicios a la comunidad.
                                              <br><br><b>Visión:</b><br>
                                                  La Biblioteca de Santiago pretende continuar siendo el modelo de biblioteca pública para el país. 
                                                  Consolidándose como un espacio comunitario, inclusivo y pluralista que entrega servicios de 
                                                  información bibliográfica, actividades culturales y de fomento a la lectura y escritura, atendiendo
                                                  las demandas de conocimiento, información, educación, cultura y recreación de la comunidad.  
                                              <br><br><b>Objetivos estratégicos:</b><br>
                                                  1. Ampliar permanentemente la cobertura de la Biblioteca de Santiago y sus servicios tanto presenciales como virtuales.<br>
                                                  2. Contribuir al fomento lector y escritor, siendo un actor destacado en la promoción de la lectura y escritura.<br>
                                                  3. Consolidar la biblioteca como un espacio de participación plural, permitiendo el acceso de los diversos actores y expresiones de la comunidad.<br>
                                                  4. Contribuir a la formación de la comunidad, a través de acciones que permitan generar herramientas de productividad y desarrollo.<br>
                                                  5. Ampliar permanentemente el acceso y la capacitación en nuevas tecnologías.<br>
                                                  6. Ser modelo para el Sistema Nacional de Bibliotecas Públicas chilenas, apoyando la gestión, modernización e innovación, teniendo como eje las necesidades de la comunidad.<br>
                                                  7. Implementar un modelo formal de participación comunitaria, que permita apoyar la gestión de la biblioteca.<br>
                                                  8. Generar alianzas externas que vayan en directo beneficio de la comunidad.<br>
                                                  9. Consolidar un ecosistema digital que permita digitalizar nuestros servicios y acercar a las nuevas audiencias digitales a nuestra comunidad.<br>

                                                  <div class="card-body text-center">
                                                      <img src="images/biblioteca.jpg" alt="Biblioteca1" height="250" width="250">
                                                      <img src="images/biblioteca2.jpg" alt="Biblioteca2" height="250" width="250">
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>

                      <div class="container">
                          <div class="row justify-content-center">
                              <div class="col-lg-6">

                                  <div class="card card-primary card-outline center">
                                      <a class="d-block w-100" data-toggle="collapse" href="#collapseOne">
                                          <div class="card-header">
                                              <h4 class="card-title w-100">
                                                  <b>Contacto</b>
                                              </h4>
                                          </div>
                                      </a>
                                      <div id="collapseOne" class="collapse show" data-parent="#accordion">
                                          <div class="card-body">
                                              <p><b>Número telefono:</b> +56 9 1234 5678</p>
                                              <p><b>Dirección:</b> Avenida Matucana 151, Santiago Centro, Santiago</p>
                                              <p><b>Maps:</b> 
                                              <a href="https://www.google.com/maps?sca_esv=cd1cd8ba04cfc6b9&sca_upv=1&rlz=1C1OKWM_enCL1050CL1050&output=search&q=Av.+Matucana+151,+Santiago,+Región+Metropolitana" target="_blank">
                                                  Av. Matucana 151, Santiago, Región Metropolitana
                                              </a></p>
                                              <p><b>Correo:</b> bibliotecateca.stgo@gmail.com</p>
                                            </div>
                                          </div>
                                      </div>

                                      <div class="col-lg-6">

                                        <div class="card card-primary card-outline center">
                                            <a class="d-block w-100" data-toggle="collapse" href="#collapseTwo">
                                                <div class="card-header">
                                                    <h4 class="card-title w-100">
                                                        <b>Horarios</b>
                                                    </h4>
                                                </div>
                                            </a>
                                            <div id="collapseTwo" class="collapse show" data-parent="#accordion">
                                                <div class="card-body">
                                                    <p><b>Lunes: </b>Cerrado</p>
                                                    <p><b>Martes:</b> 11 a.m. - 7:15 p.m.</p>
                                                    <p><b>Miércoles:</b> 11 a.m. - 7:15 p.m.</p>
                                                    <p><b>Jueves:</b> 11 a.m. - 7:15 p.m.</p>
                                                    <p><b>Viernes:</b> 11 a.m. - 7:15 p.m.</p>
                                                    <p><b>Sábado:</b> 11:30 a.m. - 5 p.m.</p>
                                                    <p><b>Domingo:</b> 11:30 a.m. - 5 p.m.</p>
                                                </div>
                                            </div>
                                        </div>   

                                    </div>


                                  </div>
                              </div>
                              
                          </div>
                      </div>
                </div>
                <div class="row">
                  <section class="col-lg-7 connectedSortable ui-sortable">
                    <div class="card">
                    </div>
                  </section>
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
        <!-- AdminLTE for demo purposes -->
        <script src="dist/js/demo.js"></script>
        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        <script src="dist/js/pages/dashboard.js"></script>
    
        <div class="jqvmap-label" style="display: none;">
        </div>

    <div class="jqvmap-label" style="display: none;"></div></body>
</html>
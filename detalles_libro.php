
<?php
// Validar datos del servidor
$user = "root";
$pass = "";
$host = "localhost";
$datab = "datos";


// Conectar a la base de datos
$connection = mysqli_connect($host, $user, $pass);
session_start();

// Verificar la conexión a la base de datos
if (!$connection) {
    die("No se ha podido conectar con el servidor: " . mysqli_error($connection));
}

// Seleccionar la base de datos
$db = mysqli_select_db($connection, $datab);

if (!$db) {
    die("No se ha podido encontrar la Tabla: " . mysqli_error($connection));
}

// Renovar la sesión si ha pasado más de 30 minutos desde la última actividad
if (isset($_SESSION['ultimo_acceso']) && (time() - $_SESSION['ultimo_acceso'] > 1800)) {
    session_regenerate_id(true);
    $_SESSION['ultimo_acceso'] = time();
}

// Actualizar el tiempo de última actividad en cada carga de página
$_SESSION['ultimo_acceso'] = time();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    // Si el usuario no ha iniciado sesión, redirigirlo al formulario de inicio de sesión
    header("Location: login.php");
    exit();
}

// Obtener el nombre de usuario si está iniciada la sesión
$usuario = $_SESSION['usuario'];

// Obtener la imagen de perfil del usuario
$sql = "SELECT imagen FROM usuarios WHERE usuario = '$usuario'";
$resultado = mysqli_query($connection, $sql);
$row = mysqli_fetch_assoc($resultado);
$imagen_perfil = $row['imagen'] ?? 'default.jpg'; // Si no hay imagen en la base de datos, se usa 'default.jpg'


// Cerrar la conexión con la base de datos
mysqli_close($connection);
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>BiblioTecaTeca | Detalles</title>
      
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
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="icon" href="images/logooo.jpeg" type="image/x-icon">
      
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
            <a href="index.png" class="brand-link">
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
                    <a href="index.php" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Regresar
                    </a>
                  </div>
                </div>
              </div>
            </div>
          
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-11 ml-5 connectedSortable ui-sortable">
                        <!-- Detalles del libro -->
                        <div class="card">
                            <div class="card-body">
                             <?php
                            // Verificar si se proporcionó un ID de libro en la URL
                            if(isset($_GET['id'])) {
                                $bookId = $_GET['id'];
                                $id_libro = $_GET['id'];

                                $apiUrl = "https://www.googleapis.com/books/v1/volumes/{$bookId}";
                                $bookData = json_decode(file_get_contents($apiUrl), true);

                                if(isset($bookData['volumeInfo'])) {
                                    $bookInfo = $bookData['volumeInfo'];

                                    echo '<div class="row">';

                                    // Mostrar la imagen del libro con margen
                                    if(isset($bookInfo['imageLinks']) && isset($bookInfo['imageLinks']['thumbnail'])) {
                                        echo "<div class=\"col-md-3\">";
                                        echo "<img src=\"{$bookInfo['imageLinks']['thumbnail']}\" alt=\"Imagen del libro\">";
                                        echo "</div>";
                                    }

                                    // Contenedor para el título, autor, año y puntuación
                                    echo "<div class=\"col-md-8\">";

                                    // Mostrar los detalles del libro
                                    echo "<h2>{$bookInfo['title']}</h2>";
                                    echo "<p><strong>Autor(es):</strong> ";
                                    echo isset($bookInfo['authors']) ? implode(", ", $bookInfo['authors']) : "Desconocido";
                                    echo "</p>";
                                    echo "<p><strong>Año de publicación:</strong> ";
                                    echo isset($bookInfo['publishedDate']) ? substr($bookInfo['publishedDate'], 0, 4) : "Desconocido";
                                    echo "</p>";

                                    if(isset($bookInfo['averageRating'])) {
                                      $max_stars = 5;
                                      echo "<p>Puntaje:    ";
                                      $rating = $bookInfo['averageRating'];
                                      $filled_stars = intval($rating);
                                      $empty_stars = $max_stars - $filled_stars;

                                      for($i = 0; $i < $filled_stars; $i++) {
                                          echo "<i class=\"fas fa-star\"></i>";
                                      }

                                      for($i = 0; $i < $empty_stars; $i++) {
                                          echo "<i class=\"far fa-star\"></i>";
                                      }
                                      echo " ($rating)";
                                      echo "</p>";
                                  }   


                                    echo "<div class=\"row\">";
                                    echo "<div class=\"col-md-12\">";
                                    echo "<div class=\"mt-3\">";

                                    echo "<div class=\"d-flex\">";

                                    echo "<form action=\"agregar_pedido.php\" method=\"POST\">";
                                    echo "<input type=\"hidden\" name=\"id_libro\" value=\"$id_libro \">";
                                    echo "<button type=\"submit\" class=\"btn btn-info\">Pedir</button>";
                                    echo "</form>";

                                    echo "<form action=\"agregar_listadeseos.php\" method=\"POST\">";
                                    echo "<input type=\"hidden\" name=\"id_libro\" value=\"$id_libro \">";
                                    echo "<button type=\"submit\" class=\"btn btn-danger\">Agregar a la lista de deseos</button>";
                                    echo "</form>";
                                    echo "</div>";

                                    echo "</div>";
                                    echo "</div>";
                                    echo "</div>";

                                    echo "</div>";
                                    echo '</div>';

                                    
                                    if(isset($_SESSION['mensaje'])): 
                                        echo "<div class='alert alert-success alert-dismissible float-right' role='alert'>";
                                        echo "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>";
                                        echo "<span aria-hidden='true'>&times;</span>";
                                        echo "</button>";
                                        echo $_SESSION['mensaje'];
                                        echo "</div>";
                                        unset($_SESSION['mensaje']); 
                                    endif; 
                                    
                                    echo "<div class=\"row\">";
                                    echo "<div class=\"col-md-12\">";
                                    echo "<br><h4>Descripción</h4>";
                                    echo isset($bookInfo['description']) ? $bookInfo['description'] : "Descripción no disponible.";
                                    echo "</p>";
                                    echo "</div>";
                                    echo "</div>";

                                    echo "<div class=\"row\">";
                                    echo "<div class=\"col-md-12\">";
                                    echo "<div class=\"card\">";
                                    echo "<div class=\"card-header\">";
                                    echo "<h3 class=\"card-title\">Dejar un comentario</h3>";
                                    echo "</div>";
                                    echo "<div class=\"card-body\">";
                                    echo "<form action=\"procesar_comentario.php\" method=\"POST\">";
                                    echo "<div class=\"form-group\">";
                                    echo "<label for=\"calificacion\">Calificación:</label>";
                                    echo "<input type=\"text\" class=\"form-control\" id=\"calificacion\" name=\"calificacion\" placeholder=\"Calificación (1-5)\">";
                                    echo "</div>";
                                    echo "<div class=\"form-group\">";
                                    echo "<label for=\"comentario\">Comentario:</label>";
                                    echo "<textarea class=\"form-control\" id=\"comentario\" name=\"comentario\" rows=\"3\" placeholder=\"Escribe tu comentario aquí\"></textarea>";
                                    echo "</div>";
                                    echo "<input type=\"hidden\" name=\"id_libro\" value=\"$id_libro\">";
                                    echo "<button type=\"submit\" class=\"btn btn-primary\">Enviar comentario</button>";
                                    echo "</form>";
                                    echo "</div>";
                                    echo "</div>";
                                    echo "</div>";
                                    echo "</div>";

                                    echo "<div class=\"row\">";
                                    echo "<div class=\"col-md-12\">";
                                    echo "<h3>Comentarios de otros usuarios</h3>";

                                    $servername = "localhost";
                                    $username = "root";
                                    $password = "";
                                    $database = "datos";

                                    $conn = new mysqli($servername, $username, $password, $database);

                                    if ($conn->connect_error) {
                                        die("Error de conexión: " . $conn->connect_error);
                                    }

                                    // Consulta para obtener los comentarios del libro con los nombres de usuario
                                    $sql = "SELECT r.calificacion, r.comentario, u.usuario 
                                            FROM reseñas r 
                                            INNER JOIN usuarios u ON r.id_usuario = u.id_usuario 
                                            WHERE r.id_libro = '$id_libro'";

                                    $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    $max_stars = 5;
                                    while($row = $result->fetch_assoc()) {
                                        $calificacion = $row['calificacion'];
                                        $filled_stars = intval($calificacion);
                                        $empty_stars = $max_stars - $filled_stars;

                                        echo "<div class=\"media\">";
                                        echo "<div class=\"media-body\">";
                                        echo "<h5 class=\"mt-0\">{$row['usuario']}";

                                        echo "<div>";
                                        for($i = 0; $i < $filled_stars; $i++) {
                                            echo "<i class=\"fas fa-star\"></i>";
                                        }

                                        for($i = 0; $i < $empty_stars; $i++) {
                                            echo "<i class=\"far fa-star\"></i>";
                                        }
                                        echo "</div>";

                                        echo "</h5>";
                                        echo "<p>{$row['comentario']}</p>";
                                        echo "</div>";
                                        echo "</div>";
                                    }
                                } else {
                                    echo "No hay comentarios para este libro.";
                                }
                                    $conn->close();

                                    if(isset($_SESSION['mensaje'])) {
                                      echo "<div class='alert alert-success'>{$_SESSION['mensaje']}</div>";
                                      unset($_SESSION['mensaje']);
                                  }

                                    echo "</div>";
                                    echo "</div>";

                                } else {
                                    echo "<p>No se encontraron detalles para este libro.</p>";
                                }
                            } else {
                                echo "<p>Error: No se proporcionó un ID de libro.</p>";
                            }
                            ?>

                            </div>
                        </div>
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
        
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

      <script>
          document.getElementById('addToWishlistButton').addEventListener('click', function() {

          var idLibro = this.getAttribute('data-id-libro');
          
          // Envía una solicitud AJAX al servidor para guardar el id_libro en la tabla lista_deseos
          var xhr = new XMLHttpRequest();
          xhr.open('POST', 'guardar_lista_deseos.php');
          xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
          xhr.onload = function() {
              if (xhr.status === 200) {
                  // La solicitud fue exitosa, muestra un mensaje de exito
                  alert('El libro se agregó a tu lista de deseos correctamente.');
              } else {
                  // Hubo un error al procesar la solicitud, muestra un mensaje de error
                  alert('Ocurrió un error al agregar el libro a tu lista de deseos. Por favor, inténtalo de nuevo más tarde.');
              }
          };
          xhr.send('id_libro=' + encodeURIComponent(idLibro));
      });
    </script>

        <!-- jQuery -->
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

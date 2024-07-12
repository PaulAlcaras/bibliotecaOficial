<?php
// Validar datos del servidor
$user = "root";
$pass = "";
$host = "localhost";

// Conectar a la base de datos
$connection = mysqli_connect($host, $user, $pass);
session_start();

// Verificar la conexión a la base de datos
if (!$connection) {
    die("No se ha podido conectar con el servidor: " . mysqli_error($connection));
}

// Indicar el nombre de la base de datos
$datab = "datos";

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
$imagen_perfil = $row['imagen'] ?? 'default.png'; // Si no hay imagen en la base de datos, se usa 'default.png'


// Cerrar la conexión con la base de datos
mysqli_close($connection);
?>



<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>BiblioTecaTeca | Inicio</title>
      
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

      
    <body class="sidebar-mini layout-fixed sidebar-collapse" style="height: auto;">
        <div class="wrapper">

          <div class="preloader flex-column justify-content-center align-items-center" style="height: 0px;">
            <img class="animation__shake" src="images/logo.jpg" alt="Biblio Logo" height="60" width="60" style="display: none;">
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
        
          <div class="content-wrapper" style="min-height: 559px;">
            <div class="content-header">
              <div class="container-fluid">
                <div class="row mb-2">
                  <div class="col-sm-6">
                    <h1 class="m-0">Inicio</h1>
                  </div>
                  <div class="col-sm-6">
                  </div>
                </div>
              </div>
            </div>
        
            <section class="content">
              <div class="container-fluid ">
                <div class="row d-flex justify-content-center">
                  <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                      <div class="inner">
                        <h3>Historial<br><br></h3>
                      </div>
                      <div class="icon">
                        <i class="ion ion-ios-book"></i>
                      </div>
                      <a href="historial.php" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                  </div>
                  <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                      <div class="inner">
                        <h3>Lista Deseos<br><br></h3>
                      </div>
                      <div class="icon">
                        <i class="ion ion-heart"></i>
                      </div>
                      <a href="listadeseos.php" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                  </div>
                  <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                      <div class="inner">
                        <h3>Prórrogas<br><br></h3>
                      </div>
                      <div class="icon">
                        <i class="ion ion-ios-clock"></i>
                      </div>
                      <a href="prorrogas.php" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                  </div>
                </div>

                <div class="row">
                <div class="container mt-5">
                  <h1 class="text-center display">Buscar Libros</h1>
                  <div class="row">
                      <div class="col-md-8 offset-md-2">
                          <form id="searchForm">
                              <div class="input-group">
                                  <input type="text" class="form-control" id="searchInput" placeholder="Buscar por título o autor.">
                                  <div class="input-group-append">
                                      <button type="submit" class="btn btn-primary">Buscar</button>
                                  </div>
                              </div>
                          </form>
                      </div>
                  </div>
                  <div id="results" class="mt-5"></div>
                </div>

          <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
          <script src="https://kit.fontawesome.com/a076d05399.js"></script>

        <script>
            document.getElementById('searchForm').addEventListener('submit', function(event) {
    event.preventDefault();
    const searchInput = document.getElementById('searchInput').value;
    const apiUrl = `https://www.googleapis.com/books/v1/volumes?q=${encodeURIComponent(searchInput)}`;

    fetch(apiUrl)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.totalItems === 0) {
                document.getElementById('results').innerHTML = '<p>No se encontraron resultados.</p>';
                return;
            }
            displayResults(data.items);
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
            document.getElementById('results').innerHTML = '<p>Error fetching data. Please try again later.</p>';
        });
});

function displayResults(items) {
    const resultsDiv = document.getElementById('results');
    resultsDiv.innerHTML = '';

    const row = document.createElement('div');
    row.classList.add('row');

    // Mantener un conjunto de títulos para verificar duplicados
    const titlesSet = new Set();

    items.forEach(item => {
        const title = item.volumeInfo.title;
        const authors = item.volumeInfo.authors ? item.volumeInfo.authors.join(', ') : 'Unknown';
        const bookId = item.id; // ID único del libro (puedes usar cualquier identificador único)
        const imageUrl = item.volumeInfo.imageLinks ? item.volumeInfo.imageLinks.thumbnail : ''; // URL de la imagen del libro

        // Comprobar si el título ya está en el conjunto
        if (!titlesSet.has(title)) {
            // Agregar el título al conjunto para evitar duplicados
            titlesSet.add(title);

            // Obtener la puntuación del libro desde la API de Google Books
            const apiUrl = `https://www.googleapis.com/books/v1/volumes/${bookId}`;
            fetch(apiUrl)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    let rating = data.volumeInfo.averageRating ? data.volumeInfo.averageRating : 'No calificada';
                    let ratingStars = '';

                    // Convertir la puntuación en estrellas
                    for (let i = 0; i < 5; i++) {
                        if (i < Math.floor(rating)) {
                            ratingStars += '<span class="fas fa-star"></span>';
                        } else {
                            ratingStars += '<span class="far fa-star"></span>';
                        }
                    }

                    const col = document.createElement('div');
                    col.classList.add('col-md-6', 'mb-3');

                    const li = document.createElement('div');
                    li.classList.add('list-group-item');
                    li.innerHTML = `
                        <div class="row">
                            <div class="col-md-4">
                                <img src="${imageUrl}" alt="${title}" class="img-fluid">
                            </div>
                            <div class="col-md-8">
                                <h3 class="book-title"><button class="btn btn-link book-title-button" data-book-id="${bookId}">${title}</button></h3>
                                <p class="mb-1">Autor(es): ${authors}</p>
                                <p class="mb-0">Puntuación: ${ratingStars}</p>
                            </div>
                        </div>
                    `;

                    col.appendChild(li);
                    row.appendChild(col);

                    // Agregar manejador de eventos al botón del título del libro
                    const titleButton = li.querySelector('.book-title-button');
                    titleButton.addEventListener('click', () => {
                        // Redirigir a la página de detalles del libro al hacer clic en el título
                        const bookId = titleButton.dataset.bookId;
                        window.location.href = `detalles_libro.php?id=${bookId}`;
                    });
                })
                .catch(error => {
                    console.error('There was a problem with the fetch operation:', error);
                });
        }
    });

    resultsDiv.appendChild(row);
}

        </script>  
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
        
          <aside class="control-sidebar control-sidebar-dark" style="display: none; top: 57px; height: 616px;">
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
        <!--<script src="dist/js/demo.js"></script>
         AdminLTE dashboard demo (This is only for demo purposes) -->
         <script src="dist/js/pages/dashboard.js"></script> 
        <script>
            var nombreUsuario = documente.getElemetById('nombre-usuario-real').innerText;
            document.getElementById('nombre-usuario').innerText = nombreUsuario;
        </script>
    
        <div class="jqvmap-label" style="display: none;">
        </div>

    <div class="jqvmap-label" style="display: none;"></div></body>
</html>


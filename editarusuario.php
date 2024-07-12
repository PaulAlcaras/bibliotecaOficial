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

  // Verificar si se envió un archivo para cambiar la imagen de perfil
  if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
    // Directorio donde se guardarán las imágenes
    $directorio_destino = 'uploads/';

    // Obtener información del archivo subido
    $nombre_archivo = $_FILES['imagen']['name'];
    $ruta_temporal = $_FILES['imagen']['tmp_name'];

    // Mover el archivo al directorio destino
    $ruta_destino = $directorio_destino . $nombre_archivo;
    if (move_uploaded_file($ruta_temporal, $ruta_destino)) {
        // Actualizar la imagen de perfil en la base de datos
        $sql = "UPDATE usuarios SET imagen = '$nombre_archivo' WHERE usuario = '$usuario'";
        if (mysqli_query($connection, $sql)) {
          // echo "La imagen se ha guardado correctamente en la base de datos.";
        } else {
            echo "Error al actualizar la imagen en la base de datos: " . mysqli_error($connection);
        }
    } else {
        echo "Error al mover el archivo al directorio de destino.";
    }
  }

  // Obtener la imagen de perfil del usuario
  $sql = "SELECT imagen FROM usuarios WHERE usuario = '$usuario'";
  $resultado = mysqli_query($connection, $sql);
  $row = mysqli_fetch_assoc($resultado);
  $imagen_perfil = $row['imagen'] ?? 'default.jpg'; // Si no hay imagen en la base de datos, se usa 'default.jpg'

  // Consulta SQL para obtener los datos del usuario en sesión
  $sql = "SELECT * FROM usuarios WHERE usuario = '$usuario'";

  $resultado = mysqli_query($connection, $sql);

  // Verificar si hay resultados
  if (mysqli_num_rows($resultado) > 0) {
      $row = mysqli_fetch_assoc($resultado);
      //header("Location: editarusuario.php");
      //exit();
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

          <style>
          .perfil-imagen {
              border-radius: 50%; /* Aplica un borde circular */
              width: 100px; /* Ajusta el tamaño según tus necesidades */
              height: 100px; /* Ajusta el tamaño según tus necesidades */
              object-fit: cover; /* Ajusta el tamaño y recorta la imagen para que se ajuste al círculo */
          }
          </style>

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
                    <img src="uploads/<?php echo $row['imagen']; ?>" class="img-circle elevation-2 perfil-imagen" alt="User Image">
                  </div>
                  <div class="info">
                    <a href="usuario.php" class="d-block"><?php echo $row['usuario']; ?></a>
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

                                      <img class="profile-user-img img-fluid img-circle" src="uploads/<?php echo $row['imagen']; ?>" alt="User profile picture" id="imagen-preview">
                                      <a href="#" class="edit-link float-right" id="editar-imagen" data-field="imagen"><i class="fas fa-edit"></i></a>
                                      <div id="editar-imagen-container" style="display: none;">
                                          <form action="editarusuario.php" method="post" enctype="multipart/form-data">
                                              <input type="file" name="imagen" accept="image/*">
                                              <button type="submit">Subir imagen</button>
                                          </form>
                                          <?php
                                          $mensaje = isset($_GET['mensaje']) ? $_GET['mensaje'] : '';

                                          if ($mensaje) {
                                              echo "<script>alert('$mensaje');</script>";
                                          }
                                          ?>
                                      </div>
                                  </div>

                                  <h3 class="profile-username text-center" id="nombre-usuario-real">
                                      <?php echo $usuario; ?>
                                  </h3>
                                  <ul class="list-group list-group-unbordered mb-3">
                                      <li class="list-group-item">
                                          <b>Nombre</b>
                                          <span class="float-right" id="value-nombre"><?php echo $row['nombre']; ?></span>
                                          <input type="text" class="form-control edit-text" id="edit-nombre" style="display: none;">
                                          <a href="#" class="float-right edit-link" data-field="nombre"><i class="fas fa-edit"></i></a>
                                          <button class="btn btn-success float-right save-button" data-field="nombre" style="display: none;">Guardar</button>
                                      </li>
                                      <li class="list-group-item">
                                          <b>Correo electrónico</b> <span class="float-right"><?php echo $row['correo']; ?></span>
                                      </li>
                                      <li class="list-group-item">
                                          <b>Género</b> <span class="float-right"><?php echo $row['genero']; ?></span>
                                          <input type="text" class="form-control" id="edit-genero" style="display: none;">
                                          <a href="#" class="float-right edit-link" data-field="genero" data-value="<?php echo $row['genero']; ?>"><i class="fas fa-edit"></i></a>
                                          <button class="btn btn-success float-right save-button" data-field="genero" style="display: none;">Guardar</button>
                                      
                                      </li>
                                      <li class="list-group-item">
                                          <b>Nacimiento</b> <span class="float-right"><?php echo $row['nacimiento']; ?></span>
                                          <input type="text" class="form-control" id="edit-nacimiento" style="display: none;">
                                          <a href="#" class="float-right edit-link" data-field="nacimiento" data-value="<?php echo $row['nacimiento']; ?>"><i class="fas fa-edit"></i></a>
                                          <button class="btn btn-success float-right save-button" data-field="nacimiento" style="display: none;">Guardar</button>
                                      
                                      </li>
                                      <li class="list-group-item">
                                          <b>Dirección</b> <span class="float-right"><?php echo $row['direccion']; ?></span>
                                          <input type="text" class="form-control" id="edit-direccion" style="display: none;">
                                          <a href="#" class="float-right edit-link" data-field="direccion" data-value="<?php echo $row['direccion']; ?>"><i class="fas fa-edit"></i></a>
                                          <button class="btn btn-success float-right save-button" data-field="direccion" style="display: none;">Guardar</button>
                                      
                                      </li>
                                      <li class="list-group-item">
                                          <b>Teléfono</b> <span class="float-right"><?php echo $row['telefono']; ?></span>
                                          <input type="text" class="form-control" id="edit-telefono" style="display: none;">
                                          <a href="#" class="float-right edit-link" data-field="telefono" data-value="<?php echo $row['telefono']; ?>"><i class="fas fa-edit"></i></a>
                                          <button class="btn btn-success float-right save-button" data-field="telefono" style="display: none;">Guardar</button>
                                      </li>
                                      </li>
                                      <li class="list-group-item">
                                          <b>Desde</b> <span class="float-right"><?php echo $row['fecha_registro']; ?></span>
                                      </li>
                                  </ul>
                                  <a href="usuario.php" class="btn btn-primary btn-block"><b>Guardar perfil</b></a></div>
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

          <script>
            $(document).ready(function() {
                // Mostrar el cuadro de texto y el botón de guardar cuando se hace clic en el ícono de edición
                $('.edit-link').click(function() {
                    var field = $(this).data('field');
                    $('#value-' + field).hide();
                    $('#edit-' + field).show();
                    $('.save-button').hide();
                    $('.save-button[data-field="' + field + '"]').show();
                });

                // Manejar el evento de clic en el botón de guardar
                $('.save-button').click(function() {
                    var field = $(this).data('field');
                    var newValue = $('#edit-' + field).val();
                    
                    // Enviar los datos a actualizarusuario.php mediante AJAX
                    $.ajax({
                        url: 'actualizarusuario.php',
                        type: 'POST',
                        data: { field: field, value: newValue },
                        success: function(response) {
                            // Actualizar el valor en la página después de la respuesta exitosa
                            $('#value-' + field).text(newValue).show();
                            $('#edit-' + field).hide();
                            $('.save-button').hide();
                            alert(response); 
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                            alert('Error al actualizar los datos. Consulta la consola para más detalles.');
                        }
                    });
                });
            });
        </script>

      
          <script>
              $(document).ready(function() {
                  $("#editar-imagen").click(function(e) {
                      e.preventDefault();
                      $("#editar-imagen-container").show();
                  });
              });
          </script>


      
          <div class="jqvmap-label" style="display: none;">
          </div>

      <div class="jqvmap-label" style="display: none;"></div></body>
  </html>


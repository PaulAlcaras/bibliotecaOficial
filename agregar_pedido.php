<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

// Datos de conexión a la base de datos
$user = "root";
$pass = "";
$host = "localhost";
$database = "datos";

// Conectar a la base de datos
$connection = new mysqli($host, $user, $pass, $database);

if ($connection->connect_error) {
    die("Error al conectar a la base de datos: " . $connection->connect_error);
}

// Obtener el nombre de usuario de la sesión
$usuario = $_SESSION['usuario'];

// Obtener el id del usuario
$sql_usuario = "SELECT id_usuario FROM usuarios WHERE usuario = ?";
$stmt = $connection->prepare($sql_usuario);
$stmt->bind_param("s", $usuario);
$stmt->execute();
$result_usuario = $stmt->get_result();
if ($result_usuario->num_rows == 0) {
    die("Error al obtener el id del usuario.");
}
$row_usuario = $result_usuario->fetch_assoc();
$id_usuario = $row_usuario['id_usuario'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_libro = $_POST['id_libro'];

    if (empty($id_libro)) {
        die("ID del libro no proporcionado.");
    }

    // Verificar la cantidad de libros prestados por el usuario
    $sql_count_libros_prestados = "SELECT COUNT(*) AS cantidad FROM situacion WHERE id_usuario = ? AND estado = 'Prestado'";
    $stmt = $connection->prepare($sql_count_libros_prestados);
    $stmt->bind_param("i", $id_usuario);
    $stmt->execute();
    $result_count_libros_prestados = $stmt->get_result();
    $row_count_libros_prestados = $result_count_libros_prestados->fetch_assoc();
    $cantidad_libros_prestados = $row_count_libros_prestados['cantidad'];

    if ($cantidad_libros_prestados >= 9) {
        $_SESSION['mensaje'] = "No se pueden realizar más de 9 préstamos a la vez.";
        header("Location: en_prestamo.php");
        exit();
    }

    // Verificar si el libro existe en la tabla libros
    $sql_libro_existe = "SELECT id_libro FROM libros WHERE id_libro = ?";
    $stmt = $connection->prepare($sql_libro_existe);
    $stmt->bind_param("s", $id_libro);
    $stmt->execute();
    $result_libro_existe = $stmt->get_result();

    if ($result_libro_existe->num_rows == 0) {
        // El libro no existe en la base de datos, obtener detalles del libro desde la API
        $apiUrl = "https://www.googleapis.com/books/v1/volumes/{$id_libro}";
        $bookData = json_decode(file_get_contents($apiUrl), true);

        // Verificar si se obtuvieron los detalles del libro correctamente
        if (isset($bookData['volumeInfo'])) {
            $bookInfo = $bookData['volumeInfo'];

            // Recuperar los detalles del libro desde la API
            $titulo = $bookInfo['title'];
            $autor = isset($bookInfo['authors']) ? implode(", ", $bookInfo['authors']) : "Desconocido";
            $genero = "Genero"; // Ajusta según tus necesidades
            $año_publicacion = isset($bookInfo['publishedDate']) ? substr($bookInfo['publishedDate'], 0, 4) : "Desconocido";
            $disponibilidad = "Disponible"; // Ajusta según tus necesidades
            $ejemplares = 1; // Puedes ajustar según lo que obtengas de la API
            $isbn = isset($bookInfo['industryIdentifiers'][0]['identifier']) ? $bookInfo['industryIdentifiers'][0]['identifier'] : "Desconocido";

            // Insertar el nuevo libro en la tabla de libros
            $agregar_libro_sql = "INSERT INTO libros (id_libro, titulo, autor, genero, año_publicacion, disponibilidad, ejemplares, isbn) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $connection->prepare($agregar_libro_sql);
            $stmt->bind_param("ssssssis", $id_libro, $titulo, $autor, $genero, $año_publicacion, $disponibilidad, $ejemplares, $isbn);
            if (!$stmt->execute()) {
                die("Error al agregar el libro: " . $stmt->error);
            }
        } else {
            die("Error: No se pudieron obtener los detalles del libro desde la API.");
        }
    }

    $fecha_inicio = date('Y-m-d');
    $fecha_termino = date('Y-m-d', strtotime('+10 days')); 

    // Insertar los préstamos en la tabla historial
    $sql_insert_historial = "INSERT INTO historial (id_usuario, id_libro, fecha_inicio, fecha_termino) VALUES (?, ?, ?, ?)";
    $stmt = $connection->prepare($sql_insert_historial);
    $stmt->bind_param("isss", $id_usuario, $id_libro, $fecha_inicio, $fecha_termino);
    if (!$stmt->execute()) {
        die("Error al insertar en historial: " . $stmt->error);
    }

    // Actualizar la situación del libro
    $estado = "Prestado";
    $sql_agregar_situacion = "INSERT INTO situacion (id_libro, estado, id_usuario) VALUES (?, ?, ?)";
    $stmt = $connection->prepare($sql_agregar_situacion);
    $stmt->bind_param("ssi", $id_libro, $estado, $id_usuario);
    if ($stmt->execute()) {
        $_SESSION['mensaje'] = "Libro prestado correctamente.";
    } else {
        echo "Error al agregar el libro a la situación: " . $stmt->error;
    }

    // Redirigir a la página de en_prestamo
    header("Location: en_prestamo.php");
    exit();
}

// Cerrar la conexión
$connection->close();
?>

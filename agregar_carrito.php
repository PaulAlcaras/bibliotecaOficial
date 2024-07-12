<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

$usuario = $_SESSION['usuario'];

// Datos de conexión a la base de datos
$user = "root";
$pass = "";
$host = "localhost";
$database = "datos";

// Conectar a la base de datos
$connection = mysqli_connect($host, $user, $pass, $database);

if (!$connection) {
    die("Error al conectar a la base de datos: " . mysqli_connect_error());
}

// Verificar si el usuario está registrado en la base de datos
$verificar_usuario_sql = "SELECT id_usuario FROM usuarios WHERE usuario = '$usuario'";
$resultado_usuario = mysqli_query($connection, $verificar_usuario_sql);

if (mysqli_num_rows($resultado_usuario) == 0) {
    die("Error: El usuario no está registrado en la base de datos.");
}

$row_usuario = mysqli_fetch_assoc($resultado_usuario);
$id_usuario = $row_usuario['id_usuario'];

// Obtener la cantidad actual de libros en el carrito del usuario
$sql_count_libros = "SELECT COUNT(*) AS cantidad FROM carrito WHERE id_usuario = '$id_usuario'";
$result_count_libros = mysqli_query($connection, $sql_count_libros);
$row_count_libros = mysqli_fetch_assoc($result_count_libros);
$cantidad_libros_en_carrito = $row_count_libros['cantidad'];

if ($result_count_libros >= 9) {
    $_SESSION['mensaje'] = "Se ha alcanzado el límite máximo de 9 libros.";
    header("Location: carrito.php");
    exit();
}

// Manejo de la solicitud POST para agregar un libro al carrito
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_libro = $_POST['id_libro'];

    // Verificar si el libro ya está en el carrito del usuario
    $verificar_libro_en_carrito = "SELECT id_libro FROM carrito WHERE id_libro = '$id_libro' AND id_usuario = '$id_usuario'";
    $resultado = mysqli_query($connection, $verificar_libro_en_carrito);

    if (mysqli_num_rows($resultado) > 0) {
        echo "El libro ya está en el carrito.";
    } else {
        // Verificar si el libro existe en la base de datos
        $verificar_libro_existente_sql = "SELECT id_libro FROM libros WHERE id_libro = '$id_libro'";
        $resultado_libro = mysqli_query($connection, $verificar_libro_existente_sql);

        if (mysqli_num_rows($resultado_libro) == 0) {
            // Obtener los detalles del libro desde la API
            $apiUrl = "https://www.googleapis.com/books/v1/volumes/{$id_libro}";
            $bookData = json_decode(file_get_contents($apiUrl), true);

            // Verificar si se obtuvieron los detalles del libro correctamente
            if (isset($bookData['volumeInfo'])) {
                $bookInfo = $bookData['volumeInfo'];
                
                $titulo = $bookInfo['title'];
                $autor = isset($bookInfo['authors']) ? implode(", ", $bookInfo['authors']) : "Desconocido";
                $genero = "Genero"; // Ajusta esto según cómo determines el género
                $año_publicacion = isset($bookInfo['publishedDate']) ? substr($bookInfo['publishedDate'], 0, 4) : "Desconocido";
                $disponibilidad = "Disponible"; // Ajusta esto según tu lógica de disponibilidad
                $ejemplares = 1; // Ajusta esto según tu lógica de ejemplares
                $isbn = isset($bookInfo['industryIdentifiers'][0]['identifier']) ? $bookInfo['industryIdentifiers'][0]['identifier'] : "Desconocido";

                // Insertar el libro en la base de datos
                $agregar_libro_sql = "INSERT INTO libros (id_libro, titulo, autor, genero, año_publicacion, disponibilidad, ejemplares, isbn) VALUES ('$id_libro', '$titulo', '$autor', '$genero', '$año_publicacion', '$disponibilidad', '$ejemplares', '$isbn')";

                if (!mysqli_query($connection, $agregar_libro_sql)) {
                    echo "Error al agregar el libro: " . mysqli_error($connection);
                    exit();
                }
            } else {
                echo "Error: No se pudieron obtener los detalles del libro desde la API.";
                exit();
            }
        }
        $estado = "Prestado";
                
        $sql_agregar_situacion = "INSERT INTO situacion (id_libro, estado, id_usuario) VALUES('$id_libro', '$estado', '$id_usuario')";
        if (mysqli_query($connection, $sql_agregar_situacion)) {
            $_SESSION['mensaje'] = "Libro agregado a situacion correctamente.";
        } else {
            echo "Error al agregar el libro a situacion: " . mysqli_error($connection);
        }

        $sql_agregar_carrito = "INSERT INTO carrito (id_usuario, id_libro) VALUES('$id_usuario', '$id_libro')";
        if (mysqli_query($connection, $sql_agregar_carrito)) {
            $_SESSION['mensaje'] = "Libro agregado a carrito correctamente.";
        } else {
            echo "Error al agregar el libro a situacion: " . mysqli_error($connection);
        }
    }

    // Redirigir a detalles_libro con id_libro
    header("Location: detalles_libro.php?id=$id_libro");
    exit();
}

// Cerrar la conexión
mysqli_close($connection);
?>

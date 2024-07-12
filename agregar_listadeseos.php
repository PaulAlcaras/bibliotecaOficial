<?php
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

// Datos de conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$database = "datos";

// Recuperar el id_usuario del usuario en sesión
if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];

    // Conexión a la base de datos
    $conn = new mysqli($servername, $username, $password, $database);

    // Verificar conexión
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    // Consulta para obtener el id_usuario del usuario en sesión
    $buscar_usuario_sql = "SELECT id_usuario FROM usuarios WHERE usuario = ?";
    $stmt = $conn->prepare($buscar_usuario_sql);
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $id_usuario = $row['id_usuario'];
    } else {
        // Si no se encuentra el usuario en la base de datos, manejar el error
        die("Error: No se encontró el usuario en la base de datos.");
    }

    // Cerrar statement
    $stmt->close();

    // Procesar la solicitud de agregar a lista de deseos
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Recuperar los datos del formulario
        $id_libro = $_POST['id_libro'];

        // Verificar si el libro existe en la base de datos antes de agregarlo a la lista de deseos
        $verificar_libro_existente_sql = "SELECT id_libro FROM libros WHERE id_libro = ?";
        $stmt = $conn->prepare($verificar_libro_existente_sql);
        $stmt->bind_param("s", $id_libro);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows == 0) {
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
                $stmt = $conn->prepare($agregar_libro_sql);
                $stmt->bind_param("ssssssis", $id_libro, $titulo, $autor, $genero, $año_publicacion, $disponibilidad, $ejemplares, $isbn);

                if ($stmt->execute() === TRUE) {
                    // Continuar con la inserción en la lista de deseos
                    insertarEnListaDeseos($conn, $id_libro, $id_usuario);
                } else {
                    echo "Error al agregar el libro: " . $conn->error;
                    exit();
                }
            } else {
                echo "Error: No se pudieron obtener los detalles del libro desde la API.";
                exit();
            }
        } else {
            // El libro ya existe en la base de datos
            insertarEnListaDeseos($conn, $id_libro, $id_usuario);
        }

        // Cerrar statement
        $stmt->close();

        // Cerrar conexión
        $conn->close();
    } else {
        // Si no es una solicitud POST, redirigir a alguna página o mostrar un mensaje de error
        header("Location: login.php");
        exit();
    }
} else {
    // Si no hay usuario en sesión, redirigir al login
    header("Location: login.php");
    exit();
}

function insertarEnListaDeseos($conn, $id_libro, $id_usuario) {
    // Verificar si el libro ya está en la lista de deseos del usuario
    $verificar_libro_sql = "SELECT id_libro FROM lista_deseos WHERE id_libro = ? AND id_usuario = ?";
    $stmt = $conn->prepare($verificar_libro_sql);
    $stmt->bind_param("si", $id_libro, $id_usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['mensaje'] = "Este libro ya está en tu lista de deseos.";
    } else {
        // El libro no está en la lista de deseos del usuario, insertarlo
        $insertar_lista_sql = "INSERT INTO lista_deseos (id_libro, id_usuario) VALUES (?, ?)";
        $stmt = $conn->prepare($insertar_lista_sql);
        $stmt->bind_param("si", $id_libro, $id_usuario);

        if ($stmt->execute() === TRUE) {
            $_SESSION['mensaje'] = "Libro agregado a la lista de deseos correctamente.";
        } else {
            echo "Error: " . $insertar_lista_sql . "<br>" . $conn->error;
        }
    }

    // Redirigir a la página de detalles del libro con un mensaje
    header("Location: detalles_libro.php?id=$id_libro");
    exit();
}
?>

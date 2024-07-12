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
    $buscar_usuario_sql = "SELECT id_usuario FROM usuarios WHERE usuario = '$usuario'";
    $result = $conn->query($buscar_usuario_sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $id_usuario = $row['id_usuario'];
    } else {
        // Si no se encuentra el usuario en la base de datos, manejar el error
        die("Error: No se encontró el usuario en la base de datos.");
    }

    // Cerrar conexión
    $conn->close();
} else {
    // Si no hay usuario en sesión, redirigir al login
    header("Location: login.php");
    exit();
}

// Procesar el comentario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar los datos del formulario
    $id_libro = $_POST['id_libro'];
    $calificacion = $_POST['calificacion'];
    $comentario = $_POST['comentario'];

    // Conexión a la base de datos
    $conn = new mysqli($servername, $username, $password, $database);

    // Verificar conexión
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    // Verificar si el libro existe antes de insertar el comentario
    $verificar_libro_sql = "SELECT id_libro FROM libros WHERE id_libro = '$id_libro'";
    $result = $conn->query($verificar_libro_sql);

    if ($result->num_rows > 0) {
        // El libro existe, insertar el comentario
        $insertar_comentario_sql = "INSERT INTO reseñas (id_usuario, id_libro, calificacion, comentario) VALUES ('$id_usuario', '$id_libro', '$calificacion', '$comentario')";

        if ($conn->query($insertar_comentario_sql) === TRUE) {
            // Redirigir a la página de detalles del libro con un mensaje de éxito
            $_SESSION['mensaje'] = "¡Comentario agregado correctamente!";
            header("Location: detalles_libro.php?id=$id_libro");
            exit();
        } else {
            // Si hay un error, mostrar un mensaje de error
            echo "Error: " . $insertar_comentario_sql . "<br>" . $conn->error;
        }
    } else {
        // El libro no existe, redirigir a la página para ingresar libros
        header("Location: ingresarlibros.php?id=$id_libro");
       
    }

    // Cerrar conexión
    $conn->close();
} else {
    // Si no es una solicitud POST, redirigir a alguna página o mostrar un mensaje de error
    header("Location: login.php");
    exit();
}
?>

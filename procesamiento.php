<?php
session_start();

// Verificar si se proporcionó un ID de libro
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['mensaje'] = "Error: No se proporcionó un ID de libro válido.";
    header("Location: index.php");
    exit();
}

// Obtener el ID de libro desde la URL
$id_libro = $_GET['id'];

// Datos de conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$database = "datos";

// Recuperar el usuario en sesión, si existe
$usuario = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : null;

// Conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $database);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Consulta para obtener detalles del libro de la base de datos
$buscar_libro_sql = "SELECT * FROM libros WHERE id_libro = '$id_libro'";
$result = $conn->query($buscar_libro_sql);

if ($result->num_rows > 0) {
    // El libro existe en la base de datos, mostrar detalles
    $row = $result->fetch_assoc();
    $titulo = $row['titulo'];
    $autor = $row['autor'];
    $genero = $row['genero'];
    $año_publicacion = $row['año_publicacion'];
    $isbn = $row['isbn'];
} else {
    // El libro no está en la base de datos, intentar obtener detalles de la API de Google Books
    $apiUrl = "https://www.googleapis.com/books/v1/volumes/{$id_libro}";
    $bookData = json_decode(file_get_contents($apiUrl), true);

    // Verificar si se recibieron datos válidos de la API
    if(isset($bookData['volumeInfo'])) {
        $titulo = $bookData['volumeInfo']['title'];
        $autor = isset($bookData['volumeInfo']['authors']) ? implode(", ", $bookData['volumeInfo']['authors']) : "Desconocido";
        $genero = isset($bookData['volumeInfo']['categories']) ? implode(", ", $bookData['volumeInfo']['categories']) : "No especificado";
        $año_publicacion = isset($bookData['volumeInfo']['publishedDate']) ? substr($bookData['volumeInfo']['publishedDate'], 0, 4) : "Desconocido";
        $isbn = isset($bookData['volumeInfo']['industryIdentifiers'][0]['identifier']) ? $bookData['volumeInfo']['industryIdentifiers'][0]['identifier'] : "No disponible";
    } else {
        $_SESSION['mensaje'] = "Error: No se encontraron detalles para este libro.";
        //header("Location: index.php");
        exit();
    }
}

// Verificar si el usuario está logueado
if (!$usuario) {
    // No hay usuario logueado, redirigir al login
    $_SESSION['mensaje'] = "Por favor inicia sesión para agregar un comentario.";
    header("Location: login.php");
    exit();
}

// Procesar el comentario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si se proporcionó un comentario
    if (empty($_POST['comentario'])) {
        $_SESSION['mensaje'] = "Por favor, ingresa un comentario.";
        header("Location: detalles_libro.php?id=$id_libro");
        exit();
    }

    // Recuperar los datos del formulario
    $calificacion = $_POST['calificacion'];
    $comentario = $_POST['comentario'];

    // Consulta para insertar el comentario en la base de datos
    $insertar_comentario_sql = "INSERT INTO reseñas (id_usuario, id_libro, calificacion, comentario) VALUES ('$id_usuario', '$id_libro', '$calificacion', '$comentario')";

    if ($conn->query($insertar_comentario_sql) === TRUE) {
        $_SESSION['mensaje'] = "¡Comentario agregado correctamente!";
    } else {
        $_SESSION['mensaje'] = "Error al agregar el comentario: " . $conn->error;
    }

    // Cerrar conexión
    $conn->close();

    // Redirigir de vuelta a la página de detalles del libro
    header("Location: detalles_libro.php?id=$id_libro");
    exit();
}

// Cerrar conexión
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Libro</title>
</head>
<body>
    <h1>Detalles del Libro</h1>
    <p><strong>Título:</strong> <?php echo $titulo; ?></p>
    <p><strong>Autor:</strong> <?php echo $autor; ?></p>
    <p><strong>Género:</strong> <?php echo $genero; ?></p>
    <p><strong>Año de Publicación:</strong> <?php echo $año_publicacion; ?></p>
    <p><strong>ISBN:</strong> <?php echo $isbn; ?></p>

    <?php if(isset($_SESSION['mensaje'])): ?>
    <p><?php echo $_SESSION['mensaje']; ?></p>
    <?php unset($_SESSION['mensaje']); ?>
    <?php endif; ?>

    <form action="detalles_libro.php?id=<?php echo $id_libro; ?>" method="post">
        <label for="calificacion">Calificación:</label>
        <select name="calificacion" id="calificacion">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
        </select><br>
        <label for="comentario">Comentario:</label><br>
        <textarea name="comentario" id="comentario" cols="30" rows="5"></textarea><br>
        <button type="submit">Enviar Comentario</button>
    </form>
</body>
</html>

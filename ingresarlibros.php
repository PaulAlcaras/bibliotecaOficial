<?php

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$database = "datos";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// URL base de la API de libros
$baseUrl = "https://www.googleapis.com/books/v1/volumes";

// Número máximo de resultados por página
$maxResults = 40; 
$count = 0;

// Función para obtener datos de la API de Google Books
function fetchBookById($id) {
    global $baseUrl;
    $url = "$baseUrl/$id";
    $response = file_get_contents($url);
    return json_decode($response, true);
}

// Función para insertar libros en la base de datos
function insertBookIntoDatabase($conn, $book) {
    $id_libro = $book['id'];
    $titulo = isset($book['volumeInfo']['title']) ? mysqli_real_escape_string($conn, $book['volumeInfo']['title']) : "Sin título";
    $autor = isset($book['volumeInfo']['authors']) ? implode(", ", $book['volumeInfo']['authors']) : "Desconocido";
    $genero = isset($book['volumeInfo']['categories']) ? implode(", ", $book['volumeInfo']['categories']) : "No especificado";
    $año_publicacion = isset($book['volumeInfo']['publishedDate']) ? substr($book['volumeInfo']['publishedDate'], 0, 4) : "Desconocido";
    $disponibilidad = "Disponible";
    $ejemplares = 1;
    $isbn = isset($book['volumeInfo']['industryIdentifiers'][0]['identifier']) ? $book['volumeInfo']['industryIdentifiers'][0]['identifier'] : "No disponible";

    $sql = "INSERT INTO libros (id_libro, titulo, autor, genero, año_publicacion, disponibilidad, ejemplares, isbn)
            VALUES ('$id_libro', '$titulo', '$autor', '$genero', '$año_publicacion', '$disponibilidad', '$ejemplares', '$isbn')";

    return $conn->query($sql);
}

// Si se proporciona un ID en la URL, obtener y procesar ese libro específico
if (isset($_GET['id'])) {
    $bookId = $_GET['id'];
    $bookData = fetchBookById($bookId);

    if ($bookData && isset($bookData['id'])) {
        if (insertBookIntoDatabase($conn, $bookData)) {
            echo "Libro insertado correctamente: {$bookData['volumeInfo']['title']}<br>";
            $count++;
        } else {
            echo "Error al insertar libro: " . $conn->error . "<br>";
        }
    } else {
        echo "No se recibieron datos válidos del libro.";
    }

    // Cerrar conexión
    $conn->close();
    exit(); // Detener la ejecución después de procesar el libro específico
}

// Obtener datos de la API y procesar la paginación
$totalItems = PHP_INT_MAX; // Un número grande para asegurar que se entre al bucle
while ($count < $totalItems) {
    $start = $page * $maxResults;
    $url = "$baseUrl?q=&startIndex=$start&maxResults=$maxResults";
    $data = fetchBooksFromApi($url);

    if ($data && isset($data['items'])) {
        $totalItems = isset($data['totalItems']) ? $data['totalItems'] : 0;

        foreach ($data['items'] as $item) {
            if (insertBookIntoDatabase($conn, $item)) {
                //echo "Libro insertado correctamente: {$item['volumeInfo']['title']}<br>";
                header("Location: detalles_libro.php?id=$id_libro");
                exit();
            } else {
                echo "Error al insertar libro: " . $conn->error . "<br>";
            }
        }
    } else {
        echo "No se recibieron datos válidos de la API.";
        break;
    }
}

echo "Total de libros insertados: $count";

// Cerrar conexión
$conn->close();

?>

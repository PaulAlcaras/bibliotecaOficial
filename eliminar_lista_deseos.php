<?php
// Verificar si se recibió una solicitud POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si se recibió el ID del libro a eliminar
    if (isset($_POST['id_libro'])) {
        // Obtener el ID del libro a eliminar
        $id_libro = $_POST['id_libro'];

        // Datos de conexión a la base de datos
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "datos";

        // Establecer conexión con la base de datos
        $conn = new mysqli($servername, $username, $password, $database);

        // Verificar la conexión
        if ($conn->connect_error) {
            die("Error de conexión: " . $conn->connect_error);
        }

        // Consulta SQL para eliminar el libro de la lista de deseos
        $eliminar_libro_sql = "DELETE FROM lista_deseos WHERE id_libro = '$id_libro'";

        // Ejecutar la consulta
        if ($conn->query($eliminar_libro_sql) === TRUE) {
            // Redirigir al usuario de vuelta a la página de la lista de deseos con un mensaje de éxito
            session_start();
            $_SESSION['mensaje'] = "Libro eliminado de la lista de deseos correctamente.";
            header("Location: listadeseos.php");
            exit();
        } else {
            echo "Error al eliminar el libro de la lista de deseos: " . $conn->error;
        }

        // Cerrar la conexión
        $conn->close();
    } else {
        echo "Error: No se proporcionó el ID del libro a eliminar.";
    }
} else {
    echo "Error: Esta página solo responde a solicitudes POST.";
}
?>

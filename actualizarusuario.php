<?php
// Verificar si se ha enviado el campo y el valor a actualizar
if(isset($_POST['field']) && isset($_POST['value'])) {
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

    // Obtener el campo y el valor a actualizar
    $field = $_POST['field'];
    $value = $_POST['value'];

    // Consulta SQL para actualizar el campo específico
    $sql = "UPDATE usuarios SET $field = '$value' WHERE usuario = '$usuario'";

    if (mysqli_query($connection, $sql)) {
        echo "El campo $field ha sido actualizado correctamente.";
    } else {
        echo "Error al actualizar el campo $field: " . mysqli_error($connection);
    }

    // Cerrar la conexión
    mysqli_close($connection);
}
?>

<?php
// insertar.php

include 'db.php';  // Asegúrate de que este archivo contiene la función obtenerConexion

$mensaje = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener la conexión desde db.php
    $conn = obtenerConexion(); 

    // Escapar los datos para evitar inyecciones SQL
    $nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
    $correo = mysqli_real_escape_string($conn, $_POST['email']);
    $informacion = mysqli_real_escape_string($conn, $_POST['mensaje']);

    // Verificamos si los campos no están vacíos
    if (!empty($nombre) && !empty($correo) && !empty($informacion)) {
        // Preparar la consulta de inserción
        $sql = "INSERT INTO quinto (nombre, correo, informacion) VALUES ('$nombre', '$correo', '$informacion')";

        // Ejecutamos la consulta
        if ($conn->query($sql) === TRUE) {
            $mensaje = "Los datos fueron guardados exitosamente.";
        } else {
            $mensaje = "Error al guardar los datos: " . $conn->error;
        }

        // Cerramos la conexión
        $conn->close();
    } else {
        $mensaje = "Por favor, complete todos los campos del formulario.";
    }
}
?>

<?php if ($mensaje): ?>
    <p><?php echo $mensaje; ?></p>
<?php endif; ?>

<?php
// Incluir el archivo de conexión
include 'db.php';  // Asegúrate de que este archivo contiene la función obtenerConexion

$respuestas_correctas = array(
    "P1" => "c",
    "P2" => "f",
    "P3" => "i",
    "P4" => "l",
    "P5" => "p",
    "P6" => "s",
    "P7" => "v",
    "P8" => "y",
    "P9" => "cd",
    "P10" => "ij",
    "P11" => "op",
    "P12" => "uv",
    "P13" => "mucho",
    "P14" => "ghi",
    "P15" => "pqr",
);

$puntuacion = 0;
foreach ($respuestas_correctas as $pregunta => $respuesta_correcta) {
    if (isset($_POST[$pregunta]) && $_POST[$pregunta] === $respuesta_correcta) {
        $puntuacion++;
    }
}

// Determinar el mensaje, el color de la alerta y la relación
$mensaje = '';
$color_alerta = '';
$relacion = '';

if ($puntuacion >= 10) {
    $mensaje = "¡Cuidado tu relación es tóxica!";
    $color_alerta = "red";  // Tóxica
    $relacion = "Peligrosa"; // Relación peligrosa
} elseif ($puntuacion >= 5 && $puntuacion <= 9) {
    $mensaje = "¡No es mala pero cuidado!";
    $color_alerta = "yellow";  // Precaución
    $relacion = "En peligro";  // Relación en peligro
} else {
    $mensaje = "¡Felicidades tu relación es buena!";
    $color_alerta = "green";  // Sana
    $relacion = "Saludable";  // Relación saludable
}

// Insertar en la base de datos (si el formulario ha sido enviado)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener la conexión a la base de datos
    $conn = obtenerConexion();

    // Inserta el resultado en la tabla "preguntas"
    $sql = "INSERT INTO preguntas (relacion) VALUES ('$relacion')";

    if ($conn->query($sql) === TRUE) {
        // Si la inserción es exitosa, hacemos lo siguiente
    } else {
        // Si ocurre un error al insertar, mostrar un mensaje (esto es opcional)
        $mensaje = "Error al guardar la relación en la base de datos: " . $conn->error;
    }

    // Cerrar la conexión
    $conn->close();
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Violentometro</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
        <div id="alerta" class="alerta <?php echo $color_alerta; ?>">
            <?php echo $mensaje; ?>
        </div>
        
        <script>
            // Redirige después de 2 segundos
            setTimeout(function() {
                window.location.href = 'index.html#violentometro';  
            }, 2000);
        </script>
    <?php endif; ?>

</body>
</html>

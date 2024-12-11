<?php
// Incluir el archivo de conexión
include 'db.php';  // Asegúrate de que este archivo contiene la función obtenerConexion

// Obtener la conexión a la base de datos
$conn = obtenerConexion();

// Consultar el número de registros por cada tipo de relación
$sql = "SELECT relacion, COUNT(*) as cantidad FROM preguntas GROUP BY relacion";
$result = $conn->query($sql);

$peligrosa = 0;
$en_peligro = 0;
$saludable = 0;

// Si hay resultados, asignamos los valores a las variables
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if ($row['relacion'] === "Peligrosa") {
            $peligrosa = $row['cantidad'];
        } elseif ($row['relacion'] === "En peligro") {
            $en_peligro = $row['cantidad'];
        } elseif ($row['relacion'] === "Saludable") {
            $saludable = $row['cantidad'];
        }
    }
}

// Cerrar la conexión
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title class="title">Gráfica Violentómetro</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* Estilo para el layout */

        html, body {
    height: 100%;
    margin: 0;
    display: flex;
    flex-direction: column;
    background-color:beige;
}
        /* Centrar la gráfica */
        .chart-container {
            width: 50%;
            margin: 0 auto;
            padding-top: 50px;
            text-align: center;
            flex-grow: 1; /* Permite que el contenedor crezca si es necesario */
        }

        canvas {
            display: block;
            margin: 0 auto;
        }

        h2{
    color: #10053a;
}

        /* Footer */
        .footer {
    background-color: #220650;
    color: white;
    text-align: center;
    padding: 10px 0;
    position: relative;
    bottom: 0;
    width: 100%;
}

        .social-links {
            list-style: none;
            padding: 0;
        }

        .social-links a {
            text-decoration: none;
            color: white;
            margin: 0 10px;
            font-size: 18px;
        }

        .social-links a:hover {
            color: #ddd;
        }

       
    </style>
</head>
<body>

    <div class="chart-container">
        <h2>Gráfica de Relaciones</h2>
        <canvas id="myPieChart"></canvas>
    </div>

    <script>
        // Datos obtenidos de PHP
        var peligrosa = <?php echo $peligrosa; ?>;
        var en_peligro = <?php echo $en_peligro; ?>;
        var saludable = <?php echo $saludable; ?>;

        // Crear la gráfica de pastel usando Chart.js
        var ctx = document.getElementById('myPieChart').getContext('2d');
        var myPieChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Peligrosa', 'En Peligro', 'Saludable'],  // Etiquetas
                datasets: [{
                    label: 'Relaciones',
                    data: [peligrosa, en_peligro, saludable],  // Datos (porcentaje de cada categoría)
                    backgroundColor: ['#ff0000', '#ffcc00', '#00ff00'],  // Colores
                    borderColor: ['#ff0000', '#ffcc00', '#00ff00'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                var total = peligrosa + en_peligro + saludable;
                                var currentValue = tooltipItem.raw;
                                var percentage = Math.floor((currentValue / total) * 100);
                                return tooltipItem.label + ': ' + percentage + '%';
                            }
                        }
                    }
                }
            }
        });
    </script>

    <!-- Footer -->
    <footer class="footer">
        <div class="social-links">
            <a href="https://facebook.com" target="_blank" class="social-icon facebook"><i class="fab fa-facebook-f"></i> Facebook</a>
            <a href="https://wa.me/123456789" target="_blank" class="social-icon whatsapp"><i class="fab fa-whatsapp"></i> WhatsApp</a>
            <a href="https://instagram.com" target="_blank" class="social-icon instagram"><i class="fab fa-instagram"></i> Instagram</a>
            <a href="mailto:correo@dominio.com" class="social-icon email"><i class="fas fa-envelope"></i> Correo</a>
        </div>
    </footer>

</body>
</html>

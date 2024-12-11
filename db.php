<?php
// conexion.php

$servername = "localhost";
$username = "root";
$password = "";
$db = "yrg";

function obtenerConexion() {
    global $servername, $username, $password, $db;
    $conn = new mysqli($servername, $username, $password, $db);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    return $conn;
}
?>

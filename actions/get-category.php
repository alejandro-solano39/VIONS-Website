<?php
include_once(__DIR__ . '/../config/config.php');

// Conectar a la base de datos
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Inicializar el array de categorías
$categorias = [];

// Consulta para obtener categorías
$result = $conn->query("SELECT * FROM category");

// Verificar si la consulta fue exitosa
if ($result === false) {
    die("Error en la consulta SQL: " . $conn->error);
}

// Procesar los resultados de la consulta
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $categorias[] = $row;
    }
}

$conn->close();

// Retornar el array de categorías
return $categorias;
?>

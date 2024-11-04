<?php
include_once(__DIR__ . '/../config/config.php');

// Verificar que el parámetro 'id' esté en la URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Convertir a entero para evitar inyecciones SQL

    // Conectar a la base de datos
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Consultar el portafolio por ID
    $stmt = $conn->prepare("SELECT * FROM portfolios WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $portafolio = $result->fetch_assoc();

    $stmt->close();
    $conn->close();

    // Verificar que el portafolio exista
    if (!$portafolio) {
        echo "Portafolio no encontrado.";
        exit();
    }
} else {
    echo "ID de portafolio no proporcionado.";
    exit();
}
?>

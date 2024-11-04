<?php
include_once(__DIR__ . '/../config/config.php');

function getPortfolioDetails($id) {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    

    // Prepara la consulta para obtener los detalles del portafolio por ID
    $stmt = $conn->prepare("SELECT * FROM portfolios WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $portafolio = $result->fetch_assoc();

    $stmt->close();
    $conn->close();

    return $portafolio;
}
?>

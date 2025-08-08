<?php
include_once(__DIR__ . '/../config/config.php');

function getPortfolioDetails($id) {
    if (!isset($id) || !is_numeric($id) || $id <= 0) {
        die("Error: ID no especificado o inválido.");
    }

    static $conn = null;

    if ($conn === null) {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }
    }

    $stmt = $conn->prepare("SELECT * FROM portfolios WHERE id = ?");

    if ($stmt === false) {
        die("Error preparando la consulta: " . $conn->error);
    }

    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        die("Error: No se encontró el portafolio con el ID especificado.");
    }

    $portafolio = $result->fetch_assoc();
    $stmt->close();
    return $portafolio;
}

function closeConnection() {
    global $conn;
    if (isset($conn) && $conn instanceof mysqli) {
        $conn->close();
        $conn = null;
    }    
}
?>
